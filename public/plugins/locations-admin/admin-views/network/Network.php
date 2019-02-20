<?php
/**
 * Created by PhpStorm.
 * User: tomeastwood
 * Date: 2017-11-21
 * Time: 10:14 AM
 */

namespace MaxLiving\Location\AdminViews\Network;

use MaxLiving\Location\Includes\Network\NetworkFunctions as NetworkFunctions;
use MaxLiving\Location\Includes\CoreFunctions as CoreFunctions;

class Network
{

    public static function location_details_landing()
    { ?>
        <div class="wrap">
        <h1>Locations Network Admin</h1>
        <?php if (!empty($_GET['delete-location'])): ?>
            <h2 style="color:red;">You have successfully deleted a location</h2>
        <?php endif; ?>
        <hr>
        <br>
        <a href="<?php echo \network_admin_url('admin.php?page=location-create-site'); ?>" class="button-primary">Create Site</a>
        <a href="<?php echo \network_admin_url('admin.php?page=network-location-form&action=create_location&form_submission=Create Location'); ?>" class="button-primary">Create Location</a>

        <a href="<?php echo \network_admin_url('admin.php?page=network-view-location&purpose=update'); ?>" class="button-primary">Update a Location</a>

        <a href="<?php echo \network_admin_url('admin.php?page=network-view-location&purpose=delete'); ?>" class="button-primary">Delete a Location</a>

        </div>
        <?php
    }

    public static function location_create_site()
    { ?>
        <div class="wrap">
            <h1>Add New Site</h1>
            <hr>

            <p>You need to complete the following two pages to create a site.</p>

            <form method="POST" action="<?php echo \admin_url('admin-post.php'); ?>" id="create-site-form" class="form-table">
                <input type="hidden" name="action" value="create_site">

                <label for="name">Name: <br>
                    <small>Example: Summit Family Chiropractic</small>
                </label><br/>
                <input type="text" name="name" id="name">

                <br/><br/>

                <label for="vanity_website_url">Site Slug: <br></label>
                <input type="text" name="vanity_website_url" id="vanity_website_url">

                <br/><br/>

                <label for="whitelabel">White Label Clinic Site: </label>
                <input type="checkbox" id="whitelabel" name="whitelabel">
                <br/><br/>

                <input type="submit" value="Create Site" id="submit-btn" class="button-primary">
            </form>
        </div>

        <script>
            jQuery(document).ready(function () {
                jQuery("#name").keyup(function (e) {
                    var value = jQuery(this).val().toLowerCase();
                    value = value.replace(/[^a-zA-Z 0-9]+/g, '');
                    value = value.split(' ').join('-');
                    jQuery("#vanity_website_url").val(value);
                });
            });
        </script>

        <script>
            document.getElementById("submit-btn").addEventListener('click', function (e) {
                e.preventDefault();

                var vanity_website_url = document.getElementById("vanity_website_url").value;

                regex = /^[a-zA-Z 0-9\-]*$/;

                if (regex.test(vanity_website_url) && vanity_website_url) {
                    //submit if we pass validation
                    document.getElementById("create-site-form").submit();
                } else {
                    //make some error messages
                    var submit = this,
                        parent = submit.parentNode,
                        errors = document.createElement("p");

                    errors.setAttribute("style", "color:red;");
                    errors.setAttribute("id", "error-messages");

                    parent.insertBefore(errors, submit);

                    document.getElementById("error-messages").innerHTML = "The Site URL must be a series of letters, numbers, or '-'.";
                }


            });
        </script>

        <?php
    }

    public static function location_done()
    {
        $link = NetworkFunctions::get_new_blog();
        ?>
        <div class="wrap">
            <h1>You have successfully created a site and or location!</h1>
            <hr>
            <br>
            <a href="<?php echo \network_admin_url('admin.php?page=location-create-site'); ?>" class="button-primary">Add another Site</a>
            <a href="<?php echo \network_admin_url('admin.php?page=network-location-form&action=create_location&form_submission=Create+Location'); ?>" class="button-primary">Add another Location</a>

            <?php if (!empty($link)) { ?>
                <a href="<?php echo $link; ?>" class="button-primary">Go to site you just created</a>
            <?php } ?>

            <a href="<?php echo \network_admin_url(); ?>" class="button-primary">Go to Admin Portal</a>
        </div>
        <?php
    }

