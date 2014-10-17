<?php 
global $wpdb;
global $today_date;
global $today_week_no;
global $today_week_day;
$table_name = $wpdb->prefix . 'free_quotation_kris_IV';
    $table_name_tags = $wpdb->prefix . 'free_quotation_tags';
global $wikiuotation;

$fqnumbers = $wpdb->get_results("SELECT COUNT(*) FROM $table_name");
foreach($fqnumbers as $fqdashbordrow);
foreach($fqdashbordrow as $fqdashbordnumbers);


$fqnumbersmore = $wpdb->get_results("SELECT COUNT(*) FROM $table_name WHERE display_date > '".$today_date."'");
foreach($fqnumbersmore as $fqdashbordrowmore);
foreach($fqdashbordrowmore as $fqdashbordnumbersmore);

if($fqdashbordnumbersmore==1||$fqdashbordnumbersmore==0){
$day_sign='day';
} else {
$day_sign='days';
}

echo 'You have <b>'.$fqdashbordnumbers.'</b> quotes in your database<br>';
echo 'You have quotes for next <b>'.$fqdashbordnumbersmore.'</b> '.$day_sign.'<br>';


?>