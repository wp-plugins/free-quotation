<?php
global $wpdb;
global $today_date;
global $today_week_no;
global $today_week_day;
$table_name = $wpdb->prefix . 'free_quotation_kris_IV';
global $wikiuotation;
$fq_group_test = $instance['fq_group'];
$fq_title_to_display = $instance['title'];

if (!isset($options['fq_kk_option1'])){	$options['fq_kk_option1']='1';};
if (!isset($options['fq_kk_option2'])){	$options['fq_kk_option2']='en';};

if ($options['fq_kk_option1']=='1'||$options['fq_kk_option1']=='2'){
$Free_Quotation_table = 
	"
	SELECT * 
	FROM $table_name 
	WHERE (display_date='$today_date' AND quote_group='$fq_group_test')
	ORDER BY RAND() 
	LIMIT 1;
	";
$result = mysql_query($Free_Quotation_table);
} elseif ($options['fq_kk_option1']=='5'){
$Free_Quotation_table = 
	"
	SELECT * 
	FROM $table_name 
	WHERE (week_no='$today_week_no' AND quote_group='$fq_group_test')
	ORDER BY RAND() 
	LIMIT 1;
	";
$result = mysql_query($Free_Quotation_table);
} elseif ($options['fq_kk_option1']=='6'){
$Free_Quotation_table =
	"
	SELECT * 
	FROM $table_name 
	WHERE (week_day='$today_week_day' AND quote_group='$fq_group_test')
	ORDER BY RAND() 
	LIMIT 1;
	";
$result = mysql_query($Free_Quotation_table);
} elseif ($options['fq_kk_option1']=='7'){
$Free_Quotation_table =
	"
	SELECT * 
	FROM $table_name 
	WHERE (quote_group='$fq_group_test')
	ORDER BY RAND() 
	LIMIT 1;
	";
$result = mysql_query($Free_Quotation_table);
}
	
if ($options['fq_kk_option1']=='1' || $options['fq_kk_option1']=='5' || $options['fq_kk_option1']=='6' || $options['fq_kk_option1']=='7') {	
	//Use only Free_Quotation (if doesn't have it - use standard quotation)
	if ($row = mysql_fetch_array($result)) { 
		$quotation = $row['quotation'];
		$author = $row['author'];
	} else {
	$quotation = $options['fq_kk_tekst1'];
	$author =  $options['fq_kk_tekst2'];
	}
} elseif ($options['fq_kk_option1']=='2') {
	//Use wiqiquotes if dosn't have normal quotes
	if(isset($result)){
		if ($row = mysql_fetch_array($result)) { 
			$quotation = $row['quotation'];
			$author = $row['author'];
		}
	} else {
		if ($options['fq_kk_option2']=='en') {
			require(dirname(__FILE__)."/QuotationSystems/WikiquoteEN.php");
		} elseif ($options['fq_kk_option2']=='de') {
			require(dirname(__FILE__)."/QuotationSystems/WikiquoteDE.php");
		} elseif ($options['fq_kk_option2']=='es') {
			require(dirname(__FILE__)."/QuotationSystems/WikiquoteES.php");
		} elseif ($options['fq_kk_option2']=='ru') {
			require(dirname(__FILE__)."/QuotationSystems/WikiquoteRU.php");
		} elseif ($options['fq_kk_option2']=='pl') {
			require(dirname(__FILE__)."/QuotationSystems/WikicytatyPL.php");
		}
	}
	if (isset($quotation)){}else{
		if ($options['fq_kk_option2']=='en') {
			require(dirname(__FILE__)."/QuotationSystems/WikiquoteEN.php");
		} elseif ($options['fq_kk_option2']=='de') {
			require(dirname(__FILE__)."/QuotationSystems/WikiquoteDE.php");
		} elseif ($options['fq_kk_option2']=='es') {
			require(dirname(__FILE__)."/QuotationSystems/WikiquoteES.php");
		} elseif ($options['fq_kk_option2']=='ru') {
			require(dirname(__FILE__)."/QuotationSystems/WikiquoteRU.php");
		} elseif ($options['fq_kk_option2']=='pl') {
			require(dirname(__FILE__)."/QuotationSystems/WikicytatyPL.php");
		}
	}
} elseif ($options['fq_kk_option1']=='3') {	
	//Use QikiQuote always
	if ($options['fq_kk_option2']=='en') {
		require(dirname(__FILE__)."/QuotationSystems/WikiquoteEN.php");
	} elseif ($options['fq_kk_option2']=='de') {
		require(dirname(__FILE__)."/QuotationSystems/WikiquoteDE.php");
	} elseif ($options['fq_kk_option2']=='es') {
		require(dirname(__FILE__)."/QuotationSystems/WikiquoteES.php");
	} elseif ($options['fq_kk_option2']=='ru') {
		require(dirname(__FILE__)."/QuotationSystems/WikiquoteRU.php");
	} elseif ($options['fq_kk_option2']=='pl') {
		require(dirname(__FILE__)."/QuotationSystems/WikicytatyPL.php");
	}
	
} elseif ($options['fq_kk_option1']=='4') {	
	$quotation = $options['fq_kk_tekst1'];
	$author =  $options['fq_kk_tekst2'];
	
}
if ($instance['fq_ask_title']==1){
	if(isset($options['fq_kk_option5'])) {
		if ($options['fq_kk_option5']==true){
			echo '<div style="font-size:';
			if(isset($options['fq_kk_tekst6'])){echo $options['fq_kk_tekst6'];} else {echo '12';};
			echo 'px; font-family:';
			if(isset($options['fq_kk_tekst7'])){echo $options['fq_kk_tekst7'];} else {echo 'Arial';};
			echo '; font-weight:';
			if(isset($options['fq_kk_option6'])){if ($options['fq_kk_option6']==true){echo 'bold';} else {echo 'normal';}} else {echo 'normal';};
			echo '; text-align:';
			if(isset($options['fq_kk_info_headeralign'])){echo $options['fq_kk_info_headeralign'];} else {echo 'left';};
			echo '; font-style:';
			if(isset($options['fq_kk_option7'])){if ($options['fq_kk_option7']==true){echo 'italic';} else {echo 'normal';}} else {echo 'normal';};
			echo ';">'.$fq_title_to_display.'</div>';
		}
	} else {
		echo '<h3>'.$fq_title_to_display.'</h3>';
	}
}

