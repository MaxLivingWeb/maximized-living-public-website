<?php
global $blog_id;
$createURL = admin_url('admin.php?page=create-content');
$createEvent = admin_url('post-new.php?post_type=event');
$createRecipe = admin_url('post-new.php?post_type=recipe');
$draftRecipe = admin_url('edit.php?post_type=recipe&post_status=draft');
$createArticle = admin_url('post-new.php?post_type=article');
$draftArticle = admin_url('edit.php?post_type=article&post_status=draft');
$locationURL = admin_url('admin.php?page=location-details');
$manageHome = admin_url('admin.php?page=clinic-home-page-options');
$manageTeam = admin_url('admin.php?page=our-team-page-options');
$manageFooter = admin_url('admin.php?page=footer-options');
$managePatientPaperwork = admin_url('admin.php?page=patient-paperwork-page-options');
$profileURL = admin_url('profile.php');

?>
<style>
    /*
    TODO: This will be moved to scss in future release.
    */
    .clinic-admin-dashboard {
        display: flex;
        flex-wrap: wrap;
        margin-right: 1rem;
        justify-content: space-between;
    }

    .clinic-admin-dashboard-item {
        flex-basis: 49%;
        margin-top: 1rem;
        margin-bottom: 1rem;
    }

    .clinic-admin-dashboard-item-full {
        flex-basis: 100%;
        margin-top: 1rem;
        margin-bottom: -1rem;
    }
</style>
<div class="wrap">
    <h1>Clinic Admin Dashboard</h1>
    <hr>
    <p>Welcome to your clinic admin dashboard! Here you can manage your clinics website - you can create content, edit
        pages, and update your location information.</p>

    <div class="clinic-admin-dashboard">
        <div class="clinic-admin-dashboard-item-full">
            <h2>Content Management</h2>
            <hr>

        </div>
        <div class="clinic-admin-dashboard-item">
            <h3>Create Content</h3>
            <p>
                Here you can create Events, Recipes, or Articles to share on your website.
            </p>
            <a href="<?php echo $createURL; ?>" class="button-primary" title="Create Content">Create Content</a>
            <br>
            <br>
        </div>
        <div class="clinic-admin-dashboard-item">
            <h3>Events</h3>
            <p>Here you can create events to display on your website under "Community Education" or "Professional
                Development" categories.
            </p>
            <a href="<?php echo $createEvent; ?>" class="button-primary" title="Create Event">Create Event</a>
            <br>
            <br>
        </div>
        <div class="clinic-admin-dashboard-item">
            <h3>Recipes</h3>
            <p>Submit recipes to be shared in your region, network wide, or just your website.</p>
            <a href="<?php echo $createRecipe; ?>" class="button-primary" title="Create Recipe">Create Recipe</a>
            <a href="<?php echo $draftRecipe; ?>" class="button-primary" title="Recipe Drafts">Recipe Drafts</a>
            <br>
            <br>
        </div>
        <div class="clinic-admin-dashboard-item">
            <h3>Articles</h3>
            <p>Submit articles to be shared in your region, network wide, or just your website.</p>
            <a href="<?php echo $createArticle; ?>" class="button-primary" title="Create Article">Create Article</a>
            <a href="<?php echo $draftArticle; ?>" class="button-primary" title="Article Drafts">Article Drafts</a>
            <br>
            <br>
        </div>
        <div class="clinic-admin-dashboard-item-full">
            <h2>Website Management</h2>
            <hr>
        </div>
        <div class="clinic-admin-dashboard-item">
            <h3>Location</h3>
            <p>Here you can manage your clinic's location information.</p>
            <a href="<?php echo $locationURL; ?>" class="button-primary" title="Manage Location">Manage Location</a>
            <br>
            <br>
        </div>
        <div class="clinic-admin-dashboard-item">
            <h3>Home Page</h3>
            <p>Here you can manage the Home page of your website.</p>
            <a href="<?php echo $manageHome; ?>" class="button-primary" title="Manage Home Page">Manage Home Page</a>
            <br>
            <br>
        </div>
        <div class="clinic-admin-dashboard-item">
            <h3>Our Team Page</h3>
            <p>Here you can manage the Our Team page of your website.</p>
            <a href="<?php echo $manageTeam; ?>" class="button-primary" title="Manage Team Page">Manage Team Page</a>
            <br>
            <br>
        </div>
        <div class="clinic-admin-dashboard-item">
            <h3>Footer Options</h3>
            <p>Here you can manage the Footer of your website. Add your Facebook Page, Twitter Page, or Google+ Page.
                You
                can also add a custom disclaimer in the footer.</p>
            <a href="<?php echo $manageFooter; ?>" class="button-primary" title="Manage Footer">Manage Footer</a>
            <br>
            <br>
        </div>
        <div class="clinic-admin-dashboard-item">
            <h3>Patient Paperwork</h3>
            <p>Here you can manage the PDF downloads on your <a href="<?php echo get_home_url().'/patient-paperwork'; ?>" target="_blank">Patient Paperwork</a> page.</p>
            <a href="<?php echo $managePatientPaperwork; ?>" class="button-primary" title="Manage Footer">Manage Patient Paperwork</a>
            <br>
            <br>
        </div>
        <div class="clinic-admin-dashboard-item">
            <h3>Profile</h3>
            <p>Manage your MaxLiving Clinic Administrator user settings.</p>
            <a href="<?php echo $profileURL; ?>" class="button-primary" title="My Profile">My Profile</a>
            <br>
            <br>
        </div>
    </div>
</div>