    public static function view_all_locations()
    { ?>

        <h1>Locations</h1>

        <label>Select a location: </label>
        <select id="locations">
            <option>Select a Location</option>
        </select>

        <div id="location-details"></div>

        <script>
            jQuery(function ($) {

                var locations = [];
                jQuery.get("/wp-json/locations/api/get/all", function (data) {

                    let location_options = '';
                    data.locations
                        .sort(function(a, b){
                            if (a.name < b.name){
                                return -1;
                            }
                            if (a.name > b.name){
                                return 1;
                            }
                            return 0;
                        })
                        .forEach(function (loc) {
                            var addressDetails = null;
                            if (loc.addresses[0]) {
                                addressDetails = loc.addresses[0].address_1;
                                if (loc.addresses[0].city[0]) {
                                    addressDetails += ', ' + loc.addresses[0].city[0].name;
                                    if (loc.addresses[0].city[0].region[0]) {
                                        addressDetails +=  ' ' + loc.addresses[0].city[0].region[0].abbreviation;
                                    }
                                }
                            }
                            location_options += '<option value="' + loc.id + '">' + loc.name + (addressDetails!==null ? ' - '+addressDetails : '') + '</option>';
                            locations[loc.id] = loc;
                        });

                    jQuery("#locations").append(location_options);
                });

                jQuery("#locations").change(function () {
                    let location_container = jQuery('#location-details');
                    let this_location = locations[this.value];

                    location_container.empty();

                    let location_details = '' +
                        '<div class="location-info">' +
                        '<h2>' + this_location.name + '</h2>' +
                        '<p>' + this_location.addresses[0].address_1 + ', ' + this_location.addresses[0].address_2 + '</p>' +
                        '<p>' + this_location.addresses[0].city[0].name + ', ' + this_location.addresses[0].city[0].region[0].name + ' ' + this_location.addresses[0].zip_postal_code + ', ' + this_location.addresses[0].city[0].region[0].country[0].abbreviation + '</p>' +
                        <?php if($_GET['purpose'] === 'update'): ?>
                        '<p><a href="<?php echo network_admin_url("admin.php?page=network-location-form&action=update_location&form_submission=Update+Location&location_id=");?>' + this_location.id + '" class="button-primary">Update ' + this_location.name + '</a></p>' +
                        '<p><a href="<?php echo network_admin_url("admin.php?page=network-update-location-site-id&location_id=");?>' + this_location.id + '" class="button-primary">Update Site ID for ' + this_location.name + '</a></p>' +
                        <?php endif; ?>
                        <?php if($_GET['purpose'] === 'delete'): ?>
                        '<p><a href="<?php echo network_admin_url("admin.php?page=network-delete-location&location_id=");?>' + this_location.id + '" class="button-primary">Delete ' + this_location.name + '</a></p>' +
                        <?php endif; ?>
                        '</div>';

                    location_container.append(location_details);
                });
            });
        </script>
        <?php
    }

    public static function delete_location()
    {

        $location_id = filter_var($_GET['location_id'], FILTER_SANITIZE_NUMBER_INT);
        $location = CoreFunctions::get_location(null, $location_id);
        ?>

        <h1>Delete this location?</h1>

        <form method="post" action="<?php echo \admin_url('admin-post.php'); ?>">
            <input type="hidden" name="action" value="delete_location">
            <input type="hidden" name="location_id" value="<?php echo $location_id; ?>">

            <?php if ($location->vanity_website_id !== 0 && !empty($location)): ?>
                <label>This location also has a website associated with it.<br/><br/>Yes, I wish to delete the website
                    and the location</label>
                <input type="checkbox" name="delete-site" value="1">
                <br/><br/><br/>
            <?php else: ?>
                <input type="hidden" name="delete-site" value="0">
            <?php endif; ?>

            <input type="submit" value="Delete <?php echo $location->name; ?>" class="button-primary"
                   onclick="return confirm('Are you sure you wish to delete <?php echo $location->name; ?>?  This is a permanent action that cannot be undone.')">
        </form>

        <?php
    }

    public static function update_location_site_id()
    {

        $location_id = filter_var($_GET['location_id'], FILTER_SANITIZE_NUMBER_INT);
        $location = CoreFunctions::get_location(null, $location_id);
        ?>

        <h1>Update Location Site ID - <?php echo $location->name; ?></h1>
        <hr><br>
        <form method="post" action="<?php echo \admin_url('admin-post.php'); ?>">
            <input type="hidden" name="action" value="update_location_site_id">
            <input type="hidden" name="location_id" value="<?php echo $location_id; ?>">

            <input type="text" name="vanity_website_id" value="<?php echo $location->vanity_website_id; ?>">

            <input type="submit" value="Update Site ID" class="button-primary"
                   onclick="return confirm('Are you sure you wish to update the Site ID for <?php echo $location->name; ?>?')">
        </form>

        <?php
    }

}