//CHANGE THE NAME OF VARIABLES

if(isset($options['fq_kk_option5'])) {
	if ($options['fq_kk_option5']==true){
		echo '<div style="font-size:';
		if(isset($options['fq_kk_tekst8'])){echo $options['fq_kk_tekst8'];} else {echo '12';};
		echo 'px; font-family:';
		if(isset($options['fq_kk_tekst9'])){echo $options['fq_kk_tekst9'];} else {echo 'Arial';};
		echo '; font-weight:';
		if(isset($options['fq_kk_option8'])){if ($options['fq_kk_option8']==true){echo 'bold';} else {echo 'normal';}} else {echo 'normal';};
		echo '; text-align:';
		if(isset($options['fq_kk_info_bodyalign'])){echo $options['fq_kk_info_bodyalign'];} else {echo 'left';};
		echo '; font-style:';
		if(isset($options['fq_kk_option9'])){if ($options['fq_kk_option9']==true){echo 'italic';} else {echo 'normal';}} else {echo 'normal';};
		echo ';">';
	}
} else {
	echo '<div class="Free_Quotation_quotation">';
}
if (isset($options['fq_kk_option4'])){
				if ($options['fq_kk_option4']==null){ 
				} else {
					echo $options['fq_kk_tekst3'];
				}
			};
		echo $quotation;
		if (isset($options['fq_kk_option4'])) {
			if ($options['fq_kk_option4']==null){
			} else { 
				echo $options['fq_kk_tekst4'];
			}
		};
		echo '</div>';


if(isset($options['fq_kk_option5'])) {
	if ($options['fq_kk_option5']==true){
		echo '<div style="font-size:';
		if(isset($options['fq_kk_tekst10'])){echo $options['fq_kk_tekst10'];} else {echo '12';};
		echo 'px; font-family:';
		if(isset($options['fq_kk_tekst11'])){echo $options['fq_kk_tekst11'];} else {echo 'Arial';};
		echo '; font-weight:';
		if(isset($options['fq_kk_option10'])){if ($options['fq_kk_option10']==true){echo 'bold';} else {echo 'normal';}} else {echo 'normal';};
		echo '; text-align:';
		if(isset($options['fq_kk_info_signaturealign'])){echo $options['fq_kk_info_signaturealign'];} else {echo 'left';};
		echo '; font-style:';
		if(isset($options['fq_kk_option11'])){if ($options['fq_kk_option11']==true){echo 'italic';} else {echo 'normal';}} else {echo 'normal';};
		echo ';">' . $author . '</div>';
	}
} else {
	echo '<div class="Free_Quotation_author">' . $author . '</div>';
}
	//<xmp></xmp> OFF the HTML


?>