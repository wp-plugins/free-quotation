<?php

global $Free_Quotation_version;
global $wpdb;
echo $table_name;
global $today_date;
$table_name = $wpdb->prefix . 'free_quotation_kris_IV';


	?>
<div class="wrap">	
	<div class="Free_Quotation_header"></div> <h2>Free Quotation <?php echo $Free_Quotation_version; ?><a class="add-new-h2" href="admin.php?page=fq_menu_page">Add Free Quotation</a></h2></h2>
	<h4>Add CSV file</h4>
	
	<div class= "Free_Quotation_wrap2">
<?php
if ($_FILES[csv][size] > 0) {

    //get the csv file
    $file = $_FILES[csv][tmp_name];
    $handle = fopen($file,"r");
    
    //loop through the csv file and insert into database
	    do {
        if ($data[0]) {
            $fqinsert = $wpdb->insert( $table_name, array ('quotation' => addslashes($data[0]), 'author' => addslashes($data[1]),  'display_date' => addslashes($data[2]), 'adding_date' =>addslashes($today_date)), array ('%s', '%s', '%s', '%s'));       
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

}?>

<?php if ($datasuccess==null){echo 'Import is not finish yet. If you try and you doesn\'t see positive message - look for FAQ, forum or ask question<br>';} else {echo '<div style="font-weight:bold; font-size:15px; background:yellow; width: 300px; text-align:center; padding: 5px;">' . $datasuccess . '</div>';}; ?>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
 <br> Choose your file: <br>
  <input name="csv" type="file" id="csv" />
  <input type="submit" name="Submit" value="Submit" />
</form>
	<br><br>
<div class="Free_Quotation_wrap3" style="width:500px; background:#ffffbb; padding:20px;border-radius:8px;">
<h3>The Format of CSV File must be as below :</h3>
<div style="line-height:2em;border:1px solid #dedede;padding-left:10px; background:#efefef; border-radius:5px;">"Quotation";"Author";"Display date";""<br>
"Quotation2";"Author2";"Display date2";""<br>
"Quotation3";"Author3";"Display date3";""</div><br><br>

You can't use quotation marks inside a quotation! Pleas remember about it!<br>
This is wrong example:<br>
<div style="line-height:2em;border:1px solid #dedede;padding-left:10px; background:#efefef; border-radius:5px;">"I quote <b>"your quotation"</b>";"Author";"Display date";""</div><br><br>

Display date should be in good format: "<b>YYYY-MM-DD</b>". Be careful when you create your CSV file. If you use date DD like 32 the system always accept it! It's not wrong for them. 
<div style="line-height:2em;border:1px solid #dedede;padding-left:10px; background:#efefef; border-radius:5px;">"Quotation";"Author";"2013-11-29";""<br>
"Quotation2";"Author2";"2013-11-30";""<br>
"Quotation3";"Author3";"2013-12-01";""</div><br><br>

You can use Microsoft Excel to create CSV in good format in easy way. In every one column you can give different information and you can sum it in special way when you use good formula (=A1&A2&A3 and so on).

</div>
	</div>
	<?php 
?>