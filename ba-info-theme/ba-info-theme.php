<?php 
/*
Plugin Name: Footer & Header info
Plugin URI: http://www.b4after.pl/
Description: Rozszerzenie funkcjonalności strony o zarządzanie treścią stopki oraz nagłówka
Version: Wersja 1.0
Author: Kamil Winiszewski BEFORE AFTER
Author URI: http://www.b4after.pl/
License: Shareware
*/
// Hook for adding admin menus
add_action('admin_menu', 'ba_info_add_pages');

// action function for above hook
function ba_info_add_pages() {

	// Add a new top-level menu (ill-advised):
	add_menu_page(__('Dodatkowe treści','menu-ba-info'), __('Dodatkowe treści','menu-ba-info'), 'manage_options', 'ba-info', 'ba_info_toplevel_page' );

	// Add a submenu to the custom top-level menu:
	//add_submenu_page('mt-top-level-handle', __('Test Sublevel','menu-test'), __('Test Sublevel','menu-test'), 'manage_options', 'sub-page', 'mt_sublevel_page');

	// Add a second submenu to the custom top-level menu:
	//add_submenu_page('mt-top-level-handle', __('Test Sublevel 2','menu-test'), __('Test Sublevel 2','menu-test'), 'manage_options', 'sub-page2', 'mt_sublevel_page2');
}

// display attributes function

function ba_info_footer() {
	// Read in existing option value from database
	$opt_name = 'ba-info';
	$opt_val = get_option( $opt_name );
	$html = wpautop($opt_val['ba_info_footer']);

	return $html;
}
function ba_info_header() {
	// Read in existing option value from database
	$opt_name = 'ba-info';
	$opt_val = get_option( $opt_name ) ;
	$html = str_replace(array('<p>', '</p>'), '', wpautop(stripslashes($opt_val['ba_info_header'])));

	return $html;
}

function ba_info_toplevel_page() {
	echo "<h2>" . __( 'Dodatkowe treści', 'menu-bainfo' ) . "</h2>";

	//must check that the user has the required capability
	if (!current_user_can('manage_options'))
	{
		wp_die( __('Nie masz uprawnień do tego elementu.') );
	}

	// variables for the field and option names
	$opt_name = 'ba-info';
	$hidden_field_name = 'ba_info_hidden';
	$data_field_name = 'ba-info';

	// Read in existing option value from database
	$opt_val = get_option( $opt_name );

	// See if the user has posted us some information
	// If they did, this hidden field will be set to 'Y'
	if( $_POST[ $hidden_field_name ] == 'Y' ) {
		// Read their posted value
		$opt_val = (isset($_POST[ $data_field_name ]))?$_POST[ $data_field_name ]:array();
		 
		if(!isset($opt_val['ba_info_footer'])) $opt_val['ba_info_footer']=null;
		if(!isset($opt_val['ba_info_header'])) $opt_val['ba_info_header']=null;
		 
		// Save the posted value in the database
		update_option( $opt_name, stripslashes($opt_val));
		 
		// Put an settings updated message on the screen
		?><div class="updated"><p><strong><?php _e('Ustawienia zapisano.', 'menu-test' ); ?></strong></p></div><?php
    
        }
        ?>
    <div class="wrap">
    <form name="form1" method="post" action="">
    <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
            <h2><?php echo  __( 'Podaj treść w stopce', 'menu-test' ); ?></h2>
	    <?php wp_editor(stripslashes($opt_val['ba_info_footer']), 'ba_info_footer', array('textarea_name' => $data_field_name.'[ba_info_footer]')); ?>
            <h2><?php echo  __( 'Podaj treść do nagłówka', 'menu-test' ); ?></h2>
	    <?php wp_editor(stripslashes($opt_val['ba_info_header']), 'ba_info_header', array('textarea_name' => $data_field_name.'[ba_info_header]')); ?>
    
    <p class="submit">
    <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Zapisz zmiany') ?>" />
    </p>
    
    </form>
    </div>
    
<?php }