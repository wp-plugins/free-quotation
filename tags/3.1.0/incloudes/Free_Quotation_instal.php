<?php
    global $wpdb;
	global $fq_db_version;
	global $fq_installed_ver;
	
    $table_name = $wpdb->prefix . 'free_quotation_kris_IV';
    $table_name_tags = $wpdb->prefix . 'free_quotation_tags';
	
	$fq_installed_ver = get_option("fq_db_version");
		
	$sql = "CREATE TABLE " . $table_name . " (
			  id int(11) NOT NULL AUTO_INCREMENT,
			  quotation varchar(800) NOT NULL,
			  author varchar(50) NOT NULL,
			  display_date varchar(15) NOT NULL,
			  adding_date varchar(15) NOT NULL,
			  week_no int(2) NOT NULL,
			  week_day int(1) NOT NULL,
			  quote_group varchar(10) NOT NULL,
			  birth_year varchar(14),
			  death_year varchar(14),
			  job_position varchar(50),
			  PRIMARY KEY (id)
			) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci";		

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	dbDelta( $sql );
	
	$sql_2 = "CREATE TABLE " . $table_name_tags . " (
		  tag_id int(11) NOT NULL AUTO_INCREMENT,
		  id int(11) NOT NULL,
		  tag varchar(50) NOT NULL,
		  PRIMARY KEY (tag_id)
		) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci";	

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	dbDelta( $sql_2 );
		
	
	add_option("fq_db_version", $fq_db_version );	
?>