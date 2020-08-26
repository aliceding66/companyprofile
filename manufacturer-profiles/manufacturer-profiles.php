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
define( 'MFP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

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
    
    add_role('mfp_editor', __(
        'Manufacturer Editor','mfp'),
        array(
                'read'            => true, // Allows a user to read
				'create_posts'      => false, 
				'edit_posts'        => false, 
				'edit_others_posts' => false, 
				'publish_posts' => false, 
				'manage_categories' => false, 

            )
     );
 }
/**
 *  add Capabilities for custom role & admin
 * 
 *  @since  1.0.0
 */
 function add_theme_caps() {
    // Get role Manufacturer Editor
    $manufacturer = get_role( 'mfp_editor' );
    $administrator     = get_role('administrator');
    
    $administrator->add_cap( 'manage_manufacturer' );
    $manufacturer->add_cap( 'manage_manufacturer' );

    //required if woocommerce is active
    $manufacturer->add_cap( 'view_admin_dashboard' ); 
    
}
add_action( 'admin_init', 'add_theme_caps');

/**
 *  Manufacturer Profile enqueue scripts
 * 
 *  @since  1.0.0
 */
function cp_enqueue_scripts($hook) { 
    if(isset($_GET["page"])) {
        if($_GET["page"] == "cpcustomsubpage") {
            wp_enqueue_script( 'multi_select_script', plugin_dir_url( __FILE__ ) . 'js/jquery.multi-select.min.js', array('jquery') );
            wp_enqueue_style( 'multi_select_css', plugin_dir_url( __FILE__ ) . 'css/multiselect-styles.css');
        }
        if($_GET["page"] == "cpcustomsubpage" || $_GET["page"] == "cpcreatepage") {
            wp_enqueue_script( 'my_custom_script', plugin_dir_url( __FILE__ ) . 'js/custom_js.js', array('jquery') );
        }
       
    }
}
add_action('admin_enqueue_scripts', 'cp_enqueue_scripts');


/**
* Register Admin Menu
*
* @since  1.0.0
*
*/
function wpdocs_register_cp_custom_menu_page(){
	add_menu_page( __( 'Manufacturer Profile', 'mfp-plugin' ),'Manufacturer Profile','manage_manufacturer','cpcustompage','','dashicons-layout',6);
    add_submenu_page('cpcustompage', __( 'Manufacturer Profile List', 'mfp-plugin' ),'Manufacturer Profile List','manage_manufacturer','cpcustompage','cp_custom_menu_page'); 
    $user = wp_get_current_user();
    if ( in_array( 'mfp_owner', (array) $user->roles ) ) {
    }else{
    add_submenu_page('cpcustompage', __( 'Manufacturer Profile - Create', 'mfp-plugin' ),'Manufacturer Profile - Create New','manage_manufacturer','cpcreatepage','create_cp_page');}
    add_submenu_page('cpcustompage',__( '', 'mfp-plugin' ),'','manage_manufacturer','cpcustomsubpage','update_cp_page');
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
    $user = wp_get_current_user();
    if ( in_array( 'mfp_owner', (array) $user->roles ) ) {
    }else{
    echo '<a class="button" href="https://shop.solarfeeds.com/wp-admin/admin.php?page=cpcreatepage">Create New Manufacturer Profile</a></div>';}
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
    require_once MFP_PLUGIN_PATH . 'includes/functions.php';
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
/**
 *  Add Template for reviews - Page Template Dropdown
 * 
 *  @since  1.0.0
 */
function cp_add_page_template ($templates) {
    $templates['cp-review-template.php'] = 'Review Page';
        return $templates;
}
add_filter ('theme_page_templates', 'cp_add_page_template');

/**
 *  Template for reviews
 * 
 *  @since  1.0.0
 */
function cp_redirect_page_template ($template) {
    //if ('cp-review-template.php' == basename ($template))
    if( is_page_template('cp-review-template.php') )
        $template = MFP_PLUGIN_PATH . '/templates/cp-review-template.php';
        return $template;
    }
add_filter ('page_template', 'cp_redirect_page_template');
/**
 *  rewrite rule for clean url
 * 
 *  @since  1.0.0
 */
function custom_rewrite_basic() {
    add_rewrite_rule('^review/submit/([^/]*)/?', 'index.php?pagename=review&_mf_id=$matches[1]', 'top');
  }
add_action('init', 'custom_rewrite_basic');
/**
 *  Query var fo mf ID
 * 
 *  @since  1.0.0
 */
function cp_register_query_vars( $vars ) {
    $vars[] = '_mf_id';
	return $vars;
}
add_filter( 'query_vars', 'cp_register_query_vars' );

/**
 *  rewrite rule for clean url
 * 
 *  @since  1.0.0
 */
add_filter( 'cp_convert_base', 'cp_convert_base',1,3 );
function cp_convert_base($numberInput, $fromBaseInput, $toBaseInput)
{
    if ($fromBaseInput==$toBaseInput) return $numberInput;
    $fromBase = str_split($fromBaseInput,1);
    $toBase = str_split($toBaseInput,1);
    $number = str_split($numberInput,1);
    $fromLen=strlen($fromBaseInput);
    $toLen=strlen($toBaseInput);
    $numberLen=strlen($numberInput);
    $retval='';
    if ($toBaseInput == '0123456789')
    {
        $retval=0;
        for ($i = 1;$i <= $numberLen; $i++)
            $retval = bcadd($retval, bcmul(array_search($number[$i-1], $fromBase),bcpow($fromLen,$numberLen-$i)));
        return $retval;
    }
    if ($fromBaseInput != '0123456789')
        $base10=convBase($numberInput, $fromBaseInput, '0123456789');
    else
        $base10 = $numberInput;
    if ($base10<strlen($toBaseInput))
        return $toBase[$base10];
    while($base10 != '0')
    {
        $retval = $toBase[bcmod($base10,$toLen)].$retval;
        $base10 = bcdiv($base10,$toLen,0);
    }
    return $retval;
}



?>