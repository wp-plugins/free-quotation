<?php
$upload_dir = wp_upload_dir();
// EXPORT
if(isset($_POST['submit'])) { 
	ini_set("auto_detect_line_endings", true);
	$fqexport= $wpdb->get_results("SELECT * FROM $table_name", OBJECT_K);
	$file_name = date("/m_d_y_H_i_s").'.csv';
	$path = $upload_dir['path'].$file_name;
	$path_url = $upload_dir['url'].$file_name;
	$fp = fopen($path, 'w');
		foreach($fqexport as $row){
			
			$tag_line='';
			$fqtags = $wpdb->get_results("SELECT * FROM $table_name_tags WHERE id = '$row->id'", OBJECT_K);
			foreach($fqtags as $tag_row){
				if ($tag_line==''){
					$tag_line = $tag_row->tag;
				} else {
					$tag_line = $tag_line . ',' . $tag_row->tag;
				}
			}
			
			$zmienna = '"'.$row->quotation.'";"'.$row->author.'";"'.$row->display_date.'";"'.$row->adding_date.'";"'.$row->week_no.'";"'.$row->week_day.'";"'.$row->quote_group.'";"'.$row->birth_year.'";"'.$row->death_year.'";"'.$row->job_position.'";"'.$tag_line.'";'. PHP_EOL;
			fwrite($fp, $zmienna);
			unset($zmienna);
		}
	fclose($fp);
	?>
	<script type="text/javascript">
		var pathUrl = "<?php echo $path_url; ?>";
		window.location=pathUrl;
	</script>
	<?php
}
?>