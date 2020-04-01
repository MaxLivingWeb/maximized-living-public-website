<?php

/* Template Name: Essential - Core Chiropractic */
/**
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MaxLiving
 */
get_header();

get_template_part('template-parts/five-essential-button');

$footerStyleTitle = "core";
?>

    <section class="hero essentialsHero essentialsHero-core" id="content">
        <div class="heroContent container">
            <p class="heroEssentialAccent link-leftDash">5 Essentials<span>&trade;</span></p>
            <h1 class="heroHeadline bigHeading">Core Chiropractic</h1>
            <p class="heroDescription">Achieving lifelong health and wellness starts with <br>chiropractic care.</p>
        </div>
        <div class="heroCutout"></div>
    </section>
    <section class="essentialsIntroSection bg-faintGrey">
        <div class="essentialIntro flexible-fullWidth centerAlign container">
            <h2 class="title">Chiropractic Care — It’s Central to Your Health</h2>
            <div class="description">
                <p>
                    Spinal correction is at the core of chiropractic care — your spine is your body’s central information highway. Proper spinal alignment aids in maximizing nerve supply. This is important to maintaining effective nervous system function and unlocks the body’s natural potential for optimal health and improved physical ability.
                </p>
            </div>
            <span class="icon-coreSymbol brandIcon brandIcon-large brandIcon-single"></span>
        </div>
        <div class="wave wave-white"></div>
        <div class="essentialIntroSplit flexible-contentWithImage bg-white">
            <div class="container">
                <div class="contentRow">
                    <div class="contentContainer">
                        <h3 class="title">The Central Nervous System and Your Health</h3>
                        <div class="content">
                            <p>
                                Your spine is the core for all of your body’s functions. The spine is a key element to optimal health as it protects your central nervous system — the system that connects your entire body, helping it to communicate and react to daily factors. Improper spinal alignment is common and can be caused by both physical and emotional challenges. Spinal misalignment diminishes nerve supply and weakens the body. Aligning your spine and correcting abnormalities caused by stress or injury maximizes your nerve supply and clears pathways to optimize wellness. By enhancing nerve supply through spinal correction, the body’s systems can naturally interact and integrate without interference.</p>
                        </div>
                    </div>
                    <div class="imageContainer">
                        <div class="imageContent bg-image" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/2-2-1_OurApproach_CoreChiropractic_Image1.jpg');">
                            <img class="image" src="<?php echo get_template_directory_uri(); ?>/images/2-2-1_OurApproach_CoreChiropractic_Image1.jpg" alt="Core Chiropractic">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="essentialDetail flexible-introWithAlternatingContent bg-single-icon bg-single-icon-core">
        <div class="container">
            <div class="intro centerAlign">
                <h2 class="introTitle">A Focus on Chiropractic Care</h2>
                <p class="introContent">
                    With a focus on spinal alignment, chiropractic care becomes an essential approach to natural wellness, assisting in your body’s ability to achieve optimal health. Our highly trained team is here to help you achieve your goals.</p>
                <span class="introDivider icon-lineWave"></span>
            </div>
            <div class="contentRow">
                <div class="imageContainer">
                    <div class="imageContent bg-image" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/2-2-1_OurApproach_Core_Image2.jpg');">
                        <img class="image" src="<?php echo get_template_directory_uri(); ?>/images/2-2-1_OurApproach_Core_Image2.jpg" alt="Focus on Chiropractic">
                    </div>
                </div>
                <div class="contentContainer">
                    <h3 class="title">Benefits</h3>
                    <div class="content">
                        <ul>
                            <li>Identify misalignment</li>
                            <li>Help remove interference</li>
                            <li>Allow for better communication in the body</li>
                            <li>Promote overall wellness</li>
                        </ul>
                    </div>
                    <?php echo $fiveEssentialButton; ?>
                </div>
            </div>
        </div>
    </section>
    <section class="essentialCards flexible-fullWidthCards bg-faintGrey">
        <div class="flexible-fullWidth centerAlign container">
            <h2 class="borderText border-brandGrey">Treatment</h2>
            <h3 class="title">Treatment and Prevention through Spinal Correction</h3>
            <div class="description">
                <p>
                    Our approach to healthcare is based on restoring your body’s natural ability to heal, increasing energy and vitality. It’s important to find a chiropractic doctor who is trained in the detection and correction of spinal abnormalities. A chiropractor will support you with proper spinal alignment and rehabilitation that’s necessary for continued correction of the spine and optimization of the nervous system. Your MaxLiving doctor can also provide you with homecare kits to guide your spinal correction efforts at home. You may come to us to solve one problem, but the goal of the 5 Essentials<sup>&trade;</sup> is greater than that. MaxLiving doctors bring the expertise gained through our work with thousands of people to your daily health challenges. Our care plans start with an in-depth assessment of your overall spinal alignment and health.
                </p>
            </div>
        </div>
        <div class="cardContainer container container-sm">
            <div class="card card-shadow card-noBorder centerAlign card-half">
                <h3>Long-Term Spinal Correction</h3>
                <p>We focus on long-term spinal correction to eliminate or reduce the root cause of your health problems.</p>
            </div>
            <div class="card card-shadow card-noBorder centerAlign card-half">
                <h3>Underlying Issues</h3>
                <p>We address underlying issues building beneath the surface before they negatively affect your well-being.</p>
            </div>
        </div>
    </section>
    <div class="wave wave-white bg-faintGrey"></div>


    <section class="essentialNext centerAlign">
        <h2 class="borderText border-<?php echo $footerStyleTitle; ?>">5 Essentials<sup>&trade;</sup></h2>
        <h3>Discover The Next Essential</h3>
        <div class="essentialNextContent">
            <div class="nextImage nextImage-nutrition">
                <a href="<?php echo get_home_url().'/five-essentials/nutrition'; ?>"
                   title="Learn more about Nutrition" class="nextEssentialImageLink">
                    <span class="invisible" aria-hidden="true">5 Essentials: Nutrition</span>
                </a>
                <div class="nextLink">
                    <a href="<?php echo get_home_url().'/five-essentials/nutrition'; ?>" class="link-leftDash uppercase"
                       title="Learn more about Nutrition">Nutrition</a>
                </div>
            </div>
        </div>
    </section>
<?php
get_footer();
