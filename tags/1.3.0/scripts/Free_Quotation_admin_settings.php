<?php
global $Free_Quotation_version;
global $wpdb;
global $today_date;
$table_name = $wpdb->prefix . 'free_quotation_kris_IV';
?>
<div class="wrap">	
	 <h2><div class="Free_Quotation_header"></div>Free Quotation <?php echo $Free_Quotation_version; ?><a class="add-new-h2" href="admin.php?page=fq_menu_page">Free Quotation list</a></h2></h2>
	<br><h2>Settings page</h2>
	
		<form method="post" action="options.php">
			<?php settings_fields('Free_Quotation_settings_filed'); ?>
			<?php $options = get_option('Free_Quotation_options'); ?>
			<table class="form-table">
				<tr>
					<th scope="row">Permit to write date (in Add Free Quotation page)</th>
					<td>
						<input name="Free_Quotation_options[option3]" type="checkbox" value="1" <?php if(isset($options['option3'])){checked($options['option3'], 1);}?> /><br>
					</td>
				</tr>
				<tr>
					<th scope="row">Start and end quotation with special characters</th>
					<td>
						<input name="Free_Quotation_options[option4]" type="checkbox" value="1" <?php if(isset($options['option4'])){checked($options['option4'], 1);} ?> /><br>
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
 <script>
jQuery(document).ready( function($){
    $( "#tabs" ).tabs();
  });
  </script>

<div class="Free_Quotation_wrap1">

	<div id="tabs">
		Changes
	  <ul>
		<li><a href="#tabs-1">ver. 1.3</a></li>
		<li><a href="#tabs-2">ver. 1.2</a></li>
		<li><a href="#tabs-3">ver. 1.1</a></li>
		<li><a href="#tabs-4">ver. 1.0</a></li>
	  </ul>
	  <div id="tabs-1">
			1.3.0
			<ul>
				<li>Now is available edition for all of quotes. You can change:<ul>
					<li>Display date</li>
					<li>Quotation text</li>
					<li>Author of quotation</li></ul>
				</li>
			</ul>
	  </div>
	  <div id="tabs-2">
			1.2.2
			<ul>
				<li>Fix CSS in table</li>
				<li>Reorganization of code in few places</li>
			</ul>
			1.2.1
			<ul>
				<li>Fix many small issue and improve stable</li>
			</ul>
			1.2.0
			<ul>
				<li>Improve navigation (on plugin list)</li>
				<li>Better organisation in code</li>
			</ul>
	  </div>
	  <div id="tabs-3">			
			1.1.1
			<ul>
				<li>Compability with WordPress 3.8.0</li>
				<li>Make plugin lighter</li>
			</ul>
			1.1.0
			<ul>
				<li>Add new quotation change location (go to Free Quotation)</li>
				<li>Table have now new feature. Now:
					<ul>
						<li>Table is sortable</li>
						<li>Table is filterable</li>
						<li>Table have pagination</li>
						<li>User can choose how many rows is display</li>
					</ul>
				</li>
				<li>Some small improvement (Wikiquotes mechanism, layout)</li>
			</ul>
	  </div>
	  <div id="tabs-4">
			1.0
			<ul>
				<li><b>Initial release</b></li>
				<li>Function
					<ul>
						<li>Widget for displaying quotation</li>
						<li>Page for add quotation</li>
						<li>Import CSV files</li>
						<li>Displaying quotation from Wikiquotes				
							<ul>
								<li>Widget for displaying quotation</li>
								<li>Page for add quotation</li>
								<li>Import CSV files</li>
								<li>User can choose how many rows is display</li>
							</ul>
						</li>
					</ul>
				</li>
			</ul>
			1.0.1
			<ul>
				<li>Small visual improvement</li>
			</ul>
	  </div>
	</div>	
</div>
	<?php 
?>