<?php
global $wpdb;
global $today_date;
global $today_week_no;
global $today_week_day;
$table_name = $wpdb->prefix . 'free_quotation_kris_IV';
$table_name_tags = $wpdb->prefix . 'free_quotation_tags';
global $wikiuotation;
$fq_group_test = $instance['fq_group'];
$fq_title_to_display = $instance['title'];
$fq_group_or_tags = $instance['fq_group_or_tags'];

if(isset($instance['fq_display_author'])){
	$fq_display_author = esc_attr($instance['fq_display_author']);
} 
else { 
	$fq_display_author=1;
};

if(isset($instance['fq_display_date'])){
	$fq_display_life = esc_attr($instance['fq_display_date']);
} 
else { 
	$fq_display_life=0;
};

if(isset($instance['fq_display_note'])){
	$fq_display_note = esc_attr($instance['fq_display_note']);
} 
else { 
	$fq_display_note=0;
};

$fq_tags = $instance['fq_tags'];
$tag_test_res = trim($fq_tags);
$tag_test_res = str_replace(', ',',',$tag_test_res);
$tag_test_res = str_replace(' ,',',',$tag_test_res);
$tag_array = explode(",", $tag_test_res);
$tag_array_implode = implode("','", $tag_array);
$tag_array_implode = "'".$tag_array_implode."'";

if (!isset($instance['fq_display_type'])){	$instance['fq_display_type']='1';};
if (!isset($options['fq_kk_option2'])){	$options['fq_kk_option2']='en';};

$fqgroup = '';

if($fq_group_or_tags==0){
	// print_r($wpdb);
	if ($instance['fq_display_type']=='1'||$instance['fq_display_type']=='2'){
	$Free_Quotation_table = 
		"
		SELECT * 
		FROM $table_name 
		WHERE (display_date='$today_date' AND quote_group='$fq_group_test')
		ORDER BY RAND() 
		LIMIT 1;
		";
	$fqgroup = $wpdb->get_results($Free_Quotation_table);
	} elseif ($instance['fq_display_type']=='5'){
	$Free_Quotation_table = 
		"
		SELECT * 
		FROM $table_name 
		WHERE (week_no='$today_week_no' AND quote_group='$fq_group_test')
		ORDER BY RAND() 
		LIMIT 1;
		";
	$fqgroup = $wpdb->get_results($Free_Quotation_table);
	} elseif ($instance['fq_display_type']=='6'){
	$Free_Quotation_table =
		"
		SELECT * 
		FROM $table_name 
		WHERE (week_day='$today_week_day' AND quote_group='$fq_group_test')
		ORDER BY RAND() 
		LIMIT 1;
		";
	$fqgroup = $wpdb->get_results($Free_Quotation_table);
	} elseif ($instance['fq_display_type']=='7'){
	$Free_Quotation_table =
		"
		SELECT * 
		FROM $table_name 
		WHERE (quote_group='$fq_group_test')
		ORDER BY RAND() 
		LIMIT 1;
		";
	$fqgroup = $wpdb->get_results($Free_Quotation_table);
	}
} else {
	// print_r($wpdb);
	if ($instance['fq_display_type']=='1'||$instance['fq_display_type']=='2'){
	$Free_Quotation_table = 
		"
		SELECT $table_name.*, $table_name_tags.*  
		FROM $table_name 
		INNER JOIN $table_name_tags
		ON $table_name.id = $table_name_tags.id
		WHERE ($table_name.display_date='$today_date' AND $table_name_tags.tag IN ($tag_array_implode))
		ORDER BY RAND() 
		LIMIT 1;
		";
	$fqgroup = $wpdb->get_results($Free_Quotation_table);
	} elseif ($instance['fq_display_type']=='5'){
	$Free_Quotation_table = 
		"
		SELECT $table_name.*, $table_name_tags.*  
		FROM $table_name 
		INNER JOIN $table_name_tags
		ON $table_name.id = $table_name_tags.id
		WHERE ($table_name.week_no='$today_week_no' AND $table_name_tags.tag IN ($tag_array_implode))
		ORDER BY RAND() 
		LIMIT 1;
		";
	$fqgroup = $wpdb->get_results($Free_Quotation_table);
	} elseif ($instance['fq_display_type']=='6'){
	$Free_Quotation_table =
		"
		SELECT $table_name.*, $table_name_tags.*  
		FROM $table_name 
		INNER JOIN $table_name_tags
		ON $table_name.id = $table_name_tags.id
		WHERE ($table_name.week_day='$today_week_day' AND quote_group='$fq_group_test')
		ORDER BY RAND() 
		LIMIT 1;
		";
	$fqgroup = $wpdb->get_results($Free_Quotation_table);
	} elseif ($instance['fq_display_type']=='7'){
	$Free_Quotation_table =
		"
		SELECT $table_name.*, $table_name_tags.* 
		FROM $table_name 
		INNER JOIN $table_name_tags
		ON $table_name.id = $table_name_tags.id
		WHERE $table_name_tags.tag IN ($tag_array_implode)
		ORDER BY RAND() 
		LIMIT 1;
		";
	$fqgroup = $wpdb->get_results($Free_Quotation_table);
	}

}


