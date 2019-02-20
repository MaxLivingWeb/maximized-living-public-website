<?php

/* Template Name: Essential - Nutrition */
/**
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MaxLiving
 */
get_header();

get_template_part('template-parts/five-essential-button');

$footerStyleTitle = "nutrition";
?>

    <section class="hero essentialsHero essentialsHero-nutrition" id="content">
        <div class="heroContent container">
            <p class="heroEssentialAccent link-leftDash">5 Essentials<span>&trade;</span></p>
            <h1 class="heroHeadline bigHeading">Nutrition</h1>
            <p class="heroDescription">We focus on understanding your body’s specific nutritional needs <br>to create a
                plan
                that works for you.</p>
        </div>
        <div class="heroCutout"></div>
    </section>
    <section class="essentialsIntroSection bg-faintGrey">
        <div class="essentialIntro flexible-fullWidth centerAlign container">
            <h2 class="title">Nutrition, Pure and Simple</h2>
            <div class="description">
                <p>
                    A diet that focuses on natural whole foods sustains your mental and physical well-being, aids in
                    disease prevention, and helps you maintain an ideal weight. Our nutritional assessments help to
                    create an outline of your unique needs for energy, resilience, immunity, and overcoming or
                    preventing illness.
                </p>
            </div>
            <span class="icon-nutritionSymbol brandIcon brandIcon-large brandIcon-single"></span>
        </div>
        <div class="wave wave-white"></div>
        <div class="essentialIntroSplit flexible-contentWithImage bg-white">
            <div class="container">
                <div class="contentRow">
                    <div class="contentContainer">
                        <h3 class="title">Good Nutrition for a Healthier Life</h3>
                        <div class="content">
                            <p>
                                The 5 Essentials<sup>&trade;</sup> are built on the principle that a healthy diet sustains well-being,
                                maintains an ideal weight, and helps prevent disease. We know that what we eat affects
                                how we feel and <a
                                        href="http://www.who.int/dietphysicalactivity/publications/trs916/summary/en/"
                                        target="_blank">can contribute to diseases</a> like diabetes, heart and stroke,
                                and cancer. Diets that are high in grains and <a
                                        href="https://www.health.harvard.edu/blog/eating-too-much-added-sugar-increases-the-risk-of-dying-with-heart-disease-201402067021"
                                        target="_blank">sugars</a>, have pH or omega-3 imbalances, or are nutrient
                                deficient all have negative effects on your body. Unhealthy diets <a
                                        href="https://cspinet.org/eating-healthy/why-good-nutrition-important"
                                        target="_blank">can cause disease</a>, illnesses, and other symptoms. MaxLiving
                                knows that every person is different, so we focus on rethinking our modern diet and
                                understanding how changes in what we eat are directly tied to today’s health challenges.
                                This plan actually makes eating smarter easier, not harder, by rethinking fats,
                                proteins, and carbohydrates. We use nutritional science and focus on whole, natural
                                foods to shape a diet that will help you reach your wellness goals. </p>
                        </div>
                    </div>
                    <div class="imageContainer">
                        <div class="imageContent bg-image"
                             style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/2-2-2_OurApproach_Nutrition_Image1.jpg');">
                            <img class="image"
                                 src="<?php echo get_template_directory_uri(); ?>/images/2-2-2_OurApproach_Nutrition_Image1.jpg"
                                 alt="Core Chiropractic">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="essentialDetail flexible-introWithAlternatingContent bg-single-icon bg-single-icon-nutrition">
        <div class="container">
            <div class="intro centerAlign">
                <h2 class="introTitle">Nutritional Assessments</h2>
                <p class="introContent">
                    With an abundance of information (and misinformation) about nutrition, we set out to design a way
                    that people can easily understand and change their habits for lifelong health. Your MaxLiving team
                    will begin with a customized assessment to evaluate your current nutritional baseline, identifying
                    your body’s unique needs. We use this information to shape a nutrition plan that works for you.
                </p>
                <span class="introDivider icon-lineWave"></span>
            </div>
            <div class="contentRow">
                <div class="imageContainer">
                    <div class="imageContent bg-image"
                         style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/2-2-2_OurApproach_Nutrition_Image2.jpg');">
                        <img class="image"
                             src="<?php echo get_template_directory_uri(); ?>/images/2-2-2_OurApproach_Nutrition_Image2.jpg"
                             alt="Focus on Chiropractic">
                    </div>
                </div>
                <div class="contentContainer">
                    <h3 class="title">Benefits</h3>
                    <div class="content">
                        <ul>
                            <li>Our nutritional assessments help to create a plan of your unique needs for energy,
                                resilience, immunity, and overcoming or preventing illness.
                            </li>
                            <li>Assessments use solid data – not a fad diet – as a plan for eating better and
                                determining what nutritional supplements you really do or do not need.
                            </li>
                            <li>We focus on helping you to understand and solve your body’s specific nutritional
                                needs.
                            </li>
                        </ul>
                    </div>
                    <?php echo $fiveEssentialButton; ?>
                </div>
            </div>
        </div>
    </section>
    <section class="essentialCards flexible-fullWidthCards bg-faintGrey">
        <div class="flexible-fullWidth centerAlign container">
            <h2 class="borderText border-brandGreen">Programs</h2>
            <h3 class="title">Nutritional Programs for Your Personal Goals</h3>
            <div class="description">
                <p>
                    MaxLiving’s nutritional programs go beyond weight loss — they aim to improve your body’s
                    composition, helping increase the body’s muscle-to-fat ratio. We approach nutrition with a focus on
                    science and eating natural, whole food. Our nutritional programs fit any need — from those looking
                    to lose weight to high-intensity, performance-focused athletes wanting to take their training to the
                    next level. The best part about it? Natural food is good to eat and easy to prepare. Our recipes are
                    designed to give you the best health benefits without sacrificing freshness or flavor.
                </p>
            </div>
        </div>
        <div class="cardContainer container container-sm">
            <div class="card card-shadow card-noBorder centerAlign card-half">
                <h3>Core Plan</h3>
                <p>
                    The Core Plan is focused on helping you rethink your diet and understanding how it impacts your
                    health. It outlines the basics of a healthy diet, including:

                <ul class="card-list">
                    <li>Eating more healthy fats while eliminating all damaged fats</li>
                    <li>Choosing naturally raised animal proteins</li>
                    <li>Selecting whole over refined carbohydrates</li>
                    <li>Opting for fruits and vegetables over refined grains and sugars</li>
                </ul>
                </p>
            </div>
            <div class="card card-shadow card-noBorder centerAlign card-half">
                <h3>Advanced Plan</h3>
                <p>
                    The Advanced Plan expands on the core plan to help address a wide range of health and metabolic
                    challenges including:
                <ul class="card-list">
                    <li>Cognitive dysfunctions including ADD/ADHD and Autism Spectrum Disorders</li>
                    <li>Metabolic syndromes including obesity, high cholesterol, high triglycerides, high/low blood
                        sugar, high insulin, high blood pressure, heart disease, and/or high leptin
                    </li>
                    <li>Modern-day illnesses including Chronic Fatigue Syndrome, toxicity, fibromyalgia</li>
                    <li>Immune system and inflammatory diseases including cancer, autoimmune diseases, digestive
                        dysfunction, intolerance to grains, asthma, and arthritis
                    </li>
                </ul>
                </p>
            </div>
        </div>
    </section>
    <div class="wave wave-white bg-faintGrey"></div>

    <section class="essentialNext centerAlign">
        <h2 class="borderText border-<?php echo $footerStyleTitle; ?>">5 Essentials<sup>&trade;</sup></h2>
        <h3>Discover The Next Essential</h3>
        <div class="essentialNextContent">
            <div class="nextImage nextImage-mindset">
                <a href="<?php echo get_home_url().'/five-essentials/mindset'; ?>"
                   title="Learn more about Mindset" class="nextEssentialImageLink">
                    <span class="invisible" aria-hidden="true">5 Essentials: Mindset</span>
                </a>
                <div class="nextLink">
                    <a href="<?php echo get_home_url().'/five-essentials/mindset'; ?>" class="link-leftDash uppercase"
                       title="Learn more about Mindset">Mindset</a>
                </div>
            </div>
        </div>
    </section>

<?php
get_footer();
