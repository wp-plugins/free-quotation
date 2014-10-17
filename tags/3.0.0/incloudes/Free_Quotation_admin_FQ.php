<?php
global $Free_Quotation_version;
global $wpdb;
global $today_date;
global $today_week_no;
global $today_week_day;
$table_name = $wpdb->prefix . 'free_quotation_kris_IV';
$table_name_tags = $wpdb->prefix . 'free_quotation_tags';
$fq_installed_ver = get_option("fq_db_version");
?>
<div class="wrap">
		<form method="post" action="options.php">
			<?php settings_fields('Free_Quotation_settings_filed'); ?>
			<?php $options = get_option('Free_Quotation_options'); 
			
			if (!isset($options['fq_kk_option1'])){	$options['fq_kk_option1']='1';};
			if (!isset($options['fq_kk_option2'])){	$options['fq_kk_option2']='en';};
			?>
		</form>
		 <h2><div class="Free_Quotation_header"></div>Free Quotation <?php echo $Free_Quotation_version; ?><a class="add-new-h2" href="admin.php?page=fq_add_CSV">Add file CSV</a></h2>
	<?php if(empty($options['fq_kk_option1'])){?>
		<div id="welcome-panel" class="welcome-panel">
			<div style="color: red; font-size: 1.5em;">
				Pleas configurate Free Quotation. You must chose "Type of quotation display:" before you start use this WordPress plugin!
			</div>
		</div>
	<?php	}?>
	<div id="welcome-panel" class="welcome-panel">
		
		<h3>Add quotation</h3><br>
<?php
// global $fq_db_version;
// $fq_installed_ver = get_option("fq_db_version");
// echo $fq_db_version;
// echo $fq_installed_ver;
?>


<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#display_date').datepicker({
			dateFormat : 'yy-mm-dd',
			firstDay: 1
		});
	});
