<?php
/**
 * Created by PhpStorm.
 * User: tomeastwood
 * Date: 2017-11-21
 * Time: 10:44 AM
 */

namespace MaxLiving\Location\AdminViews;

use MaxLiving\Location\Includes\LocationForm\LocationFormFunctions as LocationFormFunctions;
use MaxLiving\Location\Includes\Network\NetworkFunctions as NetworkFunctions;

class LocationForm
{
    public static function render_form()
    {
        $site_info = LocationFormFunctions::get_site_info();

        //we're updating a location on a childsite
        $vanity_website_id = get_current_blog_id();
        $location = LocationFormFunctions::get_location_info( get_current_blog_id(), null );
        $vanity_website_url = home_url();
        $is_create = false;
        $show_vanity_website_url = false;
        $whitelabel = $site_info['whitelabel'];
        $business_hours = json_decode(html_entity_decode($location['business_hours']) );
        $child_show_gmb_hidden = true;

        //we're on network and creating a location with a newly created site
        if($vanity_website_id === 1 && $site_info['site_id'] !== '0') {
            $vanity_website_id = $site_info['site_id'];
            $location = LocationFormFunctions::get_location_info(null, null);
            $vanity_website_url = $site_info['vanity_website_url'];
            $is_create = true;
            $show_vanity_website_url = false;
        }

        //creating a location without a site, so set the vanity_website_id to zero
        if($vanity_website_id === 1 && $site_info['site_id'] === '0') {
            $vanity_website_id = time();
            $location = LocationFormFunctions::get_location_info(null, null);
            $vanity_website_url = '';
            $is_create = true;
            $show_vanity_website_url = true;
        }

        //update on the network level
        $network_show_gmb = false;
        if(isset($_GET['location_id'])) {
            $location_id = filter_var($_GET['location_id'], FILTER_SANITIZE_NUMBER_INT );
            $vanity_website_id = time();
            $location = LocationFormFunctions::get_location_info(null, $location_id);
            $vanity_website_url = $location['vanity_website_url'];
            $is_create = false;
            $show_vanity_website_url = true;
            $business_hours = json_decode(html_entity_decode($location['business_hours']) );
            $network_show_gmb = true;
            $gmb_value = NetworkFunctions::get_gmb_locations();
        }

        ?>

        <style>
            /*
            This will be moved to scss in future release.
            */
            .location-dashboard {
                display: flex;
                flex-wrap: wrap;
                margin-right: 1rem;
                justify-content: space-between;
            }

            .location-dashboard-item {
                flex-basis: 49%;
                margin-top: 1rem;
                margin-bottom: 1rem;
            }

            .location-dashboard-item-full {
                flex-basis: 100%;
                margin-top: 1rem;
                margin-bottom: -1rem;
            }

            .radios {
                display: flex;
                justify-content: flex-start;
            }

            .radioWrap {
                margin-right: 4.5rem;
            }

            .hourGroup {
                width: 100%;
                margin: 1rem 0;
                display: flex;
                padding-bottom: 1rem;
                border-bottom: 1px solid #d6d6d6;
            }

            .hourPair {
                display: flex;
                flex-direction: column;
                margin-right: 3rem;
            }

            .customHours {
                display: none;
            }

            .add {
                /*Important as the WP button styles have margin 0*/
                margin-top: 1rem !important;
            }
            .remove {
                margin-top: 18px !important;
            }
        </style>

        <div class="wrap">
            <h1><?php echo $site_info['form_submission'] . " - " . \get_bloginfo('name') ?></h1>
            <hr>
            <form method="post" action="<?php echo \admin_url('admin-post.php'); ?>">
                <input type="hidden" name="action" value="<?php echo $site_info['action']; ?>">
                <input type="hidden" name="vanity_website_id" value="<?php echo $vanity_website_id; ?>">
                <input type="hidden" name="vanity_website_url" value="<?php echo $vanity_website_url; ?>">
                <input type="hidden" name="whitelabel" value="<?php echo $whitelabel; ?>">
                <?php if(!empty($location_id) ): ?>
                    <input type="hidden" name="location_id" value="<?php echo $location_id; ?>">
                <?php endif; ?>
                <div class="location-dashboard">
                    <!-- <div class="location-dashboard-item-full">
                        <h2>General Information</h2>
                        <hr>
                    </div> -->
                    <div class="location-dashboard-item">

                        <table class="form-table">

                            <tr valign="top">
                                <th scope="row">Location Name</th>
                                <td><input type="text" name="name" value="<?php if($location['name']) {echo $location['name'];} else {switch_to_blog($_GET['site_id']); echo get_bloginfo( 'name' ); restore_current_blog();} ?>"/></td>
                            </tr>

                            <tr valign="top">
                                <th scope="row">Email</th>
                                <td><input type="email" name="email" value="<?php echo $location['email']; ?>"/></td>
                            </tr>

                            <tr valign="top">
                                <th scope="row">Phone</th>
                                <td><input type="text" name="telephone" value="<?php echo $location['telephone']; ?>"/>
                                </td>

                            </tr>
                            <tr valign="top">
                                <th scope="row">Phone Ext</th>
                                <td><input type="text" name="telephone_ext"
                                           value="<?php echo $location['telephone_ext']; ?>"/></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">Fax</th>
                                <td><input type="text" name="fax" value="<?php echo $location['fax']; ?>"/></td>
                            </tr>

                            <?php if($show_vanity_website_url): ?>
                                <tr valign="top">
                                    <th scope="row">Website URL</th>
                                    <td><input type="text" name="vanity_website_url" value="<?php echo $location['vanity_website_url']; ?>"/></td>
                                </tr>
                            <?php endif; ?>

                        </table>
                    </div>
                    <!-- <div class="location-dashboard-item">
                        <table class="form-table">

                            <tr valign="top">
                                <th scope="row">Opening Date</th>
                                <td><input type="date" name="opening_date"
                                           value="<?php echo $location['opening_date']; ?>"/></td>
                            </tr>

                            <tr valign="top">
                                <th scope="row">Closing Date</th>
                                <td><input type="date" name="closing_date"
                                           value="<?php echo $location['closing_date']; ?>"/></td>
                            </tr>

                            <tr valign="top">
                                <th scope="row">Pre Open Display Date</th>
                                <td><input type="date" name="pre_open_display_date"
                                           value="<?php echo $location['pre_open_display_date']; ?>"/></td>
                            </tr>

                            <tr valign="top">
                                <th scope="row">Day Light Savings Applies</th>
                                <td><input type="checkbox" name="daylight_savings_applies"
                                           value="1"
                                           <?php if ($location['pre_open_display_date']){ ?>checked<?php } ?> /></td>
                            </tr>
                        </table>
                    </div> -->

                    <div class="location-dashboard-item-full">
                        <h2>Location Information</h2>
                        <hr>
                    </div>
                    <div class="location-dashboard-item location-section">

                        <table class="form-table">

                            <tr valign="top">
                                <th scope="row">Address 1</th>
                                <td><input type="text" name="addresses[1][address1]"
                                           value="<?php echo $location['address_1']; ?>"/>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row">Address 2</th>
                                <td><input type="text" name="addresses[1][address2]"
                                           value="<?php echo $location['address_2']; ?>"/>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row">City</th>
                                <td><input type="text" name="addresses[1][city]"
                                           value="<?php echo $location['city_name']; ?>"/>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row">Country</th>
                                <td>
                                    <select name="addresses[1][country]">
                                        <option value="United States of America" <?php if($location['country_name'] === "United States"){echo "selected";} ?>>United States</option>
                                        <option value="Canada" <?php if($location['country_name'] === "Canada"){echo "selected";} ?>>Canada</option>
                                    </select>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row">Region (State/Province)</th>
                                <td><select name="addresses[1][region]">
                                        <option disabled>United States</option>
                                        <option disabled>─────────────</option>
                                        <option value="Alabama" <?php if($location['region_name'] === "Alabama"){echo "selected";} ?>>Alabama</option>
                                        <option value="Alaska" <?php if($location['region_name'] === "Alaska"){echo "selected";} ?>>Alaska</option>
                                        <option value="Arizona" <?php if($location['region_name'] === "Arizona"){echo "selected";} ?>>Arizona</option>
                                        <option value="Arkansas" <?php if($location['region_name'] === "Arkansas"){echo "selected";} ?>>Arkansas</option>
                                        <option value="California" <?php if($location['region_name'] === "California"){echo "selected";} ?>>California</option>
                                        <option value="Colorado" <?php if($location['region_name'] === "Colorado"){echo "selected";} ?>>Colorado</option>
                                        <option value="Connecticut" <?php if($location['region_name'] === "Connecticut"){echo "selected";} ?>>Connecticut</option>
                                        <option value="Delaware" <?php if($location['region_name'] === "Delaware"){echo "selected";} ?>>Delaware</option>
                                        <option value="District Of Columbia" <?php if($location['region_name'] === "District Of Columbia<"){echo "selected";} ?>>District Of Columbia</option>
                                        <option value="Florida" <?php if($location['region_name'] === "Florida"){echo "selected";} ?>>Florida</option>
                                        <option value="Georgia" <?php if($location['region_name'] === "Georgia"){echo "selected";} ?>>Georgia</option>
                                        <option value="Hawaii" <?php if($location['region_name'] === "Hawaii"){echo "selected";} ?>>Hawaii</option>
                                        <option value="Idaho" <?php if($location['region_name'] === "Idaho"){echo "selected";} ?>>Idaho</option>
                                        <option value="Illinois" <?php if($location['region_name'] === "Illinois"){echo "selected";} ?>>Illinois</option>
                                        <option value="Indiana" <?php if($location['region_name'] === "Indiana"){echo "selected";} ?>>Indiana</option>
                                        <option value="Iowa" <?php if($location['region_name'] === "Iowa"){echo "selected";} ?>>Iowa</option>
                                        <option value="Kansas" <?php if($location['region_name'] === "Kansas"){echo "selected";} ?>>Kansas</option>
                                        <option value="Kentucky" <?php if($location['region_name'] === "Kentucky"){echo "selected";} ?>>Kentucky</option>
                                        <option value="Louisiana" <?php if($location['region_name'] === "Louisiana"){echo "selected";} ?>>Louisiana</option>
                                        <option value="Maine" <?php if($location['region_name'] === "Maine"){echo "selected";} ?>>Maine</option>
                                        <option value="Maryland" <?php if($location['region_name'] === "Maryland"){echo "selected";} ?>>Maryland</option>
                                        <option value="Massachusetts" <?php if($location['region_name'] === "Massachusetts"){echo "selected";} ?>>Massachusetts</option>
                                        <option value="Michigan" <?php if($location['region_name'] === "Michigan"){echo "selected";} ?>>Michigan</option>
                                        <option value="Minnesota" <?php if($location['region_name'] === "Minnesota"){echo "selected";} ?>>Minnesota</option>
                                        <option value="Mississippi" <?php if($location['region_name'] === "Mississippi"){echo "selected";} ?>>Mississippi</option>
                                        <option value="Missouri" <?php if($location['region_name'] === "Missouri"){echo "selected";} ?>>Missouri</option>
                                        <option value="Montana" <?php if($location['region_name'] === "Montana"){echo "selected";} ?>>Montana</option>
                                        <option value="Nebraska" <?php if($location['region_name'] === "Nebraska"){echo "selected";} ?>>Nebraska</option>
                                        <option value="Nevada" <?php if($location['region_name'] === "Nevada"){echo "selected";} ?>>Nevada</option>
                                        <option value="New Hampshire" <?php if($location['region_name'] === "New Hampshire"){echo "selected";} ?>>New Hampshire</option>
                                        <option value="New Jersey" <?php if($location['region_name'] === "New Jersey"){echo "selected";} ?>>New Jersey</option>
                                        <option value="New Mexico" <?php if($location['region_name'] === "New Mexico"){echo "selected";} ?>>New Mexico</option>
                                        <option value="New York" <?php if($location['region_name'] === "New York"){echo "selected";} ?>>New York</option>
                                        <option value="North Carolina" <?php if($location['region_name'] === "North Carolina"){echo "selected";} ?>>North Carolina</option>
                                        <option value="North Dakota" <?php if($location['region_name'] === "North Dakota"){echo "selected";} ?>>North Dakota</option>
                                        <option value="Ohio" <?php if($location['region_name'] === "Ohio"){echo "selected";} ?>>Ohio</option>
                                        <option value="Oklahoma" <?php if($location['region_name'] === "Oklahoma"){echo "selected";} ?>>Oklahoma</option>
                                        <option value="Oregon" <?php if($location['region_name'] === "Oregon"){echo "selected";} ?>>Oregon</option>
                                        <option value="Pennsylvania" <?php if($location['region_name'] === "Pennsylvania"){echo "selected";} ?>>Pennsylvania</option>
                                        <option value="Rhode Island" <?php if($location['region_name'] === "Rhode Island"){echo "selected";} ?>>Rhode Island</option>
                                        <option value="South Carolina" <?php if($location['region_name'] === "South Carolina"){echo "selected";} ?>>South Carolina</option>
                                        <option value="South Dakota" <?php if($location['region_name'] === "South Dakota"){echo "selected";} ?>>South Dakota</option>
                                        <option value="Tennessee" <?php if($location['region_name'] === "Tennessee"){echo "selected";} ?>>Tennessee</option>
                                        <option value="Texas" <?php if($location['region_name'] === "Texas"){echo "selected";} ?>>Texas</option>
                                        <option value="Utah" <?php if($location['region_name'] === "Utah"){echo "selected";} ?>>Utah</option>
                                        <option value="Vermont" <?php if($location['region_name'] === "Vermont"){echo "selected";} ?>>Vermont</option>
                                        <option value="Virginia" <?php if($location['region_name'] === "Virginia"){echo "selected";} ?>>Virginia</option>
                                        <option value="Washington" <?php if($location['region_name'] === "Washington"){echo "selected";} ?>>Washington</option>
                                        <option value="West Virginia" <?php if($location['region_name'] === "West Virginia"){echo "selected";} ?>>West Virginia</option>
                                        <option value="Wisconsin" <?php if($location['region_name'] === "Wisconsin"){echo "selected";} ?>>Wisconsin</option>
                                        <option value="Wyoming" <?php if($location['region_name'] === "Wyoming"){echo "selected";} ?>>Wyoming</option>
                                        <option value="Federated States of Micronesia" <?php if($location['region_name'] === "Federated States of Micronesia"){echo "selected";} ?>>Federated States of Micronesia</option>
                                        <option value="Guam" <?php if($location['region_name'] === "Guam"){echo "selected";} ?>>Guam</option>
                                        <option value="Marshall Islands" <?php if($location['region_name'] === "Marshall Islands"){echo "selected";} ?>>Marshall Islands</option>
                                        <option value="Northern Mariana Islands" <?php if($location['region_name'] === "Northern Mariana Islands"){echo "selected";} ?>>Northern Mariana Islands</option>
                                        <option value="Palau" <?php if($location['region_name'] === "Palau"){echo "selected";} ?>>Palau</option>
                                        <option value="Puerto Rico" <?php if($location['region_name'] === "Puerto Rico"){echo "selected";} ?>>Puerto Rico</option>
                                        <option value="Virgin Islands" <?php if($location['region_name'] === "Virgin Islands"){echo "selected";} ?>>Virgin Islands</option>
                                        <option disabled></option>
                                        <option disabled>Canada</option>
                                        <option disabled>─────────────</option>
                                        <option value="Alberta" <?php if($location['region_name'] === "Alberta"){echo "selected";} ?>>Alberta</option>
                                        <option value="British Columbia" <?php if($location['region_name'] === "British Columbia"){echo "selected";} ?>>British Columbia</option>
                                        <option value="Manitoba" <?php if($location['region_name'] === "Manitoba"){echo "selected";} ?>>Manitoba</option>
                                        <option value="New Brunswick" <?php if($location['region_name'] === "New Brunswick"){echo "selected";} ?>>New Brunswick</option>
                                        <option value="Newfoundland and Labrador" <?php if($location['region_name'] === "Newfoundland and Labrador"){echo "selected";} ?>>Newfoundland and Labrador</option>
                                        <option value="Nova Scotia" <?php if($location['region_name'] === "Nova Scotia"){echo "selected";} ?>>Nova Scotia</option>
                                        <option value="Ontario" <?php if($location['region_name'] === "Ontario"){echo "selected";} ?>>Ontario</option>
                                        <option value="Prince Edward Island" <?php if($location['region_name'] === "Prince Edward Island"){echo "selected";} ?>>Prince Edward Island</option>
                                        <option value="Quebec" <?php if($location['region_name'] === "Quebec"){echo "selected";} ?>>Quebec</option>
                                        <option value="Saskatchewan" <?php if($location['region_name'] === "Saskatchewan"){echo "selected";} ?>>Saskatchewan</option>
                                        <option value="Northwest Territories" <?php if($location['region_name'] === "Northwest Territories"){echo "selected";} ?>>Northwest Territories</option>
                                        <option value="Nunavut" <?php if($location['region_name'] === "Nunavut"){echo "selected";} ?>>Nunavut</option>
                                        <option value="Yukon" <?php if($location['region_name'] === "Yukon"){echo "selected";} ?>>Yukon</option>
                                    </select>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row">Zip / Postal Code</th>
                                <td><input type="text" name="addresses[1][zip_postal_code]"
                                           value="<?php echo $location['zip_postal_code']; ?>"/></td>
                            </tr>

                            <tr valign="top">
                                <th scope="row">Latitude</th>
                                <td><input type="text" name="addresses[1][latitude]"
                                           value="<?php echo $location['latitude']; ?>"/>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row">Longitude</th>
                                <td><input type="text" name="addresses[1][longitude]"
                                           value="<?php echo $location['longitude']; ?>"/>
                                </td>
                            </tr>
                        </table>
                    </div>


                    <script>
                        jQuery(document).ready(function ($) {
                            $('input[type="radio"]').click(function () {
                                if ($(this).attr('class') == 'open') {
                                    var parent = $(this).parent().parent().parent();
                                    $(parent).find(".customHours").show();
                                } else {
                                    var parent = $(this).parent().parent().parent();
                                    $(parent).find(".customHours").hide();
                                }
                            });

                            $('body').on("click", '.remove', function() {
                                $(this).parent().remove();
                            });

                            var hoursNumber = 2;
                            $(".add").click(function () {
                                var container = $(this).parent();
                                var day = $(this).attr("title");
                                var hoursRow =
                                    '<div class="hourGroup">\n' +
                                    '<div class="hourPair">\n' +
                                    '<label for="open'+day+'">Open Time</label>\n' +
                                    '<input type="text" name="' + day + '[' + hoursNumber + '][open]">\n' +
                                    '</div>\n' +
                                    '<div class="hourPair">\n' +
                                    '<label for="closed'+day+'">Closed Time</label>\n' +
                                    '<input type="text" name="' + day + '[' + hoursNumber + '][closed]">\n' +
                                    '</div>\n' +
                                    '<div class="button-secondary remove" title="">Remove This Set</div>\n' +
                                    '</div>';
                                $(container).append(hoursRow);
                                ++hoursNumber;
                            });

                        });
                    </script>

                    <div class="location-dashboard-item-full">
                        <h2>Hours</h2>
                        <hr>
                        <table class="form-table">

                            <?php if($is_create): ?>

                                <tr valign="top">
                                    <th scope="row">Monday</th>
                                    <td>
                                        <div class="radios">
                                            <div class="radioWrap"><input type="radio" id="closedMonday" name="hoursMonday" value="closed">
                                                <label for="closedMonday">Closed</label>
                                            </div>
                                            <div class="radioWrap">
                                                <input type="radio" id="apptMonday" name="hoursMonday" value="appointment">
                                                <label for="apptMonday">By Appointment</label>
                                            </div>
                                            <div class="radioWrap">
                                                <input type="radio" id="openMonday" name="hoursMonday" class="open" value="open">
                                                <label for="openMonday">Open</label>
                                            </div>
                                        </div>
                                        <div class="customHours">
                                            <div class="button-primary add" title="monday">Add Another Set</div>
                                            <div class="hourGroup">
                                                <div class="hourPair">
                                                    <label for="openMonday">Open Time</label>
                                                    <input type="text" name="monday[1][open]">
                                                </div>
                                                <div class="hourPair">
                                                    <label for="closedMonday">Closed Time</label>
                                                    <input type="text" name="monday[1][closed]">
                                                </div>
                                                <div class="button-secondary remove">Remove This Set</div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row">Tuesday</th>
                                    <td>
                                        <div class="radios">
                                            <div class="radioWrap">
                                                <input type="radio" id="closedTuesday" name="hoursTuesday" value="closed">
                                                <label for="closedTuesday">Closed</label>
                                            </div>
                                            <div class="radioWrap">
                                                <input type="radio" id="apptTuesday" name="hoursTuesday" value="appointment">
                                                <label for="apptTuesday">By Appointment</label>
                                            </div>
                                            <div class="radioWrap">
                                                <input type="radio" id="openTuesday" name="hoursTuesday" class="open" value="open">
                                                <label for="openTuesday">Open</label>
                                            </div>
                                        </div>
                                        <div class="customHours">
                                            <div class="button-primary add" title="tuesday">Add Another Set</div>
                                            <div class="hourGroup">
                                                <div class="hourPair">
                                                    <label for="openTuesday">Open Time</label>
                                                    <input type="text" name="tuesday[1][open]">
                                                </div>
                                                <div class="hourPair">
                                                    <label for="closedTuesday">Closed Time</label>
                                                    <input type="text" name="tuesday[1][closed]">
                                                </div>
                                                <div class="button-secondary remove">Remove This Set</div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row">Wednesday</th>
                                    <td>
                                        <div class="radios">
                                            <div class="radioWrap">
                                                <input type="radio" id="closedWednesday" name="hoursWednesday" value="closed">
                                                <label for="closedWednesday">Closed</label>
                                            </div>
                                            <div class="radioWrap">
                                                <input type="radio" id="apptWednesday" name="hoursWednesday" value="appointment">
                                                <label for="apptWednesday" value="appointment">By Appointment</label>
                                            </div>
                                            <div class="radioWrap">
                                                <input type="radio" id="openWednesday" name="hoursWednesday" class="open" value="open">
                                                <label for="openWednesday">Open</label>
                                            </div>
                                        </div>
                                        <div class="customHours">
                                            <div class="button-primary add" title="wednesday">Add Another Set</div>
                                            <div class="hourGroup">
                                                <div class="hourPair">
                                                    <label for="openWednesday">Open Time</label>
                                                    <input type="text" name="wednesday[1][open]">
                                                </div>
                                                <div class="hourPair">
                                                    <label for="closedWednesday">Closed Time</label>
                                                    <input type="text" name="wednesday[1][closed]">
                                                </div>
                                                <div class="button-secondary remove">Remove This Set</div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row">Thursday</th>
                                    <td>
                                        <div class="radios">
                                            <div class="radioWrap">
                                                <input type="radio" id="closedThursday" name="hoursThursday" value="closed">
                                                <label for="closedThursday">Closed</label>
                                            </div>
                                            <div class="radioWrap">
                                                <input type="radio" id="apptThursday" name="hoursThursday" value="appointment">
                                                <label for="apptThursday">By Appointment</label>
                                            </div>
                                            <div class="radioWrap">
                                                <input type="radio" id="openThursday" name="hoursThursday" value="open" class="open">
                                                <label for="openThursday">Open</label>
                                            </div>
                                        </div>
                                        <div class="customHours">
                                            <div class="button-primary add" title="thursday">Add Another Set</div>
                                            <div class="hourGroup">
                                                <div class="hourPair">
                                                    <label for="openThursday">Open Time</label>
                                                    <input type="text" name="thursday[1][open]">
                                                </div>
                                                <div class="hourPair">
                                                    <label for="closedThursday">Closed Time</label>
                                                    <input type="text" name="thursday[1][closed]">
                                                </div>
                                                <div class="button-secondary remove">Remove This Set</div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row">Friday</th>
                                    <td>
                                        <div class="radios">
                                            <div class="radioWrap">
                                                <input type="radio" id="closedFriday" name="hoursFriday" value="closed">
                                                <label for="closedFriday">Closed</label>
                                            </div>
                                            <div class="radioWrap">
                                                <input type="radio" id="apptFriday" name="hoursFriday" value="appointment">
                                                <label for="apptFriday">By Appointment</label>
                                            </div>
                                            <div class="radioWrap">
                                                <input type="radio" id="openFriday" name="hoursFriday" value="open" class="open">
                                                <label for="openFriday">Open</label>
                                            </div>
                                        </div>
                                        <div class="customHours">
                                            <div class="button-primary add" title="friday">Add Another Set</div>
                                            <div class="hourGroup">
                                                <div class="hourPair">
                                                    <label for="openFriday">Open Time</label>
                                                    <input type="text" name="friday[1][open]">
                                                </div>
                                                <div class="hourPair">
                                                    <label for="closedFriday">Closed Time</label>
                                                    <input type="text" name="friday[1][closed]">
                                                </div>
                                                <div class="button-secondary remove">Remove This Set</div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row">Saturday</th>
                                    <td>
                                        <div class="radios">
                                            <div class="radioWrap">
                                                <input type="radio" id="closedSaturday" value="closed" name="hoursSaturday">
                                                <label for="closedSaturday">Closed</label>
                                            </div>
                                            <div class="radioWrap">
                                                <input type="radio" id="apptSaturday" name="hoursSaturday" value="appointment">
                                                <label for="apptSaturday">By Appointment</label>
                                            </div>
                                            <div class="radioWrap">
                                                <input type="radio" id="openSaturday" name="hoursSaturday" value="open" class="open">
                                                <label for="openSaturday">Open</label>
                                            </div>
                                        </div>
                                        <div class="customHours">
                                            <div class="button-primary add" title="saturday">Add Another Set</div>
                                            <div class="hourGroup">
                                                <div class="hourPair">
                                                    <label for="openSaturday">Open Time</label>
                                                    <input type="text" name="saturday[1][open]">
                                                </div>
                                                <div class="hourPair">
                                                    <label for="closedSaturday">Closed Time</label>
                                                    <input type="text" name="saturday[1][closed]">
                                                </div>
                                                <div class="button-secondary remove">Remove This Set</div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row">Sunday</th>
                                    <td>
                                        <div class="radios">
                                            <div class="radioWrap">
                                                <input type="radio" id="closedSunday" value="closed" name="hoursSunday">
                                                <label for="closedSunday">Closed</label>
                                            </div>
                                            <div class="radioWrap">
                                                <input type="radio" id="apptSunday" name="hoursSunday" value="appointment">
                                                <label for="apptSunday">By Appointment</label>
                                            </div>
                                            <div class="radioWrap">
                                                <input type="radio" id="openSunday" name="hoursSunday" value="open" class="open">
                                                <label for="openSunday">Open</label>
                                            </div>
                                        </div>
                                        <div class="customHours">
                                            <div class="button-primary add" title="sunday">Add Another Set</div>
                                            <div class="hourGroup">
                                                <div class="hourPair">
                                                    <label for="openSunday">Open Time</label>
                                                    <input type="text" name="sunday[1][open]">
                                                </div>
                                                <div class="hourPair">
                                                    <label for="closedSunday">Closed Time</label>
                                                    <input type="text" name="sunday[1][closed]">
                                                </div>
                                                <div class="button-secondary remove">Remove This Set</div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                            <?php foreach($business_hours as $bh): ?>
                            <tr valign="top">
                                <th scope="row"><?php echo ucfirst($bh[0]); ?></th>
                                <td>
                                    <div class="radios">
                                        <div class="radioWrap">
                                            <input type="radio" id="closed<?php echo $bh[0]; ?>" value="closed" name="hours<?php echo ucfirst($bh[0]); ?>" <?php if($bh[1] === "closed"){echo 'checked';}?> >
                                            <label for="hours<?php echo $bh[0]; ?>">Closed</label>
                                        </div>
                                        <div class="radioWrap">
                                            <input type="radio" id="appt<?php echo $bh[0]; ?>" name="hours<?php echo ucfirst($bh[0]); ?>" value="appointment" <?php if($bh[1] === "appointment"){echo 'checked';}?> >
                                            <label for="hours<?php echo $bh[0]; ?>">By Appointment</label>
                                        </div>
                                        <div class="radioWrap">
                                            <input type="radio" id="open<?php echo $bh[0]; ?>" name="hours<?php echo ucfirst($bh[0]); ?>" value="open" class="open" <?php if($bh[1] === "open"){echo 'checked';}?> >
                                            <label for="hours<?php echo $bh[0]; ?>">Open</label>
                                        </div>
                                    </div>
                                    <?php if($bh[1] === "open"): ?>
                                    <div class="customHours" style="display:block;">
                                        <div class="button-primary add" title="<?php echo $bh[0]; ?>">Add Another Set</div>
                                        <?php $count = 1; ?>
                                        <?php foreach($bh[2] as $hours): ?>
                                            <div class="hourGroup">
                                                <div class="hourPair">
                                                    <label for="open<?php echo $bh[0]; ?>">Open Time</label>
                                                    <input type="text" name="<?php echo $bh[0]; ?>[<?php echo $count; ?>][open]" value="<?php echo $hours->open; ?>">
                                                </div>
                                                <div class="hourPair">
                                                    <label for="closed<?php echo $bh[0]; ?>">Closed Time</label>
                                                    <input type="text" name="<?php echo $bh[0]; ?>[<?php echo $count; ?>][closed]" value="<?php echo $hours->closed; ?>">

                                                </div>
                                                <div class="button-secondary remove">Remove This Set</div>
                                            </div>
                                            <?php $count++; ?>
                                        <?php endforeach; ?>
                                    </div>
                    </div>
                    <?php else: ?>
                        <div class="customHours">
                            <div class="button-primary add" title="<?php echo $bh[0]; ?>">Add Another Set</div>
                            <div class="hourGroup">
                                <div class="hourPair">
                                    <label for="open<?php echo $bh[0]; ?>">Open Time</label>
                                    <input type="text" name="<?php echo $bh[0]; ?>[1][open]">
                                </div>
                                <div class="hourPair">
                                    <label for="closed<?php echo $bh[0]; ?>">Closed Time</label>
                                    <input type="text" name="<?php echo $bh[0]; ?>[1][closed]">
                                </div>
                                <div class="button-secondary remove">Remove This Set</div>
                            </div>
                        </div>
                    <?php endif; ?>
                    </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                </table>
        </div>
        <?php if($child_show_gmb_hidden): //on the childsite update form, just add the hidden input of gmb_id so we don't do anything with it ?>
            <input type="hidden" name="gmb_id" value="<?php echo $location['gmb_id']; ?>">
        <?php endif; ?>
        <?php if($network_show_gmb): ?>

            <div class="location-dashboard-item-full">
                <h2>Google My Business</h2>
                <hr>
                <?php if(!empty($location['gmb_id']) ): ?>
                    <!-- if they have a gmb_id in here, show it -->
                    <label for="gmb_id">Google My Business ID: </label>
                    <input type="text" disabled name="gmb_id" value="<?php echo $location['gmb_id']; ?>">
                    <input type="hidden" name="gmb_id" value="<?php echo $location['gmb_id']; ?>">

                    <br>

                    <label for="gmb_id_remove">Yes, I want to disassociate this location from its current Google My Business information.</label>
                    <input type="checkbox" name="gmb_id_remove" value="1">
                <?php else: ?>
                    <!-- if there is not gmb_id, show all gmb_entries in a dropdown.  This dropdown will need to be populated based on the unused gmb_id that are sotred in the GMB setup -->
                    <select name="gmb_id">
                        <option value=""> - SELECT - </option>
                        <?php foreach($gmb_value as $gmb): ?>
                            <option value="<?php echo LocationFormFunctions::get_gmb_id($gmb->name); ?>"><?php echo LocationFormFunctions::get_gmb_id($gmb->locationName); ?></option>
                        <?php endforeach; ?>
                    </select>

                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="location-dashboard-item-full">
            <?php \submit_button($site_info['form_submission']); ?>
        </div>
        </div>
        </form>
        </div>
        <?php
    }
}

?>
