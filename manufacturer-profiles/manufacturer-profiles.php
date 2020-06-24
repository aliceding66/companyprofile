<?php
/*
Plugin Name: Manufacturer Profiles -New
Description:  This plugin is for editing products on Manufacturer Profiles
Author: Alice Ding
Version: 1.0.0
Text Domain: mfp-plugin
Text Path: languages
 */

// direct access abort
if ( ! defined( 'WPINC' ) ) {
    die();
}

/**
* Define plugin constants
* MFP_PLUGIN_PATH
* @since  1.0.0
*
*/
define( 'MFP_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

/**
* Plugin activation
* MFP_PLUGIN_PATH
* @since  1.0.0
*
*/
register_activation_hook( __FILE__, 'mfp_add_role' );


function has_files_to_upload( $id ) {	return ( ! empty( $_FILES ) ) && isset( $_FILES[ $id ] );	}

/**
 *  add role
 * 
 *  @since  1.0.0
 */

 function mfp_add_role(){
    $wp_roles = new WP_Roles();
    $wp_roles->remove_role("mf_editor");
    $wp_roles->remove_role("manufacture_editor");
   
    
    add_role('mfp_editor', __(
        'Manufacturer Editor','mfp'),
        array(
                'read'            => true, // Allows a user to read
				'create_posts'      => false, // Allows user to create new posts
				'edit_posts'        => false, // Allows user to edit their own posts
				'edit_others_posts' => false, // Allows user to edit others posts too
				'publish_posts' => false, // Allows the user to publish posts
				'manage_categories' => false, // Allows user to manage post categories

            )
     );
 }

/**
 *  Manufacturer Profile enqueue scripts
 * 
 *  @since  1.0.0
 */
function enqueue_scripts($hook) { 
    if(isset($_GET["page"])) {
        if($_GET["page"] == "cpcustomsubpage" || $_GET["page"] == "cpcreatepage") {
    wp_enqueue_script( 'my_custom_script', plugin_dir_url( __FILE__ ) . 'js/custom_js.js', array('jquery') );
        }
    }
}
add_action('admin_enqueue_scripts', 'enqueue_scripts');


/**
* Register Admin Menu
*
* @since  1.0.0
*
*/
function wpdocs_register_cp_custom_menu_page(){
	add_menu_page( __( 'Manufacturer Profile', 'mfp-plugin' ),'Manufacturer Profile','edit_posts','cpcustompage','','dashicons-layout',6);
    add_submenu_page('cpcustompage', __( 'Manufacturer Profile List', 'mfp-plugin' ),'Manufacturer Profile List','edit_posts','cpcustompage','cp_custom_menu_page'); 
    add_submenu_page('cpcustompage', __( 'Manufacturer Profile - Create', 'mfp-plugin' ),'Manufacturer Profile - Create New','edit_posts','cpcreatepage','create_cp_page');
    add_submenu_page('cpcustompage',__( '', 'mfp-plugin' ),'','edit_posts','cpcustomsubpage','update_cp_page');
   // remove_submenu_page('cpcustompage','cpcustomsubpage');
}
add_action( 'admin_menu', 'wpdocs_register_cp_custom_menu_page' );


/**
 *  Manufacturer Profile List Callback
 * 
 *  @since  1.0.0
 */
function cp_custom_menu_page(){
	echo '<br>';
    echo '<div style="font-size:18px;">Manufacturer Profile Page</div>';
    echo '<br>';
    echo '<div>';
    echo '<form action="" method="post" style="width: 25%; float: left;">';
    if($_POST && isset($_POST['psearch'])){
        $search_string = $_POST['psearch'];
        echo '<input type="text" id="search" name="psearch" value="'.$search_string.'">';
    }
    elseif(isset($_GET['psearch'])){
        $search_string = $_GET['psearch'];
        echo '<input type="text" id="search" name="psearch"  value="'.$search_string.'">';
    }
    else {
        echo '<input type="text" id="search" name="psearch" placeholder="Search...">';
    }
    
    echo '<input type="submit" value="Search">';
    echo '</form>';
    
    echo '<a class="button" href="https://shop.solarfeeds.com/wp-admin/admin.php?page=cpcreatepage">Create New Manufacturer Profile</a></div>';
    echo '<br>';
	require '../wp-load.php'; 
	require_once MFP_PLUGIN_PATH . 'includes/cp_custom_menu_page.php';
	}

/**
 *  Manufacturer Profile Create Callback
 * 
 *  @since  1.0.0
 */
function create_cp_page(){
	echo '<style>td {border: 1px solid black;}</style>';
    echo '<br>';
    echo '<div style="font-size:18px;">Manufacturer Profile - Create New Manufacturer Profile Page</div>';
    echo '<br>';
    require_once '../wp-load.php'; 
    require_once MFP_PLUGIN_PATH . 'includes/cp_page.php';
}

/**
 *  Manufacturer Profile Edit
 * 
 *  @since  1.0.0
 */
function update_cp_page(){
   require_once '../wp-load.php'; 
   require_once MFP_PLUGIN_PATH . 'includes/functions.php';
   require_once MFP_PLUGIN_PATH . 'includes/edit_cp_page.php';
}


?>