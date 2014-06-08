<?php 
global $wpdb;
global $today_date;
global $today_week_no;
global $today_week_day;
$table_name = $wpdb->prefix . 'free_quotation_kris_IV';
global $wikiuotation;

$fqnumbers = $wpdb->get_results("SELECT COUNT(*) FROM $table_name");
foreach($fqnumbers as $fqdashbordrow);
foreach($fqdashbordrow as $fqdashbordnumbers);


$fqnumbersmore = $wpdb->get_results("SELECT COUNT(*) FROM $table_name WHERE display_date > '".$today_date."'");
foreach($fqnumbersmore as $fqdashbordrowmore);
foreach($fqdashbordrowmore as $fqdashbordnumbersmore);

if($fqdashbordnumbersmore==1||$fqdashbordnumbersmore==0){
$day_sign='day';
} else {
$day_sign='days';
}

echo 'You have <b>'.$fqdashbordnumbers.'</b> quotes in your database<br>';
echo 'You have quotes for next <b>'.$fqdashbordnumbersmore.'</b> '.$day_sign.'<br>';
echo '<br>One of your actaully display quotation:<br><br>';

$options = get_option('Free_Quotation_options');


if ($options['option1']=='1'||$options['option1']=='2'){
$Free_Quotation_table = 
	"
	SELECT * 
	FROM $table_name 
	WHERE (display_date='$today_date')
	ORDER BY RAND() 
	LIMIT 1;
	";
$result = mysql_query($Free_Quotation_table);
} elseif ($options['option1']=='5'){
$Free_Quotation_table = 
	"
	SELECT * 
	FROM $table_name 
	WHERE (week_no='$today_week_no')
	ORDER BY RAND() 
	LIMIT 1;
	";
$result = mysql_query($Free_Quotation_table);
} elseif ($options['option1']=='6'){
$Free_Quotation_table =
	"
	SELECT * 
	FROM $table_name 
	WHERE (week_day='$today_week_day')
	ORDER BY RAND() 
	LIMIT 1;
	";
$result = mysql_query($Free_Quotation_table);
}
	
if ($options['option1']=='1' || $options['option1']=='5' || $options['option1']=='6') {	
	//Use only Free_Quotation (if doesn't have it - use standard quotation)
	if ($row = mysql_fetch_array($result)) { 
		$quotation = $row['quotation'];
		$author = $row['author'];
	} else {
	$quotation = $options['tekst1'];
	$author =  $options['tekst2'];
	}
} elseif ($options['option1']=='2') {
	//Use wiqiquotes if dosn't have normal quotes
	if(isset($result)){
		if ($row = mysql_fetch_array($result)) { 
			$quotation = $row['quotation'];
			$author = $row['author'];
		}
	} else {
		if ($options['option2']=='en') {
			require(dirname(__FILE__)."/QuotationSystems/WikiquoteEN.php");
		} elseif ($options['option2']=='de') {
			require(dirname(__FILE__)."/QuotationSystems/WikiquoteDE.php");
		} elseif ($options['option2']=='es') {
			require(dirname(__FILE__)."/QuotationSystems/WikiquoteES.php");
		} elseif ($options['option2']=='ru') {
			require(dirname(__FILE__)."/QuotationSystems/WikiquoteRU.php");
		} elseif ($options['option2']=='pl') {
			require(dirname(__FILE__)."/QuotationSystems/WikicytatyPL.php");
		}
	}
	if (isset($quotation)){}else{
		if ($options['option2']=='en') {
			require(dirname(__FILE__)."/QuotationSystems/WikiquoteEN.php");
		} elseif ($options['option2']=='de') {
			require(dirname(__FILE__)."/QuotationSystems/WikiquoteDE.php");
		} elseif ($options['option2']=='es') {
			require(dirname(__FILE__)."/QuotationSystems/WikiquoteES.php");
		} elseif ($options['option2']=='ru') {
			require(dirname(__FILE__)."/QuotationSystems/WikiquoteRU.php");
		} elseif ($options['option2']=='pl') {
			require(dirname(__FILE__)."/QuotationSystems/WikicytatyPL.php");
		}
	}
} elseif ($options['option1']=='3') {	
	//Use QikiQuote always
	if ($options['option2']=='en') {
		require(dirname(__FILE__)."/QuotationSystems/WikiquoteEN.php");
	} elseif ($options['option2']=='de') {
		require(dirname(__FILE__)."/QuotationSystems/WikiquoteDE.php");
	} elseif ($options['option2']=='es') {
		require(dirname(__FILE__)."/QuotationSystems/WikiquoteES.php");
	} elseif ($options['option2']=='ru') {
		require(dirname(__FILE__)."/QuotationSystems/WikiquoteRU.php");
	} elseif ($options['option2']=='pl') {
		require(dirname(__FILE__)."/QuotationSystems/WikicytatyPL.php");
	}
	
} elseif ($options['option1']=='4') {	
	$quotation = $options['tekst1'];
	$author =  $options['tekst2'];
	
}

//CHANGE THE NAME OF VARIABLES

	echo '"'.$quotation.'"';
	echo '<div style="text-align:right;"><i>'.$author.'</i></div>';
?>