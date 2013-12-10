<?php
global $wpdb;
global $today_date;
$table_name = $wpdb->prefix . 'free_quotation_kris_IV';
global $wikiuotation;

$Free_Quotation_table = 
	"
	SELECT * 
	FROM $table_name 
	WHERE display_date='$today_date' 
	ORDER BY RAND() 
	LIMIT 1;
	";		$result = mysql_query($Free_Quotation_table);
	
if ($options['option1']=='1') {	
	//Use only Free_Quotation (if doesn't have it - use standard quotation)
	if ($row = mysql_fetch_array($result)) { 
		$quotation = $row['quotation'];
		$author = $row['author'];
	} else {
		echo 'cytat stały';
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

	echo '<div class="Free_Quotation_quotation">';?><?php if ($options['option4']==null){ } else { echo $options['tekst3'];};?><?php echo $quotation;?><?php if ($options['option4']==null){ } else { echo $options['tekst4'];};?><?php echo '</div>';
	echo '<div class="Free_Quotation_author">' . $author . '</div>';
?> <?php


?>