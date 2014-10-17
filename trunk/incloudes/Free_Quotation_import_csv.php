<?php 
	if (isset($_FILES['csv'])){
		if ($_FILES['csv']['size'] > 0) {

		//get the csv file
		$file = $_FILES['csv']['tmp_name'];
		$handle = fopen($file,"r");
		
		//loop through the csv file and insert into database
			do {
				if (isset($data)){
					if ($data[0]) {
						$fqinsert = $wpdb->insert( $table_name, array ('quotation' => addslashes($data[0]), 'author' => addslashes($data[1]),  'display_date' => addslashes($data[2]), 'adding_date' =>addslashes($today_date), 'week_no' => addslashes($data[4]), 'week_day' => addslashes($data[5]), 'quote_group' =>addslashes($data[6]), 'birth_year' =>addslashes($data[7]), 'death_year' =>addslashes($data[8]), 'job_position' =>addslashes($data[9])), array ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'));  
						
						$inserted_id = mysql_insert_id();
						
						$tag_test_res = trim(addslashes($data[10]));
						$tag_test_res = str_replace(', ',',',$tag_test_res);
						$tag_test_res = str_replace(' ,',',',$tag_test_res);
						$tag_array = explode(",", $tag_test_res);
						$tag_size = count($tag_array);

						for( $i=0 ; $i<$tag_size ; $i++){
							if($tag_array[$i]!=''){
								$fq_quote_insert = $wpdb->insert( $table_name_tags, array( 'id' => $inserted_id, 'tag' =>$tag_array[$i]), array('%d', '%s') );
							}
						}						
					}
				}
			$datasuccess = "Your file has been successfully imported.";
			} while ($data = fgetcsv($handle,1000,';','"'));
		}
		
				
		$fq_week_no_edit = $wpdb->get_results("SELECT * FROM " . $table_name . " WHERE id ORDER BY id DESC", OBJECT_K);
		foreach($fq_week_no_edit as $row){
					 $operateid = $row->id;
					 $operatedisplay_data = $row->display_date;
					 $operateadding_date = $row->adding_date;
					 $week_no_data = $row->week_no;
					 $week_no_day = $row->week_day;
					 $display_group = $row->quote_group;
			if ($week_no_data=="0"){			
			$week_no_data_edit = date('W', strtotime($operatedisplay_data));
			$fqinsert = $wpdb->update( $table_name, array( 'display_date' => $operatedisplay_data, 'week_no' => $week_no_data_edit), array('id'=>$operateid));
			}
			if ($week_no_day=="0"){			
			$week_no_day_edit = date('N', strtotime($operatedisplay_data));
			$fqinsert = $wpdb->update( $table_name, array( 'display_date' => $operatedisplay_data, 'week_day' => $week_no_day_edit), array('id'=>$operateid));
			}
			if ($display_group==null){			
			$display_group_edit = "main group";
			$fqinsert = $wpdb->update( $table_name, array( 'display_date' => $operatedisplay_data, 'quote_group' => $display_group_edit), array('id'=>$operateid));
			}
		 }
	}
	if (isset($datasuccess)){
		if ($datasuccess==null){
			echo 'Import is not finish yet. If you try and you doesn\'t see positive message - look for FAQ, forum or ask question<br>';
		} else {
			echo '<div style="font-weight:bold; font-size:15px; background:yellow; width: 300px; text-align:center; padding: 5px;">' . $datasuccess . '</div>';
		}
	}; 

?>