</script>
<?php
			if(isset($_POST['edit'])){
			   $id = $_POST['edit_rec_id'];  
			   $fqedit = $wpdb->get_results("SELECT * FROM $table_name WHERE id=$id", OBJECT_K);
			foreach($fqedit as $row);
				$tag_line='';
					$fqtags = $wpdb->get_results("SELECT * FROM $table_name_tags WHERE id = '$row->id'", OBJECT_K);
					foreach($fqtags as $tag_row){
						if ($tag_line==''){
							$tag_line = $tag_row->tag;
						} else {
							$tag_line = $tag_line . ',' . $tag_row->tag;
						}
					}
			$editid = $row->id;
			$editquotation = $row->quotation;
			$editauthor = $row->author;
			$editdisplay_data = $row->display_date;
			$editadding_date = $row->adding_date;
			$editgroup = $row->quote_group;
			$editbirthyear = $row->birth_year;
			$editdeathyear = $row->death_year;
			$editjobposition = $row->job_position;
			$edittags = $tag_line;
			}
			
			$fqgroup = $wpdb->get_results("SELECT DISTINCT quote_group FROM $table_name");
			?>

		<form id='reloader' method='post'  onSubmit="<?php if(isset($editid)){
				echo 'return confirm(\'Are you sure?\nWhen you edit this quotation it is impossible to regain it in previous form.\');';}?>">
			<table class="widefat" >
				<thead>
					<tr><th style="width:100%;">Quotation</th></tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<input type="hidden" name="quot_id" value="<?php if (isset($editid)){echo $editid;}; ?>">
							<textarea placeholder="New quotation" style="width:100%;height: 50px;" name="quotation_textarea" required><?php if (isset($editquotation)){echo $editquotation;}else{}; ?></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<table>
								<thead>
									<tr><td style="width:25%">Author</td><td style="width:25%">Birth</td><td style="width:25%">Death</td><td style="width:25%">Note</td>
								</thead>
								<tbody>
									<tr>
										<td><input type="text" name="autor_text" maxlength="50"  placeholder="Author" value="<?php if (isset($editauthor)){echo $editauthor;}; ?>"required></td>
										<td><input type="text" name="birth_date" maxlength="14" placeholder="Birth date" value="<?php if (isset($editbirthyear)){echo $editbirthyear;}; ?>"></td>
										<td><input type="text" name="death_date" maxlength="14" placeholder="Death date" value="<?php if (isset($editdeathyear)){echo $editdeathyear;}; ?>"></td>
										<td><input type="text" name="job_position" maxlength="50" placeholder="Additional note" value="<?php if (isset($editjobposition)){echo $editjobposition;}; ?>"></td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<tr>
						<td>
							<table>
								<thead>
									<tr><td>Display Date</td><td colspan="2">Group (chose or add new)</td><td>Tags <i>(separate by "," [coma]) (expamle: tag, tags, bigTag)</i></td>
								</thead>
								<tbody>
									<tr>
										<td><input  placeholder="chose a date" type="text" id="display_date" name="display_date" size="10" value="<?php if (isset($editdisplay_data)){echo $editdisplay_data;}; ?>"  
											<?php if (isset($options['fq_kk_option3'])) {} else {echo 'readonly';}?> required></td>
										<td colspan="2"><select name="group">
											<?php
												if (isset($editgroup)) {
													echo '<option selected="selected">'.$editgroup.'</option>';
												}
												foreach($fqgroup as $gropu_name) {
													$group_value = $gropu_name->quote_group;
													if ($group_value == $editgroup) {
													} else{
														echo '<option>'.$group_value.'</option>';
													}
												} 
											?>
										</select>
										<input type="text" name="group_txt" size="10" maxlength="10" value="" placeholder="new group">
										</td>
										<td><input type="text" id="all_tags" name="all_tags" style="width:292px;" value="<?php if (isset($edittags)){echo $edittags;}; ?>" placeholder="add tags"/></td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
			
			<input class="button button-primary" type="submit" name="submit" value="<?php if (isset($editid)){echo 'Edit';}else{echo 'Submit';}; ?>" style="width:140px;"/>
			<input type="hidden" value="<?=md5(time())?>" name="reloader" />
			<?php if (isset($editid)){wp_nonce_field( 'updateFeedback' );}else{wp_nonce_field( 'insertFeedbdack' );};  ?>
			<input name="action" type="hidden" id="action" value="<?php if (isset($editid)){echo 'updateFeedback';}else{echo 'insertFeedback';}; ?>"/>
				
		</form><br>
	</div>
	<?php

	if(isset($_POST["quotation_textarea"])){
		global $current_user;
		$ufUserID = $current_user->ID;
		$id = $_POST["quot_id"] ;
        $quotation = $_POST["quotation_textarea"];
        $author = $_POST["autor_text"];
		$birth_date = $_POST["birth_date"];
		$death_date = $_POST["death_date"];
		$job_position = $_POST["job_position"];
        $display_date = $_POST["display_date"];
		$week_no = date('W', strtotime($display_date));
		$week_day = date('N', strtotime($display_date));
		$grup_tester_trim=trim($_POST["group_txt"]);
		if(empty($grup_tester_trim)) {
			$group_name = $_POST["group"];
		} else {
			$group_name = trim($_POST["group_txt"]);
		}
        $tag_separate_by_coma = $_POST["all_tags"];
		
		
		$url = $_SERVER['PHP_SELF'];
		$adding_date = $today_date;
			if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'updateFeedback' ) {
				$fq_quote_edit = $wpdb->update( $table_name, array( 'quotation' => $quotation, 'author' => $author, 'display_date' => $display_date, 'adding_date' => $adding_date, 'week_no' => $week_no, 'week_day' => $week_day, 'quote_group' => $group_name, 'birth_year' => $birth_date, 'death_year' => $death_date, 'job_position' => $job_position), array('id'=>$id));
				
				$fqtags = $wpdb->get_results("SELECT * FROM $table_name_tags WHERE id = '$id'", OBJECT_K);
				
				$tag_line = '';
				
				foreach($fqtags as $tag_row){
					if ($tag_line==''){
						$tag_line = $tag_row->tag;
					} else {
						$tag_line = $tag_line . ',' . $tag_row->tag;
					}
				}
				$tag_array_source = explode(",", $tag_line);
				
				$tag_test_res = trim($tag_separate_by_coma);
				$tag_test_res = str_replace(', ',',',$tag_test_res);
				$tag_test_res = str_replace(' ,',',',$tag_test_res);
				$tag_array = explode(",", $tag_test_res);
				
				$tag_to_remove=array_diff($tag_array_source,$tag_array);
				$tag_to_remove = array_values($tag_to_remove);
				$tag_to_remove_size = count($tag_to_remove);
				
				for($i=0; $i<$tag_to_remove_size; $i++){
					$fqdelete = $wpdb->delete( $table_name_tags, array( 'id' => $id, 'tag' => $tag_to_remove[$i]), array( '%d', '%s' ));
				}	
				
				$tag_to_add=array_diff($tag_array, $tag_array_source);
				$tag_to_add = array_values($tag_to_add);
				$tag_to_add_size = count($tag_to_add);
				
				for($i=0; $i<$tag_to_add_size; $i++){
					$fqadd= $wpdb->insert( $table_name_tags, array( 'id' => $id, 'tag' => $tag_to_add[$i]), array( '%d', '%s' ));
				}
			}			
			if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'insertFeedback' ) {
				$fq_quote_insert = $wpdb->insert( $table_name, array( 'quotation' => $quotation, 'author' => $author, 'display_date' => $display_date, 'adding_date' => $adding_date, 'week_no' => $week_no, 'week_day' => $week_day, 'quote_group' => $group_name, 'birth_year' => $birth_date, 'death_year' => $death_date, 'job_position' => $job_position), array('%s', '%s', '%s', '%s', '%d', '%d', '%s', '%s', '%s', '%s') );
				
				$inserted_id = mysql_insert_id();
				
				$tag_test_res = trim($tag_separate_by_coma);
				$tag_test_res = str_replace(', ',',',$tag_test_res);
				$tag_test_res = str_replace(' ,',',',$tag_test_res);
				$tag_array = explode(",", $tag_test_res);
				$tag_size = count($tag_array);

				for( $i=0 ; $i<$tag_size ; $i++){
					if($tag_array[$i]!=''){
						$fq_quote_insert = $wpdb->insert( $table_name_tags, array( 'id' => $inserted_id, 'tag' =>$tag_array[$i]), array('%d', '%s') );
					}
				}
			}
		}else{}
