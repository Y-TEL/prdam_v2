<?php
session_start();
require_once '../../includes/views/define_include.php';
require '../../classes/marketing/dealer_issue.php';

$issue = new DealerIssue();

//<<<<<<--------------confirm Dealer Issues start-------------->>>>>>>//
if (isset($_GET['id_1'])) {

$issue_id = $_GET['id_1'];	
  
    $msg = $issue->resolvedIssue($issue_id);
        
    if ($msg=1) { 
        header('Location: dealer_issue_view?iid='.$msg);
    }
}

if (isset($_GET['id_2'])) {

$issue_id = $_GET['id_2'];	
  
    $msg = $issue->closeIssue($issue_id);
        
    if ($msg=1) { 
        header('Location: dealer_issue_view?iid='.$msg);
    }
}
//<<<<<<--------------confirm Dealer Issues end-------------->>>>>>>//

?>
