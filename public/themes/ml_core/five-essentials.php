<?php
/* Template Name: 5 Essentials */
/**
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MaxLiving
 */
get_header();
$essentialFooterAppointment = get_home_url().'/locations';
$essentialFooterText = 'Find a Clinic';
if(get_current_blog_id() != 1) {
    $essentialFooterAppointment = get_home_url().'/sign-up';
    $essentialFooterText = 'Request An Appointment';
}

global $smoothScrollScripts;
$smoothScrollScripts = true;

?>
<section class="hero essentialsOverviewHero bg-faintGrey" id="content">
    <div class="heroContent container">
        <p class="heroEssentialAccent link-leftDash">Our Approach</p>
        <h1 class="heroHeadline bigHeading">5 Essentials<span>&trade;</span></h1>
        <p class="heroDescription">
            The first step to living a maximized life is understanding your own health. Our step-by-step plan provides
            you with all of the tools you need to reach your unique lifestyle and wellness goals, naturally.
        </p>
    </div>
    <div class="heroSymbol"></div>
</section>
<section class="bg-faintGrey essentialsIntro wave wave-white">
    <div class="flexible-fullWidth flexibleContentItem container centerAlign">
        <h2>Simplifying Good Health for Life</h2>
        <p>MaxLiving simplifies the many and complex options for finding your personal and natural health and wellness
            plan for life. Our 5 Essentials<sup>&trade;</sup> plan has chiropractic care at the core — your spine is your body’s central
            information highway. Correcting spinal abnormalities maximizes your nerve supply and enhances your body’s
            ability to heal. In addition to core chiropractic, the four other powerful essentials are our unique
            approach on mindset, pure and simple nutrition, exercise and oxygen, and minimizing toxin exposure. On their
            own or in combination – we customize the right balance so you can align your health naturally. Transform
            your health today.
        </p>
    </div>
</section>
<section class="flexible-leftRightContent essentialsSplit flexibleContentItem bg-white">
    <div class="leftRightRow container">
        <div class="contentContainer">
            <div class="content content-left">
                <h2>Lifelong Health Starts with a Trained MaxLiving Chiropractor</h2>
                <p>Your first visit with a MaxLiving chiropractic doctor is focused on assessing your current health and
                    helping you understand how your lifestyle is impacting you. Everyone’s body is different, and each
                    person has unique needs and health challenges — that’s why we help you set realistic health and
                    wellness goals that are customized to you. Some patients simply want to be free from pain and be
                    able to do their day-to-day activities. Others are looking for a way to feel better and look their
                    best, and everyone wants to age well. Our scientifically-based approach to healthcare is based on
                    restoring your body’s natural ability to heal, increasing energy and vitality. The 5 Essentials<sup>&trade;</sup> work
                    because they’re what your body needs for natural wellness, and your MaxLiving Doctor is there to
                    support you every step of the way.
                </p>
            </div>
            <div class="content content-right">
                <div class="card card-shadow">
                    <span class="icon iconTwoTone twoTone-list"></span>
                    <h3>Your 5 Essentials<sup>&trade;</sup> Plan:</h3>
                    <ul>
                        <li>Gives you your own specific plan to good health</li>
                        <li>Fits to your unique wellness and lifestyle goals</li>
                        <li>Is a step-by-step plan that makes your life better for today – and for the future</li>
                        <li>Is continuously supported by your MaxLiving Doctor</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="squiggleDivider"></div>
