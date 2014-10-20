<?php
    global $wpdb;
	global $fq_db_version;
	global $fq_installed_ver;
	$fq_installed_ver = get_option("fq_db_version");
	
    $table_name = $wpdb->prefix . 'free_quotation_kris_IV';
    $table_name_tags = $wpdb->prefix . 'free_quotation_tags';
	
	if($fq_installed_ver < 0.7) {
		$wpdb->query("alter table ". $table_name ." add column adding_date int(2) NOT NULL");
		
		update_option("fq_db_version", $fq_db_version );
	 } else {};
				
	if($fq_installed_ver < 0.9) {
		$wpdb->query("alter table ". $table_name ." add column week_no int(2) NOT NULL");
		
		update_option("fq_db_version", $fq_db_version );
		
		$fq_week_no_edit = $wpdb->get_results("SELECT * FROM $table_name WHERE id ORDER BY id DESC", OBJECT_K);
		foreach($fq_week_no_edit as $row){
					$operateid = $row->id;
					$operatedisplay_data = $row->display_date;
					$operateadding_date = $row->adding_date;
					$week_no_data = $row->week_no;
		if ($week_no_data=="0"){			
		$week_no_data_edit = date('W', strtotime($operatedisplay_data));
		$fqinsert = $wpdb->update( $table_name, array( 'display_date' => $operatedisplay_data, 'week_no' => $week_no_data_edit), array('id'=>$operateid));
		}}
	 }
				
	if($fq_installed_ver < 0.99) {
		$wpdb->query("alter table ". $table_name ." add column week_day int(1) NOT NULL");
		
		update_option("fq_db_version", $fq_db_version );
		
		$fq_week_no_edit = $wpdb->get_results("SELECT * FROM $table_name WHERE id ORDER BY id DESC", OBJECT_K);
		foreach($fq_week_no_edit as $row){
					$operateid = $row->id;
					$operatedisplay_data = $row->display_date;
					$week_no_day = $row->week_day;
		if ($week_no_day=="0"){			
		$week_no_day_edit = date('N', strtotime($operatedisplay_data));
		$fqinsert = $wpdb->update( $table_name, array( 'display_date' => $operatedisplay_data, 'week_day' => $week_no_day_edit), array('id'=>$operateid));
		}}
	 }
				
	if($fq_installed_ver < 1.00) {
		$wpdb->query("alter table ". $table_name ." add column quote_group varchar(10) NOT NULL");
		
		update_option("fq_db_version", $fq_db_version );
		
		$fq_quote_group_fulfill = $wpdb->get_results("SELECT * FROM $table_name WHERE id ORDER BY id DESC", OBJECT_K);
		foreach($fq_quote_group_fulfill as $row){
					$operateid = $row->id;
					$operatedisplay_data = $row->display_date;
					$fq_quote_group = $row->quote_group;
		if ($fq_quote_group==null){			
		$fq_quote_group_data = 'main group';
		$fqinsert = $wpdb->update( $table_name, array( 'display_date' => $operatedisplay_data, 'quote_group' => $fq_quote_group_data), array('id'=>$operateid));
		}}
	}
			
	if($fq_installed_ver <= 1.10) {
		$wpdb->query("alter table ". $table_name ." add column birth_year  varchar(14)");
		$wpdb->query("alter table ". $table_name ." add column death_year  varchar(14)");
		$wpdb->query("alter table ". $table_name ." add column job_position  varchar(50)");
	
		$sql_2 = "CREATE TABLE " . $table_name_tags . " (
			  tag_id int(11) NOT NULL AUTO_INCREMENT,
			  id int(11) NOT NULL,
			  tag varchar(50) NOT NULL,
			  PRIMARY KEY (tag_id)
			) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci";	

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		dbDelta( $sql_2 );
		
		update_option("fq_db_version", $fq_db_version );
	}
?>