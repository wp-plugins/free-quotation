<?php
/*
	Plugin Name: Free Quotation by KRIS_IV
	Description: Quotation displayer for any WordPress page
	Author: Krzysztof Kubiak
	Version: 2.1.2
	Author URI: http://my-motivator.pl/Free_Quotation
	License: GPLv2
	License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
global $wpdb;
global $Free_Quotation_version;
$Free_Quotation_version = "2.1.2";
global $today_date;
$today_date = date('Y-m-d');
global $today_week_no;
$today_week_no = date('W');
global $today_week_day;
$today_week_day = date('N');
global $wikiquotation;
global $table_name;
$table_name = $wpdb->prefix . 'free_quotation_kris_IV';

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
	wp_enqueue_script('jquery-ui-autocomplete');
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
	add_submenu_page( 'fq_menu_page', 'CSV', 'CSV', 'manage_options', 'fq_add_CSV', 'fq_add_CSV');
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
if (isset($input['option5'])){	$input['option5'] = ( $input['option5']);}
if (isset($input['option6'])){	$input['option6'] = ( $input['option6']);}
if (isset($input['option7'])){	$input['option7'] = ( $input['option7']);}
if (isset($input['option8'])){	$input['option8'] = ( $input['option8']);}
if (isset($input['option9'])){	$input['option9'] = ( $input['option9']);}
if (isset($input['option10'])){	$input['option10'] = ( $input['option10']);}
if (isset($input['option11'])){	$input['option11'] = ( $input['option11']);}
if (isset($input['tekst1'])){	$input['tekst1'] =  ($input['tekst1']);}
if (isset($input['tekst2'])){	$input['tekst2'] =  ($input['tekst2']);}
if (isset($input['tekst3'])){	$input['tekst3'] =  ($input['tekst3']);}
if (isset($input['tekst4'])){	$input['tekst4'] =  ($input['tekst4']);}
if (isset($input['tekst5'])){	$input['tekst5'] =  ($input['tekst5']);}
if (isset($input['tekst6'])){	$input['tekst6'] =  ($input['tekst6']);}
if (isset($input['tekst7'])){	$input['tekst7'] =  ($input['tekst7']);}
if (isset($input['tekst8'])){	$input['tekst8'] =  ($input['tekst8']);}
if (isset($input['tekst9'])){	$input['tekst9'] =  ($input['tekst9']);}
if (isset($input['tekst10'])){	$input['tekst10'] =  ($input['tekst10']);}
if (isset($input['tekst11'])){	$input['tekst11'] =  ($input['tekst11']);}
	
	return $input;
}

class Free_Quotation_widget extends WP_Widget {


	function __construct() {
		parent::__construct(
			'foo_widget', // Base ID
			__('Free Quotation widget', 'text_domain'), // Name
			array( 'description' => __( 'A quotation widget', 'text_domain' ), ) // Args
		);
	}

	
	
	public function widget( $args, $instance ) {
		$options = get_option('Free_Quotation_options');
		require(dirname(__FILE__)."/scripts/Free_Quotation_widget.php");		
	}

	
	public function form( $instance ) {
	
if(isset($instance['fq_ask_title'])){
	$fq_ask_title = esc_attr($instance['fq_ask_title']);
} 
else { 
	$fq_ask_title=0;
};

if(isset($instance['title'])){
	if ($instance['title'] == ""){
		$fq_title = 'Quote for you';
	}
	else {
		$fq_title = esc_attr($instance['title']);
	}
} 
else { 
	$fq_title = 'Quote for you';
}

if(isset($instance['fq_group'])){
	if ($instance['fq_group'] == ""){
		$fq_disp_group = 'main group';
	}
	else {
		$fq_disp_group = esc_attr($instance['fq_group']);
	}
} 
else { 
	$fq_disp_group = 'main group';
}

	global $table_name;
	global $wpdb;
	$fqgroup = $wpdb->get_results("SELECT DISTINCT quote_group FROM $table_name");
		?>
		<p>
		<label>Display title on Widget?</label>
		<input id="<?php echo $this->get_field_id('fq_ask_title'); ?>" name="<?php echo $this->get_field_name('fq_ask_title'); ?>" type="checkbox" value="1" <?php checked( '1', $fq_ask_title ); ?>/>
		<br>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<br>
		<input type="text" name="<?php echo $this->get_field_name( 'title' ); ?>" id="<?php echo $this->get_field_id( 'title' ); ?>" value="<?php echo esc_attr( $fq_title ); ?>">
		<br>
		<label for="<?php echo $this->get_field_id( 'fq_group' ); ?>"><?php _e( 'Group:' ); ?></label>
		<br>
		<select name="<?php echo $this->get_field_name( 'fq_group' ); ?>">
		<?php
			foreach($fqgroup as $gropu_name) {
				$group_value = $gropu_name->quote_group;
				if ($group_value == esc_attr( $fq_disp_group )) {
				echo '<option selected="selected">'.$group_value.'</option>';
				} else {
				echo '<option>'.$group_value.'</option>';
				}
			} 
		?>
		</select>
		</p>


<?php 
	}

	
	
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] =  strip_tags( $new_instance['title'] ); 
		$instance['fq_group'] =  strip_tags( $new_instance['fq_group'] ); 
		$instance['fq_ask_title'] = strip_tags($new_instance['fq_ask_title']);


		return $instance;
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