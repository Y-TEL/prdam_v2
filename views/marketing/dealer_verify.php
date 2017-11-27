<?php
##############################################
## @DESCRIPTION : DEALER DETAIL VIEW
## @AUTHOR      : JALIYA LAMAHEWA
## @MODULE      : MARKETING
##############################################

session_start();
require_once '../../includes/views/define_include.php';
require '../../classes/marketing/dealer.php';

########### AUTHENTICATION CHECK #############
$loginManager = new LoginManager();
$logerHD = new LoggerHD();

if (!$loginManager->confirm_member()) {
    header('Location: ../../index.php');
}
########### END ##############################
########### PAGE NAVIGATION SETUP ############
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

$id = $_GET['id'];

$user_detail = $dealer->viewSelectedUserDetails($id);
$dealer_code = $user_detail['dealer_code'];
$verify_code = $user_detail['dealer_verify_code'];

$drop_downs = new DropDownlist();
$drop_down_user_country = $drop_downs->getAllCountry();
$drop_down_user_dept = $drop_downs->getAllDepartment();

$RepID = $user_detail['dealer_sales_rep_id'];
$detailRep = $dealer->viewSelectedSalesRep($RepID); 
$AreaMgID = $user_detail['dealer_area_manager'];
$detailAreaMg = $dealer->viewSelectedAreaMg($AreaMgID); 
$RegMgID = $user_detail['dealer_regional_manager'];
$detailRegMg  = $dealer->viewSelectedRegMg($RegMgID); 


if (isset($_POST['update'])) {
    
    $dealer_verify_code   = filter_input(INPUT_POST, 'dealer_verify_code', FILTER_SANITIZE_STRING);
    $dealer_active        = 1;
   
    if($dealer_verify_code == $verify_code){
    $msg = $dealer->ActivateDealer($dealer_active,$dealer_code);
            
    if ($msg=1) {
       header('Location: dealer_list_view?iid='.$msg);
	}
    }else{
        // : RETURN MESSAGE.
        $returnmessage = array();
        array_push($returnmessage, array("type" => "error"));  //succes | warning | error | information
        array_push($returnmessage, array("message" => "Incorrect Dealer Verfication Code"));
        $_SESSION['returnmessage'] = $returnmessage; 
    }
    
  }
?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery-latest.js"></script>
        <script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery.validate.js"></script>
        <script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery-ui.min.js"></script>

        <link href="<?php echo SITEURL ?>/assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo SITEURL ?>/assets/admin/pages/css/profile.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo SITEURL ?>/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
        <!-- class head -->
        <?php require("../../includes/views/head.php") ?>
        <!-- class head -->
        <style>
            .bold_red{
                color: #D91E18;
                font-weight: bold;
            }

            .profile-background{
                background: #F1F3FA; 
            }

        </style>
        <style>
            .preview1
            {
                width:150px;
                border:solid 1px #dedede;
                padding:4px;
                height:150px;
            }
        </style> 
        
