<?php
/*
	Plugin Name: Free Quotation
	Description: Quotation displayer for any WordPress page
	Author: Krzysztof Kubiak
	Version: 3.1.0
	Author URI: http://my-motivator.pl/Free_Quotation
	License: GPLv2
	License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

global $wpdb;
global $Free_Quotation_version;
$Free_Quotation_version = "3.1.0";
global $today_date;
$today_date = date('Y-m-d');
global $today_week_no;
$today_week_no = date('W');
global $today_week_day;
$today_week_day = date('N');
global $wikiquotation;
global $table_name;
$table_name = $wpdb->prefix . 'free_quotation_kris_IV';
$table_name_tags = $wpdb->prefix . 'free_quotation_tags';
global $fq_installed_ver;
$fq_installed_ver = get_option("fq_db_version");
global $fq_db_version;
$fq_db_version = "1.11";
				
register_activation_hook( __FILE__, 'Free_Quotation_DB_install' );
function Free_Quotation_DB_install() {
	require(dirname(__FILE__)."/incloudes/Free_Quotation_instal.php");
}

function Free_Quotation_update_db_check() {
	global $fq_installed_ver;
	global $fq_db_version;
	
    if ($fq_installed_ver != $fq_db_version) {
		require(dirname(__FILE__)."/incloudes/Free_Quotation_update.php");
    }
}
add_action( 'plugins_loaded', 'Free_Quotation_update_db_check' );


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
	
/**
 * Content of Dashboard-Widget
 */
function fq_wp_dashboard_info() {
	$options = get_option('Free_Quotation_options');
	require(dirname(__FILE__)."/incloudes/Free_Quotation_admin_widget.php");
}

function free_quotation_dashboard_setup() {
	wp_add_dashboard_widget( 'fq_wp_dashboard_info', __( 'Free Quotation Info' ), 'fq_wp_dashboard_info' );
}

add_action('wp_dashboard_setup', 'free_quotation_dashboard_setup');
	
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
	wp_enqueue_script('jquery');
	wp_register_style( 'Free_Quotation-style', plugins_url('css/style.css', __FILE__) );                 
	
}    

// Add menu page
function Free_Quotation_menu_page(){
    add_menu_page( 'Free Quotation', 'Free Quotation', 'manage_options', 'fq_menu_page', 'fq_add_page', plugins_url('images/Free_Quotation_16.png',__FILE__), 98 );
	add_submenu_page( 'fq_menu_page', 'CSV', 'CSV', 'manage_options', 'fq_add_CSV', 'fq_add_CSV');
	add_submenu_page( 'fq_menu_page', 'FQ settings', 'FQ settings', 'manage_options', 'fq_admin_settings', 'fq_admin_settings');
}

// Draw the menu page itself
function fq_add_page() {
	wp_enqueue_style( 'Free_Quotationadmin-style' );
	wp_enqueue_style( 'Free_Quotationadmin2-style' );
	require(dirname(__FILE__)."/incloudes/Free_Quotation_admin_FQ.php");
}

function fq_add_CSV() {
	wp_enqueue_style( 'Free_Quotationadmin-style' );
	wp_enqueue_style( 'Free_Quotationadmin2-style' );
	require(dirname(__FILE__)."/incloudes/Free_Quotation_admin_addCSV.php");
}

function fq_admin_settings() {
	wp_enqueue_style( 'Free_Quotationadmin-style' );
	wp_enqueue_style( 'Free_Quotationadmin2-style' );
	require(dirname(__FILE__)."/incloudes/Free_Quotation_admin_settings.php");
	
}

function fq_admin_dev() {
	wp_enqueue_style( 'Free_Quotationadmin-style' );
	wp_enqueue_style( 'Free_Quotationadmin2-style' );
	require(dirname(__FILE__)."/incloudes/Free_Quotation_dev.php");
	
}

