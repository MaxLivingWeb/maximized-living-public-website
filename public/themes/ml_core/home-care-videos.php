
<?php
/* Template Name: Home Care Videos */
/**
* The template for displaying the information for home care videos
*
* @link https://codex.wordpress.org/Template_Hierarchy
*
* @package MaxLiving
*/
get_header();

$heroImage = get_template_directory_uri() . "/images/placeholder.jpeg";
if (has_post_thumbnail()) :
    $heroImage = get_the_post_thumbnail_url(get_the_ID(),'full');
endif;

global $youtubeScripts;
$youtubeScripts = true;

?>
<section class="flexHeader bg-faintGrey" id="content">
    <div class="hero wave wave-multi" style="background-image:url('<?php echo $heroImage; ?>');">
        <div class="heroContent centerAlign container container-xs">
            <h1 class="heroHeadline">Information For Patients</h1>
            <p class="heroDescription">
                <span class="icon-lineWave"></span>
            </div>
        </div>
        <div class="flexIntro centerAlign wave wave-white">
            <div class="container">
                <h2>Information For Patients</h2>
                <p>
                    A better chiropractic lifestyle doesn’t start and end in your doctor’s office. There are helpful, healing exercises and routines you can practice at home and in between adjustments. It’s recommended that you wait until after your first adjustment for home care.
                </p>
              </p>
            </div>
        </div>
    </section>
    <div class="flexibleContentWrapper bg-white">
        <section class="flexible-videoCardList flexibleContentItem container">
            <div class="videoList cardContainer cardContainer-leftAlign">
                <div class="videoContainer card card-third card-shadowHover card-underlineHover-brandGrey">
                    <div class="videoPlayer" data-id="8lKG7pAZzbM" data-name="Home Rehabilitation Program Intro"></div>
                    <div class="videoContent">
                        <h3>Home Rehabilitation Program Intro</h3>
                        <p>
                            The specific spinal correction offered in our clinic consists of three vital components: our spinal adjustment procedure, in-clinic rehabilitation and at-home rehabilitation exercises. In the clinic, our doctor and staff will administer your adjustment and guide you through the in-clinic rehabilitation process.
                        </p>
                    </div>
                </div>
                <div class="videoContainer card card-third card-shadowHover card-underlineHover-brandGrey">
                    <div class="videoPlayer" data-id="EB09TxBiu88" data-name="Psoas Lift"></div>
                    <div class="videoContent">
                        <h3>Psoas Lift</h3>
                        <p>
                            This exercise helps open and strengthen the core muscles in your hips, which helps reduce subluxations in your pelvic regions. It also helps strengthen your spine.
                        </p>
                    </div>
                </div>
                <div class="videoContainer card card-third card-shadowHover card-underlineHover-brandGrey">
                    <div class="videoPlayer" data-id="4W5q3t-dOoU" data-name="Upper Shoulder Weight"></div>
                    <div class="videoContent">
                        <h3>Upper Shoulder Weight</h3>
                        <p>
                            This video explains and demonstrates the use of the head weighting system to strengthen and stabilize your cervical spine. This exercise focuses specifically on, and addresses, the cervical subluxation patterns between the neck and mid back.
                        </p>
                    </div>
                </div>
                <div class="videoContainer card card-third card-shadowHover card-underlineHover-brandGrey">
                    <div class="videoPlayer" data-id="AAPiqxxoJSQ" data-name="Alar Ligament Excercise"></div>
                    <div class="videoContent">
                        <h3>Alar Ligament Excercise</h3>
                        <p>
                            This rehab exercise works the muscles just below the base of the skull to strengthen and stabilize the uppermost vertebra in your spine. This video demonstrates the proper form to maintain throughout the exercise.
                        </p>
                    </div>
                </div>
                <div class="videoContainer card card-third card-shadowHover card-underlineHover-brandGrey">
                    <div class="videoPlayer" data-id="1sQt49qVR_s" data-name="Posterior T12"></div>
                    <div class="videoContent">
                        <h3>Posterior T12</h3>
                        <p>
                            This video explains and demonstrates the use of cervical rolls and pelvic support wedges to strengthen and stabilize your thoracic spine. This exercise specifically addresses the thoracic subluxation patterns between the mid and lower back.
                        </p>
                    </div>
                </div>
                <div class="videoContainer card card-third card-shadowHover card-underlineHover-brandGrey">
                    <div class="videoPlayer" data-id="x-hwp0w8xJU" data-name="Decreased Sacral Base Blocking"></div>
                    <div class="videoContent">
                        <h3>Decreased Sacral Base Blocking</h3>
                        <p>
                            This video explains and demonstrates the use of pelvic support wedges to strengthen and stabilize your lumbar spine. This exercise specifically addresses the positioning of the sacrum.
                        </p>
                    </div>
                </div>
                <div class="videoContainer card card-third card-shadowHover card-underlineHover-brandGrey">
                    <div class="videoPlayer" data-id="k8PK9UoA3YU" data-name="Cervical Flexion Exercise"></div>
                    <div class="videoContent">
                        <h3>Cervical Flexion Exercise</h3>
                        <p>
                            This home care exercise focuses on stabilizing and strengthening the vertebrae in your neck. Your neck contains each of the cervical vertebra that give it a natural curve, known as the “arc of life.” Losing the curvature in your neck can damage and deteriorate
                        </p>
                    </div>
                </div>
                <div class="videoContainer card card-third card-shadowHover card-underlineHover-brandGrey">
                    <div class="videoPlayer" data-id="JXntLOOYvC4" data-name="Unpacking Your Head Weights"></div>
                    <div class="videoContent">
                        <h3>Unpacking Your Head Weights</h3>
                        <p>
                            The head weight system helps reestablish the cervical curve in your neck, which is essential to optimizing the function of your entire nervous system. Dr. Tony Nalda explains what is included in the head weight package and how to set the system up for your specific needs.
                        </p>
                    </div>
                </div>
                <div class="videoContainer card card-third card-shadowHover card-underlineHover-brandGrey">
                    <div class="videoPlayer" data-id="aVZf3Uf1Jio" data-name="Cervical Dorsal Exercise"></div>
                    <div class="videoContent">
                        <h3>Cervical Dorsal Exercise</h3>
                        <p>
                            This simple home care exercise is vital to stabilizing your cervical spine. It will help repair the shift and irregularities—known as subluxations—in your neck bones.
                        </p>
                    </div>
                </div>
                <div class="videoContainer card card-third card-shadowHover card-underlineHover-brandGrey">
                    <div class="videoPlayer" data-id="KaLuaaCAdTM" data-name="Chest Expander Exercise"></div>
                    <div class="videoContent">
                        <h3>Chest Expander Exercise</h3>
                        <p>
                            The chest expander exercise is used to correct subluxations in the upper thoracic and lower cervical spine. We’ll teach you the proper form to hold for 60 seconds to successfully and safely complete this exercise.
                        </p>
                    </div>
                </div>
                <div class="videoContainer card card-third card-shadowHover card-underlineHover-brandGrey">
                    <div class="videoPlayer" data-id="4aWyIiSp954" data-name="Praying Mantis Exercise"></div>
                    <div class="videoContent">
                        <h3>Praying Mantis Exercise</h3>
                        <p>
                            This torso stretching exercise focuses on strengthening your thoracic spine. For maximum effect, hold this position for 60 seconds.
                        </p>
                    </div>
                </div>
                <div class="videoContainer card card-third card-shadowHover card-underlineHover-brandGrey">
                    <div class="videoPlayer" data-id="94ea-uTSGt4" data-name="Traction Unit"></div>
                    <div class="videoContent">
                        <h3>Traction Unit</h3>
                        <p>
                            This exercise is essential to removing abnormalities in the cervical spine as well as preventing degeneration of the vertebrae in your neck. Dr. Tony Nalda demonstrates how to safely use the cervical traction door unit.
                        </p>
                    </div>
                </div>
                <div class="videoContainer card card-third card-shadowHover card-underlineHover-brandGrey">
                    <div class="videoPlayer" data-id="L3WRj5Sv67g" data-name="Putting On the Head Weight"></div>
                    <div class="videoContent">
                        <h3>Putting On the Head Weight</h3>
                        <p>
                            The head weight system helps reestablish the cervical curve in your neck, which is essential to optimizing the function of your entire nervous system. Dr. Tony Nalda explains how to properly fit your head weight for at home use.
                        </p>
                    </div>
                </div>
                <div class="videoContainer card card-third card-shadowHover card-underlineHover-brandGrey">
                    <div class="videoPlayer" data-id="Sv5KY_B9BUc" data-name="Psoas Stretch"></div>
                    <div class="videoContent">
                        <h3>Psoas Stretch</h3>
                        <p>
                            This stretch helps open and loosen your hips, which prevents subluxations in your pelvic regions. It also helps strengthen your spine.
                        </p>
                    </div>
                </div>
                <div class="videoContainer card card-third card-shadowHover card-underlineHover-brandGrey">
                    <div class="videoPlayer" data-id="bwQGtcrVFig" data-name="Increased Sacral Base Blocking"></div>
                    <div class="videoContent">
                        <h3>Increased Sacral Base Blocking</h3>
                        <p>
                            This video explains and demonstrates the use of pelvic support wedges to strengthen and stabilize your lumbar spine. This exercise specifically addresses the positioning of the sacrum.
                        </p>
                    </div>
                </div>
                <div class="videoContainer card card-third card-shadowHover card-underlineHover-brandGrey">
                    <div class="videoPlayer" data-id="jrqvIKz5ymw" data-name="Cervical and Lumbar Rolls or Sleep Aids"></div>
                    <div class="videoContent">
                        <h3>Cervical and Lumbar Rolls or Sleep Aids</h3>
                        <p>
                            This video demonstrates the proper use of your sleeping aids in the cervical and lumbar spine. This system of supports helps maintain the necessary natural curves of your spine. At night, your nervous system actually becomes more active. Use your doctor-prescribed supports and wedges to get the most out of every adjustment procedure.
                        </p>
                    </div>
                </div>
                <div class="videoContainer card card-third card-shadowHover card-underlineHover-brandGrey">
                    <div class="videoPlayer" data-id="B7krH_J6tOc" data-name="Wobble Cushion – Posterior T12"></div>
                    <div class="videoContent">
                        <h3>Wobble Cushion – Posterior T12</h3>
                        <p>
                            This video demonstrates how to warm up your spine with a specific exercise that helps to correct the lumbar spine plane. Going through this simple range of motions effectively addresses the subluxation pattern.
                        </p>
                    </div>
                </div>
                <div class="videoContainer card card-third card-shadowHover card-underlineHover-brandGrey">
                    <div class="videoPlayer" data-id="QTyYCbDrrYQ" data-name="Wobble Cushion – LD Focus"></div>
                    <div class="videoContent">
                        <h3>Wobble Cushion – LD Focus</h3>
                        <p>
                            This video will demonstrate how to warm up your spine through a specific exercise to help correct the position of the lumbar spine plane by going through a range of motion to address the subluxation pattern that is simple and super effective.
                        </p>
                    </div>
                </div>
                <div class="videoContainer card card-third card-shadowHover card-underlineHover-brandGrey">
                    <div class="videoPlayer" data-id="uDznQTru_gk" data-name="Wobble Cushion – General"></div>
                    <div class="videoContent">
                        <h3>Wobble Cushion – General</h3>
                        <p>
                            The wobble cushion is an inflatable disc that sits on a chair or table. We’ll demonstrate how to warm up your entire spine through each plane of motion using this simple, yet super effective tool.
                        </p>
                    </div>
                </div>
                <div class="videoContainer card card-third card-shadowHover card-underlineHover-brandGrey">
                    <div class="videoPlayer" data-id="2BwEHFHVvjc" data-name="Wobble Cushion – Anterior T12"></div>
                    <div class="videoContent">
                        <h3>Wobble Cushion – Anterior T12</h3>
                        <p>
                            This video demonstrates how to warm up your spine with a specific exercise that helps to correct the thoracic spine plane. Going through this simple range of motions effectively addresses the subluxation pattern.
                        </p>
                    </div>
                </div>
                <div class="videoContainer card card-third card-shadowHover card-underlineHover-brandGrey">
                    <div class="videoPlayer" data-id="ibFhY-Q206g" data-name="Lumbar Extension"></div>
                    <div class="videoContent">
                        <h3>Lumbar Extension</h3>
                        <p>
                            This exercise targets the lumbar vertebrae in your low back. Perform this exercise properly and you will accentuate the essential curve in your lower spine while stabilizing your lumbar vertebrae.
                        </p>
                    </div>
                </div>
                <div class="videoContainer card card-third card-shadowHover card-underlineHover-brandGrey">
                    <div class="videoPlayer" data-id="x_MebEJvJh4" data-name="CTU Pull"></div>
                    <div class="videoContent">
                        <h3>CTU Pull</h3>
                        <p>
                            This video explains and demonstrates the use of the cervical traction unit to strengthen and stabilize your cervical spine. This exercise focuses specifically on, and addresses, the cervical subluxation patterns between the neck and mid back.
                        </p>
                    </div>
                </div>
                <div class="videoContainer card card-third card-shadowHover card-underlineHover-brandGrey">
                    <div class="videoPlayer" data-id="ds8a8JuJSNw" data-name="L-5 Spondylo Lower Exercise"></div>
                    <div class="videoContent">
                        <h3>L-5 Spondylo Lower Exercise</h3>
                        <p>
                            This lower back exercise targets the lowest verterbra in your spine, or the L5. This is a two-part exercise that helps stabilize the bottom portion of your spine.
                        </p>
                    </div>
                </div>
                <div class="videoContainer card card-third card-shadowHover card-underlineHover-brandGrey">
                    <div class="videoPlayer" data-id="kPNakkTb4x4" data-name="Cervical Extension"></div>
                    <div class="videoContent">
                        <h3>Cervical Extension</h3>
                        <p>
                            This simple exercise helps increase the effectiveness of spinal adjustments targeting your pelvis.We’ll demonstrate the proper technique and form for this exercise, so you can improve the health of your spine.
                        </p>
                    </div>
                </div>
                <div class="videoContainer card card-third card-shadowHover card-underlineHover-brandGrey">
                    <div class="videoPlayer" data-id="C7pOhnvpn-o" data-name="Pelvic Rotation Blocking"></div>
                    <div class="videoContent">
                        <h3>Pelvic Rotation Blocking</h3>
                        <p>
                            This video explains and demonstrates the use of pelvic support wedges to strengthen and stabilize your cervical and lumbar spinal bones. This exercise is essential to maintaining the proper alignment of your spine.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php
get_footer();
