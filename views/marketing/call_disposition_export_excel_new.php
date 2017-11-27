<?php
session_start();
require_once '../../includes/views/define_include.php';
require '../../classes/marketing/call_disposition.php';

ini_set('max_execution_time', 400);

$call_disposition = new CLDisposition();

if(isset($_GET['start_from']) & isset($_GET['end_to'])){
$start_from  =	$_GET['start_from'];
$end_to      =	$_GET['end_to'];
	
$orders_list = $call_disposition->viewSelectedActivationList($start_from,$end_to);

function cleanData(&$str)
  {
    $str = preg_replace("/\t/", "\\t", $str);

    $str = preg_replace("/\r?\n/", "\\n", $str);

    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }

  $filename = date('Ymd')."_excel.xls";


  header("Content-Disposition: attachment; filename=\"$filename\"");

  header("Content-Type: application/vnd.ms-excel");


  $flag = false;

  
foreach ($orders_list as $detail) {

  $data = array(
  array("ID" => $detail['activation_id'],"Agent Name" => $detail['activation_agent_name'], "Store Name" => $detail['activation_store_name'],"Market Type" => $detail['activation_market_type'],"Market" => $detail['market_name'], "Dealer Type" => $detail['activation_dealer_type'], "Phone Number" => $detail['activation_phone_no'], "Outcome" => $detail['activation_outcome'], "Comments" => $detail['activation_comments'], "Date" => $detail['activation_entered_date'], "Time" => $detail['activation_entered_time'])
  );

  foreach($data as $row) { 

    if(!$flag) {
      // display field/column names as first row

      echo implode("\t", array_keys($row)) . "\r\n";

      $flag = true;
    }

    array_walk($row, 'cleanData');

    echo implode("\t", array_values($row)) . "\r\n";

  }}

  exit;
}
//}