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
			$zmienna = '"'.$row->quotation.'";"'.$row->author.'";"'.$row->display_date.'";"'.$row->adding_date.'";"'.$row->week_no.'";"'.$row->week_day.'";"'.$row->quote_group.'";'. PHP_EOL;
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