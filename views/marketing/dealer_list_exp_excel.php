<?php
session_start();
require_once '../../includes/views/define_include.php';
require '../../classes/marketing/dealer.php';

ini_set('max_execution_time', 400);

$dealer = new Dealer();
	
$dealer_list = $dealer->viewDealerList();

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

  
foreach ($dealer_list as $detail) {
    $ME= $detail['dealer_marketing_exe'];
    $value = $dealer->selectDealerME($ME);
    
    $REP= $detail['dealer_sales_rep_id'];
    $data = $dealer->selectDealerRep($REP);

    $ACM= $detail['dealer_area_manager'];
    $values = $dealer->selectDealerACM($ACM);

    $RM= $detail['dealer_regional_manager'];
    $valuess = $dealer->selectDealerRM($RM);

  $data = array(
  array("ID" => $detail['dealer_id'],"Dealer Type" => $detail['cus_type_name'],"Dealer ME" => $value['user_calling_name'],"Dealer Sales Rep" => $data['user_calling_name'],"Dealer ACM" => $values['user_calling_name'],"Dealer RM" => $valuess['user_calling_name'], "Dealer Code" => $detail['dealer_code'],"Email " => $detail['dealer_email'],"First Name" => $detail['dealer_fname'], "Last Name" => $detail['dealer_lname'], "Store Name" => $detail['dealer_store_name'], "Address" => $detail['dealer_address'], "City" => $detail['dealer_city'], "State" => $detail['dealer_state'], "Zip Code" => $detail['dealer_zip_code'], "Contact No" => $detail['dealer_contact_no'], "Fax No" => $detail['dealer_fax']
  , "Dealer Region" => $detail['dealer_region'], "Dealer State" => $detail['dealer_states'], "Dealer Market" => $detail['market_name'], "BL Code" => $detail['dealer_bl_code'], "Billing Address" => $detail['dealer_billing_addrs'], "Billing City" => $detail['dealer_billing_city'], "Billing State" => $detail['dealer_billing_state'], "Billing Zip Code" => $detail['dealer_billing_zip'], "Shipping Address" => $detail['dealer_shipping_addrs'], "Shipping City" => $detail['dealer_shipping_city'], "Shipping State" => $detail['dealer_shipping_state'], "Shipping Zip Code" => $detail['dealer_shipping_zip'])
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
