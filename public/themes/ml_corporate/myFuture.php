<?php
/* Template Name: Corporate - My Future Page */
/**
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MaxLiving
 */
global $promoScripts;
global $smoothScrollScripts;
global $blankHeader;
global $simpleFooter;
$promoScripts = true;
$smoothScrollScripts = true;
$blankHeader = true;
$simpleFooter = true;

get_header();
?>

<section class="myFutureHero bg-faintGrey">
    <div class="container">
        <a id="myFutureCTA" href="#myFutureForm" class="smoothScroll">Get more info</a>
        <div class="myFutureHeroTitle">
            <h1>Own your future.</h1>
        </div>
        <div class="myFutureHeroFormContainer">
            <div class="myFutureHeroFormIntro">
                <h2>Get more info.</h2>
                <p>
                    Interested in MaxLiving? Let us know! You’ll automatically be entered to win a three-night stay at the Hyatt Regency in Denver, CO for the <a href="https://maxliving.com/events/mlx-transform-chiropractic-continuing-education-conference" target="_blank"><strong>MLX&nbsp;Transform</strong></a> conference June 6 through 8.
                </p>
            </div>

            <?php echo do_shortcode('[contact-form-7 id="2703" title="My Future"]') ?>
        </div>
    </div>
</section>
<section class="myFutureWhyMaxliving bg-brandGrey wave wave-white">
    <div class="flexible-fullWidth text-white centerAlign container">
        <h2 class="title">Why MaxLiving?</h2>
        <div class="description">
            <p>
                We’re transforming lives across North America and changing the future of chiropractic. Our natural approach to wellness has helped
                hundreds of thousands of people across the globe better understand and manage their health now to keep them healthy long-term.
            </p>
        </div>
    </div>