// Sanitize and validate input. Accepts an array, return a sanitized array.
function Free_Quotation_validate($input) {
if (isset($input['fq_kk_option1'])){	$input['fq_kk_option1'] = ( $input['fq_kk_option1']);}
if (isset($input['fq_kk_option2'])){	$input['fq_kk_option2'] = ( $input['fq_kk_option2']);}
if (isset($input['fq_kk_option3'])){	$input['fq_kk_option3'] = ( $input['fq_kk_option3'] == 1 ? 1 : 0 );}
if (isset($input['fq_kk_option4'])){	$input['fq_kk_option4'] = ( $input['fq_kk_option4'] == 1 ? 1 : 0 );}
if (isset($input['fq_kk_option5'])){	$input['fq_kk_option5'] = ( $input['fq_kk_option5']);}
if (isset($input['fq_kk_option6'])){	$input['fq_kk_option6'] = ( $input['fq_kk_option6']);}
if (isset($input['fq_kk_option7'])){	$input['fq_kk_option7'] = ( $input['fq_kk_option7']);}
if (isset($input['fq_kk_option8'])){	$input['fq_kk_option8'] = ( $input['fq_kk_option8']);}
if (isset($input['fq_kk_option9'])){	$input['fq_kk_option9'] = ( $input['fq_kk_option9']);}
if (isset($input['fq_kk_option10'])){	$input['fq_kk_option10'] = ( $input['fq_kk_option10']);}
if (isset($input['fq_kk_option11'])){	$input['fq_kk_option11'] = ( $input['fq_kk_option11']);}
if (isset($input['fq_kk_tekst1'])){	$input['fq_kk_tekst1'] =  ($input['fq_kk_tekst1']);}
if (isset($input['fq_kk_tekst2'])){	$input['fq_kk_tekst2'] =  ($input['fq_kk_tekst2']);}
if (isset($input['fq_kk_tekst3'])){	$input['fq_kk_tekst3'] =  ($input['fq_kk_tekst3']);}
if (isset($input['fq_kk_tekst4'])){	$input['fq_kk_tekst4'] =  ($input['fq_kk_tekst4']);}
if (isset($input['fq_kk_tekst5'])){	$input['fq_kk_tekst5'] =  ($input['fq_kk_tekst5']);}
if (isset($input['fq_kk_tekst6'])){	$input['fq_kk_tekst6'] =  ($input['fq_kk_tekst6']);}
if (isset($input['fq_kk_tekst7'])){	$input['fq_kk_tekst7'] =  ($input['fq_kk_tekst7']);}
if (isset($input['fq_kk_tekst8'])){	$input['fq_kk_tekst8'] =  ($input['fq_kk_tekst8']);}
if (isset($input['fq_kk_tekst9'])){	$input['fq_kk_tekst9'] =  ($input['fq_kk_tekst9']);}
if (isset($input['fq_kk_tekst10'])){	$input['fq_kk_tekst10'] =  ($input['fq_kk_tekst10']);}
if (isset($input['fq_kk_tekst11'])){	$input['fq_kk_tekst11'] =  ($input['fq_kk_tekst11']);}
if (isset($input['fq_kk_tekst12'])){	$input['fq_kk_tekst12'] =  ($input['fq_kk_tekst12']);}
if (isset($input['fq_kk_tekst13'])){	$input['fq_kk_tekst13'] =  ($input['fq_kk_tekst13']);}
if (isset($input['fq_kk_info_signaturealign'])){	$input['fq_kk_info_signaturealign'] =  ($input['fq_kk_info_signaturealign']);}
if (isset($input['fq_kk_info_headeralign'])){	$input['fq_kk_info_headeralign'] =  ($input['fq_kk_info_headeralign']);}
if (isset($input['fq_kk_info_bodyalign'])){	$input['fq_kk_info_bodyalign'] =  ($input['fq_kk_info_bodyalign']);}
	
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
		require(dirname(__FILE__)."/incloudes/Free_Quotation_widget.php");		
	}
		
	public function form( $instance ) {
		
		if(isset($instance['id_rand'])){
			$id_rand = esc_attr($instance['id_rand']);
		} 
		else { 
			$id_rand= rand();
		};	

		if(isset($instance['fq_ask_title'])){
			$fq_ask_title = esc_attr($instance['fq_ask_title']);
		} 
		else { 
			$fq_ask_title=0;
		};

		if(isset($instance['fq_display_date'])){
			$fq_display_date = esc_attr($instance['fq_display_date']);
		} 
		else { 
			$fq_display_date=0;
		};

		if(isset($instance['fq_display_author'])){
			$fq_display_author = esc_attr($instance['fq_display_author']);
		} 
		else { 
			$fq_display_author=1;
		};

		if(isset($instance['fq_display_note'])){
			$fq_display_note = esc_attr($instance['fq_display_note']);
		} 
		else { 
			$fq_display_note=0;
		};

		if(isset($instance['title'])){
			if ($instance['title'] == ""){
				$fq_title = 'Quote for you';
			} else {
				$fq_title = esc_attr($instance['title']);
			}
		} 
		else { 
			$fq_title = 'Quote for you';
		}

		if(isset($instance['fq_group_or_tags'])){
			if ($instance['fq_group_or_tags'] == ""){
				$fq_g_o_t = 0;
			} else {
				$fq_g_o_t = $instance['fq_group_or_tags'];
			}
		} 
		else { 
			$fq_g_o_t = 0;
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

		if(isset($instance['fq_tags'])){
			if ($instance['fq_tags'] == ""){
				$fq_tags = '';
			}
			else {
				$fq_tags = esc_attr($instance['fq_tags']);
			}
		} 
		else { 
			$fq_tags = '';
		}

		if(isset($instance['fq_display_type'])){
			if ($instance['fq_display_type'] == ""){
				$fq_display_type = '';
			}
			else {
				$fq_display_type = esc_attr($instance['fq_display_type']);
			}
		} 
		else { 
			$fq_display_type = '1';
		}

		global $table_name;
		global $wpdb;
		$fqgroup = $wpdb->get_results("SELECT DISTINCT quote_group FROM $table_name");
			?>
			<script>
			function checkbox_check(val, rand, fqGroup, fqTags){
				if(val===0){
					document.getElementById(fqGroup + rand).disabled = false;
					document.getElementById(fqTags + rand).disabled = true;
				} else {
					document.getElementById(fqGroup + rand).disabled = true;
					document.getElementById(fqTags + rand).disabled = false;
				}
			}
			</script>
			<p>
			<input type="hidden" name="<?php echo $this->get_field_name('id_rand'); ?>" value="<?php echo $id_rand; ?>">
			<input id="<?php echo $this->get_field_id('fq_ask_title'); ?>" name="<?php echo $this->get_field_name('fq_ask_title'); ?>" type="checkbox" value="1" <?php checked( '1', $fq_ask_title ); ?>/><label>Display Widget title</label>
			<br>
			<br>
			<input type="hidden" name="<?php echo $this->get_field_name('fq_display_author'); ?>" value="<?php echo $id_rand; ?>">
			<input id="<?php echo $this->get_field_id('fq_display_author'); ?>" name="<?php echo $this->get_field_name('fq_display_author'); ?>" type="checkbox" value="1" <?php checked( '1', $fq_display_author ); ?>/><label>Display author</label>
			<br>
			<br>
			<input type="hidden" name="<?php echo $this->get_field_name('fq_display_date'); ?>" value="<?php echo $id_rand; ?>">
			<input id="<?php echo $this->get_field_id('fq_display_date'); ?>" name="<?php echo $this->get_field_name('fq_display_date'); ?>" type="checkbox" value="1" <?php checked( '1', $fq_display_date ); ?>/><label>Display birth-death date (if define)</label>
			<br>
			<br>
			<input type="hidden" name="<?php echo $this->get_field_name('fq_display_note'); ?>" value="<?php echo $id_rand; ?>">
			<input id="<?php echo $this->get_field_id('fq_display_note'); ?>" name="<?php echo $this->get_field_name('fq_display_note'); ?>" type="checkbox" value="1" <?php checked( '1', $fq_display_note ); ?>/><label>Display additional notes (if define)</label>
			<br>
			<br>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<br>
			<input type="text" name="<?php echo $this->get_field_name( 'title' ); ?>" id="<?php echo $this->get_field_id( 'title' ); ?>" value="<?php echo esc_attr( $fq_title ); ?>">
			<br>
			<br>
			<input id="toqd-1" type="radio" name="<?php echo $this->get_field_name( 'fq_display_type' ); ?>" value="1" <?php checked('1', $fq_display_type); ?> /><label for="toqd-1">Use only FQ - display by quotation display day</label></br>
			<input id="toqd-2" type="radio" name="<?php echo $this->get_field_name( 'fq_display_type' ); ?>" value="5" <?php checked('5', $fq_display_type); ?> /><label for="toqd-2">Use only FQ - display by quotation week number</label></br>
			<input id="toqd-3" type="radio" name="<?php echo $this->get_field_name( 'fq_display_type' ); ?>" value="6" <?php checked('6', $fq_display_type); ?> /><label for="toqd-3">Use only FQ - display by quotation weekday</label></br>
			<input id="toqd-7" type="radio" name="<?php echo $this->get_field_name( 'fq_display_type' ); ?>" value="7" <?php checked('7', $fq_display_type); ?> /><label for="toqd-7">Use only FQ - display random quotes from database</label><br>
			<input id="toqd-4" type="radio" name="<?php echo $this->get_field_name( 'fq_display_type' ); ?>" value="2" <?php checked('2', $fq_display_type); ?> /><label for="toqd-4">Use Wikiquote if you doesn't have quotation display daily (instead standard quot)</label><br>
			<input id="toqd-5" type="radio" name="<?php echo $this->get_field_name( 'fq_display_type' ); ?>" value="3" <?php checked('3', $fq_display_type); ?> /><label for="toqd-5">Use Wikiquote always for quotations displaying</label><br>
			<input id="toqd-6" type="radio" name="<?php echo $this->get_field_name( 'fq_display_type' ); ?>" value="4" <?php checked('4', $fq_display_type); ?> /><label for="toqd-6">Use one standard quotation</label><br><br>
			<label for="<?php echo $this->get_field_id( 'fq_group_or_tags' ); ?>"><?php _e( 'Group or Tags' ); ?></label>
			<br>
			<input type="radio" name="<?php echo $this->get_field_name( 'fq_group_or_tags' ); ?>" value="0" onchange="checkbox_check(0, <?php echo $id_rand; ?>, '<?php echo $this->get_field_id( 'fq_group' ); ?>', '<?php echo $this->get_field_id( 'fq_tags' ); ?>')" <?php if($fq_g_o_t==0){echo 'checked';} ?>>Group<br>
			<input type="radio" name="<?php echo $this->get_field_name( 'fq_group_or_tags' ); ?>" value="1" onchange="checkbox_check(1, <?php echo $id_rand; ?>, '<?php echo $this->get_field_id( 'fq_group' ); ?>', '<?php echo $this->get_field_id( 'fq_tags' ); ?>')" <?php if($fq_g_o_t==1){echo 'checked';} ?>>Tags (the best work with: "Use only FQ - display random quotes from database")
			<br>
			<br>
			<label for="<?php echo $this->get_field_id( 'fq_group' ); ?>"><?php _e( 'Group:' ); ?></label>
			<br>
			<select name="<?php echo $this->get_field_name( 'fq_group' ); ?>" id="<?php echo $this->get_field_id( 'fq_group' ).$id_rand; ?>" <?php if($fq_g_o_t==1){echo 'disabled';} ?>>
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
			</select><br><br>
			<label for="<?php echo $this->get_field_id( 'fq_tags' ); ?>"><?php _e( 'Tags to display (separate by coma ,):' ); ?></label><br>
			<input type="text" name="<?php echo $this->get_field_name( 'fq_tags' ); ?>"  id="<?php echo $this->get_field_id( 'fq_tags' ).$id_rand; ?>" value="<?php echo esc_attr( $fq_tags ); ?>"<?php if($fq_g_o_t==0){echo 'disabled';} ?>>
			</p>


	<?php 
	}

	public function update( $new_instance, $old_instance ) {
			$instance = array();
			
			$instance['id_rand'] =  strip_tags( $new_instance['id_rand'] ); 
			$instance['title'] =  strip_tags( $new_instance['title'] ); 
			$instance['fq_group'] =  strip_tags( $new_instance['fq_group'] ); 
			$instance['fq_ask_title'] = strip_tags($new_instance['fq_ask_title']);
			$instance['fq_group_or_tags'] = strip_tags($new_instance['fq_group_or_tags']);
			$instance['fq_tags'] = strip_tags($new_instance['fq_tags']);
			$instance['fq_display_type'] = strip_tags($new_instance['fq_display_type']);
			$instance['fq_display_date'] = strip_tags($new_instance['fq_display_date']);
			$instance['fq_display_note'] = strip_tags($new_instance['fq_display_note']);
			$instance['fq_display_author'] = strip_tags($new_instance['fq_display_author']);


			return $instance;
	}

}
 
