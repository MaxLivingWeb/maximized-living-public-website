<?php
global $blog_id;

//
//Content Management
//

//Events
$createEvent = admin_url('post-new.php?post_type=event');
$categoriesEvent = admin_url('edit-tags.php?taxonomy=event_categories&post_type=event');

//Recipes
$createRecipe = admin_url('post-new.php?post_type=recipe');
$pendingRecipe = admin_url('edit.php?post_type=recipe&post_status=pending');
$submittedRecipe = admin_url('edit.php?post_type=recipe&submitted=true');
$corporateRecipe = admin_url('edit.php?post_type=recipe&corporate_only=true');
$categoriesRecipe = admin_url('edit-tags.php?taxonomy=recipe_categories&post_type=recipe');

//Articles
$createArticle = admin_url('post-new.php?post_type=article');
$pendingArticle = admin_url('edit.php?post_type=article&post_status=pending');
$submittedArticle = admin_url('edit.php?post_type=article&submitted=true');
$corporateArticle = admin_url('edit.php?post_type=article&corporate_only=true');
$categoriesArticle = admin_url('edit-tags.php?taxonomy=article_categories&post_type=article');

//Press & Media Releases
$createPress = admin_url('post-new.php?post_type=press');

//
//Site Management
//
$manageHome = admin_url('admin.php?page=home-page-options');
$manageContact = admin_url('admin.php?page=contact-page-options');
$locationURL = admin_url('admin.php?page=location-details');
$manageFooter = admin_url('admin.php?page=footer-options');
$profileURL = admin_url('profile.php');

//Pages
$createPage = admin_url('post-new.php?post_type=page');
$managePage = admin_url('edit.php?post_type=page');

//Network Management
$networkUsers = network_admin_url('users.php');
$networkSites = network_admin_url('sites.php');
$networkCreateSite = network_admin_url('admin.php?page=location-create-site');
$networkRegions = network_admin_url('admin.php?page=regions');
$networkLocations = network_admin_url('admin.php?page=location-details-landing');

?>
<style>
    /*
    TODO: This will be moved to scss in future release.
    */
    .admin-dashboard {
        display: flex;
        flex-wrap: wrap;
        margin-right: 1rem;
        justify-content: space-between;
    }

    .admin-dashboard-item {
        flex-basis: 49%;
        margin-bottom: 1rem;
    }

    .admin-dashboard-item-full {
        flex-basis: 100%;
        margin-bottom: 1rem;
    }
    .admin-dashboard-header {
        flex-basis: 100%;
        margin-top: 1rem;
    }