</section>
<section class="essentials bg-white centerAlign">
    <div class="container discoverEssentials">
        <h2>Discover the 5 Essentials<sup>&trade;</sup></h2>
        <p>
            We believe there are 5 Essentials™ to good health — chiropractic care, pure and simple nutrition, the right mindset, exercise and oxygen,
            and minimizing toxin exposure. Our natural, holistic lifestyle approach has been adopted by some of the most successful chiropractors in
            the country, transforming the lives of chiropractors and their patients since 1998.
        </p>
    </div>
    <div class="essentialsContainer container">
        <div class="card card-fifth card-noBorder core">
            <div class="cardContent">
                <span class="essentialIcon icon-coreSymbol text-brandGrey"></span>
                <h3 class="essentialName uppercase">Core Chiropractic</h3>
                <div class="essentialContent centerAlign">
                    <div class="content">
                        <p>The proper function of the nervous system through spinal correction is central to
                            chiropractic care.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-fifth card-noBorder nutrition">
            <div class="cardContent">
                <span class="essentialIcon icon-nutritionSymbol text-brandGreen"></span>
                <h3 class="essentialName uppercase">Nutrition</h3>
                <div class="essentialContent centerAlign">
                    <div class="content">
                        <p>Nutrition goes beyond weight loss — a healthy diet focused on natural foods improves your
                            body's composition and muscle-to-fat ratio, helping you achieve better health overall to
                            last a lifetime.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-fifth card-noBorder mindset">
            <div class="cardContent">
                <span class="essentialIcon icon-mindsetSymbol text-brandOrange"></span>
                <h3 class="essentialName uppercase">Mindset</h3>
                <div class="essentialContent centerAlign">
                    <div class="content">
                        <p>A healthy body starts with the right mindset. We believe a healthy lifestyle supports
                            nutrients for optimal brain function, stress management, and good sleep patterns.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-fifth card-noBorder oxygen">
            <div class="cardContent">
                <span class="essentialIcon icon-oxygenSymbol text-brandTeal"></span>
                <h3 class="essentialName uppercase">Oxygen &amp; Exercise</h3>
                <div class="essentialContent centerAlign">
                    <div class="content">
                        <p>Exercise helps your body increase oxygen levels and lean muscle, helping reduce fat and
                            improve performance while increasing your ability to fight stress, anxiety, and other
                            illnesses.</p>
                    </div>
                </div>
            </div>

        </div>
        <div class="card card-fifth card-noBorder toxins">
            <div class="cardContent">
                <span class="essentialIcon icon-toxinsSymbol text-brandBrown"></span>
                <h3 class="essentialName uppercase">Minimize Toxins</h3>
                <div class="essentialContent centerAlign">
                    <div class="content">
                        <p>Minimize Toxins: Harmful chemicals surround us every day in our lives — our program
                            supports the body's natural ability to cleanse itself, resulting in long-lasting
                            positive effects.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="flexible-contentWithImage flexibleContentItem bg-single-icon bg-single-icon-white bg-single-icon-core">
    <div class="container myFuture-flexibleContainer">
        <div class="contentRow">
            <div class="contentContainer">
                <h3 class="title">Join our Network of Chiropractors</h3>
                <div class="content">
                    <p>
                        With <strong>257% more weekly patient visits</strong> than the chiropractic national average, we’re transforming the future of natural,
                        holistic healthcare. From opening your own franchise to professional coaching and business support, MaxLiving offers a turnkey approach
                        to building a successful practice.
                    </p>
                    <ul>
                        <li>
                            Better patient results through professionally developed marketing materials for 12–15 research-based educational workshops annually.
                        </li>
                        <li>
                            Access to affordable and results-driven web and marketing support to bring new patients into your clinic — with minimal work required by you!
                        </li>
                        <li>
                            Personal and professional development and practice support from successful MaxLiving chiropractors plus training and support for CAs.
                        </li>
                        <li>
                            Access to premium patient education through exclusive in-office streaming updated monthly.
                        </li>
                    </ul>
                </div>
            </div>
            <div class="imageContainer">
                <div class="imageContent bg-image myFuture-imageZoom"
                     style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/MyFuture_BodyImage1.png');">
                </div>
            </div>
        </div>

        <div class="contentRow">
            <div class="contentContainer">
                <h3 class="title">Ensure Patients Receive High-Quality Supplements</h3>
                <div class="content">
                    <p>
                        Offer MaxLiving’s high-quality vitamins and supplements to your patients and earn additional revenue for your clinic.
                        These supplements are designed by chiropractors for chiropractic patients, reflecting our commitment to providing only
                        the best in natural health care.
                    </p>
                    <ul>
                        <li>
                            Health centers average $80K in additional revenue annually from MaxLiving supplement and resource sales.
                        </li>
                        <li>
                            Your clinic becomes a one-stop-shop for your patients to enhance their wellness journey.
                        </li>
                        <li>
                            Receive supportive product education from MaxLiving that aligns with chiropractic values.
                        </li>
                        <li>
                            Help your patients reach their full potential with products that go beyond their in-clinic visits.
                        </li>
                    </ul>
                </div>
            </div>
            <div class="imageContainer">
                <div class="imageContent bg-image"
                     style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/MyFuture_BodyImage2.jpg');">
                </div>
            </div>
        </div>

        <div class="contentRow">
            <div class="contentContainer">
                <h3 class="title">Attend Chiropractic Events</h3>
                <div class="content">
                    <p>
                        Join us at our series of energetic and inspirational seminars for chiropractic professionals. They feature
                        passionate world-class speakers from across the field and industry leaders hosting specialized training
                        sessions to support the continued growth of the profession.
                    </p>
                    <ul>
                        <li>
                            Participate in intensive training for, DCs, CAs and Office Managers.
                        </li>
                        <li>
                            Earn continuing education credits delivered by world-class chiropractors.
                        </li>
                        <li>
                            Learn about MaxLiving’s holistic approach to wellness through the 5 Essentials™.
                        </li>
                        <li>
                            Attend practical workshops and classes on all the latest chiropractic techniques and research.
                        </li>
                    </ul>
                </div>
            </div>
            <div class="imageContainer">
                <div class="imageContent bg-image"
                     style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/MyFuture_BodyImage3.jpg');">
                </div>
            </div>
        </div>

        <div class="contentRow">
            <div class="contentContainer">
                <h3 class="title">Go from Class to Clinic with MaxU</h3>
                <div class="content">
                    <p>
                        MaxU brings together chiropractic students to educate, inspire, and empower them to reach their
                        full potential. MaxU opens the door for multiple career opportunities, including associate positions,
                        business owners, and future coaching clients.
                    </p>
                    <ul>
                        <li>
                            Get support on opening, building, and growing a successful business.
                        </li>
                        <li>
                            Free access to North America’s top chiropractic doctors and in-office mentorship opportunities.
                        </li>
                        <li>
                            Obtain your Nutrition Certification and Spinal Corrective Process Certification.
                        </li>
                        <li>
                            Graduates can choose between three different tracks — become an associate, open a MaxLiving Health Center, or become a MaxLiving Partner.
                        </li>
                    </ul>
                </div>
            </div>
            <div class="imageContainer">
                <div class="imageContent bg-image"
                     style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/MyFuture_BodyImage4.png');">
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
