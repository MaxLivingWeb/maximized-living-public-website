<?php

/*
Plugin Name: Plagiarism Tool
Plugin URI:
Description: Handles Plagiarism check for content for MaxLiving.
Version: 1.0.0
Author: Arcane
Author URI: https://arcane.ws/
Copyright: Arcane
*/

namespace MaxLiving\PlagiarismTool;
global $blog_id;
if (get_stylesheet() === "ml_corporate" && $blog_id == 1) {
    add_action( 'manage_recipe_posts_custom_column', __NAMESPACE__  .'\Includes\Plagiarism::plagiarism_post_table_column', 10, 2 );
    add_filter( 'manage_recipe_posts_columns', __NAMESPACE__  .'\Includes\Plagiarism::plagiarism_head' );
    add_action( 'manage_article_posts_custom_column', __NAMESPACE__  .'\Includes\Plagiarism::plagiarism_post_table_column', 10, 2 );
    add_filter( 'manage_article_posts_columns', __NAMESPACE__  .'\Includes\Plagiarism::plagiarism_head' );
    add_action( 'admin_post_plagiarism_check', __NAMESPACE__  .'\Includes\Plagiarism::plagiarism_check' );
    add_action( 'admin_footer', __NAMESPACE__  .'\Includes\Plagiarism::add_plagiarism_options');
}