</style>
<div class="wrap">
    <h1>MaxLiving Admin Dashboard</h1>
    <hr>
    <p>Welcome to the MaxLiving admin dashboard!</p>

    <div class="admin-dashboard">
        <div class="admin-dashboard-header">
            <h2>Content Management</h2>
            <hr>

        </div>
        <div class="admin-dashboard-item-full">
            <h3>Create Content</h3>
            <p>
                You can create Recipes, Articles, or Events that can be shared throughout the network to the entire
                network or to specific regions.
            </p>
            <a href="<?php echo $createRecipe; ?>" class="button-primary" title="Create Recipe">Create Recipe</a>
            <a href="<?php echo $createArticle; ?>" class="button-primary" title="Create Article">Create Article</a>
            <a href="<?php echo $createEvent; ?>" class="button-primary" title="Create Event">Create Event</a>
            <br>
            <br>
        </div>
        <div class="admin-dashboard-item">
            <h3>Recipes</h3>
            <p>Submit recipes to be shared across your region or network wide. </p>
            <p>
                <a href="<?php echo $createRecipe; ?>" class="button-primary" title="Create Recipe">Create Recipe</a>
                <a href="<?php echo $pendingRecipe; ?>" class="button-primary" title="Pending Recipes">Pending
                    Recipes</a>


                <a href="<?php echo $submittedRecipe; ?>" class="button-primary" title="Submitted Recipes">Submitted
                    Recipes</a>
                <a href="<?php echo $corporateRecipe; ?>" class="button-primary" title="Corporate Recipes">Corporate
                    Recipes</a>
            </p>

            <p>
                <a href="<?php echo $categoriesRecipe; ?>" class="button-primary" title="Recipe Categories">Recipe
                    Categories</a>

            </p>

        </div>
        <div class="admin-dashboard-item">
            <h3>Articles</h3>
            <p>Submit articles to be shared across your region or network wide. </p>
            <p>

                <a href="<?php echo $createArticle; ?>" class="button-primary" title="Create Article">Create Article</a>
                <a href="<?php echo $pendingArticle; ?>" class="button-primary" title="Pending Articles">Pending
                    Articles</a>


                <a href="<?php echo $submittedArticle; ?>" class="button-primary" title="Submitted Articles">Submitted
                    Articles</a>
                <a href="<?php echo $corporateArticle; ?>" class="button-primary" title="Corporate Articles">Corporate
                    Articles</a>
            </p>
            <p>

                <a href="<?php echo $categoriesArticle; ?>" class="button-primary" title="Article Categories">Article
                    Categories</a>
            </p>


        </div>
        <div class="admin-dashboard-item">
            <h3>Events</h3>
            <p>You can create events and display them on your website under "Community Education" or "Professional
                Development".
            </p>
            <a href="<?php echo $createEvent; ?>" class="button-primary" title="Create Event">Create Event</a>
            <a href="<?php echo $categoriesEvent; ?>" class="button-primary" title="Event Categories">Event
                Categories</a>

            <br>
            <br>
        </div>
        <div class="admin-dashboard-item">
            <h3>Press &amp; Media</h3>
            <p>Here you can create a Press &amp; Media Release and manage Press &amp; Media Release categories.
            </p>
            <a href="<?php echo $createPress; ?>" class="button-primary" title="Create Press &amp; Media Release">Create
                Press &amp; Media Release</a>

            <br>
            <br>
        </div>
        <div class="admin-dashboard-header">
            <h2>Website Management</h2>
            <hr>
        </div>
        <div class="admin-dashboard-item">
            <h3>Pages</h3>
            <p>Here you can manage pages on the website.</p>
            <a href="<?php echo $createPage; ?>" class="button-primary" title="Create Page">Create Page</a>
            <a href="<?php echo $managePage; ?>" class="button-primary" title="Manage Pages">Manage Pages</a>
            <br>
            <br>
        </div>
        <div class="admin-dashboard-item">
            <h3>Location</h3>
            <p>Here you can manage the location information for this website.</p>
            <a href="<?php echo $locationURL; ?>" class="button-primary" title="Manage Location">Manage Location</a>
            <br>
            <br>
        </div>
        <div class="admin-dashboard-item">
            <h3>Home Page</h3>
            <p>Here you can manage the Home page.</p>
            <a href="<?php echo $manageHome; ?>" class="button-primary" title="Manage Home Page">Manage Home Page</a>
            <br>
            <br>
        </div>
        <div class="admin-dashboard-item">
            <h3>Contact Page</h3>
            <p>Here you can manage the Contact page.</p>
            <a href="<?php echo $manageContact; ?>" class="button-primary" title="Manage Contact Page">Manage Contact
                Page</a>
            <br>
            <br>
        </div>
        <div class="admin-dashboard-item">
            <h3>Footer Options</h3>
            <p>Here you can manage the Footer of the website. Add your Facebook Page, Twitter Page, or Google+ Page.
                You
                can also add a custom disclaimer in the footer. This is copied over to all clinic sites unless they have
                added their own social profiles and disclaimer.</p>
            <a href="<?php echo $manageFooter; ?>" class="button-primary" title="Manage Footer">Manage Footer</a>
            <br>
            <br>
        </div>
        <div class="admin-dashboard-item">
            <h3>Profile</h3>
            <p>Manage your MaxLiving Administrator user settings.</p>
            <a href="<?php echo $profileURL; ?>" class="button-primary" title="My Profile">My Profile</a>
            <br>
            <br>
        </div>
        <?php if (current_user_can('manage_network')): ?>
            <div class="admin-dashboard-header">
                <h2>Network Management</h2>
                <hr>
            </div>
            <div class="admin-dashboard-item">
                <h3>Sites</h3>
                <p>Here you can create and manage sites within the network.</p>
                <a href="<?php echo $networkCreateSite; ?>" class="button-primary" title="Create Site">Create Site</a>
                <a href="<?php echo $networkSites; ?>" class="button-primary" title="Manage Sites">Manage Sites</a>
                <br>
                <br>
            </div>
            <div class="admin-dashboard-item">
                <h3>Locations</h3>
                <p>Create a new location.</p>
                <a href="<?php echo $networkLocations; ?>" class="button-primary" title="Manage Locations">Manage
                    Locations</a>
                <br>
                <br>
            </div>
            <div class="admin-dashboard-item">
                <h3>Regions</h3>
                <p>Manage regions.</p>
                <a href="<?php echo $networkRegions; ?>" class="button-primary" title="Manage Regions">Manage
                    Regions</a>
                <br>
                <br>
            </div>
            <div class="admin-dashboard-item">
                <h3>Users</h3>
                <p>Manage users.</p>
                <a href="<?php echo $networkUsers; ?>" class="button-primary" title="Manage Users">Manage Users</a>
                <br>
                <br>
            </div>
        <?php endif; ?>
    </div>
</div>
