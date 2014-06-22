<?php
global $wpdb;
global $today_date;
global $today_week_no;
global $today_week_day;
$table_name = $wpdb->prefix . 'free_quotation_kris_IV';
global $wikiuotation;
$fq_group_test = $instance['fq_group'];
$fq_title_to_display = $instance['title'];


if ($options['option1']=='1'||$options['option1']=='2'){
$Free_Quotation_table = 
	"
	SELECT * 
	FROM $table_name 
	WHERE (display_date='$today_date' AND quote_group='$fq_group_test')
	ORDER BY RAND() 
	LIMIT 1;
	";
$result = mysql_query($Free_Quotation_table);
} elseif ($options['option1']=='5'){
$Free_Quotation_table = 
	"
	SELECT * 
	FROM $table_name 
	WHERE (week_no='$today_week_no' AND quote_group='$fq_group_test')
	ORDER BY RAND() 
	LIMIT 1;
	";
$result = mysql_query($Free_Quotation_table);
} elseif ($options['option1']=='6'){
$Free_Quotation_table =
	"
	SELECT * 
	FROM $table_name 
	WHERE (week_day='$today_week_day' AND quote_group='$fq_group_test')
	ORDER BY RAND() 
	LIMIT 1;
	";
$result = mysql_query($Free_Quotation_table);
} elseif ($options['option1']=='7'){
$Free_Quotation_table =
	"
	SELECT * 
	FROM $table_name 
	ORDER BY RAND() 
	LIMIT 1;
	";
$result = mysql_query($Free_Quotation_table);
}
	
if ($options['option1']=='1' || $options['option1']=='5' || $options['option1']=='6' || $options['option1']=='7') {	
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
if ($instance['fq_ask_title']==1){
	if(isset($options['option5'])) {
		if ($options['option5']==true){
			echo '<div style="font-size:';
			if(isset($options['tekst6'])){echo $options['tekst6'];} else {echo '12';};
			echo 'px; font-family:';
			if(isset($options['tekst7'])){echo $options['tekst7'];} else {echo 'Arial';};
			echo '; font-weight:';
			if(isset($options['option6'])){if ($options['option6']==true){echo 'bold';} else {echo 'normal';}} else {echo 'normal';};
			echo '; text-align:';
			if(isset($options['headeralign'])){echo $options['headeralign'];} else {echo 'left';};
			echo '; font-style:';
			if(isset($options['option7'])){if ($options['option7']==true){echo 'italic';} else {echo 'normal';}} else {echo 'normal';};
			echo ';">'.$fq_title_to_display.'</div>';
		}
	} else {
		echo '<h3>'.$fq_title_to_display.'</h3>';
	}
}

//CHANGE THE NAME OF VARIABLES

if(isset($options['option5'])) {
	if ($options['option5']==true){
		echo '<div style="font-size:';
		if(isset($options['tekst8'])){echo $options['tekst8'];} else {echo '12';};
		echo 'px; font-family:';
		if(isset($options['tekst9'])){echo $options['tekst9'];} else {echo 'Arial';};
		echo '; font-weight:';
		if(isset($options['option8'])){if ($options['option8']==true){echo 'bold';} else {echo 'normal';}} else {echo 'normal';};
		echo '; text-align:';
		if(isset($options['bodyalign'])){echo $options['bodyalign'];} else {echo 'left';};
		echo '; font-style:';
		if(isset($options['option9'])){if ($options['option9']==true){echo 'italic';} else {echo 'normal';}} else {echo 'normal';};
		echo ';">';
	}
} else {
	echo '<div class="Free_Quotation_quotation">';
}
if (isset($options['option4'])){
				if ($options['option4']==null){ 
				} else {
					echo $options['tekst3'];
				}
			};
		echo $quotation;
		if (isset($options['option4'])) {
			if ($options['option4']==null){
			} else { 
				echo $options['tekst4'];
			}
		};
		echo '</div>';


if(isset($options['option5'])) {
	if ($options['option5']==true){
		echo '<div style="font-size:';
		if(isset($options['tekst10'])){echo $options['tekst10'];} else {echo '12';};
		echo 'px; font-family:';
		if(isset($options['tekst11'])){echo $options['tekst11'];} else {echo 'Arial';};
		echo '; font-weight:';
		if(isset($options['option10'])){if ($options['option10']==true){echo 'bold';} else {echo 'normal';}} else {echo 'normal';};
		echo '; text-align:';
		if(isset($options['signaturealign'])){echo $options['signaturealign'];} else {echo 'left';};
		echo '; font-style:';
		if(isset($options['option11'])){if ($options['option11']==true){echo 'italic';} else {echo 'normal';}} else {echo 'normal';};
		echo ';">' . $author . '</div>';
	}
} else {
	echo '<div class="Free_Quotation_author">' . $author . '</div>';
}
	//<xmp></xmp> OFF the HTML


?>