</section>
<section class="essentials essentials-mainPage essentialsOverviewCards bg-white centerAlign">
    <div class="container">
        <h2>Discover the 5 Essentials<sup>&trade;</sup></h2>
        <p>Understanding your health and how to improve it naturally can be a confusing and complicated process. At
            MaxLiving, we’ve created an innovative approach to make it simple to both understand and implement. The 5
            Essentials<sup>&trade;</sup> provide you with a new way to look at your health that’s focused on helping your body restore its
            own power and performance. It all starts with optimal nerve supply, achieved through core chiropractic
            care.</p>
    </div>
    <div class="essentialsContainer container">

            <div class="card card-fifth card-noBorder core first">
                <a href="#discover-core" class="essentialLink essentialLink-overview"></a>
                <div class="cardContent">
                    <span class="essentialIcon icon-coreSymbol text-brandGrey"></span>
                    <p class="essentialName uppercase">Core Chiropractic</p>
                    <span class="icon-arrowRight text-brandGrey"></span>
                    <div class="essentialContent centerAlign">
                        <div class="content">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/icons/Icon-Arrow-Grey.svg" alt="Thin Grey Arrow Icon Pointing Down">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-fifth card-noBorder nutrition">
                <a href="#discover-nutrition" class="essentialLink essentialLink-overview"></a>
                <div class="cardContent">
                    <span class="essentialIcon icon-nutritionSymbol text-brandGreen"></span>
                    <p class="essentialName uppercase">Nutrition</p><br>
                    <span class="icon-arrowRight text-brandGrey"></span>
                    <div class="essentialContent centerAlign">
                        <div class="content">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/icons/Icon-Arrow-Green.svg" alt="Thin Green Arrow Icon Pointing Down">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-fifth card-noBorder mindset">
                    <a href="#discover-mindset" class="essentialLink essentialLink-overview"></a>
                <div class="cardContent">
                    <span class="essentialIcon icon-mindsetSymbol text-brandOrange"></span>
                    <p class="essentialName uppercase">Mindset</p><br>
                    <span class="icon-arrowRight text-brandGrey"></span>
                    <div class="essentialContent centerAlign">
                        <div class="content">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/icons/Icon-Arrow-Orange.svg" alt="Thin Orange Arrow Icon Pointing Down">
                        </div>
                    </div>
                </div>
            </div>


            <div class="card card-fifth card-noBorder oxygen">
                <a href="#discover-oxygen" class="essentialLink essentialLink-overview"></a>
                <div class="cardContent">
                    <span class="essentialIcon icon-oxygenSymbol text-brandTeal"></span>
                    <p class="essentialName uppercase">Oxygen &amp; Exercise</p>
                    <span class="icon-arrowRight text-brandGrey"></span>
                    <div class="essentialContent centerAlign">
                        <div class="content">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/icons/Icon-Arrow-Teal.svg" alt="Thin Teal Arrow Icon Pointing Down">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-fifth card-noBorder toxins">
                <a href="#discover-toxins" class="essentialLink essentialLink-overview"></a>
                <div class="cardContent">
                    <span class="essentialIcon icon-toxinsSymbol text-brandBrown"></span>
                    <p class="essentialName uppercase">Minimize Toxins</p>
                    <span class="icon-arrowRight text-brandGrey"></span>
                    <div class="essentialContent centerAlign">
                        <div class="content">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/icons/Icon-Arrow-Brown.svg" alt="Thin Brown Arrow Icon Pointing Down">
                        </div>
                    </div>
                </div>
            </div>

    </div>
