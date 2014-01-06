<?php
    global $wpdb;

    $table_name = $wpdb->prefix . 'free_quotation_kris_IV';
	
    $sql = "CREATE TABLE $table_name (
      id int(11) NOT NULL AUTO_INCREMENT,
      quotation varchar(300) NOT NULL,
      author varchar(50) NOT NULL,
      display_date varchar(15) NOT NULL,
      adding_date varchar(15) NOT NULL,
      PRIMARY KEY id (id),
	  CONSTRAINT uc_ognewsID UNIQUE (quotation)
    ) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;
	
	ALTER TABLE $table_name ADD COLUMN adding_date varchar(15) NULL";    

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
	
	
?>