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
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

$page = new Page();
$page->setIcon("iconfa-home");
$page->setHeader("Dealer_Issue_Page");
$page->setTag_line("Dealer_Issue");
$page->setMenu_active("Dealer_Issue_view");
$page->setMenu_group("Marketing_Department");

$issue = new DealerIssue();

date_default_timezone_set('America/New_York');
@$today = date('Y-m-d');

$drop_downs = new DropDownlist();
//$drop_down_bl_code = $drop_downs->getAllMyDealers($user_id);
$drop_down_bl_code = $drop_downs->getAllDealers();

if (isset($_POST['add'])) {
    
    $issue_rep          = filter_input(INPUT_POST, 'issue_rep', FILTER_SANITIZE_STRING);
    //$order_dealer_code  = filter_input(INPUT_POST, 'order_dealer_code', FILTER_SANITIZE_STRING);
    if(isset($_POST['order_dealer_code'])){$order_dealer_code = filter_input(INPUT_POST, 'order_dealer_code', FILTER_SANITIZE_STRING);}else{$order_dealer_code = filter_input(INPUT_POST, 'order_dealer_code_cl', FILTER_SANITIZE_STRING);}
    
    ########## Only For Visible ###################
    if(isset($_POST['order_bl_code'])){$order_bl_code = filter_input(INPUT_POST, 'order_bl_code', FILTER_SANITIZE_STRING);}else{$order_bl_code = filter_input(INPUT_POST, 'order_bl_code_rep', FILTER_SANITIZE_STRING);}
    
    if(isset($_POST['dealer_market'])){$dealer_market = filter_input(INPUT_POST, 'dealer_market', FILTER_SANITIZE_STRING);}else{$dealer_market = filter_input(INPUT_POST, 'dealer_market_cl', FILTER_SANITIZE_STRING);}
    if(isset($_POST['store_name'])){$store_name = filter_input(INPUT_POST, 'store_name', FILTER_SANITIZE_STRING);}else{$store_name = filter_input(INPUT_POST, 'store_name_cl', FILTER_SANITIZE_STRING);}
    if(isset($_POST['contact_name'])){$contact_name = filter_input(INPUT_POST, 'contact_name', FILTER_SANITIZE_STRING);}else{$contact_name = filter_input(INPUT_POST, 'contact_name_cl', FILTER_SANITIZE_STRING);}
    if(isset($_POST['dealer_cont_no'])){$dealer_cont_no = filter_input(INPUT_POST, 'dealer_cont_no', FILTER_SANITIZE_STRING);}else{$dealer_cont_no = filter_input(INPUT_POST, 'dealer_cont_no_cl', FILTER_SANITIZE_STRING);}
    if(isset($_POST['email_address'])){$email_address = filter_input(INPUT_POST, 'email_address', FILTER_SANITIZE_STRING);}else{$email_address = filter_input(INPUT_POST, 'email_address_cl', FILTER_SANITIZE_STRING);}
    if(isset($_POST['billing_address'])){$billing_address = filter_input(INPUT_POST, 'billing_address', FILTER_SANITIZE_STRING);}else{$billing_address = filter_input(INPUT_POST, 'billing_address_cl', FILTER_SANITIZE_STRING);}
    if(isset($_POST['shipping_address'])){$shipping_address = filter_input(INPUT_POST, 'shipping_address', FILTER_SANITIZE_STRING);}else{$shipping_address = filter_input(INPUT_POST, 'shipping_address_cl', FILTER_SANITIZE_STRING);}
    
    //$dealer_market        = filter_input(INPUT_POST, 'dealer_market', FILTER_SANITIZE_STRING);
    //$store_name           = filter_input(INPUT_POST, 'store_name', FILTER_SANITIZE_STRING);
    //$contact_name         = filter_input(INPUT_POST, 'contact_name', FILTER_SANITIZE_STRING);
    //$dealer_cont_no       = filter_input(INPUT_POST, 'dealer_cont_no', FILTER_SANITIZE_STRING);
    //$email_address        = filter_input(INPUT_POST, 'email_address', FILTER_SANITIZE_STRING);
    //$billing_address      = filter_input(INPUT_POST, 'billing_address', FILTER_SANITIZE_STRING);
    //$shipping_address     = filter_input(INPUT_POST, 'shipping_address', FILTER_SANITIZE_STRING);
    ########## Only For Visible ###################
    $issue_date         = filter_input(INPUT_POST, 'issue_date', FILTER_SANITIZE_STRING);
    $issue_category     = filter_input(INPUT_POST, 'issue_category', FILTER_SANITIZE_STRING);
    $issue_details      = filter_input(INPUT_POST, 'issue_details', FILTER_SANITIZE_STRING);
    $issue_emailto      = filter_input(INPUT_POST, 'issue_emailto', FILTER_SANITIZE_STRING);
    $issue_emailcc      = filter_input(INPUT_POST, 'issue_emailcc', FILTER_SANITIZE_STRING);
    $issue_note_taken   = $_SESSION['user_id'];
    $note_taken         = $_SESSION['user_calling_name'];
    
                        //<-----------------------========== Start send email===========-------------------------------------------->
                                $from .= "info@rdams.com";

                                $to    = $issue_emailto;
                                //$to .= "nirushika@witellsolutions.com";

                                $headers .= "From: " . $from. "\r\n";

                                $headers .= "CC: " . $issue_emailcc.",".$user_name. "\r\n";

                                $headers .= "Reply-To: ".$from. "\r\n";

                                $headers .= "MIME-Version: 1.0\r\n";

                                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                                $email_subject="Dealer Issue Form Submission - RDAMS";

                                $email_message .= '<table rules="all" style="border-color: #000;" border="1" cellpadding="10" width="100%">';

                                $email_message .= "<tr style='background: #fff;'><td width='25%'><strong>Issue For Rep : </strong> </td><td>".$issue_rep."</td><td width='25%'><strong>BL Code : </strong></td><td>".$order_bl_code."</td></tr>";
                                
                                $email_message .= "<tr style='background: #F5F5F5;'><td width='25%'><strong>Dealer Code : </strong> </td><td>".$order_dealer_code."</td><td width='25%'><strong>Market : </strong> </td><td>".$dealer_market."</td></tr>";

                                $email_message .= "<tr style='background: #fff;'><td width='25%'><strong>Dealer Store Name : </strong> </td><td>".$store_name."</td><td width='25%'><strong>Dealer First Name : </strong> </td><td>".$contact_name."</td></tr>";
                                                                
                                $email_message .= "<tr style='background: #F5F5F5;'><td width='25%'><strong>Dealer Contact No : </strong> </td><td>".$dealer_cont_no."</td><td width='25%'><strong>Dealer Email : </strong> </td><td>".$email_address."</td></tr>";
                                 
                                $email_message .= "<tr style='background: #fff;'><td width='25%'><strong>Billing Address : </strong> </td><td>".$billing_address."</td><td width='25%'><strong>Shipping Address : </strong> </td><td>".$shipping_address."</td></tr>";
                                
                                $email_message .= "<tr style='background: #F5F5F5;'><td width='25%'><strong>Date : </strong> </td><td>".$issue_date."</td><td width='25%'><strong>Issue Category : </strong> </td><td>".$issue_category."</td></tr>";

                                $email_message .= "<tr style='background: #fff;'><td width='25%'><strong>Issue Details : </strong> </td><td colspan='3'>".$issue_details."</td></tr>";
                                
                                $email_message .= "<tr style='background: #F5F5F5;'><td width='25%'><strong>Note Taken By : </strong> </td><td colspan='3'>".$note_taken."</td></tr>";
                        
                                $email_message .= "</table>"; 

                       mail($to, $email_subject, $email_message, $headers); 
		// <-----------------------========== End send email===========-------------------------------------------->
   
    $msg = $issue->addNewDealerIssue($issue_rep,$order_dealer_code,$issue_date,$issue_category,$issue_details,$issue_emailto,$issue_emailcc,$issue_note_taken);

    if ($msg=1) { 
    header('Location: dealer_issue_view.php?id='.$msg);
    }
}
?>
<!DOCTYPE html>

