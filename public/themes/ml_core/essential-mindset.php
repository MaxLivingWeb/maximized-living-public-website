<?php

/* Template Name: Essential - Mindset */
/**
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MaxLiving
 */
get_header();

get_template_part('template-parts/five-essential-button');

$footerStyleTitle = "mindset";
?>

    <section class="hero essentialsHero essentialsHero-mindset" id="content">
        <div class="heroContent container">
            <p class="heroEssentialAccent link-leftDash">5 Essentials<span>&trade;</span></p>
            <h1 class="heroHeadline bigHeading">Mindset</h1>
            <p class="heroDescription">
                We’re here to support you in creating new, healthy habits for life.
            </p>
        </div>
        <div class="heroCutout"></div>
    </section>
    <section class="essentialsIntroSection bg-faintGrey">
        <div class="essentialIntro flexible-fullWidth centerAlign container">
            <h2 class="title">Mind Over Matter, Naturally</h2>
            <div class="description">
                <p>
                    It is your mindset that will ultimately influence your success. With any lifestyle change, the right
                    attitude can spell success or failure. We help you find a new mindset about health, wellness, and
                    healing that is needed to begin and follow a new lifestyle plan. </p>
            </div>
            <span class="icon-mindsetSymbol brandIcon brandIcon-large brandIcon-single"></span>
        </div>
        <div class="wave wave-white"></div>
        <div class="essentialIntroSplit flexible-contentWithImage bg-white">
            <div class="container">
                <div class="contentRow">
                    <div class="contentContainer">
                        <h3 class="title">A Lifestyle Approach that Works</h3>
                        <div class="content">
                            <p>

                                The pressures of our busy, connected lives result in increased stress, anxiety,
                                sleeplessness, and mental health disorders. <a
                                        href="https://www.npr.org/2016/09/08/493157917/federal-survey-finds-119-million-americans-use-prescription-drugs"
                                        target="_blank">Nearly half of us over the age of 12</a> take prescription pain
                                relievers, tranquilizers, sedatives, or stimulants. Often, these are used improperly. We
                                believe that traditional medicine doesn’t look at the root of health problems and
                                focuses on reacting – rather than being proactive. We take the time to understand your
                                challenges and can create a plan that works to improve healthy brain function and
                                emotional wellness.

                            </p>
                        </div>
                    </div>
                    <div class="imageContainer">
                        <div class="imageContent bg-image"
                             style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/2-2-3_OurApproach_Mindset_Image1.jpg');">
                            <img class="image" src="<?php echo get_template_directory_uri(); ?>/images/2-2-3_OurApproach_Mindset_Image1.jpg"
                                 alt="Core Chiropractic">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="essentialDetail flexible-introWithAlternatingContent bg-single-icon bg-single-icon-mindset">
        <div class="container">
            <div class="intro centerAlign">
                <h2 class="introTitle">Commit Your Mind to a New Lifestyle</h2>
                <div class="introContent">
                    <p>
                        Your body has the natural potential to sustain health and wellness when it’s functioning at its
                        fullest potential. However, problems like trauma, poor lifestyle, or issues with your spine and
                        nervous system can interfere with your body’s normal function. This limits your ability to reach
                        optimal physical, mental, and social well-being. Your health should be your first priority and
                        it’s critical to do all you can to help your body fight disease and illness naturally.
                    </p>
                </div>
                <span class="introDivider icon-lineWave"></span>
            </div>
            <div class="contentRow">
                <div class="imageContainer">
                    <div class="imageContent bg-image"
                         style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/2-2-3_OurApproach_Mindset_Image2.jpg');">
                        <img class="image" src="<?php echo get_template_directory_uri(); ?>/images/2-2-3_OurApproach_Mindset_Image2.jpg"
                             alt="Focus on Chiropractic">
                    </div>
                </div>
                <div class="contentContainer">
                    <h3 class="title">Benefits</h3>
                    <div class="content">
                        <p>
                            MaxLiving focuses on areas like improving your relationships with others, time and stress
                            management, and making sure that you form healthy sleeping habits. We’ll help you create new
                            lifestyle habits that support healthy brain function, good mental health, and neurological
                            nutrients. Working on all of these facets of your life helps to improve your attitude and
                            help your overall peace and well-being.
                        </p>
                    </div>
                    <?php echo $fiveEssentialButton; ?>
                </div>
            </div>
        </div>
    </section>
    <section class="essentialNext centerAlign">
        <h2 class="borderText border-<?php echo $footerStyleTitle; ?>">5 Essentials<sup>&trade;</sup></h2>
        <h3>Discover The Next Essential</h3>
        <div class="essentialNextContent">
            <div class="nextImage nextImage-oxygen">
                <a href="<?php echo get_home_url().'/five-essentials/oxygen-and-exercise'; ?>"
                   title="Learn more about Oxygen and Exercise" class="nextEssentialImageLink">
                    <span class="invisible" aria-hidden="true">5 Essentials: Oxygen and Exercise</span>
                </a>
                <div class="nextLink">
                    <a href="<?php echo get_home_url().'/five-essentials/oxygen-and-exercise'; ?>" class="link-leftDash uppercase"
                       title="Learn more about Oxygen and Exercise">Oxygen and Exercise</a>
                </div>
            </div>
        </div>
    </section>

<?php
get_footer();
