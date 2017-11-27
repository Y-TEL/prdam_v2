<?php
session_start();
require_once '../../includes/views/define_include.php';
require_once '../../classes/marketing/file_upload.php';

if (!empty($_POST["folderName"]))
	$folderName = $_POST["folderName"];
if (!empty($_POST["folderDesc"]))
	$folderDesc = $_POST["folderDesc"];

    $random_no = mt_rand(1000000000,9999999999).time();

    $main_category  = filter_input(INPUT_POST, 'folderName', FILTER_SANITIZE_STRING);
    $sub_category = filter_input(INPUT_POST, 'subCategory', FILTER_SANITIZE_STRING);
    $date = filter_input(INPUT_POST, 'uploadDate', FILTER_SANITIZE_STRING);
    $business_name = filter_input(INPUT_POST, 'businessName', FILTER_SANITIZE_STRING);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);   //$_SESSION['user_id'];
    $carrier  = filter_input(INPUT_POST, 'carrier', FILTER_SANITIZE_STRING);
    $designed_by = filter_input(INPUT_POST, 'designedBy', FILTER_SANITIZE_STRING);
    $file_name = $random_no."".$_FILES['Filedata']['name'];
    $file_name = str_replace(' ', '',$file_name);
    $file_name_id = $random_no;
    $added_by = $_SESSION['user_id'];
    
    $size = filter_input(INPUT_POST, 'size', FILTER_SANITIZE_STRING);
    $paper_size = filter_input(INPUT_POST, 'paper_size', FILTER_SANITIZE_STRING);
    $resolution = filter_input(INPUT_POST, 'resolution', FILTER_SANITIZE_STRING);
    
    ############# send file to remote server #########
   
    $RealTitleID = $main_category."@".$file_name;
    $string = str_replace(' ', '', $RealTitleID);
    $ch = curl_init("http://rdams.com/api1/upload.php"); 
   /* $ch = curl_init("localhost/api1/upload.php"); */
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $args['file'] = new CurlFile($_FILES['Filedata']['tmp_name'],'file/exgpd',$string);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $args); 
    $result = curl_exec($ch);    
    ############## end  ##############################
    
    ############# add to db
    $file_upload = new gDriveUpload();
    $msg = $file_upload->addUploadedFileDetails($main_category,$sub_category,$date,$business_name,$name,$carrier,$designed_by,$file_name,$file_name_id,$added_by,$size,$paper_size,$resolution);


header('Location: file_upload.php?success=1');

//echo "<br>Link to file: " . $driveInfo["alternateLink"];

?>