<?php
/**
 * Description of User
 *
 * @author Nirushika
 */
session_start();
require_once '../../includes/views/define_include.php';
require '../../classes/marketing/dealer.php';

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
$page->setMenu_group("Dealers_page");
########### END NAVIGATION SETUP #############

date_default_timezone_set('America/New_York');
@$today = date('Y-m-d');

$dealer = new Dealer();

if(isset($_GET['iid'])){
    
$iid = $_GET['iid'];
$delete = $dealer->DeleteDealer($iid);  

if ($delete=1) {
    header('Location: dealer_list_view.php?iiid='.$delete);
}
    
}else{

$id = $_GET['id'];
$user_detail = $dealer->viewSelectedUserDetails($id);

$drop_downs = new DropDownlist();
$drop_down_customer_type     = $drop_downs->getAllCustomerTypes();
$drop_down_area_manager      = $drop_downs->getAllAreaManagers();
$drop_down_regional_manager  = $drop_downs->getAllRegionalManager();
$drop_down_market            = $drop_downs->getAllMarket();
$drop_down_states            = $drop_downs->getAllUSAStates();

//To Insert Gallery				
$path = "../../uploads/Dealer_Photo/";
$valid_formats = array("jpg", "png");
if (isset($_POST['update'])) { 
if(!empty($_FILES['avatar']["name"]) ){

   	//$old_image = $_POST['old_image'];
   	$name = $_FILES['avatar']['name'];
   	$size = $_FILES['avatar']['size'];
	if(strlen($name)) {
		list($txt, $ext) = explode(".", $name);
		if(in_array($ext,$valid_formats)) {
			if($size<(3264*2448)) {
				
			// getting file extension
			$uploadedfile = $_FILES['avatar']['name'];
			$names = explode(".",basename($uploadedfile));
			$namess = $names[1]; // rhis is file extension
			
			// uploading main pic from here
			$target_path = "../../uploads/Dealer_Photo/" . basename( $_FILES['avatar']['name']); 	
			if(move_uploaded_file($_FILES['avatar']['tmp_name'], $target_path)) {
				$mainimages = basename($_FILES['avatar']['name']);	
			}
			$thistime = md5(time());
			rename("../../uploads/Dealer_Photo/$mainimages", "../../uploads/Dealer_Photo/$thistime.$namess");
			$imagename = "../../uploads/Dealer_Photo/$thistime.$namess";
			$image = "$thistime.$namess";
			$_SESSION['image']=$image;
									
                        }else{
			echo "Image file size max 250k";					
                        }
		 
		} else {
		echo "Invalid file format..";	 
		} 
                
	}  else {
  	echo "Please select image..!";
  	exit;
	}
}
}

if (isset($_POST['update'])) {
	
    $dealer_type        = filter_input(INPUT_POST, 'dealer_type', FILTER_SANITIZE_STRING);
    $dealer_fname       = filter_input(INPUT_POST, 'dealer_fname', FILTER_SANITIZE_STRING);
    $dealer_lname       = filter_input(INPUT_POST, 'dealer_lname', FILTER_SANITIZE_STRING);
    $dealer_store_name  = filter_input(INPUT_POST, 'dealer_store_name', FILTER_SANITIZE_STRING);
    $dealer_telephone   = filter_input(INPUT_POST, 'dealer_telephone', FILTER_SANITIZE_STRING);
    $dealer_fax         = filter_input(INPUT_POST, 'dealer_fax', FILTER_SANITIZE_STRING);
    $dealer_address     = filter_input(INPUT_POST, 'dealer_address', FILTER_SANITIZE_STRING);
    $dealer_city        = filter_input(INPUT_POST, 'dealer_city', FILTER_SANITIZE_STRING);
    $dealer_postal_code = filter_input(INPUT_POST, 'dealer_postal_code', FILTER_SANITIZE_STRING);
    $dealer_state       = filter_input(INPUT_POST, 'dealer_state', FILTER_SANITIZE_STRING);
    $db_address         = filter_input(INPUT_POST, 'db_address', FILTER_SANITIZE_STRING);
    $db_city            = filter_input(INPUT_POST, 'db_city', FILTER_SANITIZE_STRING);
    $db_state           = filter_input(INPUT_POST, 'db_state', FILTER_SANITIZE_STRING);
    $db_postal_code     = filter_input(INPUT_POST, 'db_postal_code', FILTER_SANITIZE_STRING);
    $ds_address         = filter_input(INPUT_POST, 'ds_address', FILTER_SANITIZE_STRING);
    $ds_city            = filter_input(INPUT_POST, 'ds_city', FILTER_SANITIZE_STRING);
    $ds_state           = filter_input(INPUT_POST, 'ds_state', FILTER_SANITIZE_STRING);
    $ds_postal_code     = filter_input(INPUT_POST, 'ds_postal_code', FILTER_SANITIZE_STRING);
    $dealer_bl_code     = filter_input(INPUT_POST, 'dealer_bl_code', FILTER_SANITIZE_STRING);
    $dealer_region      = filter_input(INPUT_POST, 'dealer_region', FILTER_SANITIZE_STRING);
    $dealer_states      = filter_input(INPUT_POST, 'dealer_states', FILTER_SANITIZE_STRING);
    $dealer_market      = filter_input(INPUT_POST, 'dealer_market', FILTER_SANITIZE_STRING);
    $dealer_mark_exe    = filter_input(INPUT_POST, 'dealer_mark_exe', FILTER_SANITIZE_STRING);
    $dealer_sales_rep   = filter_input(INPUT_POST, 'dealer_sales_rep', FILTER_SANITIZE_STRING);
    $dealer_area_manager= filter_input(INPUT_POST, 'dealer_area_manager', FILTER_SANITIZE_STRING);
    $dealer_reg_manager = filter_input(INPUT_POST, 'dealer_reg_manager', FILTER_SANITIZE_STRING);
    $dealer_code        = filter_input(INPUT_POST, 'dealer_code', FILTER_SANITIZE_STRING);
    
    if(isset($_SESSION['image'])){ 
        $dealer_image = $_SESSION['image'];
    }else{
        if($user_detail['dealer_prof_picture']!=NULL){  
          $dealer_image = $user_detail['dealer_prof_picture'];
          }else { $dealer_image = "";}
    }
    
    $msg = $dealer->UpdateDealer($dealer_type,$dealer_fname,$dealer_lname,$dealer_store_name,$dealer_telephone,$dealer_fax,$dealer_address,$dealer_city,$dealer_postal_code,$dealer_state,$db_address,$db_city,$db_state,$db_postal_code,$ds_address,$ds_city,$ds_state,$ds_postal_code,$dealer_bl_code,$dealer_region,$dealer_states,$dealer_market,$dealer_mark_exe,$dealer_sales_rep,$dealer_area_manager,$dealer_reg_manager,$dealer_code,$dealer_image,$id);
            
   if ($msg=1) {
       header('Location: dealer_list_view?iid='.$msg);
	}
  }
?>
<!DOCTYPE html>

<html lang="en">

<head>
<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery-latest.js"></script>
<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery-ui.min.js"></script>

<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?php echo SITEURL ?>/assets/global/plugins/select2/select2.css"/>
<!-- BEGIN THEME STYLES -->

<!-- class head -->
   <?php require("../../includes/views/head.php") ?>
<!-- class head -->

<link href="<?php echo SITEURL ?>/assets/global/plugins/bootstrap-fileinput-master/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="<?php echo SITEURL ?>/assets/global/plugins/bootstrap-fileinput-master/js/fileinput.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/global/plugins/bootstrap-fileinput-master/js/fileinput_locale_fr.js" type="text/javascript"></script>        

<style>
    .kv-avatar .file-preview-frame,.kv-avatar .file-preview-frame:hover {
        margin: 0;
        padding: 0;
        border: none;
        box-shadow: none;
        text-align: center;
    }
    .kv-avatar .file-input {
        display: table-cell;
        max-width: 220px;
    }
    
</style>

<script>
    $(document).ready(function () {
        $("#commentForm").validate({
            rules:
                    {
                        dealer_type        : "required",
                        dealer_fname       : "required",
                        dealer_lname       : "required",
                        dealer_store_name  : "required",
                        dealer_region      : "required",
                        dealer_market      : "required",
                        dealer_telephone   :{ 
                                            required: true,
                                            number: true,
                                            minlength:10,
                                            maxlength:10
                                            },
                        dealer_address     : "required",
                        dealer_city        : "required",
                        dealer_postal_code : { 
                                            required: true,
                                            number: true,
                                            minlength:5,
                                            maxlength:5
                                            },
                        dealer_state       : "required",
                        db_address         : "required",
                        db_city            : "required",
                        db_state           : "required",
                        db_postal_code     : { 
                                            required: true,
                                            number: true,
                                            minlength:5,
                                            maxlength:5
                                            },
                        ds_address         : "required",
                        ds_city            : "required",
                        ds_state           : "required",
                        ds_postal_code     : { 
                                            required: true,
                                            number: true,
                                            minlength:5,
                                            maxlength:5
                                            },
                        dealer_system_no   : { 
                                            number: true
                                            },
                        dealer_bl_code     : { 
                                            required: true,
                                            number: true
                                            },
                        dealer_active_no   : { 
                                            number: true
                                            },
                        //dealer_mark_exe    : "required",
                        //dealer_area_manager: "required",
                        dealer_reg_manager : "required",

                    },
            messages:
                    {
                        dealer_type        : "required",
                        dealer_fname       : "required",
                        dealer_lname       : "required",
                        dealer_store_name  : "required",
                        dealer_region      : "required",
                        dealer_market      : "required",
                        dealer_telephone   : {
                                              required: "Enter Phone Number.",
                                              number:"Enter number.",
                                              minlength: $.validator.format("Please enter 10 characters."),
                                              maxlength: $.validator.format("Please enter nor more than 10 characters.")
                                             },
                        dealer_address     : "required",
                        dealer_city        : "required",
                        dealer_postal_code : {
                                              required: "Enter Dealer Postal Code.",
                                              number:"Enter number.",
                                              minlength: $.validator.format("Please enter 5 characters."),
                                              maxlength: $.validator.format("Please enter nor more than 5 characters.")
                                             },
                        dealer_state       : "required",
                        db_address         : "required",
                        db_city            : "required",
                        db_state           : "required",
                        db_postal_code     : {
                                              required: "Enter Billing Postal Code.",
                                              number:"Enter number.",
                                              minlength: $.validator.format("Please enter 5 characters."),
                                              maxlength: $.validator.format("Please enter nor more than 5 characters.")
                                             },
                        ds_address         : "required",
                        ds_city            : "required",
                        ds_state           : "required",
                        ds_postal_code     : {
                                              required: "Enter Shipping Postal Code.",
                                              number:"Enter number.",
                                              minlength: $.validator.format("Please enter 5 characters."),
                                              maxlength: $.validator.format("Please enter nor more than 5 characters.")
                                             },
                        dealer_system_no   : {
                                              number:"Enter number."
                                             },
                        dealer_bl_code     : {
                                              required: "Enter BL Code.",
                                              number:"Enter number."
                                             },
                        dealer_active_no   : {
                                              number:"Enter number."
                                             },
                        //dealer_mark_exe    : "required",
                        //dealer_area_manager: "required",
                        dealer_reg_manager : "required",

                    }
               });
            });
</script>

</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->

<!-- BEGIN HEADER -->
   <?php require("../../includes/views/header_admin.php") ?>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
	<!-- BEGIN SIDEBAR -->
            <?php require("../../includes/views/quick_sidebar.php") ?>
	<!-- END SIDEBAR -->
        
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
            <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->

                    <!-- END PAGE HEADER-->
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tabbable tabbable-custom boxless tabbable-reversed">
                                <div class="tab-pane active" id="tab_2">
                                    <div class="portlet box green">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-user-plus"></i>Dealer Update 
                                            </div>
                                            <div class="tools">
                                                
                                            </div>
                                        </div>
                                        <div class="portlet-body form">
                                            <!-- BEGIN FORM-->

                                            <form id="commentForm" class="form-horizontal" name ="edit_dealer" action="" method="post" enctype="multipart/form-data"> 
                                                <div class="form-body">

                                                    <div class="panel panel-info">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title block">Profile </h3>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="row" style=" margin-top:30px;">
                                                                <div class="col-md-5">
                                                                    <div class="alert alert-success alert-dismissable" style=" margin-top:-3px;">
                                                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                                            <ul>
                                                                                    <li>
                                                                                             Please upload the image size in (<strong>170px X 170px</strong>).
                                                                                    </li>
                                                                                    <li>
                                                                                             Only image files (<strong>jpg and png</strong>) are allowed to upload .
                                                                                    </li>
                                                                            </ul>
                                                                    </div>
                                                                    
                                                                    <!-- the avatar markup -->
                                                                    <div id="kv-avatar-errors" class="center-block" style="display:none"></div>
                                                                    <div class="kv-avatar center-block" style="width:185px">
                                                                        <input id="avatar" name="avatar" type="file" class="file-loading">
                                                                    </div>
                                                                    <script>
                                                                        var btnCust = "";

                                                                        jQuery("#avatar").fileinput({
                                                                            overwriteInitial: true,
                                                                            maxFileSize: 1500,
                                                                            showClose: false,
                                                                            showCaption: false,
                                                                            browseLabel: ' Browse',
                                                                            removeLabel: ' Close',
                                                                            browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
                                                                            removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
                                                                            removeTitle: 'Cancel or reset changes',
                                                                            elErrorContainer: '#kv-avatar-errors',
                                                                            msgErrorClass: 'alert alert-block alert-danger',
                                                                            defaultPreviewContent: '<?php if($user_detail['dealer_prof_picture']!=NULL){?><img src="<?php echo SITEURL ?>/uploads/Dealer_Photo/<?php echo $user_detail['dealer_prof_picture'];?>" style="width:170px;height:170px;"><?php }else{?><img src="<?php echo SITEURL ?>/uploads/Dealer_Photo/blank_profile.jpg" alt="Your Avatar" style="width:170px;height:170px;"><?php } ?>',
                                                                            layoutTemplates: {main2: '{preview} ' + btnCust + ' {remove} {browse}'},
                                                                            allowedFileExtensions: ["jpg", "png", "gif"]
                                                                        });
                                                                    </script>
                                                                </div>

                                                                <div class="col-md-6 tweaked-margin">

                                                                    <div class="row">
                                                                        <div class="col-md-10">
                                                                            <div class="form-group">
                                                                                <label class="control-label col-md-5">Username (Email) <span class="required"> * </span> :</label>
                                                                                <div class="col-md-7">
                                                                                    <input type="email" name="dealer_user_name" id="dealer_user_name" class="form-control" value="<?php echo $user_detail['dealer_email']; ?>" readonly="">
                                                                                </div>
                                                                            </div>
                                                                            
                                                                        </div>
                                                                        <!--/span-->
                                                                    </div>
                                                                    <!--/row-->
                                                                </div>  
                                                                
                                                                <!--/span-->
                                                            </div>
                                                            <!--/row-->
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="panel panel-info">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title block">Company Details</h3>
                                                        </div>
                                                        <div class="panel-body">
                                                                                                                        
                                                            
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">BL Code <span class="required"> * </span> :</label>
                                                                        <div class="col-md-4">
                                                                            <input type="text" name="dealer_bl_code" id="dealer_bl_code" class="form-control" value="<?php echo $user_detail['dealer_bl_code']; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">Region <span class="required"> * </span> :</label>
                                                                        <div class="col-md-4">
                                                                            <select name="dealer_region" id="dealer_region" class="form-control" required>
                                                                                <option value="" selected="true" disabled="true">Select</option>
                                                                                <option value="Region I" <?php if($user_detail['dealer_region']=="Region I"){?>  selected="selected" <?php }?>>Region I</option>
                                                                                <option value="Region II" <?php if($user_detail['dealer_region']=="Region II"){?>  selected="selected" <?php }?>>Region II</option>
                                                                                <option value="Region III" <?php if($user_detail['dealer_region']=="Region III"){?>  selected="selected" <?php }?>>Region III</option>
                                                                                <option value="Region IV" <?php if($user_detail['dealer_region']=="Region IV"){?>  selected="selected" <?php }?>>Region IV</option>
                                                                                <option value="Region V" <?php if($user_detail['dealer_region']=="Region V"){?>  selected="selected" <?php }?>>Region V</option>
                                                                                <option value="Region VI" <?php if($user_detail['dealer_region']=="Region VI"){?>  selected="selected" <?php }?>>Region VI</option>
                                                                                <option value="Region VII" <?php if($user_detail['dealer_region']=="Region VII"){?>  selected="selected" <?php }?>>Region VII</option>
                                                                                <option value="Region VIII" <?php if($user_detail['dealer_region']=="Region VIII"){?>  selected="selected" <?php }?>>Region VIII</option>
                                                                                <option value="Region IX" <?php if($user_detail['dealer_region']=="Region IX"){?>  selected="selected" <?php }?>>Region IX</option>
                                                                                <option value="Region X" <?php if($user_detail['dealer_region']=="Region X"){?>  selected="selected" <?php }?>>Region X</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">State <span class="required"> * </span> :</label>
                                                                        <div class="col-md-4">
                                                                            <select name="dealer_states" id="dealer_states" class="form-control select2me">
                                                                                <option value="" selected="true" disabled="true">SELECT</option>
                                                                                <?php foreach ($drop_down_states as $values) { 
                                                                                    if ($values == $user_detail['dealer_states']) {
                                                                                            $selected = "selected";
                                                                                    } else {
                                                                                            $selected = "";
                                                                                    }
                                                                                    ?>
                                                                                    <option value="<?php echo $values; ?>" <?php echo $selected; ?>><?php echo $values; ?></option><?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">Market <span class="required"> * </span>:</label>
                                                                        <div class="col-md-4">
                                                                            <select name="dealer_market" id="dealer_market" class="form-control select2me">
                                                                                <option value="" selected="true" disabled="true">SELECT</option>
                                                                                <?php foreach ($drop_down_market as $value) { 
                                                                                if ($value['market_id'] == $user_detail['dealer_market_id']) {
                                                                                        $selected = "selected";
                                                                                } else {
                                                                                        $selected = "";
                                                                                }
                                                                                    ?>
                                                                                    <option value="<?php echo $value['market_id']; ?>" <?php echo $selected; ?>><?php echo $value['market_name']; ?></option><?php } ?>
                                                                            </select> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">Marketing Executive(ME) :</label>
                                                                        <div class="col-md-4">
                                                                            <select name="dealer_mark_exe" id="dealer_mark_exe" class="form-control select2me">
                                                                                <option value="" selected="true" disabled="true">SELECT</option>
                                                                                <?php foreach ($drop_down_area_manager as $value) { 
                                                                                if ($value['user_id'] == $user_detail['dealer_marketing_exe']) {
                                                                                        $selected = "selected";
                                                                                } else {
                                                                                        $selected = "";
                                                                                }
                                                                                ?>
                                                                                <option value="<?php echo $value['user_id']; ?>" <?php echo $selected; ?>><?php echo $value['user_calling_name']; ?></option><?php } ?>
                                                                            </select>  
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">Sales Rep :</label>
                                                                        <div class="col-md-4">
                                                                            <select name="dealer_sales_rep" id="dealer_sales_rep" class="form-control select2me">
                                                                                <option value="" selected="true" disabled="true">SELECT</option>
                                                                                <?php foreach ($drop_down_area_manager as $value) { 
                                                                                if ($value['user_id'] == $user_detail['dealer_sales_rep_id']) {
                                                                                        $selected = "selected";
                                                                                } else {
                                                                                        $selected = "";
                                                                                }
                                                                                ?>
                                                                                <option value="<?php echo $value['user_id']; ?>" <?php echo $selected; ?>><?php echo $value['user_calling_name']; ?></option><?php } ?>
                                                                            </select>  
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">Account Manager(ACM) :</label>
                                                                        <div class="col-md-4">
                                                                            <select name="dealer_area_manager" id="dealer_area_manager" class="form-control select2me">
                                                                                <option value="" selected="true" disabled="true">SELECT</option>
                                                                                <?php foreach ($drop_down_area_manager as $value) { 
                                                                                if ($value['user_id'] == $user_detail['dealer_area_manager']) {
                                                                                        $selected = "selected";
                                                                                } else {
                                                                                        $selected = "";
                                                                                }
                                                                                ?>
                                                                                <option value="<?php echo $value['user_id']; ?>" <?php echo $selected; ?>><?php echo $value['user_calling_name']; ?></option><?php } ?>
                                                                            </select>  
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">Regional Manager(RM) <span class="required"> * </span> :</label>
                                                                        <div class="col-md-4">
                                                                            <select name="dealer_reg_manager" id="dealer_reg_manager" class="form-control select2me">
                                                                                <option value="" selected="true" disabled="true">SELECT</option>
                                                                                <?php foreach ($drop_down_regional_manager as $value) { 
                                                                                if ($value['user_id'] == $user_detail['dealer_regional_manager']) {
                                                                                        $selected = "selected";
                                                                                } else {
                                                                                        $selected = "";
                                                                                }
                                                                                ?>
                                                                                <option value="<?php echo $value['user_id']; ?>" <?php echo $selected; ?>><?php echo $value['user_calling_name']; ?></option><?php } ?>
                                                                            </select>  
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        
                                                    </div>

                                                    <div class="panel panel-info">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title block">Basic Details</h3>
                                                        </div>
                                                        <div class="panel-body">
                                                            
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">Dealer Code <span class="required">* </span> :</label>
                                                                        <div class="col-md-4">
                                                                            <input type="text" name="dealer_code" id="dealer_code" class="form-control" value="<?php echo $user_detail['dealer_code']; ?>" readonly="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>                                                            

                                                            <div class="row">   
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">User Type <span class="required"> * </span> :</label>
                                                                        <div class="col-md-4">
                                                                            <select name="dealer_type" id="dealer_type" class="form-control"> 
                                                                                <option value="" selected="true" disabled="true">Select</option>
                                                                                <?php
                                                                                foreach ($drop_down_customer_type as $values) {
                                                                                if ($values['cus_type_id'] != 3) {
                                                                                    if ($values['cus_type_id'] == $user_detail['dealer_type_id']) {
                                                                                        $selected = "selected";
                                                                                    } else {
                                                                                            $selected = "";
                                                                                    }
                                                                                    ?>
                                                                                    <option value="<?php echo $values['cus_type_id']; ?>" <?php echo $selected; ?>><?php echo $values['cus_type_name']; ?></option>
                                                                                    <?php
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </select> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!--/span-->
                                                            </div>
                                                            <!--/row-->

                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">First Name <span class="required" > * </span> :</label>
                                                                        <div class="col-md-4">
                                                                            <input type="text" name="dealer_fname" id="dealer_fname" class="form-control" value="<?php echo $user_detail['dealer_fname']; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!--/span-->
                                                            </div>
                                                            <!--/row-->

                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">Last Name <span class="required"> * </span> :</label>
                                                                        <div class="col-md-4">
                                                                            <input type="text" name="dealer_lname" id="dealer_lname" class="form-control" value="<?php echo $user_detail['dealer_lname']; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!--/span-->
                                                            </div>
                                                            <!--/row-->

                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">Store Name <span class="required"> * </span> :</label>
                                                                        <div class="col-md-4">
                                                                            <input type="text" name="dealer_store_name" id="dealer_store_name" class="form-control" value="<?php echo $user_detail['dealer_store_name']; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-info">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title block">Contact Details</h3>
                                                        </div>
                                                        <div class="panel-body">

                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">Telephone <span class="required" > * </span> :</label>
                                                                        <div class="col-md-4">
                                                                            <input type="text" name="dealer_telephone" id="dealer_telephone" class="form-control" value="<?php echo $user_detail['dealer_contact_no']; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">Fax :</label>
                                                                        <div class="col-md-4">
                                                                            <input type="text" name="dealer_fax" id="dealer_fax" class="form-control" value="<?php echo $user_detail['dealer_fax']; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">Permanent Business Address<span class="required"> * </span> :</label>
                                                                        <div class="col-md-4">
                                                                            <textarea class="form-control" rows='5' id="dealer_address" name="dealer_address"><?php echo $user_detail['dealer_address']; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">City/Town <span class="required">* </span> :</label>
                                                                        <div class="col-md-4">
                                                                            <input type="text" name="dealer_city" id="dealer_city" class="form-control" value="<?php echo $user_detail['dealer_city']; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">State <span class="required"> * </span> :</label>
                                                                        <div class="col-md-4">
                                                                            <input type="text" name="dealer_state" id="dealer_state" class="form-control" value="<?php echo $user_detail['dealer_state']; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">Postal/Zip Code <span class="required"> * </span> :</label>
                                                                        <div class="col-md-4">
                                                                            <input type="text" name="dealer_postal_code" id="dealer_postal_code" class="form-control" value="<?php echo $user_detail['dealer_zip_code']; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="panel panel-info">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title block">Billing Details</h3>
                                                        </div>
                                                        <div class="panel-body">

                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">Billing Address<span class="required"> * </span> :</label>
                                                                        <div class="col-md-4">
                                                                            <textarea class="form-control" rows='5' id="db_address" name="db_address"><?php echo $user_detail['dealer_billing_addrs']; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">City/Town <span class="required">* </span> :</label>
                                                                        <div class="col-md-4">
                                                                            <input type="text" name="db_city" id="db_city" class="form-control" value="<?php echo $user_detail['dealer_billing_city']; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">State <span class="required">* </span> :</label>
                                                                        <div class="col-md-4">
                                                                            <input type="text" name="db_state" id="db_state" class="form-control" value="<?php echo $user_detail['dealer_billing_state']; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">Postal/Zip Code <span class="required"> * </span> :</label>
                                                                        <div class="col-md-4">
                                                                            <input type="text" name="db_postal_code" id="db_postal_code" class="form-control" value="<?php echo $user_detail['dealer_billing_zip']; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                           
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="panel panel-info">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title block">Shipping Details</h3>
                                                        </div>
                                                        <div class="panel-body">

                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">Shipping Address<span class="required"> * </span> :</label>
                                                                        <div class="col-md-4">
                                                                            <textarea class="form-control" rows='5' id="ds_address" name="ds_address"><?php echo $user_detail['dealer_shipping_addrs']; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">City/Town <span class="required">* </span> :</label>
                                                                        <div class="col-md-4">
                                                                            <input type="text" name="ds_city" id="ds_city" class="form-control" value="<?php echo $user_detail['dealer_shipping_city']; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">State <span class="required">* </span> :</label>
                                                                        <div class="col-md-4">
                                                                            <input type="text" name="ds_state" id="ds_state" class="form-control" value="<?php echo $user_detail['dealer_shipping_state']; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">Postal/Zip Code <span class="required"> * </span> :</label>
                                                                        <div class="col-md-4">
                                                                            <input type="text" name="ds_postal_code" id="ds_postal_code" class="form-control" value="<?php echo $user_detail['dealer_shipping_zip']; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                           
                                                        </div>
                                                        
                                                        <div class="form-actions">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <div class="col-md-offset-4 col-md-8">
                                                                            <button type="submit" name="update" class="btn green"><i class="fa fa-save"></i> Save</button>
                                                                            <a href="dealer_list_view" class="btn default" style="text-decoration:none;"><i class="fa fa-times-circle-o"></i> Cancel</a>
                                                                            <button type="reset" name="reset" class="btn default"><i class="fa fa-refresh"></i> Reset</button>  
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>

                                                    
                                                </div>

                                            </form><!-- END FORM-->
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
			<!-- END PAGE CONTENT-->
		</div>
	</div>
<!-- END CONTENT -->
        
<!-- BEGIN FOOTER -->
<?php require("../../includes/views/footer_admin.php"); ?>
<!-- END FOOTER -->

<?php
//Clear all the Message Session Variables...
if(isset($_SESSION['returnmessage'])) { unset($_SESSION['returnmessage']);}
?>
 
</body>

<!-- END BODY -->
</html>
<?php } ?>