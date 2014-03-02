<?php
global $wpdb;
global $today_date;
global $today_week_no;
global $today_week_day;
$table_name = $wpdb->prefix . 'free_quotation_kris_IV';
global $wikiuotation;
$fq_group_test = $instance['fq_group'];
$fq_title_to_display = $instance['title'];

if ($options['option1']=='1'){
$Free_Quotation_table = 
	"
	SELECT * 
	FROM $table_name 
	WHERE (display_date='$today_date' AND quote_group='$fq_group_test')
	ORDER BY RAND() 
	LIMIT 1;
	";
} elseif ($options['option1']=='5'){
$Free_Quotation_table = 
	"
	SELECT * 
	FROM $table_name 
	WHERE (week_no='$today_week_no' AND quote_group='$fq_group_test')
	ORDER BY RAND() 
	LIMIT 1;
	";
} elseif ($options['option1']=='6'){
$Free_Quotation_table =
	"
	SELECT * 
	FROM $table_name 
	WHERE (week_day='$today_week_day' AND quote_group='$fq_group_test')
	ORDER BY RAND() 
	LIMIT 1;
	";
}
	$result = mysql_query($Free_Quotation_table);
	
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
	if ($row = mysql_fetch_array($result)) { 
		$quotation = $row['quotation'];
		$author = $row['author'];
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
?>  <?php
if ($instance['fq_ask_title']==1){
	echo '<h3>'.$fq_title_to_display.'</h3>';
}
	echo '<div class="Free_Quotation_quotation">';?><?php if (isset($options['option4'])) {if ($options['option4']==null){ } else { echo $options['tekst3'];}};?><?php echo $quotation;?><?php if (isset($options['option4'])) {if ($options['option4']==null){ } else { echo $options['tekst4'];}};?><?php echo '</div>';
	echo '<div class="Free_Quotation_author">' . $author . '</div>';
	//<xmp></xmp> OFF the HTML
?> <?php


?>