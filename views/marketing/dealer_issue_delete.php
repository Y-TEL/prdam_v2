<?php
/**
 * Description of User
 *
 * @author Nirushika
 */
session_start();
require_once '../../includes/views/define_include.php';
require '../../classes/marketing/dealer_issue.php';

$loginManager = new LoginManager();
$logerHD = new LoggerHD();

if (!$loginManager->confirm_member()) {
    header('Location: ../../index.php');
}

$page = new Page();
$page->setIcon("iconfa-home");
$page->setHeader("Other_Add_Page");
$page->setTag_line("User_View");
$page->setMenu_active("dealer_detail_add");
$page->setMenu_group("Marketing_Department");

$issue = new DealerIssue();

if(isset($_GET['iid'])){
    
$iid = $_GET['iid'];
$delete = $issue->DeleteDealerIssue($iid);  

if ($delete=1) {
     header('Location: dealer_issue_view?iiid='.$delete);
}
    
}