<script>
    $(document).ready(function () {
        $("#commentForm").validate({
            rules:
                    {
                        dealer_verify_code  : "required",
                    },
            messages:
                    {
                        dealer_verify_code  : "required",
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
                    <div id="hide"><?php include ("../../includes/views/messager.php"); //Display  Messages for Entered Data ?></div>     
                    <!-- END PAGE HEADER-->
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tabbable tabbable-custom boxless tabbable-reversed">

                                <div class="tab-pane active" id="tab_2">
                                    <div class="portlet box green">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-gift"></i>Verify Dealer
                                            </div>
                                            <div class="tools">
                                                <a href="dealer_list_view" class="btn default" style="text-decoration:none; height: 30px;" >
                                                     <li class="m-icon-swapleft"></li> Back</a>
                                            </div>

                                        </div>
                                        <div class="portlet-body form">
                                            <!-- BEGIN FORM-->
                                            <div class="form-body profile-background">
                                                <form id="commentForm" class="form-horizontal" name ="add_new_user" action="" method="post" enctype="multipart/form-data">      

                                                    <div class="row margin-top-5">
                                                        <div class="col-md-12">
                                                            <!-- BEGIN PROFILE SIDEBAR -->
                                                            <div class="profile-sidebar">
                                                                <!-- PORTLET MAIN -->
                                                                <div class="portlet light profile-sidebar-portlet">
                                                                    <!-- SIDEBAR USERPIC -->
                                                                    <div class="profile-userpic">
                                                                        <?php if ($user_detail['dealer_prof_picture'] != "") { ?>
                                                                            <img src="<?php echo SITEURL ?>/uploads/Dealer_Photo/<?php echo $user_detail['dealer_prof_picture']; ?>" class="img-responsive" alt="">
                                                                        <?php } else { ?>
                                                                            <img src="<?php echo SITEURL ?>/uploads/Dealer_Photo/blank_profile.jpg" class="img-responsive" alt="">
                                                                        <?php } ?> 
                                                                    </div>
                                                                    <!-- END SIDEBAR USERPIC -->
                                                                    <!-- SIDEBAR USER TITLE -->
                                                                    <div class="profile-usertitle">
                                                                        <div class="profile-usertitle-name">
                                                                            <?php echo $user_detail['dealer_fname'] . " " . $user_detail['dealer_lname']; ?>
                                                                        </div>
                                                                        <div class="profile-usertitle-job">
                                                                            ( <?php echo $user_detail['dealer_store_name']; ?> )
                                                                        </div>
                                                                    </div>
                                                                    <!-- END SIDEBAR USER TITLE -->
                                                                    <br />
                                                                </div>
                                                                <!-- END PORTLET MAIN -->
                                                                <!-- PORTLET MAIN -->
                                                                <div class="portlet light">

                                                                    <div>
                                                                        <h4 class="profile-desc-title">Quick Contact</h4>

                                                                        <div class="margin-top-20 profile-desc-link">
                                                                            <i class="fa fa-globe"></i>
                                                                            <?php echo $user_detail['dealer_email']; ?>
                                                                        </div>
                                                                        <div class="margin-top-20 profile-desc-link">
                                                                            <i class="fa fa-phone"></i>
                                                                            <?php echo $user_detail['dealer_contact_no']; ?>
                                                                        </div>
                                                                        <div class="margin-top-20 profile-desc-link">
                                                                            <i class="fa fa-fax"></i>
                                                                            <?php echo $user_detail['dealer_fax']; ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- END PORTLET MAIN -->
                                                            </div>
                                                            <!-- END BEGIN PROFILE SIDEBAR -->
                                                            <!-- BEGIN PROFILE CONTENT -->
                                                            <div class="profile-content">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        
                                                                        <div class="portlet light">
                                                                            <div class="form-body">

                                                                                <h3 class="form-section">Company Info</h3>
                                                                                <!-- row start -->
                                                                                <div class="row">
                                                                                    
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12">
                                                                                                <label>BL Code :</label>
                                                                                                <input type="text" class="form-control" value="<?php echo $user_detail['dealer_bl_code']; ?>" readonly="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12">
                                                                                                <label>Region :</label>
                                                                                                <input type="text" class="form-control" value="<?php echo $user_detail['dealer_region']; ?>" readonly="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>  
                                                                                    
                                                                                </div>
                                                                                <!-- row end -->
                                                                                
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12">
                                                                                                <label>State :</label>
                                                                                                <input type="text" class="form-control" value="<?php echo $user_detail['dealer_states']; ?>" readonly="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div> 
                                                                                    
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12">
                                                                                                <label>Market :</label>
                                                                                                <input type="text" class="form-control" value="<?php echo $user_detail['market_name']; ?>" readonly="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div> 
                                                                                   
                                                                                </div>
                                                                                <!-- row end -->
                                                                                
                                                                                <!-- row start -->
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12">
                                                                                                <label>Marketing Executive(ME) :</label>
                                                                                                <input type="text" class="form-control" value="<?php echo $user_detail['user_calling_name']; ?>" readonly="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>  
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12">
                                                                                                <label>Sales Rep :</label>
                                                                                                <input type="text" class="form-control" value="<?php echo $detailRep['user_calling_name']; ?>" readonly="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    
                                                                                </div>
                                                                                <!-- row end -->
                                                                                
                                                                                <!-- row start -->
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12">
                                                                                                <label>Account Manager(ACM) :</label>
                                                                                                <input type="text" class="form-control" value="<?php echo $detailAreaMg['user_calling_name']; ?>" readonly="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>                                                                                      
                                                                                    
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12">
                                                                                                <label>Regional Manager(RM) :</label>
                                                                                                <input type="text" class="form-control" value="<?php echo $detailRegMg['user_calling_name']; ?>" readonly="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>  
                                                                                    
                                                                                    <div class="col-md-6">
                                                                                        
                                                                                    </div>  
                                                                                    
                                                                                </div>
                                                                                <!-- row end -->
                                                                             
                                                                        </div>
                                                                        </div>
                                                                        
                                                                        <div class="portlet light">

                                                                            <!-- BEGIN FORM-->
                                                                            <div class="form-body">
                                                                                <h3 class="form-section">Personal Info</h3>

                                                                                <!-- row start -->
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12">
                                                                                                <label>First Name :</label>
                                                                                                <input type="text" class="form-control" value="<?php echo $user_detail['dealer_fname']; ?>" readonly="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>    
                                                                                
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12">
                                                                                                <label>Last Name :</label>
                                                                                                <input type="text" class="form-control" value="<?php echo $user_detail['dealer_lname']; ?>" readonly="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- row end -->

                                                                                <!-- row start -->
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12">
                                                                                                <label>Store Name :</label>
                                                                                                <input type="text" class="form-control" value="<?php echo $user_detail['dealer_store_name']; ?>" readonly="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>  
                                                                                    
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12">
                                                                                                <label>Email :</label>
                                                                                                <input type="text" class="form-control" value="<?php echo $user_detail['dealer_email']; ?>" readonly="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>  
                                                                                </div>
                                                                                <!-- row end -->
                                                                                
                                                                                      <!-- row start -->
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12">
                                                                                                <label>Dealer Code :</label>
                                                                                                <input type="text" class="form-control" value="<?php echo $user_detail['dealer_code']; ?>" readonly="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    
                                                                                </div>
                                                                                <!-- row end -->
                                                                                 
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        
                                                                        <div class="portlet light">
                                                                            <div class="form-body">
                                                                                
                                                                                <h3 class="form-section">Contact Info</h3>
                                                                                <!-- row start -->
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12">
                                                                                                <label>Telephone :</label>
                                                                                                <input type="text" class="form-control" value="<?php echo $user_detail['dealer_contact_no']; ?>" readonly="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>  
                                                                                    
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12">
                                                                                                <label>Fax :</label>
                                                                                                <input type="text" class="form-control" value="<?php echo $user_detail['dealer_fax']; ?>" readonly="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- row end -->
                                                                                
                                                                                <!-- row start -->
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12">
                                                                                                <label>Permanent Address :</label>
                                                                                                <input type="text" class="form-control" value="<?php echo $user_detail['dealer_address']; ?>" readonly="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>  
                                                                                    
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12">
                                                                                                <label>City/Town :</label>
                                                                                                <input type="text" class="form-control" value="<?php echo $user_detail['dealer_city']; ?>" readonly="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- row end -->
                                                                                
                                                                                <!-- row start -->
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12">
                                                                                                <label>State :</label>
                                                                                                <input type="text" class="form-control" value="<?php echo $user_detail['dealer_state']; ?>" readonly="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>  
                                                                                    
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12">
                                                                                                <label>Postal/Zip Code :</label>
                                                                                                <input type="text" class="form-control" value="<?php echo $user_detail['dealer_zip_code']; ?>" readonly="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>  
                                                                                </div>
                                                                                <!-- row end -->
                                                                                
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="portlet light">
                                                                            <div class="form-body">
                                                                                
                                                                                <h3 class="form-section">Billing Info</h3>
                                                                                <!-- row start -->
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12">
                                                                                                <label>Address :</label>
                                                                                                <input type="text" class="form-control" value="<?php echo $user_detail['dealer_billing_addrs']; ?>" readonly="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>  
                                                                                    
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12">
                                                                                                <label>City :</label>
                                                                                                <input type="text" class="form-control" value="<?php echo $user_detail['dealer_billing_city']; ?>" readonly="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- row end -->
                                                                                
                                                                                <!-- row start -->
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12">
                                                                                                <label>State :</label>
                                                                                                <input type="text" class="form-control" value="<?php echo $user_detail['dealer_billing_state']; ?>" readonly="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>  
                                                                                    
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12">
                                                                                                <label>Postal/Zip Code :</label>
                                                                                                <input type="text" class="form-control" value="<?php echo $user_detail['dealer_billing_zip']; ?>" readonly="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>  
                                                                                </div>
                                                                                <!-- row end -->
                                                                                
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="portlet light">
                                                                            <div class="form-body">
                                                                                
                                                                                <h3 class="form-section">Shipping Info</h3>
                                                                                <!-- row start -->
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12">
                                                                                                <label>Address :</label>
                                                                                                <input type="text" class="form-control" value="<?php echo $user_detail['dealer_shipping_addrs']; ?>" readonly="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>  
                                                                                    
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12">
                                                                                                <label>City :</label>
                                                                                                <input type="text" class="form-control" value="<?php echo $user_detail['dealer_shipping_city']; ?>" readonly="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- row end -->
                                                                                
                                                                                <!-- row start -->
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12">
                                                                                                <label>State :</label>
                                                                                                <input type="text" class="form-control" value="<?php echo $user_detail['dealer_shipping_state']; ?>" readonly="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>  
                                                                                    
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12">
                                                                                                <label>Postal/Zip Code :</label>
                                                                                                <input type="text" class="form-control" value="<?php echo $user_detail['dealer_shipping_zip']; ?>" readonly="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>  
                                                                                </div>
                                                                                <!-- row end -->
                                                                            
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="portlet light">
                                                                            <div class="form-body">
                                                                                
                                                                                <h3 class="form-section">Verify Account</h3>
                                                                                <!-- row start -->
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12">
                                                                                                <label class="control-label">Verification Code <span class="required" > * </span> :</label>
                                                                                                <input type="text" class="form-control" name="dealer_verify_code" id="dealer_verify_code" value="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>  
                                                                                    
                                                                                </div>
                                                                                <!-- row end -->
                                                                                
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        
                                                                        <!-- END FORM-->

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- END PROFILE CONTENT -->
                                                            
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-actions">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-md-offset-3 col-md-8">
                                                                        <button type="submit" name="update" class="btn green"><i class="fa fa-check"></i> Activate</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
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
            <script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js"></script> 

    <?php
    //Clear all the Message Session Variables...
    if(isset($_SESSION['returnmessage'])) { unset($_SESSION['returnmessage']);}
    ?>
 
    </body>

    <!-- END BODY -->
</html>

<script>

    /* Delete  Entered Data display message ======-------------------->>>>>>*/
    $(document).ready(function () {
        $('#hide div').live('click', function () {
            $(this).parent().parent().remove();
        });
    });

    /* Delete upload display message ======-------------------->>>>>>*/
    $(document).ready(function () {
        $('span#delete ').live('click', function () {
            $(this).parent().parent().remove();
        });
    });
</script> 

<?php
//Clear all the Message Session Variables...
if (isset($_SESSION['returnmessage'])) {
    unset($_SESSION['returnmessage']);
}
?>