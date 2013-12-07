<?php

global $Free_Quotation_version;
global $wpdb;
echo $table_name;
global $today_date;
$table_name = $wpdb->prefix . 'free_quotation_kris_IV';


?>
<div class="wrap">
		<div class="Free_Quotation_header"></div> <h2>Free Quotation <?php echo $Free_Quotation_version; ?><a class="add-new-h2" href="admin.php?page=fq_menu_page_add">Add Free Quotation</a></h2>

		<h4>All quotation</h4>
		
	<div class="Free_Quotation_wrap3">
		<table class="widefat">
		<?php 
			if(isset($_POST['delete'])){
			   $id = $_POST['delete_rec_id'];  
			   $fqdelete = $wpdb->delete( $table_name, array( 'id' => $id), array( '%d' ));
			}

				//nagłówek
			echo '<thead><tr><th style="width:10px;"> ID </th><th> Quotation </th><th  style="width:170px;"> Author </th><th style="width:100px;"> Display Date </th><th style="width:40px;"> Delete </th></tr></thead>';
				//treść	foreach ( $Free_Quotation_table as $ogresults ) 

			$fqshowtable = $wpdb->get_results("SELECT * FROM $table_name WHERE id ORDER BY display_date DESC", OBJECT_K);
			foreach($fqshowtable as $row){
				echo '<tr><td>' . $row->id.'</td><td>'.$row->quotation.'</td><td>'.$row->author.'</td><td>'.$row->display_date.'</td><td>';?>
					<form id="delete" method="post" action="">
						<input type="hidden" name="delete_rec_id" value="<?php print $row->id; ?>"/> 
						<input type="submit" name="delete" value="Delete!"/>    
					</form><?
				 echo '</td></tr>';
				 }
			
			echo '<tfoot><tr><th> ID </td><th> Quotation </td><th> Author </td><th> Display Date </th><th> Delete </td></tr></tfoot>';
			?>
		</table>
	</div>
</div>	<?php 

?>