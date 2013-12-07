<?php

global $Free_Quotation_version;
global $wpdb;
echo $table_name;
global $today_date;
$table_name = $wpdb->prefix . 'free_quotation_kris_IV';

	?>
<div class="wrap">	
	<div class="Free_Quotation_header"></div> <h2>Free Quotation <?php echo $Free_Quotation_version; ?><a class="add-new-h2" href="admin.php?page=fq_menu_page">Free Quotation list</a></h2></h2>
	<h4>Settings page</h4>
	
		<form method="post" action="options.php">
			<?php settings_fields('Free_Quotation_settings_filed'); ?>
			<?php $options = get_option('Free_Quotation_options'); ?>
			<table class="form-table">
				<tr>
					<th scope="row">Permit to write date (in Add Free Quotation page)</th>
					<td>
						<input name="Free_Quotation_options[option3]" type="checkbox" value="1" <?php checked('1', $options['option3']); ?> /><br>
					</td>
				</tr>
				<tr>
					<th scope="row">Start and end quotation with special characters</th>
					<td>
						<input name="Free_Quotation_options[option4]" type="checkbox" value="1" <?php checked('1', $options['option4']); ?> /><br>
					</td>
				</tr>
			
				<tr style="background:#ccc; width: 900px; <?php if ($options['option4']==null){ echo 'display:none;';} else {}?>">
					<th scope="row">Start character</th>
					<td>
						<input name="Free_Quotation_options[tekst3]" type="input"  value="<?php echo htmlentities($options['tekst3']);?>" maxlength="1" size="1"></input>
					</td>
				</tr>	
				<tr style="background:#ccc; width: 900px; <?php if ($options['option4']==null){ echo 'display:none;';} else {}?>">
					<th scope="row">End character</th>
					<td>
						<input name="Free_Quotation_options[tekst4]" type="input"  value="<?php echo htmlentities($options['tekst4']);?>" maxlength="1" size="1"></input>
					</td>
				</tr>
			<?php ?>
				<tr>
					<th scope="row">Type of quotation display:</th>
					<td>
						<input type="radio" name="Free_Quotation_options[option1]" value="1" <?php checked('1', $options['option1']); ?> />Use only Free_Quotation</br>
						<input type="radio" name="Free_Quotation_options[option1]" value="2" <?php checked('2', $options['option1']); ?> />Use Wikiquote if you doesn't have FQ for display<br>
						<input type="radio" name="Free_Quotation_options[option1]" value="3" <?php checked('3', $options['option1']); ?> />Use Wikiquote always for quotations displaying<br>
						<input type="radio" name="Free_Quotation_options[option1]" value="4" <?php checked('4', $options['option1']); ?> />Use one standard quotation (always active if Free_Quotation doesn't have quotation for displaying)<br>
					</td>
				</tr>
				<tr>
					<th scope="row">Choose Wikiquote system:</th>
					<td><select name="Free_Quotation_options[option2]">
						<option <?php if($options['option2']=="en" ){ echo "selected"; } ?> value="en">Wikiquote [en] (Quote of the day)</option>
						<option <?php if($options['option2']=="de"){ echo "selected";} ?> value="de">Wikiquote [de] (Zitat der Woche)</option>
						<option <?php if($options['option2']=="es"){ echo "selected";} ?> value="es">Wikiquote [es] (Cita del día)</option>
						<option <?php if($options['option2']=="ru"){ echo "selected";} ?> value="ru">Wikiquote [ru] (Избранная цитата)</option>
						<option <?php if($options['option2']=="pl"){ echo "selected";} ?> value="pl">Wikiquote [pl] (Cytat dnia)</option>
						</select>
					</td>
				</tr>
				<tr style="background:#ccc; width: 900px;">
					<th scope="row">Standard quotation</th>
						<td><textarea name="Free_Quotation_options[tekst1]" type="text" cols="80" rows="2"><?php echo $options['tekst1']; ?></textarea></td>
				</tr>			
				<tr style="background:#ccc;">
					<th scope="row">Quotation author</th>
					<td>
						<input name="Free_Quotation_options[tekst2]" type="input" value="<?php echo $options['tekst2']; ?>"></input>
					</td>
				</tr>
				
			</table>
			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save') ?>" />
			</p>
		</form>	
	
	<div class="Free_Quotation_wrap4">
		Zmiany:
		<?php
	echo '<br>';
	if  ($options['option1']=='1') {
	echo 'Use only Free_Quotation';
	} elseif ($options['option1']=='2') {
	echo "Use Wikiquote if you doesn't have FQ for display";
	}elseif ($options['option1']=='3') {
	echo "Use Wikiquote always for qotations displaying";
	}elseif ($options['option1']=='4') {
	echo "Use one standard quotation";
	};
	?>
			<?php
	echo '<br>';
	if  ($options['option2']=='en') {
	echo 'en';
	} elseif ($options['option2']=='de') {
	echo "de";
	}elseif ($options['option2']=='es') {
	echo "es";
	}elseif ($options['option2']=='ru') {
	echo "ru";
	}elseif ($options['option2']=='pl') {
	echo "pl";
	};
	?>
	</div>
</div>
	<?php 
?>