<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="<?php echo SITEURL ?>/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo SITEURL ?>/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo SITEURL ?>/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo SITEURL ?>/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo SITEURL ?>/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?php echo SITEURL ?>/assets/global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo SITEURL ?>/assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo SITEURL ?>/assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo SITEURL ?>/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<!-- END PAGE LEVEL STYLES -->

<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery-latest.js"></script>
<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery-ui.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo SITEURL ?>/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo SITEURL ?>/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo SITEURL ?>/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo SITEURL ?>/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>

<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?php echo SITEURL ?>/assets/global/plugins/select2/select2.css"/>
<!-- BEGIN THEME STYLES -->
        
<!-- BEGIN THEME STYLES -->
<link href="<?php echo SITEURL ?>/assets/global/css/components.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo SITEURL ?>/assets/global/css/res-nav.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="<?php echo SITEURL ?>/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo SITEURL ?>/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo SITEURL ?>/assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="<?php echo SITEURL ?>/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="<?php echo SITEURL ?>/assets/global/css/message.css">  
<link href="<?php echo SITEURL ?>/assets/admin/layout/css/themes/darkblue.css" rel="stylesheet" type="text/css" id="style_color"/>
<!-- END THEME STYLES -->
<!-- BEGIN CC MAIL STYLES -->

