<?php

// Remove Excerpt More elipsis
add_filter( 'excerpt_more', '__return_false' );

// Protected Pages for Clinic Site Creation
if ( get_current_blog_id() == 1 ) {
	add_action( 'save_post', 'clinic_protected_pages' );
	add_action( 'wp_trash_post', 'restrict_post_deletion', 10, 1 );
	add_action( 'before_delete_post', 'restrict_post_deletion', 10, 1 );
}

/**
 * @param $post_id
 * Protected page - prevented from deleting the page
 */
function restrict_post_deletion( $post_id ) {
	$protected_post_id = get_page_by_path( 'patient-paperwork-clinic-site-template-protected-page' )->ID;
	if ( $post_id == $protected_post_id ) {
		wp_die( 'The page you were trying to delete is protected.', 'Protected Page' );
	}
}

/**
 * @param $post_id
 * Protected page - disable page from being published. Always set as draft.
 */
function clinic_protected_pages( $post_id ) {
	if ( get_post_status( $post_id ) === 'auto-draft' ) {
		return;
	}
	if ( get_page_by_path( 'patient-paperwork-clinic-site-template-protected-page' ) ) {
		$protected_post_id = get_page_by_path( 'patient-paperwork-clinic-site-template-protected-page' )->ID;
		if ( $post_id !== $protected_post_id ) {
			return;
		}
		if ( $post_id == $protected_post_id ) {
			// Keeping as draft so it can't be published.
			wp_update_post( array(
				'ID'          => $protected_post_id,
				'post_status' => 'draft'
			) );
			wp_die( 'The page you were trying to publish is protected.', 'Protected Page' );

		}
	}
}

add_action( 'edit_form_advanced', 'force_post_title' );
function force_post_title( $post ) {
	// List of post types that we want to require post titles for.
	$post_types = array(
		'article',
		'recipe',
		'event',
		'press'
	);
	// If the current post is not one of the chosen post types, exit this function.
	if ( ! in_array( $post->post_type, $post_types ) ) {
		return;
	}
	?>
    <script type='text/javascript'>
        (function ($) {
            $(document).ready(function () {
                //Require post title when adding/editing Project Summaries
                $('body').on('submit.edit-post', '#post', function () {
                    // If the title isn't set
                    if ($("#title").val().replace(/ /g, '').length === 0) {
                        // Show the alert
                        if (!$("#title-required-msj").length) {
                            $("#titlewrap")
                                .append('<div id="title-required-msj"><em>Title is required.</em></div>')
                                .css({
                                    "padding": "5px",
                                    "margin": "5px 0",
                                    "background": "#ffebe8",
                                    "border": "1px solid #c00"
                                });
                        }
                        // Hide the spinner
                        $('#major-publishing-actions .spinner').hide();
                        // The buttons get "disabled" added to them on submit. Remove that class.
                        $('#major-publishing-actions').find(':button, :submit, a.submitdelete, #post-preview').removeClass('disabled');
                        // Focus on the title field.
                        $("#title").focus();
                        return false;
                    }
                });
            });
        }(jQuery));
    </script>
	<?php
}