?>
<script>
jQuery(document).ready( function($){
    $('#sortable').dataTable( {
	        "aaSorting": [[ 4, "desc" ]],
			"aLengthMenu": [[25, 50, 75, -1], [25, 50, 75, "All"]],
			"iDisplayLength": 25
	} );
});
</script>		
<script language="JavaScript">
function toggle(source) {
  checkboxes = document.getElementsByName('checkbox[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>
	<div id="welcome-panel" class="welcome-panel">
	<?php
			 if(isset($_POST['gdelete'])){
					if(isset($_POST['checkbox'])){$checkbox = $_POST['checkbox'];
						$count = count($checkbox);
						for($i = 0; $i < $count; $i++) {
							$id = (int) $checkbox[$i]; // Parse your value to integer
							if ($id > 0) { // and check if it's bigger then 0
								$fqdelete = $wpdb->delete( $table_name, array( 'id' => $id), array( '%d' ));
							} else { echo 'nothing';};
						}
					} else {echo '<script type="text/javascript">alert("You should check minimum one checkbox!");</script>'; }
				}
		?>
		<form id="groupdelete" method="post" action="" onSubmit="return confirm('Are you sure?');">	
		
		<table class="widefat sortable" id="sortable" style="width:100%;" >
		
			<?php 
				if(isset($_POST['delete'])){
				   $id = $_POST['delete_rec_id'];  
				   $fqdelete = $wpdb->delete( $table_name, array( 'id' => $id), array( '%d' ));
				}
					//nagłówek
				echo '<thead style="cursor:pointer"><tr><th style="width:20px;">
				<input class="button button-primary"  name="gdelete" type="submit" id="gdelete" value="Delete" style="margin-bottom:2px;"><br/><input type="checkbox" onClick="toggle(this)"  style="margin-top:2px;"/> All</th><th style="width:30px;"> ID </th><th> Quotation </th><th  style="width:170px;"> Author </th>';
				if ($options['fq_kk_option1']=='5' || $options['fq_kk_option1']=='6'){
				if ($options['fq_kk_option1']=='5') {
				echo '<th style="width:50px;"> Week no. </th>';}
				if ($options['fq_kk_option1']=='6') {
				echo '<th style="width:70px;"> Week day </th>';}}
				echo '<th style="width:100px;"> Display Date </th><th style="width:90px;"> Group </th><th style="width:90px;">Birth - Death</th><th style="width:90px;">Note</th><th style="width:40px;"> Tags </th><th style="width:40px;"> Edit </th><th style="width:40px;"> Delete </th></tr></thead><tbody>';
				
					//treść	foreach ( $Free_Quotation_table as $ogresults ) 

				$fqshowtable = $wpdb->get_results("SELECT * FROM $table_name WHERE id ORDER BY id DESC", OBJECT_K);
				foreach($fqshowtable as $row){
					$tag_line='';
					$fqtags = $wpdb->get_results("SELECT * FROM $table_name_tags WHERE id = '$row->id'", OBJECT_K);
					foreach($fqtags as $tag_row){
						if ($tag_line==''){
							$tag_line = $tag_row->tag;
						} else {
							$tag_line = $tag_line . ',' . $tag_row->tag;
						}
					}
					
					echo '<tr><td>';?>
							<input name="checkbox[]" type="checkbox" id="checkbox[]"  value="<?php print $row->id; ?>">
			<?php	echo '</td><td>' . $row->id.'</td><td>'. stripslashes( $row->quotation ) . '</td><td>' . stripslashes( $row->author ) .'</td>';
			if ($options['fq_kk_option1']=='5' || $options['fq_kk_option1']=='6'){
			if ($options['fq_kk_option1']=='5'){
			echo '<td>'.$row->week_no.'</td>';}
			if ($options['fq_kk_option1']=='6'){
			echo '<td>';
			$week_day_text_var = $row->week_day;
			if ($week_day_text_var=='1'){
			echo 'Monday';}
			elseif ($week_day_text_var=='2'){
			echo 'Tuesday';}
			elseif ($week_day_text_var=='3'){
			echo 'Wednesday';}
			elseif ($week_day_text_var=='4'){
			echo 'Thursday';}
			elseif ($week_day_text_var=='5'){
			echo 'Friday';}
			elseif ($week_day_text_var=='6'){
			echo 'Saturday';}
			elseif ($week_day_text_var=='7'){
			echo 'Sunday';}
			echo '</td>';}
			}
			echo '<td>'.$row->display_date.'</td><td>'.$row->quote_group.'</td><td>'.$row->birth_year.' - '.$row->death_year.'</td><td>'.$row->job_position.'</td>
			<td>'. $tag_line .'</td><td>';?>
					<form id="clerer" method="post" action="">
					</form>  
					<form id="edit" method="post" action="">
							<input type="hidden" name="edit_rec_id" value="<?php print $row->id; ?>"/> 
							<input style="width:50px;" class="button button-primary"  type="submit" name="edit" value="Edit"/>    
						</form>  		
						</td><td>
					<form id="delete" method="post" action="" onSubmit="return confirm('Are you sure?\nIf you delete this quotation it is impossible to regain it.');">
							<input type="hidden" name="delete_rec_id" value="<?php print $row->id; ?>"/> 
							<input class="button button-primary"  type="submit" name="delete" value="Delete!"/>    
						</form>  <?
					 echo '</td></tr>';
					 }
				
				echo '</tbody><tfoot style="cursor:pointer"><tr><th>
				<input class="button button-primary"  name="gdelete" type="submit" id="gdelete" value="Delete"></th><th> ID </td><th> Quotation </td><th> Author </td>';
				if ($options['fq_kk_option1']=='5' || $options['fq_kk_option1']=='6'){
				if ($options['fq_kk_option1']=='5'){
				echo '<th> Week no. </th>';}
				if ($options['fq_kk_option1']=='6') {
				echo '<th> Week day </th>';}}
				echo '<th> Display Date </th><th> Group </th><th>Birth-death</th><th>Note</th><th>Tags</th><th> Edit </th><th> Delete </td></tr></tfoot>';
				?>
		</table>
		
		</form>
	</div>
</div>	<?php 

?>