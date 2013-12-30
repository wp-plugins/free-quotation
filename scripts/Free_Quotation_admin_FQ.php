<?php
global $Free_Quotation_version;
global $wpdb;
global $today_date;
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

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#display_date').datepicker({
			dateFormat : 'yy-mm-dd'
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
			}
?>
		<form id='reloader' method='post' onSubmit="<?php echo $url;?>">
			<table class="widefat" >
				<thead>
				<tr><th style="width:100%;">Quotation</th><th style="width:170px;">Author</th><th style="width:140px;">Display Date</th></tr>
				</thead>
				<tbody>
				<tr><td>
				<input style="display:none;" type="text" name="quot_id" value="<?php if (isset($editid)){echo $editid;}; ?>">
				<textarea style="width:100%;" name="quotation_textarea" required><?php if (isset($editquotation)){echo $editquotation;}else{}; ?></textarea>
				</td>
				<td>
				</input>
				<input type="text" name="autor_text" value="<?php if (isset($editauthor)){echo $editauthor;}; ?>"required>
				</input>
				</td>
				<td>    
				<input type="text" id="display_date" name="display_date" size="30" value="<?php if (isset($editdisplay_data)){echo $editdisplay_data;}; ?>"  
				<?php if (isset($options['option3'])) {} else {echo 'readonly';}?> required>
				<div style="margin-left:10px;">(rrrr-mm-dd)</div>
				</td></th>
				</tbody>
				<tfoot>
				<tr><th style="width:100%;"></th><th style="width:170px;"></th><th style="width:140px;">
				<input class="button button-primary" type="submit" name="submit" value="<?php if (isset($editid)){echo 'Edit';}else{echo 'Submit';}; ?>"  style="width:140px;"/>
				<input type="hidden" value="<?=md5(time())?>" name="reloader" />
				<?php if (isset($editid)){wp_nonce_field( 'updateFeedback' );}else{wp_nonce_field( 'insertFeedbdack' );};  ?>
				<input name="action" type="hidden" id="action" value="<?php if (isset($editid)){echo 'updateFeedback';}else{echo 'insertFeedback';}; ?>"/>
				
				</th></tr>
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
		$url = $_SERVER['PHP_SELF'];
		$adding_date = $today_date;
			if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'updateFeedback' ) {
				$fqinsert = $wpdb->update( $table_name, array( 'quotation' => $quotation, 'author' => $author, 'display_date' => $display_date, 'adding_date' => $adding_date), array('id'=>$id));
			}			
			if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'insertFeedback' ) {
				$fqinsert = $wpdb->insert( $table_name, array( 'quotation' => $quotation, 'author' => $author, 'display_date' => $display_date, 'adding_date' => $adding_date), array('%s', '%s', '%s', '%s') );
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

	<div id="welcome-panel" class="welcome-panel">
	
	<table class="widefat sortable" id="sortable" style="width:100%;" >
		
		<?php 
			if(isset($_POST['delete'])){
			   $id = $_POST['delete_rec_id'];  
			   $fqdelete = $wpdb->delete( $table_name, array( 'id' => $id), array( '%d' ));
			}


				//nagłówek
			echo '<thead><tr><th style="width:30px;"> ID </th><th> Quotation </th><th  style="width:170px;"> Author </th><th style="width:100px;"> Display Date </th><th style="width:40px;"> Edit </th><th style="width:40px;"> Delete </th></tr></thead><tbody>';
			
				//treść	foreach ( $Free_Quotation_table as $ogresults ) 

			$fqshowtable = $wpdb->get_results("SELECT * FROM $table_name WHERE id ORDER BY id DESC", OBJECT_K);
			foreach($fqshowtable as $row){
				echo '<tr><td>' . $row->id.'</td><td>'.$row->quotation.'</td><td>'.$row->author.'</td><td>'.$row->display_date.'</td><td>';?>
					<form id="edit" method="post" action="">
						<input type="hidden" name="edit_rec_id" value="<?php print $row->id; ?>"/> 
						<input style="width:50px;" class="button button-primary"  type="submit" name="edit" value="Edit"/>    
					</form>				
					</td><td>
					<form id="delete" method="post" action="">
						<input type="hidden" name="delete_rec_id" value="<?php print $row->id; ?>"/> 
						<input class="button button-primary"  type="submit" name="delete" value="Delete!"/>    
					</form><?
				 echo '</td></tr>';
				 }
			
			echo '</tbody><tfoot><tr><th> ID </td><th> Quotation </td><th> Author </td><th> Display Date </th><th style="width:40px;"> Edit </th><th> Delete </td></tr></tfoot>';
			?>
		</table>
	</div>
</div>	<?php 

?>