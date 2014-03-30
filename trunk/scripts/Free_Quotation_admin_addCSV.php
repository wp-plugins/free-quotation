<?php
global $Free_Quotation_version;
global $wpdb;
global $today_date;
$table_name = $wpdb->prefix . 'free_quotation_kris_IV';
?>
<script>
var showInstructionText = "Show instruction";
</script>

<div class="wrap">	
	 <h2><div class="Free_Quotation_header"></div>Free Quotation <?php echo $Free_Quotation_version; ?><a class="add-new-h2" href="admin.php?page=fq_menu_page">Add Free Quotation</a></h2></h2>

<div id="welcome-panel" class="welcome-panel">

	<h3>Add CSV file</h3>
<?php
if (isset($_FILES['csv'])){
	if ($_FILES['csv']['size'] > 0) {

    //get the csv file
    $file = $_FILES['csv']['tmp_name'];
    $handle = fopen($file,"r");
    
    //loop through the csv file and insert into database
	    do {
			if (isset($data)){
				if ($data[0]) {
					$fqinsert = $wpdb->insert( $table_name, array ('quotation' => addslashes($data[0]), 'author' => addslashes($data[1]),  'display_date' => addslashes($data[2]), 'adding_date' =>addslashes($today_date), 'quote_group' =>addslashes($data[5])), array ('%s', '%s', '%s', '%s', '%s'));       
				}
			}
		// do {
			// if ($data[0]) {
				// mysql_query("INSERT INTO $table_name (quotation, author, display_date, adding_date) VALUES
					// (
						// '".addslashes($data[0])."',
						// '".addslashes($data[1])."',
						// '".addslashes($data[2])."',
						// '".addslashes($today_date)."'
					// )
				// ");
			// }
		$datasuccess = "Your file has been successfully imported.";
		} while ($data = fgetcsv($handle,1000,';','"'));
			
			$fq_week_no_edit = $wpdb->get_results("SELECT * FROM $table_name WHERE id ORDER BY id DESC", OBJECT_K);
			foreach($fq_week_no_edit as $row){
						$operateid = $row->id;
						$operatedisplay_data = $row->display_date;
						$operateadding_date = $row->adding_date;
						$week_no_data = $row->week_no;
						$week_no_day = $row->week_day;
						$display_group = $row->quote_group;
			if ($week_no_data=="0"){			
			$week_no_data_edit = date('W', strtotime($operatedisplay_data));
			$fqinsert = $wpdb->update( $table_name, array( 'display_date' => $operatedisplay_data, 'week_no' => $week_no_data_edit), array('id'=>$operateid));
			}
			if ($week_no_day=="0"){			
			$week_no_day_edit = date('N', strtotime($operatedisplay_data));
			$fqinsert = $wpdb->update( $table_name, array( 'display_date' => $operatedisplay_data, 'week_day' => $week_no_day_edit), array('id'=>$operateid));
			}
			if ($display_group==null){			
			$display_group_edit = "main group";
			$fqinsert = $wpdb->update( $table_name, array( 'display_date' => $operatedisplay_data, 'quote_group' => $display_group_edit), array('id'=>$operateid));
			}}
	}
}?>

<?php 
if (isset($datasuccess)){
if ($datasuccess==null){echo 'Import is not finish yet. If you try and you doesn\'t see positive message - look for FAQ, forum or ask question<br>';} else {echo '<div style="font-weight:bold; font-size:15px; background:yellow; width: 300px; text-align:center; padding: 5px;">' . $datasuccess . '</div>';}}; ?>
<br>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">

  <input  class="search-submit" name="csv" type="file" id="csv" />
  <input class="button button-primary" type="submit" name="Submit" value="Submit" />
</form>
<br>
</div>

<div id="welcome-panel" class="welcome-panel" style="background:#ffffbb; padding-bottom: 20px;">

<h2 style="float:left;">Instruction for CSV file</h2>
<input class="button button-primary button_show_instruction" type="submit" value="Show or hide" onclick="showInstructionFQ()" />

<div id="hidden_instruction" style="display:none;">
<h4>The Format of CSV File must be as below :</h4>
<div style="line-height:2em;border:1px solid #dedede;padding-left:10px; background:#efefef; border-radius:5px;">"Quotation";"Author";"Display date";"";"";"Group"<br>
"Quotation2";"Author2";"Display date2";"";"";"Group";<br>
"Quotation3";"Author3";"Display date3";"";"";"Group";</div><br>

You can (but it's highly non recommended!!!) use quotation marks inside a quotation. Pleas remember about it!<br>
This is example like it shouldn't look:<br>
<div style="line-height:2em;border:1px solid #dedede;padding-left:10px; background:#efefef; border-radius:5px;">"I quote <b>"your quotation"</b>";"Author";"Display date";"";"";"Group";</div><br>

Display date should be in good format: "<b>YYYY-MM-DD</b>". Be careful when you create your CSV file. If you use date DD like 32 the system always accept it! It's not wrong for them. 
<div style="line-height:2em;border:1px solid #dedede;padding-left:10px; background:#efefef; border-radius:5px;">"Quotation";"Author";"2013-11-29";"";"";"Group";<br>
"Quotation2";"Author2";"2013-11-30";"";"";"Group";<br>
"Quotation3";"Author3";"2013-12-01";"";"";"Group";</div><br>

You should remember, that the name of group can't be longer than 10 characters. It means, that the name "main group" have 10 characters (we calculate also space). If your name is longer the Free Quotation can non accept your request to upload CSV file or it can be change on "main group" what is the default value.
<div style="line-height:2em;border:1px solid #dedede;padding-left:10px; background:#efefef; border-radius:5px;">"Quotation";"Author";"2013-11-29";"";"";"main group";<br>
"Quotation2";"Author2";"2013-11-30";"";"";"main group";<br>
"Quotation3";"Author3";"2013-12-01";"";"";"main group";</div><br>

You can use Microsoft Excel to create CSV in good format in easy way. In every one column you can give different information and you can sum it in special way when you use good formula (=A1&A2&A3 and so on).

</div>
</div>

<script>
var showCssInstruction = localStorage.getItem('show-or-hide-css-instruction');
if (showCssInstruction=='true'){
	var showInstructionFQdiv = document.getElementById("hidden_instruction");
	showInstructionFQdiv.style.display = "inline";
} else if  (showCssInstruction=='false') {
	var showInstructionFQdiv = document.getElementById("hidden_instruction");
	showInstructionFQdiv.style.display = "none";
} else {
	var showInstructionFQdiv = document.getElementById("hidden_instruction");
	showInstructionFQdiv.style.display = "none";
}

function showInstructionFQ() {
	var showCssInstruction = localStorage.getItem('show-or-hide-css-instruction');
	if (showCssInstruction=='true')
	{
	localStorage.setItem('show-or-hide-css-instruction','false')
	var showInstructionFQdiv = document.getElementById("hidden_instruction");
	showInstructionFQdiv.style.display = "none";
	} else {
	localStorage.setItem('show-or-hide-css-instruction','true')
	var showInstructionFQdiv = document.getElementById("hidden_instruction");
	showInstructionFQdiv.style.display = "inline";
	}
}
</script>
	<?php 
?>