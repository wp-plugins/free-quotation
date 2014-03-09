<?php
global $Free_Quotation_version;
global $wpdb;
global $today_date;
global $today_week_no;
global $today_week_day;
$table_name = $wpdb->prefix . 'free_quotation_kris_IV';
?>
<div class="wrap">
		 <h2><div class="Free_Quotation_header"></div>Free Quotation <?php echo $Free_Quotation_version; ?><a class="add-new-h2" href="admin.php?page=fq_add_CSV">Add file CSV</a></h2>
		
	<div id="welcome-panel" class="welcome-panel">
	
		<h3>Add quotation</h3><br>
		<form method="post" action="options.php">
			<?php settings_fields('Free_Quotation_settings_filed'); ?>
			<?php $options = get_option('Free_Quotation_options'); ?>
		</form>
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
			$editid = $row->id;
			$editquotation = $row->quotation;
			$editauthor = $row->author;
			$editdisplay_data = $row->display_date;
			$editadding_date = $row->adding_date;
			$editgroup = $row->quote_group;
			}
			
			$fqgroup = $wpdb->get_results("SELECT DISTINCT quote_group FROM $table_name");
			?>

		<form id='reloader' method='post'  onSubmit="<?php if(isset($editid)){
				echo 'return confirm(\'Are you sure?\nWhen you edit this quotation it is impossible to regain it in previous form.\');';}?>">
			<table class="widefat" >
				<thead>
				<tr><th style="width:100%;">Quotation</th><th>Group</th><th>Author</th><th>Display Date</th></tr>
				</thead>
				<tbody>
				<tr><td>
				<input style="display:none;" type="text" name="quot_id" value="<?php if (isset($editid)){echo $editid;}; ?>">
				<textarea style="width:100%;" name="quotation_textarea" required><?php if (isset($editquotation)){echo $editquotation;}else{}; ?></textarea>
				</td>
				<td>
				<select name="group">
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
				or add new group:
				<input type="text" name="group_txt" size="10" maxlength="10" value="">
				</input>
				</td>
				<td>
				</input>
				<input type="text" name="autor_text" value="<?php if (isset($editauthor)){echo $editauthor;}; ?>"required>
				</input>
				</td>
				<td>    
				<input type="text" id="display_date" name="display_date" size="10" value="<?php if (isset($editdisplay_data)){echo $editdisplay_data;}; ?>"  
				<?php if (isset($options['option3'])) {} else {echo 'readonly';}?> required>
				<div style="margin-left:10px;">(rrrr-mm-dd)</div>
				</td></th>
				</tbody>
				<tfoot>
				<tr><th style="width:100%;"></th><th style="width:170px;"></th><th style="width:140px;">
				<input class="button button-primary" type="submit" name="submit" value="<?php if (isset($editid)){echo 'Edit';}else{echo 'Submit';}; ?>" style="width:140px;"/>
				<input type="hidden" value="<?=md5(time())?>" name="reloader" />
				<?php if (isset($editid)){wp_nonce_field( 'updateFeedback' );}else{wp_nonce_field( 'insertFeedbdack' );};  ?>
				<input name="action" type="hidden" id="action" value="<?php if (isset($editid)){echo 'updateFeedback';}else{echo 'insertFeedback';}; ?>"/>
				
				</th><th></th></tr>
				</tfoot>
			</table>
		</form><br>
	</div>
	<?php

	if(isset($_POST["quotation_textarea"])){
		global $current_user;
		$ufUserID = $current_user->ID;
		$id = $_POST["quot_id"] ;
        $quotation = $_POST["quotation_textarea"];
        $author = $_POST["autor_text"];
        $display_date = $_POST["display_date"];
		$week_no = date('W', strtotime($display_date));
		$week_day = date('N', strtotime($display_date));
		$grup_tester_trim=trim($_POST["group_txt"]);
		if(empty($grup_tester_trim)) {
			$group_name = $_POST["group"];
		} else {
			$group_name = trim($_POST["group_txt"]);
		}	
		$url = $_SERVER['PHP_SELF'];
		$adding_date = $today_date;
			if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'updateFeedback' ) {
				$fqinsert = $wpdb->update( $table_name, array( 'quotation' => $quotation, 'author' => $author, 'display_date' => $display_date, 'adding_date' => $adding_date, 'week_no' => $week_no, 'week_day' => $week_day, 'quote_group' => $group_name), array('id'=>$id));
			}			
			if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'insertFeedback' ) {
				$fqinsert = $wpdb->insert( $table_name, array( 'quotation' => $quotation, 'author' => $author, 'display_date' => $display_date, 'adding_date' => $adding_date, 'week_no' => $week_no, 'week_day' => $week_day, 'quote_group' => $group_name), array('%s', '%s', '%s', '%s', '%d', '%d', '%s') );
			}
		}else{}
?>
<script>
jQuery(document).ready( function($){
    $('#sortable').dataTable( {
	        "aaSorting": [[ 0, "desc" ]]
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
				if ($options['option1']=='5' || $options['option1']=='6'){
				if ($options['option1']=='5') {
				echo '<th style="width:50px;"> Week no. </th>';}
				if ($options['option1']=='6') {
				echo '<th style="width:70px;"> Week day </th>';}}
				echo '<th style="width:100px;"> Display Date </th><th style="width:90px;"> Group </th><th style="width:40px;"> Edit </th><th style="width:40px;"> Delete </th></tr></thead><tbody>';
				
					//treść	foreach ( $Free_Quotation_table as $ogresults ) 

				$fqshowtable = $wpdb->get_results("SELECT * FROM $table_name WHERE id ORDER BY id DESC", OBJECT_K);
				foreach($fqshowtable as $row){
					echo '<tr><td>';?>
							<input name="checkbox[]" type="checkbox" id="checkbox[]"  value="<?php print $row->id; ?>">
			<?php	echo '</td><td>' . $row->id.'</td><td>'.$row->quotation.'</td><td>'.$row->author.'</td>';
			if ($options['option1']=='5' || $options['option1']=='6'){
			if ($options['option1']=='5'){
			echo '<td>'.$row->week_no.'</td>';}
			if ($options['option1']=='6'){
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
			echo '<td>'.$row->display_date.'</td><td>'.$row->quote_group.'</td><td>';?>
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
				if ($options['option1']=='5' || $options['option1']=='6'){
				if ($options['option1']=='5'){
				echo '<th> Week no. </th>';}
				if ($options['option1']=='6') {
				echo '<th> Week day </th>';}}
				echo '<th> Display Date </th><th> Group </th><th> Edit </th><th> Delete </td></tr></tfoot>';
				?>
		</table>
		
		</form>
	</div>
</div>	<?php 

?>