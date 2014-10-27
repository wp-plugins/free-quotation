<?php
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
			if(isset($options['fq_kk_tekst12'])){echo $options['fq_kk_tekst12'];} else {echo '20';};
			echo '; line-height:';
			if(isset($options['fq_kk_tekst13'])){echo $options['fq_kk_tekst13'];} else {echo '20';};
			echo 'px; text-align:';
			if(isset($options['fq_kk_info_signaturealign'])){echo $options['fq_kk_info_signaturealign'];} else {echo 'left';};
			echo '; font-style:';
			if(isset($options['fq_kk_option11'])){if ($options['fq_kk_option11']==true){echo 'italic';} else {echo 'normal';}} else {echo 'normal';};
			echo ';">' . $author . '</div>';
		}
	} else {
		echo '<div class="Free_Quotation_author">' . stripslashes( $author ) . '</div>';
	}
}

if($fq_display_life==1 && isset($life) && $life ){
	if(isset($options['fq_kk_option5'])) {
		if ($options['fq_kk_option5']==true){
			echo '<div style="font-size:';
			if(isset($options['fq_kk_tekst10'])){echo $options['fq_kk_tekst10'];} else {echo '12';};
			echo 'px; font-family:';
			if(isset($options['fq_kk_tekst11'])){echo $options['fq_kk_tekst11'];} else {echo 'Arial';};
			echo '; font-weight:';
			if(isset($options['fq_kk_option10'])){if ($options['fq_kk_option10']==true){echo 'bold';} else {echo 'normal';}} else {echo 'normal';};
			echo '; margin-bottom:';
			if(isset($options['fq_kk_tekst12'])){echo $options['fq_kk_tekst12'];} else {echo '20';};
			echo '; line-height:';
			if(isset($options['fq_kk_tekst13'])){echo $options['fq_kk_tekst13'];} else {echo '20';};
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

if($fq_display_note==1 && isset($note) && $note){
	if(isset($options['fq_kk_option5'])) {
		if ($options['fq_kk_option5']==true){
			echo '<div style="font-size:';
			if(isset($options['fq_kk_tekst10'])){echo $options['fq_kk_tekst10'];} else {echo '12';};
			echo 'px; font-family:';
			if(isset($options['fq_kk_tekst11'])){echo $options['fq_kk_tekst11'];} else {echo 'Arial';};
			echo '; font-weight:';
			if(isset($options['fq_kk_option10'])){if ($options['fq_kk_option10']==true){echo 'bold';} else {echo 'normal';}} else {echo 'normal';};
			echo '; margin-bottom:';
			if(isset($options['fq_kk_tekst12'])){echo $options['fq_kk_tekst12'];} else {echo '20';};
			echo '; line-height:';
			if(isset($options['fq_kk_tekst13'])){echo $options['fq_kk_tekst13'];} else {echo '20';};
			echo 'px; text-align:';
			if(isset($options['fq_kk_info_signaturealign'])){echo $options['fq_kk_info_signaturealign'];} else {echo 'left';};
			echo '; font-style:';
			if(isset($options['fq_kk_option11'])){if ($options['fq_kk_option11']==true){echo 'italic';} else {echo 'normal';}} else {echo 'normal';};
			echo ';">' . $note . '</div>';
		}
	} else {
		echo '<div class="Free_Quotation_author">' . stripslashes( $note ) . '</div>';
	}
}
?>