if ($instance['fq_display_type']=='1' || $instance['fq_display_type']=='5' || $instance['fq_display_type']=='6' || $instance['fq_display_type']=='7') {	
	//Use only Free_Quotation (if doesn't have it - use standard quotation)
	if ($fqgroup) { 
		foreach($fqgroup as $row){
			$quotation = $row->quotation;
			$author = $row->author;
			$life_b = $row->birth_year;
			$life_d = $row->death_year;
			
			if(isset($life_b) && isset($life_d)){
				$life = $life_b . ' - ' . $life_d;
			} else {
				$life = '';
			}
			
			$note = $row->job_position;
		}
	} else {
	$quotation = $options['fq_kk_tekst1'];
	$author =  $options['fq_kk_tekst2'];
	}
} elseif ($instance['fq_display_type']=='2') {
	//Use wiqiquotes if dosn't have normal quotes
	if(isset($fqgroup)){
		foreach($fqgroup as $row){
			$quotation = $row->quotation;
			$author = $row->author;
			$life_b = $row->birth_year;
			$life_d = $row->death_year;
			
			if(isset($life_b) && isset($life_d)){
				$life = $life_b . ' - ' . $life_d;
			} else {
				$life = '';
			}
			
			$note = $row->job_position;
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
} elseif ($instance['fq_display_type']=='3') {	
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
	
} elseif ($instance['fq_display_type']=='4') {	
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
		echo stripslashes( $quotation );
		if (isset($options['fq_kk_option4'])) {
			if ($options['fq_kk_option4']==null){
			} else { 
				echo $options['fq_kk_tekst4'];
			}
		};
		echo '</div>';

if($fq_display_author==1){
	if(isset($options['fq_kk_option5'])) {
		if ($options['fq_kk_option5']==true){
			echo '<div style="font-size:';
			if(isset($options['fq_kk_tekst10'])){echo $options['fq_kk_tekst10'];} else {echo '12';};
			echo 'px; font-family:';
			if(isset($options['fq_kk_tekst11'])){echo $options['fq_kk_tekst11'];} else {echo 'Arial';};
			echo '; font-weight:';
			if(isset($options['fq_kk_option10'])){if ($options['fq_kk_option10']==true){echo 'bold';} else {echo 'normal';}} else {echo 'normal';};
			echo '; margin-bottom:';
			if(isset($options['fq_kk_option12'])){echo $options['fq_kk_tekst11'];} else {echo '20';};
			echo '; text-align:';
			if(isset($options['fq_kk_info_signaturealign'])){echo $options['fq_kk_info_signaturealign'];} else {echo 'left';};
			echo '; font-style:';
			if(isset($options['fq_kk_option11'])){if ($options['fq_kk_option11']==true){echo 'italic';} else {echo 'normal';}} else {echo 'normal';};
			echo ';">' . $author . '</div>';
		}
	} else {
		echo '<div class="Free_Quotation_author">' . stripslashes( $author ) . '</div>';
	}
}

if($fq_display_life==1 && isset($life)){
	if(isset($options['fq_kk_option5'])) {
		if ($options['fq_kk_option5']==true){
			echo '<div style="font-size:';
			if(isset($options['fq_kk_tekst10'])){echo $options['fq_kk_tekst10'];} else {echo '12';};
			echo 'px; font-family:';
			if(isset($options['fq_kk_tekst11'])){echo $options['fq_kk_tekst11'];} else {echo 'Arial';};
			echo '; font-weight:';
			if(isset($options['fq_kk_option10'])){if ($options['fq_kk_option10']==true){echo 'bold';} else {echo 'normal';}} else {echo 'normal';};
			echo '; margin-bottom:';
			if(isset($options['fq_kk_option12'])){echo $options['fq_kk_tekst11'];} else {echo '20';};
			echo 'px; text-align:';
			if(isset($options['fq_kk_info_signaturealign'])){echo $options['fq_kk_info_signaturealign'];} else {echo 'left';};
			echo '; font-style:';
			if(isset($options['fq_kk_option11'])){if ($options['fq_kk_option11']==true){echo 'italic';} else {echo 'normal';}} else {echo 'normal';};
			echo ';">' . $life . '</div>';
		}
	} else {
		echo '<div class="Free_Quotation_author">' . stripslashes( $life ) . '</div>';
	}
}

if($fq_display_note==1 && isset($note)){
	if(isset($options['fq_kk_option5'])) {
		if ($options['fq_kk_option5']==true){
			echo '<div style="font-size:';
			if(isset($options['fq_kk_tekst10'])){echo $options['fq_kk_tekst10'];} else {echo '12';};
			echo 'px; font-family:';
			if(isset($options['fq_kk_tekst11'])){echo $options['fq_kk_tekst11'];} else {echo 'Arial';};
			echo '; font-weight:';
			if(isset($options['fq_kk_option10'])){if ($options['fq_kk_option10']==true){echo 'bold';} else {echo 'normal';}} else {echo 'normal';};
			echo '; margin-bottom:';
			if(isset($options['fq_kk_option12'])){echo $options['fq_kk_tekst11'];} else {echo '20';};
			echo '; text-align:';
			if(isset($options['fq_kk_info_signaturealign'])){echo $options['fq_kk_info_signaturealign'];} else {echo 'left';};
			echo '; font-style:';
			if(isset($options['fq_kk_option11'])){if ($options['fq_kk_option11']==true){echo 'italic';} else {echo 'normal';}} else {echo 'normal';};
			echo ';">' . $note . '</div>';
		}
	} else {
		echo '<div class="Free_Quotation_author">' . stripslashes( $note ) . '</div>';
	}
}

	//<xmp></xmp> OFF the HTML


?>