function register_Free_Quotation_widget() {
    register_widget( 'Free_Quotation_widget' );
}
add_action( 'widgets_init', 'register_Free_Quotation_widget');
// WIDGET 1 - END


// WIDGET 2 - START
class Free_Quotation_shortcode_selector extends WP_Widget {

	function __construct() {
		parent::__construct(
			'fq2_widget', // Base ID
			__('BETA - Free Quotation shortcode selector', 'text_domain'), // Name
			array( 'description' => __( 'Your website visitor can choose quotation by select a good TAG', 'text_domain' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {
		
		add_action('wp_print_footer_scripts', 'print_js', 1000);

		function print_js() { ?>
			<script type="text/javascript">
				jQuery(document).ready(function($){
					$(".tag_to_select").click(function(){
						var id = $(this).attr('id');
						jQuery.ajax({
							url: 'wp-admin/admin-ajax.php',
							type: 'POST',
							data: {
								'action': 'testaction',
								'quote_id': id
							},
							success: function (output) {
							  $('#shortcode_to').html(output);
							}       
						});
					});
				});
			</script>
		<?php
		}	
		require(dirname(__FILE__)."/incloudes/Free_Quotation_shortcode_selector.php");	
	}
	
	public function form( $instance ) {
		wp_enqueue_script('jquery');
		if(isset($instance['id2_rand'])){
			$id2_rand = esc_attr($instance['id2_rand']);
		} else { 
			$id2_rand= rand();
		};
		
		if(isset($instance['fq2_ask_title'])){
			$fq2_ask_title = esc_attr($instance['fq2_ask_title']);
		} else { 
			$fq2_ask_title= 0;
		};
		
		if(isset($instance['title2'])){
			if ($instance['title2'] == ""){
				$fq2_title = 'Quote for you';
			} else {
				$fq2_title = esc_attr($instance['title2']);
			}
		}  else { 
			$fq2_title = 'Chose quote for you';
		}	
		
		if(isset($instance['fq2_display_date'])){
			$fq_display_date = esc_attr($instance['fq2_display_date']);
		} 
		else { 
			$fq_display_date=0;
		};

		if(isset($instance['fq2_display_author'])){
			$fq_display_author = esc_attr($instance['fq2_display_author']);
		} 
		else { 
			$fq_display_author=1;
		};

		if(isset($instance['fq2_display_note'])){
			$fq_display_note = esc_attr($instance['fq2_display_note']);
		} 
		else { 
			$fq_display_note=0;
		};

		if(isset($instance['tags_to_display'])){
			if ($instance['tags_to_display'] == ""){
				$tags_to_display = '';
			} else {
				$tags_to_display = esc_attr($instance['tags_to_display']);
			}
		}  else { 
			$tags_to_display = '';
		}		
		
		if(isset($instance['fq_select_level'])){
			$fq_select_level = esc_attr($instance['fq_select_level']);
		} else { 
			$fq_select_level= 1;
		};	
		
		if(isset($instance['fq_select_elements'])){
			$fq_select_elements = esc_attr($instance['fq_select_elements']);
		} else { 
			$fq_select_elements= 1;
		};		
		
		if(isset($instance['fq_select_tags'])){
			$fq_select_tags = esc_attr($instance['fq_select_tags']);
		} else { 
			$fq_select_tags= 1;
		};		
		
?>		<p>
		<input type="hidden" name="<?php echo $this->get_field_name('id2_rand'); ?>" value="<?php echo $id2_rand; ?>">
		<input id="<?php echo $this->get_field_id('fq2_ask_title'); ?>" name="<?php echo $this->get_field_name('fq2_ask_title'); ?>" type="checkbox" value="1" <?php checked( '1', $fq2_ask_title ); ?>/><label>Display Widget title</label>
		<br>
		<br>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<br>
		<input type="text" name="<?php echo $this->get_field_name( 'title2' ); ?>" id="<?php echo $this->get_field_id( 'title2' ); ?>" value="<?php echo esc_attr( $fq2_title ); ?>">
		<br>
		<br>
<!--		<input type="hidden" name="<?php echo $this->get_field_name('fq2_display_author'); ?>" value="<?php echo $id_rand; ?>">
		<input id="<?php echo $this->get_field_id('fq2_display_author'); ?>" name="<?php echo $this->get_field_name('fq2_display_author'); ?>" type="checkbox" value="1" <?php checked( '1', $fq_display_author ); ?>/><label>Display author</label>
		<br>
		<br>
		<input type="hidden" name="<?php echo $this->get_field_name('fq2_display_date'); ?>" value="<?php echo $id_rand; ?>">
		<input id="<?php echo $this->get_field_id('fq2_display_date'); ?>" name="<?php echo $this->get_field_name('fq2_display_date'); ?>" type="checkbox" value="1" <?php checked( '1', $fq_display_date ); ?>/><label>Display birth-death date (if define)</label>
		<br>
		<br>
		<input type="hidden" name="<?php echo $this->get_field_name('fq2_display_note'); ?>" value="<?php echo $id_rand; ?>">
		<input id="<?php echo $this->get_field_id('fq2_display_note'); ?>" name="<?php echo $this->get_field_name('fq2_display_note'); ?>" type="checkbox" value="1" <?php checked( '1', $fq_display_note ); ?>/><label>Display additional notes (if define)</label>
		<br>
		<br>
-->
<!--		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'How many select levels:' ); ?></label>
		<br>
		<input id="sel-1" type="radio" name="<?php echo $this->get_field_name( 'fq_select_level' ); ?>" value="1" <?php checked('1', $fq_select_level); ?> /><label for="sel-1">1 select level</label></br>
		<input id="sel-2" type="radio" name="<?php echo $this->get_field_name( 'fq_select_level' ); ?>" value="2" <?php checked('2', $fq_select_level); ?> /><label for="sel-2">2 select level</label></br>
		<input id="sel-3" type="radio" name="<?php echo $this->get_field_name( 'fq_select_level' ); ?>" value="3" <?php checked('3', $fq_select_level); ?> /><label for="sel-3">3 select level</label></br>
		<br>
		<br> -->
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Elements to choose by user:' ); ?></label>
		<br>
		<input id="sel-1" type="radio" name="<?php echo $this->get_field_name( 'fq_select_elements' ); ?>" value="1" <?php checked('1', $fq_select_elements); ?> /><label for="sel-1">1 element</label></br>
		<input id="sel-2" type="radio" name="<?php echo $this->get_field_name( 'fq_select_elements' ); ?>" value="2" <?php checked('2', $fq_select_elements); ?> /><label for="sel-2">2 element</label></br>
		<input id="sel-3" type="radio" name="<?php echo $this->get_field_name( 'fq_select_elements' ); ?>" value="3" <?php checked('3', $fq_select_elements); ?> /><label for="sel-3">3 element</label></br>
		<input id="sel-4" type="radio" name="<?php echo $this->get_field_name( 'fq_select_elements' ); ?>" value="4" <?php checked('4', $fq_select_elements); ?> /><label for="sel-4">4 element</label></br>
		<input id="sel-5" type="radio" name="<?php echo $this->get_field_name( 'fq_select_elements' ); ?>" value="5" <?php checked('5', $fq_select_elements); ?> /><label for="sel-5">5 element</label></br>
		<br>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Select tags to display:' ); ?></label>
		<br>
		<input id="wtags-1" type="radio" name="<?php echo $this->get_field_name( 'fq_select_tags' ); ?>" value="1" <?php checked('1', $fq_select_tags); ?> /><label for="wtags-1">All tags</label></br>
		<input id="wtags-2" type="radio" name="<?php echo $this->get_field_name( 'fq_select_tags' ); ?>" value="2" <?php checked('2', $fq_select_tags); ?> /><label for="wtags-2">Selected tags</label></br>
		<br>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Tags to display (separate by coma ,):' ); ?></label>
		<br>
		<input type="text" name="<?php echo $this->get_field_name( 'tags_to_display' ); ?>" id="<?php echo $this->get_field_id( 'tags_to_display' ); ?>" value="<?php echo esc_attr( $tags_to_display ); ?>">
		<br>
		</p>
<?php 
	}

	
	
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		
		$instance['id2_rand'] =  strip_tags( $new_instance['id2_rand'] ); 
		$instance['fq2_ask_title'] =  strip_tags( $new_instance['fq2_ask_title'] ); 
		$instance['title2'] =  strip_tags( $new_instance['title2'] ); 
		$instance['fq2_display_author'] =  strip_tags( $new_instance['fq2_display_author'] ); 
		$instance['fq2_display_date'] =  strip_tags( $new_instance['fq2_display_date'] ); 
		$instance['fq2_display_note'] =  strip_tags( $new_instance['fq2_display_note'] ); 
		$instance['fq_select_level'] =  strip_tags( $new_instance['fq_select_level'] ); 
		$instance['fq_select_elements'] =  strip_tags( $new_instance['fq_select_elements'] ); 
		$instance['fq_select_tags'] =  strip_tags( $new_instance['fq_select_tags'] ); 
		$instance['tags_to_display'] =  strip_tags( $new_instance['tags_to_display'] ); 


		return $instance;
	}
}

// register widget

// WIDGET 2 - END

function register_Free_Quotation_shortcode_selector() {
    register_widget( 'Free_Quotation_shortcode_selector' );
}

add_action('widgets_init', 'register_Free_Quotation_shortcode_selector');

add_action( 'wp_enqueue_scripts', 'Free_Quotation_style_CSS' );

function Free_Quotation_style_CSS() {
    wp_enqueue_style( 'Free_Quotation-style' );
}


//AJAX FROM HIRE

function test_callback() {
	global $wpdb;
	$options = get_option('Free_Quotation_options');
	$table_name = $wpdb->prefix . 'free_quotation_kris_IV';
	$table_name_tags = $wpdb->prefix . 'free_quotation_tags';
		
	$fq_display_author = 1;
	$fq_display_life = 1;
	$fq_display_note = 1;
	
	$quote_val = $_POST['quote_id'];
	
	// echo $quote_val;
	$Free_Quotation_shortcode_table = 
		"
		SELECT * 
		FROM $table_name_tags 
		WHERE tag = '$quote_val'
		ORDER BY RAND() 
		LIMIT 1;
		";
	$fqshortcode = $wpdb->get_results($Free_Quotation_shortcode_table);
	
	if ($fqshortcode) { 
		foreach($fqshortcode as $fqshortcode){
			$display_quote_id = $fqshortcode->id;
		}
	} else {
		$display_quote_id = 1;
	}
	
	$Free_Quotation_shortcode_quotation =
		"
		Select *
		From $table_name
		WHERE id = '$display_quote_id';
		";
	$fqshortcodeid = $wpdb->get_results($Free_Quotation_shortcode_quotation);
	
	if ($fqshortcodeid) { 
		foreach($fqshortcodeid as $fqshortcodeid_row){
			$quotation = $fqshortcodeid_row->quotation;
			$author = $fqshortcodeid_row->author;
			$life_b = $fqshortcodeid_row->birth_year;
			$life_d = $fqshortcodeid_row->death_year;
			
			if( $life_b && $life_d ){
				$life = $life_b . ' - ' . $life_d;
			} else {
				$life = '';
			}
			
			$note = $fqshortcodeid_row->job_position;
		}
	} else {
		$quotation = 'nothing to display';
	}
	
	require(dirname(__FILE__)."/incloudes/Free_Quotation_displayer.php");

	die();
}
add_action( 'wp_ajax_nopriv_testaction', 'test_callback' );
add_action( 'wp_ajax_testaction', 'test_callback' );

?>