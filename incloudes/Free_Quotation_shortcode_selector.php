<?php
global $wpdb;
$options = get_option('Free_Quotation_options'); 
$table_name = $wpdb->prefix . 'free_quotation_kris_IV';
$table_name_tags = $wpdb->prefix . 'free_quotation_tags';

$id2_rand = $instance['id2_rand'];
$fq2_ask_title = $instance['fq2_ask_title'];
$fq2_title = $instance['title2'];
$fq_select_level = $instance['fq_select_level'];
$fq_select_elements = $instance['fq_select_elements'];
$fq_select_tags = $instance['fq_select_tags'];
$tags_to_display = $instance['tags_to_display'];


if ($fq2_ask_title==1){
echo '<h3>'.$fq2_title.'</h3>';
}

$fqtags_array = $wpdb->get_results("SELECT * FROM $table_name_tags GROUP BY tag ORDER BY RAND() LIMIT $fq_select_elements", OBJECT_K);

$check_empty = array_filter($fqtags_array);

if(isset($options['fq_kk_sc_color'])){htmlentities($tag_background_color = $options['fq_kk_sc_color']);}else{$tag_background_color = '#666666';};
if(isset($options['fq_kk_sc_color_2'])){htmlentities($tag_border_color = $options['fq_kk_sc_color_2']);}else{$tag_border_color = '#000000';};
if(isset($options['fq_kk_sc_color_3'])){htmlentities($tag_text_color = $options['fq_kk_sc_color_3']);}else{$tag_text_color = '#000000';};
if(isset($options['fq_kk_sc_border_size'])){htmlentities($tag_border_size = $options['fq_kk_sc_border_size']);}else{$tag_border_size = '1';};
if(isset($options['fq_kk_sc_width'])){htmlentities($tag_width = $options['fq_kk_sc_width']);}else{$tag_width = 'auto';};
if(isset($options['fq_kk_sc_align'])){htmlentities($tag_align = $options['fq_kk_sc_align']);}else{$tag_align = 'center';};

$tag_style_variable = 'background: ' . $tag_background_color . '; border: ' . $tag_border_size . 'px ' . 'solid ' . $tag_border_color . '; color: ' . $tag_text_color . '; width: ' . $tag_width . 'px; text-align: ' . $tag_align . ';';

echo '<div id="shortcode_to">';


if(empty($check_empty)){
	echo 'Lack of tag content';
} else {
	$fqtags_array_map = array_values($fqtags_array);
	$fqtags_array_map_size = count($fqtags_array_map);
	
	if($fq_select_elements<$fqtags_array_map_size){
		$fq_i_limit = $fq_select_elements;
	} else {
		$fq_i_limit = $fqtags_array_map_size;
	}
	
	for ($i=0; $i<$fq_i_limit; $i++){
		?>
		<div class="tag_to_select" style="<?php echo $tag_style_variable;?>"id="<?php echo $fqtags_array_map[$i]->tag; ?>"><?php echo $fqtags_array_map[$i]->tag; ?></div>
		<?php
	}
}

echo '</div>';




?>