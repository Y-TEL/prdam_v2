<?php
require_once '../../includes/views/define_include.php';
require '../../classes/marketing/dealer_issue.php';

$id = $_POST['id'];

if(isset($_POST['resolved_note'])){
    
$note = $_POST['resolved_note'];

$issue = new DealerIssue();
$msg = $issue->updateIssueResolved($note,$id);
}

if(isset($_POST['closed_note'])){
    
$note = $_POST['closed_note'];

$issue = new DealerIssue();
$msg = $issue->updateIssueClosed($note,$id);
}
?>