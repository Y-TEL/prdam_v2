<?php
session_start();
require_once '../../includes/views/define_include.php';
require '../../classes/marketing/dealer_issue.php';

ini_set('max_execution_time', 400);

$issue = new DealerIssue();
	
$closed_list   = $issue->viewClosedDealerList();

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

  
foreach ($closed_list as $detail) {

  $data = array(
  array("Date" => $detail['issue_date'],"Dealer Code" => $detail['issue_dealer_code'], "Store Name" => $detail['dealer_store_name'],"BL Code " => $detail['dealer_bl_code'],"Issue Category" => $detail['issue_category'], "Issue Details" => $detail['issue_details'], "Note Taken By" => $detail['user_calling_name'], "Email To" => $detail['issue_to'], "Email CC" => $detail['issue_cc'], "Resolved Note" => $detail['issue_resolved_note'], "Resolved Note Entered By" => $detail['resolved_note_entered'], "Closed Note" => $detail['issue_closed_note'], "Closed Note Entered By" => $detail['closed_note_entered'])
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