</section>
<section class="essentialOverviewList">
    <div id="discover-core"
         class="essentialOverviewSection essentialOverviewSection-core bg-icon bg-single-icon bg-single-icon-core smoothScroll">
        <div class="container">
            <div class="essentialCallout">
                <span class="icon icon-coreSymbol"></span>
                <h3>Core Chiropractic</h3>
                <p>The proper function of the nervous system through spinal correction is central to chiropractic care.
                    The spine connects all of the cells, organs, and systems in the body. Improper spinal alignment is
                    common and is caused by physical, chemical, and emotional stress that affects your body every day.
                    Optimizing nerve supply through spinal correction unlocks your body’s natural potential for your
                    best performance and faster healing. A chiropractor will provide you with proper spinal correction
                    and rehabilitation needed for complete correction of the spine and nervous system.
                </p>
                <a href="<?php echo get_home_url().'/five-essentials/core-chiropractic'; ?>">
                    <button class="button">Learn more about Core Chiropractic</button>
                </a>
                <div class="essentialCutout"></div>
            </div>
        </div>
    </div>
    <div id="discover-mindset"
         class="essentialOverviewSection essentialOverviewSection-mindset bg-icon bg-single-icon bg-single-icon-mindset smoothScroll">
        <div class="container">
            <div class="essentialCallout">
                <span class="icon icon-mindsetSymbol"></span>
                <h3>Mindset</h3>
                <p>A healthy body starts with the right mindset. We’ll start with understanding where you are today to
                    help you build a new mindset about health, wellness, and healing. We believe a healthy lifestyle
                    supports nutrients for optimal brain function, stress management, and good sleep patterns. We’re
                    here to support you in creating and following a new lifestyle plan.

                </p>
                <a href="<?php echo get_home_url().'/five-essentials/mindset'; ?>">
                    <button class="button">Learn more about Mindset</button>
                </a>
                <div class="essentialCutout"></div>
            </div>
        </div>
    </div>
    <div id="discover-nutrition"
         class="essentialOverviewSection essentialOverviewSection-nutrition bg-icon bg-single-icon bg-single-icon-nutrition smoothScroll">
        <div class="container">
            <div class="essentialCallout">
                <span class="icon icon-nutritionSymbol"></span>
                <h3>Nutrition</h3>
                <p>You are what you eat – what you put into your body affects not only how your body functions, but how
                    you feel every day. Our nutritional assessments help you understand your current nutritional
                    baseline to create a plan for your body’s specific nutritional needs. Nutrition goes beyond weight
                    loss — a healthy diet focused on natural foods improves your body’s composition and muscle-to-fat
                    ratio, helping you achieve better health overall to last a lifetime.
                </p>
                <a href="<?php echo get_home_url().'/five-essentials/nutrition'; ?>">
                    <button class="button">Learn more about Nutrition
                    </button>
                </a>
                <div class="essentialCutout"></div>
            </div>
        </div>
    </div>
    <div id="discover-oxygen"
         class="essentialOverviewSection essentialOverviewSection-oxygen bg-icon bg-single-icon bg-single-icon-oxygen smoothScroll">
        <div class="container">
            <div class="essentialCallout">
                <span class="icon icon-oxygenSymbol"></span>
                <h3>Oxygen &amp; Exercise</h3>
                <p>Exercise helps your body increase oxygen levels and lean muscle, helping reduce fat and improve
                    performance while increasing your ability to fight stress, anxiety, and other illnesses. Our
                    scientifically-based exercise programs incorporate interval training and are designed to be quick
                    and easy to fit into your life. Combined with the rest of the 5 Essentials<sup>&trade;</sup>, regular exercise will
                    supercharge your ability to enjoy your life and do the things you want to do.
                </p>
                <a href="<?php echo get_home_url().'/five-essentials/oxygen-and-exercise'; ?>">
                    <button class="button">Learn more about Oxygen &amp; Exercise</button>
                </a>
                <div class="essentialCutout"></div>
            </div>
        </div>
    </div>
    <div id="discover-toxins"
         class="essentialOverviewSection essentialOverviewSection-toxins bg-icon bg-single-icon bg-single-icon-toxins smoothScroll">
        <div class="container">
            <div class="essentialCallout">
                <span class="icon icon-toxinsSymbol"></span>
                <h3>Minimize Toxins</h3>
                <p>Harmful chemicals surround us every day in our lives — our program supports the body’s natural
                    ability to cleanse itself, resulting in long-lasting positive effects. We’ll also provide you with
                    strategies to create new lifestyle habits to minimize your exposure. Good health and longevity
                    depends on regaining your body’s natural balance and helping it detoxify itself.
                </p>
                <a href="<?php echo get_home_url().'/five-essentials/minimize-toxins'; ?>">
                    <button class="button">Learn more about Minimize Toxins</button>
                </a>
                <div class="essentialCutout"></div>
            </div>
        </div>
    </div>
    <div class="flexible-contentEssentialIcon aboutFooter container centerAlign">
        <div class="contentContainer">
            <div class="borderTextDivider essentialsOverviewDivider">
                <span class="borderText border-brandGrey">Appointments</span>
            </div>
            <ul class="iconsList" aria-hidden="true">
                <li class="brandIcon icon-coreSymbol"></li>
                <li class="brandIcon icon-nutritionSymbol"></li>
                <li class="brandIcon icon-mindsetSymbol"></li>
                <li class="brandIcon icon-oxygenSymbol"></li>
                <li class="brandIcon icon-toxinsSymbol"></li>
            </ul>
            <h2 class="title">Start Your Journey</h2>
            <p class="content">MaxLiving helps you rebuild your body and correct your spinal alignment, resulting in
                unlimited positive changes to
                your health. We are here to improve your life — <br><strong>make an appointment with MaxLiving
                    today.</strong></p>
            <a class="button button-secondary" href="<?php echo $essentialFooterAppointment;?>" title="<?php echo $essentialFooterText;?>"><?php echo $essentialFooterText;?></a>
        </div>
    </div>
</section>
<?php
get_footer();
?>
