<?php
global $wpdb;
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
$fqtags_array_map = array_values($fqtags_array);

echo '<div id="shortcode_to">';

for ($i=0; $i<$fq_select_elements; $i++){
	?>
	<div class="tag_to_select" id="<?php echo $fqtags_array_map[$i]->tag; ?>"><?php echo $fqtags_array_map[$i]->tag; ?></div>
	<?php
}

echo '</div>';

?>