<link rel="stylesheet" href="<?php echo SITEURL ?>/assets/admin/pages/cc_emaill/styles/token-input.css" type="text/css" />
<link rel="stylesheet" href="<?php echo SITEURL ?>/assets/admin/pages/cc_emaill/styles/token-input-facebook.css" type="text/css" />
<link rel="stylesheet" href="<?php echo SITEURL ?>/assets/admin/pages/cc_emaill/styles/token-input-mac.css" type="text/css" />
<script type="text/javascript" src="<?php echo SITEURL ?>/assets/admin/pages/cc_emaill/src/jquery.tokeninput2.js"></script>
<!-- END CC MAIL STYLES -->


<script>
$(document).ready(function(){ 
	$("#commentForm").validate({ //common validation start
        rules: {
            
                        order_bl_code     : "required",

                        order_bl_code_rep : "required",
                        
                        order_dealer_code : "required",

                        issue_category    : "required",
                                                                                                 
                        issue_details     : "required",
                        
                        issue_emailto     : "required",
                },

           messages: {

                        order_bl_code      : "Select BL Code.",

                        order_bl_code_rep  : "Enter BL Code.",
                        
                        order_dealer_code  : "Dealer Code Required (Dealer not exist in database).",

                        issue_category     : "Select Issue Category.",
                                                                                               
                        issue_details      : "Enter Issue Details.",
                        
                        issue_emailto      : "Enter Email To.",
                        
                        }
        }); ///common validation end

 });
 
</script>
 
<script type="text/javascript">
    
function Select_BL_Code()
{ 
    $("#cc_dealer_view").hide();
    
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
		var order_bl_code = document.getElementById('order_bl_code').value;
		//alert(item_det_id);
		xmlhttp.onreadystatechange=function()
		{//7
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{//8
                            document.getElementById('Dealer_textbox').innerHTML=xmlhttp.responseText;
 			}
		}
		xmlhttp.open("GET","dealer_issue_select_dealer.php?order_bl_code="+order_bl_code,true);
		xmlhttp.send();
}

function Select_BL_Code_Rep()
{ 
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
		var order_bl_code = document.getElementById('order_bl_code_rep').value;
		//alert(item_det_id);
		xmlhttp.onreadystatechange=function()
		{//7
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{//8
                            document.getElementById('Dealer_textbox_rep').innerHTML=xmlhttp.responseText;
 			}
		}
		xmlhttp.open("GET","dealer_issue_select_dealer.php?order_bl_code="+order_bl_code,true);
		xmlhttp.send();
}

jQuery(function() {
        jQuery( "#datepicker" ).datepicker({
          maxDate: '0',
          dateFormat: 'dd-mm-yy',
          changeMonth: true,
          changeYear: true
        });
});
</script>

