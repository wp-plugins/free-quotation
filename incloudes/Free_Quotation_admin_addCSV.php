<?php
global $Free_Quotation_version;
global $wpdb;
global $today_date;
$table_name = $wpdb->prefix . 'free_quotation_kris_IV';
    $table_name_tags = $wpdb->prefix . 'free_quotation_tags';
?>
<script>
var showInstructionText = "Show instruction";
</script>

<div class="wrap">	
	 <h2><div class="Free_Quotation_header"></div>Free Quotation <?php echo $Free_Quotation_version; ?><a class="add-new-h2" href="admin.php?page=fq_menu_page">Add Free Quotation</a></h2></h2>

<div id="welcome-panel" class="welcome-panel">

	<h3>Import CSV file</h3>
	
	<?php
		require 'Free_Quotation_import_csv.php';
	?>

<br>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">

  <input  class="search-submit" name="csv" type="file" id="csv" />
  <input class="button button-primary" type="submit" name="Submit" value="Submit" />
</form>
<br>
</div>

<div id="welcome-panel" class="welcome-panel">

	<h3>Export to CSV file</h3>
	
	<form action="" method="post"> 
		<input class="button button-primary"  type="submit" name="submit" value="Export"  style="margin-top:20px; margin-bottom:35px;"> 
	</form> 
	
	<?php
		require 'Free_Quotation_export_csv.php';
	?>

</div>

<div id="welcome-panel" class="welcome-panel" style="background:#ffffbb; padding-bottom: 20px;">

<h2 style="float:left;">Any problem with CSV file?</h2>
<input class="button button-primary button_show_instruction" type="submit" value="Show or hide help" onclick="showInstructionFQ()" />

<div id="hidden_instruction" style="display:none;">

<h3 style=" margin-top:20px;">Help for "Import CSV file" section:</h3>

<h4>The Format of CSV File must be as below :</h4>
<div style="line-height:2em;border:1px solid #dedede;padding-left:10px; background:#efefef; border-radius:5px;">"Quotation";"Author";"Display date";"";"";"";"Group";"Birth date";"Death date";"Additional note";"Tag,tag2,tag3,tag4";<br>
"Quotation2";"Author2";"Display date";"";"";"";"Group";"Birth date";"Death date";"Additional note";"Tag,tag2,tag3,tag4";<br>
"Quotation3";"Author3";"Display date";"";"";"";"Group";"Birth date";"Death date";"Additional note";"Tag,tag2,tag3,tag4";</div><br>

Of course - it can be richer like:<br>
<div style="line-height:2em;border:1px solid #dedede;padding-left:10px; background:#efefef; border-radius:5px;">"Quotation";"Author";"Display date";"Adding date";"week number";"week day";"Group";"Birth date";"Death date";"Additional note";"Tag,tag2,tag3,tag4";</div>
but all additional data (Adding date, week number, week day) are recalculate during CSV import process. It's necessary to recalculate all this data because you need keep your database clean.<br><br>

You can (but it's highly non recommended!!!) use quotation marks inside a quotation. Pleas remember about it!<br>
This is example like it shouldn't look:<br>
<div style="line-height:2em;border:1px solid #dedede;padding-left:10px; background:#efefef; border-radius:5px;">"I quote <b>"your quotation"</b>";"Author";"Display date";"";"";"";"Group";"Birth date";"Death date";"Additional note";"Tag,tag2,tag3,tag4";</div><br>

Display date should be in good format: "<b>YYYY-MM-DD</b>". Be careful when you create your CSV file. If you use date DD like 32 the system always accept it! It's not wrong for them. 
<div style="line-height:2em;border:1px solid #dedede;padding-left:10px; background:#efefef; border-radius:5px;">"Quotation";"Author";"2013-11-29";"";"";"";"Group";"Birth date";"Death date";"Additional note";"Tag,tag2,tag3,tag4";<br>
"Quotation2";"Author2";"2013-11-30";"";"";"";"Group";"Birth date";"Death date";"Additional note";"Tag,tag2,tag3,tag4";<br>
"Quotation3";"Author3";"2013-12-01";"";"";"";"Group";"Birth date";"Death date";"Additional note";"Tag,tag2,tag3,tag4";</div><br>

You should remember, that the name of group can't be longer than 10 characters. It means, that the name "main group" have 10 characters (we calculate also space). If your name is longer the Free Quotation can non accept your request to upload CSV file or it can be change on "main group" what is the default value.
<div style="line-height:2em;border:1px solid #dedede;padding-left:10px; background:#efefef; border-radius:5px;">"Quotation";"Author";"2013-11-29";"";"";"";"main group";"Birth date";"Death date";"Additional note";"Tag,tag2,tag3,tag4";<br>
"Quotation2";"Author2";"2013-11-30";"";"";"";"main group";"Birth date";"Death date";"Additional note";"Tag,tag2,tag3,tag4";<br>
"Quotation3";"Author3";"2013-12-01";"";"";"";"main group";"Birth date";"Death date";"Additional note";"Tag,tag2,tag3,tag4";</div><br>

You can use Microsoft Excel to create CSV in good format in easy way. In every one column you can give different information and you can sum it in special way when you use good formula (=A1&A2&A3 and so on).

<h3 style="margin-top:20px;margin-bottom:20px;">Help for "Export CSV file" section:</h3>
If you have problem with export to CSV file - pleas permit your browser to create PopUp window from your website. This function is necessary to create download function.<br>
Other way you can get your export file by FTP client. Exported file is located in: 
<div style="line-height:2em;border:1px solid #dedede;padding-left:10px; background:#efefef; border-radius:5px; margin-bottom:20px; max-width:800px;">
wordpress/wp-content/uploads/{this year}/{number of this month}/{file name is a date in format: dd_mm_yy_hh_mm_ss.csv}
</div>
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