<?php
/**
 * Attaches an admin page, with basic options for mail chimp
 */

class JM_Options 
{
	function __construct()
	{
		add_option( 'mailchimp_api' );
		add_option( 'mailchimp_list_key' );
		add_action( 'admin_menu', array( &$this, 'constructAdminPage' ) );
	}

	function constructAdminPage()
	{
		add_options_page( 'Mail Chimp', 'Mail Chimp', 'manage_options', 'mail-chimp', array( &$this, 'adminPageHTML' ) );  
	}

	function adminPageHTML()
	{
		// Construct the top of our admin page
		echo '<div class="wrap">';
		screen_icon();
		echo '<h2>Mail Chimp</h2>';

		// Handle if the form has been submitted
		if( isset( $_POST['submit_chimp'] ) && wp_verify_nonce( $_POST['mail_chimp_nonce'], 'update_chimp' ) )
		{
			update_option( 'mailchimp_api', $_POST['mailchimp_api_key'] );
			update_option( 'mailchimp_list_key', $_POST['mailchimp_api_id'] );
		}

		// Generate the form
		echo'<form method="post" action="">';
		echo'<table class="form-table">';

		// Row for the API Key
		echo'<tr valign="top"><th scope="row"><label for="mailchimp_api_key">Mail Chimp API Key</label></th>';
		echo'<td><input name="mailchimp_api_key" type="text" id="blogname" value="' . get_option('mailchimp_api') . '" class="regular-text"></td>';
		echo'</tr>';

		// Row for the List ID
		echo'<tr valign="top"><th scope="row"><label for="mailchimp_api_id">List ID</label></th>';
		echo'<td><input name="mailchimp_api_id" type="text" id="blogname" value="' . get_option('mailchimp_list_key') . '" class="regular-text"></td>';
		echo'</tr>';

		// End the table & add the submit button
		echo'</table>';
		echo'<p class="submit"><input type="submit" name="submit_chimp" id="submit" class="button-primary" value="Save Changes"></p>';

		// Nonce for security
		wp_nonce_field('update_chimp', 'mail_chimp_nonce');

		// End the form and the page
		echo'</form>';
		echo '</div>';
	}
}

new JM_Options;