<script>
$(document).ready(function(){
    
    $("#rep_dealer_view").hide();
    $("#rep_dealer_bl_code").hide();
    
        $('input[type="radio"]').click(function(){
           
            if($(this).attr("value")=="No"){
                $("#my_dealer_bl_code").show();
                $("#my_dealer_view").show();
                $("#rep_dealer_bl_code").hide();
                $("#rep_dealer_view").hide();
            }
            if($(this).attr("value")=="Yes"){
                $("#my_dealer_bl_code").hide();
                $("#my_dealer_view").hide();
                $("#rep_dealer_bl_code").show();
                $("#rep_dealer_view").show();
                $("#cc_dealer_view").hide();
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
			
            
                        <div id="hide"><?php include ("../../includes/views/messager.php"); //Display  Messages for Entered Data  ?></div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
                        <div class="row">
				<div class="col-md-12">
					<div class="tabbable tabbable-custom boxless tabbable-reversed">
						
						  <div class="tab-pane active" id="tab_2">
								<div class="portlet box green">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-gift"></i>Add Dealer Issue
										</div>
										<div class="tools">* Mandatory fields
											<a href="javascript:;" class="reload">
											</a>
											
										</div>
									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
                                                                                
											<div class="form-body" >
                                                                                             
                                                                                            <form id="commentForm" class="form-horizontal" name ="add_new_dealer_issue" action="" method="POST" enctype="multipart/form-data"> 
                                                                                             
                                                                                                <fieldset style="margin-left:8px; margin-top:10px; background-color:#FFF; border-width: medium; border-color: #000;"><legend>Dealer Details</legend>
                                                                                                <div class="row" style=" margin-top:50px;">
                                                                                                    
                                                                                                    <div class="col-md-6">
                                                                                                            <div class="form-group">
                                                                                                                    <label class="control-label col-md-5">Issue For Rep : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                    <div class="col-md-6">
                                                                                                                        <div class="form-md-radios">
                                                                                                                                    <div class="md-radio-inline">
                                                                                                                                            <div class="md-radio">
                                                                                                                                                <input type="radio" id="radio1" name="issue_rep" id="no" class="md-radiobtn" value="No" checked>
                                                                                                                                                    <label for="radio1">
                                                                                                                                                    <span></span>
                                                                                                                                                    <span class="check"></span>
                                                                                                                                                    <span class="box"></span>
                                                                                                                                                    No</label>
                                                                                                                                            </div>
                                                                                                                                            <div class="md-radio">
                                                                                                                                                    <input type="radio" id="radio2" name="issue_rep" id="yes" class="md-radiobtn" value="Yes">
                                                                                                                                                    <label for="radio2">
                                                                                                                                                    <span></span>
                                                                                                                                                    <span class="check"></span>
                                                                                                                                                    <span class="box"></span>
                                                                                                                                                    Yes</label>
                                                                                                                                            </div>
                                                                                                                                    </div>
                                                                                                                            </div>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                    </div>
                                                                                                    <div id="my_dealer_bl_code">
                                                                                                    <div class="col-md-6">
                                                                                                            <div class="form-group">
                                                                                                                    <label class="control-label col-md-5">BL Code : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                    <div class="col-md-6">
                                                                                                                        <select name="order_bl_code" id="order_bl_code" class="form-control select2me" onchange="Select_BL_Code();">
                                                                                                                            <option value="" selected="true" disabled="true">Select</option>
                                                                                                                            <?php  foreach ($drop_down_bl_code as $values) {
                                                                                                                                if($_GET['id_2'] == $values['dealer_bl_code']){  
                                                                                                                                    $selected = "selected";
                                                                                                                                }else {
                                                                                                                                    $selected = "";
                                                                                                                                }
                                                                                                                            ?>
                                                                                                                            <option value="<?php echo $values['dealer_bl_code'];?>" <?php //echo $selected; ?>><?php echo $values['dealer_bl_code']." (".$values['dealer_store_name'].")";?></option>
                                                                                                                            <?php }?>
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                    </div>
                                                                                                    <!--/span-->
                                                                                                    </div>
                                                                                                    
                                                                                                    <div id="rep_dealer_bl_code">
                                                                                                      <div class="col-md-6">
                                                                                                        <div class="form-group">
                                                                                                                    <label class="control-label col-md-5">BL Code : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                    <div class="col-md-6">
                                                                                                                        <input type="text" name="order_bl_code_rep" id="order_bl_code_rep" class="form-control" onblur="Select_BL_Code_Rep();">
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                      </div>
                                                                                                    </div>

                                                                                                  </div>
                                                                                                  <!--/row-->

                                                                                                    <?php if(isset($_GET['id_2'])){
                                                                                                        $order_bl_code=$_GET['id_2'];
                                                                                                        $details = $issue->viewSelectedDealerDetails($order_bl_code); 
                                                                                                    ?>
                                                                                                    <div id="cc_dealer_view">
                                                                                                    <div class="row">
                                                                                                            <div class="col-md-6">
                                                                                                                    <div class="form-group">
                                                                                                                            <label class="control-label col-md-5">Dealer Code : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                            <div class="col-md-6">
                                                                                                                                    <input type="text" name="order_dealer_code_cl" id="order_dealer_code_cl" class="form-control" value="<?php if(isset($details['dealer_code'])){ echo $details['dealer_code']; }else { echo "";}?>" readonly="">
                                                                                                                            </div>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                            <!--/span-->

                                                                                                            <div class="col-md-6">
                                                                                                                    <div class="form-group">
                                                                                                                            <label class="control-label col-md-5">Market : </label>
                                                                                                                            <div class="col-md-6">
                                                                                                                                <input type="text" name="dealer_market_cl" id="dealer_market_cl" class="form-control" value="<?php if(isset($details['market_name'])){ echo $details['cus_type_name']; }else { echo "";}?>" readonly="">
                                                                                                                            </div>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                            <!--/span-->
                                                                                                    </div>
                                                                                                    <!--/row-->

                                                                                                    <div class="row">
                                                                                                            <div class="col-md-6">
                                                                                                                    <div class="form-group">
                                                                                                                            <label class="control-label col-md-5">Store Name : </label>
                                                                                                                            <div class="col-md-6">
                                                                                                                                    <input type="text" name="store_name_cl" id="store_name_cl" class="form-control" value="<?php if(isset($details['dealer_store_name'])){ echo $details['dealer_store_name']; }else { echo "";}?>" readonly="">
                                                                                                                            </div>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                            <!--/span-->

                                                                                                            <div class="col-md-6">
                                                                                                                    <div class="form-group">
                                                                                                                            <label class="control-label col-md-5">First Name : </label>
                                                                                                                            <div class="col-md-6">
                                                                                                                                <input type="text" name="contact_name_cl" id="contact_name_cl" class="form-control" value="<?php if(isset($details['dealer_fname'])){ echo $details['dealer_fname']; }else { echo "";}?>" readonly="">
                                                                                                                            </div>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                            <!--/span-->
                                                                                                    </div>
                                                                                                    <!--/row-->

                                                                                                    <div class="row">
                                                                                                            <div class="col-md-6">
                                                                                                                    <div class="form-group">
                                                                                                                            <label class="control-label col-md-5">Contact Number : </label>
                                                                                                                            <div class="col-md-6">
                                                                                                                                <input type="text" name="dealer_cont_no_cl" id="dealer_cont_no_cl" class="form-control" value="<?php if(isset($details['dealer_contact_no'])){ echo $details['dealer_contact_no']; }else { echo "";}?>" readonly="">
                                                                                                                            </div>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                            <!--/span-->

                                                                                                            <div class="col-md-6">
                                                                                                                    <div class="form-group">
                                                                                                                            <label class="control-label col-md-5">Email Address : </label>
                                                                                                                            <div class="col-md-6">
                                                                                                                                    <input type="text" name="email_address_cl" id="email_address_cl" class="form-control" value="<?php if(isset($details['dealer_email'])){ echo $details['dealer_email']; }else { echo "";}?>" readonly="">
                                                                                                                            </div>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                            <!--/span-->
                                                                                                    </div>
                                                                                                    <!--/row-->

                                                                                                    <div class="row">
                                                                                                       <div class="col-md-6">
                                                                                                                <div class="form-group">
                                                                                                                        <label class="control-label col-md-5">Billing Address : </label>
                                                                                                                        <div class="col-md-6">
                                                                                                                            <input type="text" name="billing_address_cl" id="billing_address_cl" class="form-control" value="<?php if(isset($details['dealer_billing_addrs'])){ echo $details['dealer_billing_addrs']; }else { echo "";}?>" readonly="">
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                        <!--/span-->

                                                                                                        <div class="col-md-6">
                                                                                                                <div class="form-group">
                                                                                                                        <label class="control-label col-md-5">Shipping Address : </label>
                                                                                                                        <div class="col-md-6">
                                                                                                                            <input type="text" name="shipping_address_cl" id="shipping_address_cl" class="form-control" value="<?php if(isset($details['dealer_shipping_addrs'])){ echo $details['dealer_shipping_addrs']; }else { echo "";}?>" readonly="">
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                        <!--/span-->
                                                                                                    </div>
                                                                                                    <!--/row-->
                                                                                                 
                                                                                                    </div>
                                                                                                    <?php } ?>
                                                                                                    
                                                                                                    
                                                                                                  
                                                                                                  <div id="my_dealer_view">
                                                                                                  <div class="row">
                                                                                                      <div id="Dealer_textbox"></div>
                                                                                                  </div>
                                                                                                  </div>
                                                                                                  
                                                                                                  <div id="rep_dealer_view">
                                                                                                  <div class="row">
                                                                                                      <div id="Dealer_textbox_rep"></div>
                                                                                                  </div>
                                                                                                  </div>
                                                                                                </fieldset>
                                                                                                
                                                                                                <fieldset style="margin-left:8px; margin-top:10px; background-color:#FFF; border-width: medium; border-color: #000;"><legend>Other Details</legend>
                                                                                                
                                                                                                    <div class="row" style=" margin-top:50px;">
                                                                                                    <div class="col-md-6">
                                                                                                            <div class="form-group">
                                                                                                                    <label class="control-label col-md-5">Date : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                    <div class="col-md-6">
                                                                                                                        <input type="text" class="form-control" id="datepicker" readonly name="issue_date" value="<?php echo date('d-m-Y');?>">
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                    </div>
                                                                                                    <div class="col-md-6">
                                                                                                            <div class="form-group">
                                                                                                                    <label class="control-label col-md-5">Issue Category : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                    <div class="col-md-6">
                                                                                                                        <select name="issue_category" id="issue_category" class="form-control" required>
                                                                                                                            <option value="" selected="true" disabled="true">Select</option>
                                                                                                                            <option value="Commission">Commission</option>
                                                                                                                            <option value="Activation">Activation</option>
                                                                                                                            <option value="Terminal">Terminal</option>
                                                                                                                            <option value="Signup">Signup</option>
                                                                                                                            <option value="Shipping">Shipping</option>
                                                                                                                            <option value="Tech Support">Tech Support</option>
                                                                                                                            <option value="Rep/RM Issue">Rep/RM Issue</option>
                                                                                                                            <option value="Service not satisfied">Service not satisfied</option>
                                                                                                                            <option value="Call center">Call Center</option>
                                                                                                                            <option value="Distributor">Distributor</option>
                                                                                                                            <option value="Phone sales">Phone sales</option>
                                                                                                                            <option value="Order Issues">Order Issues</option>
                                                                                                                            <option value="ISP issues">ISP issues</option>
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                    </div>
                                                                                                    </div>
                                                                                                    
                                                                                                    <div class="row">
                                                                                                        <div class="col-md-6">
                                                                                                                <div class="form-group">
                                                                                                                        <label class="control-label col-md-5">Issue Details : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                        <div class="col-md-6">
                                                                                                                            <textarea class="form-control" rows='5' id="issue_details" name="issue_details"></textarea>
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                        
                                                                                                        <div class="col-md-6">
                                                                                                            <div class="form-group">
                                                                                                                    <label class="control-label col-md-5">Note Taken By : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                    <div class="col-md-6">
                                                                                                                        <input type="text" name="issue_note_taken" id="issue_note_taken" class="form-control" value="<?php echo $_SESSION['user_calling_name'];?>" readonly="">
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <!--/span-->

                                                                                                    </div>
                                                                                                    
                                                                                                    <div class="row">
                                                                                                    <div class="col-md-6">
                                                                                                            <div class="form-group">
                                                                                                                    <label class="control-label col-md-5">Email To : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                    <div class="col-md-6">
                                                                                                                        <input type="text" name="issue_emailto" id="issue_emailto" class="form-control">
                                                                                                                            <script type="text/javascript">
                                                                                                                            $(document).ready(function() { 
                                                                                                                                $("#issue_emailto").tokenInput2("../shipping/orders_autocomplete.php", { 
                                                                                                                                    theme: "facebook"
                                                                                                                                });
                                                                                                                            });
                                                                                                                            </script>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                    </div>
                                                                                                    <!--/span-->
                                                                                                    
                                                                                                    
                                                                                                    <div class="col-md-6">
                                                                                                            <div class="form-group">
                                                                                                                    <label class="control-label col-md-5">Email CC : </label>
                                                                                                                    <div class="col-md-6">
                                                                                                                       
                                                                                                                            <input type="text" name="issue_emailcc" id="issue_emailcc" class="form-control">
                                                                                                                            <script type="text/javascript">
                                                                                                                            $(document).ready(function() { 
                                                                                                                                $("#issue_emailcc").tokenInput2("../shipping/orders_autocomplete.php", { 
                                                                                                                                    theme: "facebook"
                                                                                                                                });
                                                                                                                            });
                                                                                                                            </script>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                    </div>
                                                                                                    <!--/span-->

                                                                                                </div>
                                                                                            <!--/row-->
                                                                                            
                                                                                             
                                                                                            </fieldset>
                                                                                                
                                                                                             
                                                                                
											<div class="form-actions">
												<div class="row">
													<div class="col-md-6">
														<div class="row">
															<div class="col-md-offset-5 col-md-8">
																<button type="submit" name="add" class="btn green">Submit</button>
                                                                                                                                <input type="reset"  class="btn default" name="reset" id="reset" value="Reset" />
                                                                                                                                <a href="dealer_issue_view" class="btn default" style="text-decoration:none;"><i class="fa fa-times-circle-o"></i> Cancel</a>
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
			</div>
			<!-- END PAGE CONTENT-->
		</div>
	<!-- END CONTENT -->
	
</div>
<!-- END CONTAINER -->

<!-- BEGIN FOOTER -->
<div class="page-footer" style="padding-bottom: 40px;">
    <div class="page-footer-inner" style="margin-top: 10px; width: 97%;">
        <div class="pull-left">Copyright &copy; <?php echo date('Y'); ?> Wireless shop LLC | All rights reserved.</div>
        <div class="pull-right">Developed By Wireless Shop SE Team.</div>
	</div>
        
	<div class="scroll-to-top">
		<i class="icon-arrow-up"></i>
	</div>
</div>
<!-- END FOOTER -->

<!--<script src="<?php echo SITEURL ?>/assets/global/plugins/jquery.min.js" type="text/javascript"></script>-->
<script src="<?php echo SITEURL ?>/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo SITEURL ?>/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="js/auto.js"></script>
<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo SITEURL ?>/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo SITEURL ?>/assets/global/plugins/bootstrap-datepicker/css/datepicker.css"/>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo SITEURL ?>/assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/global/plugins/jquery-bootpag/jquery.bootpag.min.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/global/plugins/holder.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo SITEURL ?>/assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/admin/pages/scripts/ui-general.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script src="<?php echo SITEURL ?>/assets/global/plugins/select2/select2.min.js" type="text/javascript"></script>

<script>
jQuery(document).ready(function() {    
   Metronic.init(); // init metronic core componets
   Layout.init(); // init layout
   QuickSidebar.init(); // init quick sidebar
Demo.init(); // init demo features
   Index.init();   
   Index.initDashboardDaterange();
   Index.initJQVMAP(); // init index page's custom scripts
   Index.initCalendar(); // init index page's custom scripts
   Index.initCharts(); // init index page's custom scripts
   Index.initChat();
   Index.initMiniCharts();
   Tasks.initDashboardWidget();
});
</script>

<script>
jQuery(document).ready(function() {
    jQuery('.toggle-nav').click(function(e) {
        jQuery(this).toggleClass('actives');
        jQuery('.menu ul').toggleClass('actives');
 
        e.preventDefault();
    });
});
</script>
</body>

<!-- END BODY -->
</html>

<script>
/* Delete  Entered Data display message ======-------------------->>>>>>*/
$(document).ready(function() {
  $('#hide div').live('click',function() { 
    $(this).parent().parent().remove(); 
  });
});  

/* Delete upload display message ======-------------------->>>>>>*/
$(document).ready(function() {
  $('span#delete ').live('click',function() { 
    $(this).parent().parent().remove(); 
  });
});  
</script>
    
<?php
//Clear all the Message Session Variables...
if(isset($_SESSION['returnmessage'])) { unset($_SESSION['returnmessage']);}
?>
 