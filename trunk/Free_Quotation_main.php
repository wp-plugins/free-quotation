<?php
/*
	Plugin Name: Free Quotation by KRIS_IV
	Description: Quotation displayer for any WordPress page
	Author: Krzysztof Kubiak
	Version: v1.4.1
	Author URI: http://my-motivator.pl/Free_Quotation
	License: GPLv2
	License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
global $wpdb;
global $Free_Quotation_version;
$Free_Quotation_version = "1.4.1";
global $today_date;
$today_date = date('Y-m-d');
global $wikiquotation;

register_activation_hook( __FILE__, 'Free_Quotation_DB_install' );

function Free_Quotation_DB_install() {
	require(dirname(__FILE__)."/scripts/Free_Quotation_instal.php");
}

add_action('admin_init', 'Free_Quotation_settings_init' );
add_action('admin_menu', 'Free_Quotation_menu_page');

// Init plugin options to white list our options
function Free_Quotation_settings_init(){
	register_setting( 'Free_Quotation_settings_filed', 'Free_Quotation_options', 'Free_Quotation_validate' );
}

if ( is_admin() )
{
	/* add  css and js */
	add_action('admin_print_scripts', 'add_admin_scriptserr');

    if($GLOBALS['pagenow'] == 'plugins.php'){ //check if the user is on page plugins.php
        add_filter('plugin_action_links', 'FQ_plugin_action_links', 10, 2);
        add_filter('plugin_row_meta', 'FQ_plugin_meta_links', 10, 2);
    }
}
 
$FQ_plugin_basename = plugin_basename(__FILE__);
 
function FQ_plugin_action_links($links, $file){
    global $FQ_plugin_basename;
 
    if($file == $FQ_plugin_basename){
        //the Settings link will be also translated to different languages
        $apt_settings_link = '<a href="'. admin_url('admin.php?page=fq_admin_settings') .'">' . __('Settings') . '</a>';
        $links = array_merge($links, array($apt_settings_link));
    }
    return $links;
}
 
function FQ_plugin_meta_links($links, $file){
    global $FQ_plugin_basename;
 
    if($file == $FQ_plugin_basename){
        $links[] = '<a href="http://my-motivator.pl/free-quotation-kris_iv/">Visit plugin site</a>';
        $links[] = '<a href="http://wordpress.org/plugins/free-quotation/faq/">FAQ</a>';
        $links[] = '<a href="http://wordpress.org/support/plugin/free-quotation">Support</a>';
    }
    return $links;
}

function add_admin_scriptserr()
{	
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('jquery-ui-spinner');
	wp_enqueue_script('jquery-datatables', plugins_url('js/jquery.dataTables.min.js', __FILE__) );
	wp_register_style( 'Free_Quotationadmin-style', plugins_url('css/menu.css', __FILE__) ); 
	wp_register_style( 'Free_Quotationadmin2-style', plugins_url('css/jquery-ui-smoothness.css', __FILE__) );   
}

add_action('init', 'FQ_init_method');

function FQ_init_method() {         
	wp_register_style( 'Free_Quotation-style', plugins_url('css/style.css', __FILE__) );                 
}    
 
// function FQ_insert_jquery(){
	// wp_enqueue_script('jquery');
// }

// add_action('init', 'FQ_insert_jquery');

// Add menu page
function Free_Quotation_menu_page(){
    add_menu_page( 'Free Quotation', 'Free Quotation', 'manage_options', 'fq_menu_page', '', plugins_url('images/Free_Quotation_16.png',__FILE__), 98 );
	add_submenu_page( 'fq_menu_page', 'Free Quotation', 'Free Quotation', 'manage_options', 'fq_menu_page', 'fq_menu_page');
	add_submenu_page( 'fq_menu_page', 'Add CSV', 'Add CSV', 'manage_options', 'fq_add_CSV', 'fq_add_CSV');
	add_submenu_page( 'fq_menu_page', 'FQ settings', 'FQ settings', 'manage_options', 'fq_admin_settings', 'fq_admin_settings');
	//add_submenu_page( 'fq_menu_page', 'FQ DEV', 'FQ DEV', 'manage_options', 'fq_admin_dev', 'fq_admin_dev');
}

// Draw the menu page itself
function fq_menu_page() {
	wp_enqueue_style( 'Free_Quotationadmin-style' );
	wp_enqueue_style( 'Free_Quotationadmin2-style' );
	require(dirname(__FILE__)."/scripts/Free_Quotation_admin_FQ.php");
}

function fq_add_CSV() {
	wp_enqueue_style( 'Free_Quotationadmin-style' );
	wp_enqueue_style( 'Free_Quotationadmin2-style' );
	require(dirname(__FILE__)."/scripts/Free_Quotation_admin_addCSV.php");
}

function fq_admin_settings() {
	wp_enqueue_style( 'Free_Quotationadmin-style' );
	wp_enqueue_style( 'Free_Quotationadmin2-style' );
	require(dirname(__FILE__)."/scripts/Free_Quotation_admin_settings.php");
	
}

function fq_admin_dev() {
	wp_enqueue_style( 'Free_Quotationadmin-style' );
	wp_enqueue_style( 'Free_Quotationadmin2-style' );
	require(dirname(__FILE__)."/scripts/Free_Quotation_dev.php");
	
}

// Sanitize and validate input. Accepts an array, return a sanitized array.
function Free_Quotation_validate($input) {
if (isset($input['option1'])){	$input['option1'] = ( $input['option1']);}
if (isset($input['option2'])){	$input['option2'] = ( $input['option2']);}
if (isset($input['option3'])){	$input['option3'] = ( $input['option3'] == 1 ? 1 : 0 );}
if (isset($input['option4'])){	$input['option4'] = ( $input['option4'] == 1 ? 1 : 0 );}
if (isset($input['tekst1'])){	$input['tekst1'] =  ($input['tekst1']);}
if (isset($input['tekst2'])){	$input['tekst2'] =  ($input['tekst2']);}
if (isset($input['tekst3'])){	$input['tekst3'] =  ($input['tekst3']);}
if (isset($input['tekst4'])){	$input['tekst4'] =  ($input['tekst4']);}
	
	return $input;
}

//Widget code
class Free_Quotation_widget extends WP_Widget {
	function __construct() {
		parent::__construct(false, $name = __('Free Quotation widget'));
	}
	function form() {
	}
	function update() {
	}
	function widget($args, $instance) {
$options = get_option('Free_Quotation_options');	
	require(dirname(__FILE__)."/scripts/Free_Quotation_widget.php");		

	}
}
 
function register_Free_Quotation_widget() {
    register_widget( 'Free_Quotation_widget' );
}
add_action( 'widgets_init', 'register_Free_Quotation_widget');
add_action( 'wp_enqueue_scripts', 'Free_Quotation_style_CSS' );

function Free_Quotation_style_CSS() {
    wp_enqueue_style( 'Free_Quotation-style' );
}

?>