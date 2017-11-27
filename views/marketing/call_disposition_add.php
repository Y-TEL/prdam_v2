<?php
/**
 * Description of User
 *
 * @author Nirushika
 */
session_start();
require_once '../../includes/views/define_include.php';
require '../../classes/marketing/call_disposition.php';

$loginManager = new LoginManager();
$logerHD = new LoggerHD();

if (!$loginManager->confirm_member()) {
    header('Location: ../../index.php');
}

$page = new Page();
$page->setIcon("iconfa-home");
$page->setHeader("Call Disposition");
$page->setTag_line("add_call_disposition");
$page->setMenu_active("call_disposition");
$page->setMenu_group("Marketing_Department");

$call_disp = new CLDisposition();

date_default_timezone_set('America/New_York');
@$today = date('d-m-Y');

$user_id = $_SESSION['user_id'];

$drop_downs = new DropDownlist();
$drop_down_outcomes = $drop_downs->getAllOutcomes();
$drop_down_agents   = $drop_downs->getAllAgents();
$drop_down_market   = $drop_downs->getAllMarket();
$drop_down_dealers  = $drop_downs->getAllDealerDetails();

if ((isset($_POST['add']))||(isset($_POST['continue']))) { 

    $act_agent_name  = filter_input(INPUT_POST, 'act_agent_name', FILTER_SANITIZE_STRING);
    $act_dealer_type = filter_input(INPUT_POST, 'act_dealer_type', FILTER_SANITIZE_STRING);
    $created_date = date('Y-m-d');
    $created_time = date('h:i a');
    
    if($act_dealer_type =="New Dealer"){
       $exs_dealer_bl = ""; 
       $act_store_name = filter_input(INPUT_POST, 'act_store_name', FILTER_SANITIZE_STRING);
       $act_market = filter_input(INPUT_POST, 'act_market', FILTER_SANITIZE_STRING);
       $act_market_cat = filter_input(INPUT_POST, 'act_market_cat', FILTER_SANITIZE_STRING);
       $act_phone_no = filter_input(INPUT_POST, 'act_phone_no', FILTER_SANITIZE_STRING);
       
       $phone_no_1_reachable = filter_input(INPUT_POST, 'act_phone_no_1_reachable', FILTER_SANITIZE_STRING);
       if($phone_no_1_reachable==1){ $act_dealer_status= "Reachable"; }else{ $act_dealer_status= "Unreachable";}
       
    }else{
       $exs_dealer_bl = filter_input(INPUT_POST, 'exs_dealer_bl', FILTER_SANITIZE_STRING); 
       $act_store_name = filter_input(INPUT_POST, 'exs_store_name', FILTER_SANITIZE_STRING);
       $act_market = filter_input(INPUT_POST, 'exs_market', FILTER_SANITIZE_STRING);
       $act_market_cat = filter_input(INPUT_POST, 'exs_market_cat', FILTER_SANITIZE_STRING);
       
       $phone_no_1 = filter_input(INPUT_POST, 'exs_phone_no_1', FILTER_SANITIZE_STRING);
       $phone_no_2 = filter_input(INPUT_POST, 'exs_phone_no_2', FILTER_SANITIZE_STRING);
       $phone_no_3 = filter_input(INPUT_POST, 'exs_phone_no_3', FILTER_SANITIZE_STRING);
       $phone_no_4 = filter_input(INPUT_POST, 'exs_phone_no_4', FILTER_SANITIZE_STRING);
       
       $exs_phone_no_active = filter_input(INPUT_POST, 'exs_phone_no_active', FILTER_SANITIZE_STRING);
       if($exs_phone_no_active=="1"){
       $act_phone_no = $phone_no_1;   
       }else if($exs_phone_no_active=="2"){
       $act_phone_no = $phone_no_2; 
       }else if($exs_phone_no_active=="3"){
       $act_phone_no = $phone_no_3;   
       }else if($exs_phone_no_active=="4"){
       $act_phone_no = $phone_no_4;   
       }else{}
       
       if($phone_no_1!=""){ 
           $phone_no_1_reachable = filter_input(INPUT_POST, 'exs_phone_no_1_reachable', FILTER_SANITIZE_STRING); 
           if($phone_no_1_reachable==1){ $phone_no_1_date = date('Y-m-d'); }else{ $phone_no_1_date = ""; }
       }else{ $phone_no_1_reachable =0; }
       if($phone_no_2!=""){ 
           $phone_no_2_reachable = filter_input(INPUT_POST, 'exs_phone_no_2_reachable', FILTER_SANITIZE_STRING); 
           if($phone_no_2_reachable==1){ $phone_no_2_date = date('Y-m-d'); }else{ $phone_no_2_date = ""; }
       }else{ $phone_no_2_reachable =0; }
       if($phone_no_3!=""){ 
           $phone_no_3_reachable = filter_input(INPUT_POST, 'exs_phone_no_3_reachable', FILTER_SANITIZE_STRING); 
           if($phone_no_3_reachable==1){ $phone_no_3_date = date('Y-m-d'); }else{ $phone_no_3_date = ""; }
       }else{ $phone_no_3_reachable =0; }
       if($phone_no_4!=""){ $phone_no_4_reachable = filter_input(INPUT_POST, 'exs_phone_no_4_reachable', FILTER_SANITIZE_STRING); }else{ $phone_no_4_reachable =0; }
       
       if(($phone_no_1_reachable==1)||($phone_no_2_reachable==1)||($phone_no_3_reachable==1)||($phone_no_4_reachable==1)){ $act_dealer_status= "Reachable"; }else{ $act_dealer_status= "Unreachable";}
    
        $msg_1 = $call_disp->updateDealerPhoneNoReachable($phone_no_1_reachable,$phone_no_2_reachable,$phone_no_3_reachable,$phone_no_1_date,$phone_no_2_date,$phone_no_3_date,$exs_dealer_bl);
    }
    
    $act_call_type   = filter_input(INPUT_POST, 'act_call_type', FILTER_SANITIZE_STRING);
    $act_outcome     = filter_input(INPUT_POST, 'act_outcome', FILTER_SANITIZE_STRING);
    $act_comments    = filter_input(INPUT_POST, 'act_comments', FILTER_SANITIZE_STRING);  
    
    $msg = $call_disp->addActivation($act_agent_name,$act_dealer_type,$exs_dealer_bl,$act_store_name,$act_phone_no,$act_market,$act_market_cat,$act_call_type,$act_outcome,$act_comments,$act_dealer_status,$created_date,$created_time);
    
    if ($msg=1) { 
        
//        if($act_outcome == 'Order'){
//           header('Location: ../shipping/orders_add?id_1='.$ex_dealer_bl_code); 
//        }else if($act_outcome == 'Issue Escalated'){
//           header('Location: dealer_issue_add?id_2='.$ex_dealer_bl_code); 
//        }else{
            $returnmessage = array();
            array_push($returnmessage, array("type"=>"success"));	//succes | warning | error | information
            array_push($returnmessage , array("message"=>SUCCESS));
            $_SESSION['returnmessage'] = $returnmessage; 
        //}
        
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
<link rel="stylesheet" type="text/css" href="<?php echo SITEURL ?>/assets/global/plugins/bootstrap-select/bootstrap-select.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo SITEURL ?>/assets/global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo SITEURL ?>/assets/global/plugins/jquery-multi-select/css/multi-select.css"/>
<!-- BEGIN THEME STYLES -->

<!-- class head -->
   <?php require("../../includes/views/head.php") ?>
<!-- class head -->

<script>
$(document).ready(function(){
	$("#commentForm").validate({
	    
	});
});
</script>

<style>
.errors{background-color: #d9534f;
display: inline;
padding: .2em .6em .3em;
font-size: 14px;
font-weight: 600;
line-height: 1;
color: #fff;
text-align: center;
white-space: nowrap;
vertical-align: baseline;
border-radius: .25em;		}
</style>

<style>
.switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 24px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #FC030A;
  -webkit-transition: .4s;
  transition: .4s;
  margin: 0;
}

.slider:before {
  position: absolute;
  content: "";
  height: 16px;
  width: 16px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
  margin: 0;
}

input:checked + .slider {
  background-color: #36FB39;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px !important;
}

.slider.round:before {
  border-radius: 50% !important;
}
</style>
<script>
$(document).ready(function(){
    
    $("#new_dealer_view").hide();
    
        $('input[type="radio"]').click(function(){
            if($(this).attr("value")=="New Dealer"){
                $("#exs_dealer_view").hide();
                $("#new_dealer_view").show();
            }
            if($(this).attr("value")=="Existing Dealer"){
                $("#new_dealer_view").hide();
                $("#exs_dealer_view").show();
            }
        });
        
    });
</script>

<script>
function Select_Dealer_Details()
{ 
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		 xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		 xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
		var exs_dealer_bl = document.getElementById('exs_dealer_bl').value;
		
		xmlhttp.onreadystatechange=function()
		{//7
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{//8
				document.getElementById('ex_dealer_view').innerHTML=xmlhttp.responseText;
 			}
		}
		xmlhttp.open("GET","call_disposition_select_dealer.php?exs_dealer_bl="+exs_dealer_bl,true);
		xmlhttp.send();       
}


//jQuery(function() {    
//    
//    /***********************  Button preview **********************************************************/
//    jQuery("#actionSave").show();
//    jQuery("#actionConitinue").hide();
//
//    jQuery("#act_outcome").on("change", function() {
//        var DealerType = ($("input[name=act_dealer_type]:checked").val());
//        var outcome    = jQuery("#act_outcome").val();
//        
//        if((DealerType != 'New Dealer') & ((outcome == 'Order')||(outcome == 'Issue Escalated'))){
//        jQuery("#actionSave").hide();
//        jQuery("#actionConitinue").show();
//        }else{
//        jQuery("#actionSave").show();
//        jQuery("#actionConitinue").hide();    
//        }
//        
//    });
//
//    /***********************  end ************************************************************************/
//            
//    });      
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
											<i class="fa fa-gift"></i>Add Call Disposition
										</div>
										<div class="tools">* Mandatory fields
											<a href="javascript:;" class="reload">
											</a>
											
										</div>
									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
                                                                              
                                                                                
                                                                                <form id="commentForm" class="form-horizontal" name ="add_call_disposition" action="" method="post" enctype="multipart/form-data"> 
											<div class="form-body" >
                                                                                                
                                                                                                <div class="row" style=" margin-top:50px;">   
                                                                                                        <div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-5">Agent Name : <span style="font-size:14px; color:#D90000;" >*</span></label>
															<div class="col-md-6">
                                                                                                                            <input type="text" name="act_agent_name" id="act_agent_name" class="form-control" value="<?php echo $_SESSION['user_calling_name'];?>" readonly="" required=""/>
															</div>
														</div>
													</div>
													<!--/span-->
                                                                                                        <div class="col-md-6">
														<div class="form-group">
                                                                                                                    <label class="control-label col-md-5">Dealer Type : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                    <div class="col-md-6">
                                                                                                                            
                                                                                                                            <div class="form-md-radios">
                                                                                                                                    <div class="md-radio-inline">
                                                                                                                                            <div class="md-radio">
                                                                                                                                                    <input type="radio" id="radio1" name="act_dealer_type" id="dealer_existing" class="md-radiobtn" value="Existing Dealer" checked>
                                                                                                                                                    <label for="radio1">
                                                                                                                                                    <span></span>
                                                                                                                                                    <span class="check"></span>
                                                                                                                                                    <span class="box"></span>
                                                                                                                                                    Existing</label>
                                                                                                                                            </div>
                                                                                                                                            <div class="md-radio">
                                                                                                                                                    <input type="radio" id="radio2" name="act_dealer_type" id="dealer_new" class="md-radiobtn" value="New Dealer">
                                                                                                                                                    <label for="radio2">
                                                                                                                                                    <span></span>
                                                                                                                                                    <span class="check"></span>
                                                                                                                                                    <span class="box"></span>
                                                                                                                                                    New </label>
                                                                                                                                            </div>
                                                                                                                                    </div>
                                                                                                                            </div>
                                                                                                                    </div>
                                                                                                            </div>
													</div>
													<!--/span-->
                                                                                                  </div>
                                                                                                <!--/row-->
                                                                                                
                                                                                                <h4 class="form-section">Dealer Details</h4>
                                                                                                
                                                                                                <div id="new_dealer_view">
                                                                                                
                                                                                                <div class="row">
                                                                                                        <div class="col-md-6">
														<div class="form-group">
                                                                                                                    <label class="control-label col-md-5">Market : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                    <div class="col-md-6">
                                                                                                                            <select name="act_market" id="act_market" class="form-control select2me" required="">
                                                                                                                                <option value="" selected="true" disabled="true">SELECT</option>
                                                                                                                                <?php foreach ($drop_down_market as $value) { ?>
                                                                                                                                    <option value="<?php echo $value['market_id']; ?>"><?php echo $value['market_name']; ?></option><?php } ?>
                                                                                                                            </select> 
                                                                                                                    </div>
                                                                                                            </div>
													</div>
													<!--/span-->
                                                                                                        <div class="col-md-6">
														<div class="form-group">
                                                                                                                    <label class="control-label col-md-5">Market Category : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                    <div class="col-md-6">
                                                                                                                            <select name="act_market_cat" id="act_market_cat" class="form-control" required="">
                                                                                                                                    <option value="" selected="true" disabled="true">Select</option>
                                                                                                                                    <option value="Remote market">Remote market</option>
                                                                                                                                    <option value="Represented ">Represented </option>
                                                                                                                            </select>
                                                                                                                    </div>
                                                                                                            </div>
													</div>
													<!--/span-->
                                                                                                </div>
												<!--/row-->
                                                                                                <div class="row">
                                                                                                        <div class="col-md-6">
														<div class="form-group">
                                                                                                                    <label class="control-label col-md-5">Store Name : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                    <div class="col-md-6">
                                                                                                                            <input type="text" name="act_store_name" id="act_store_name" class="form-control" value="" required=""/>
                                                                                                                    </div>
                                                                                                            </div>
													</div>
													<!--/span-->
                                                                                                        
                                                                                                </div>
												<!--/row-->
                                                                                                <div class="row">
                                                                                                        <div class="col-md-6">
                                                                                                           
                                                                                                        </div> 
                                                                                                        <div class="col-md-6">
                                                                                                        Unreachable/Reachable
                                                                                                        </div>
                                                                                                </div>
                                                                                                <!--/row-->
                                                                                                <div class="row">
                                                                                                        <div class="col-md-6">
														<div class="form-group">
                                                                                                                    <label class="control-label col-md-5">Phone Number : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                    <div class="col-md-6">
                                                                                                                        <input type="number" name="act_phone_no" id="act_phone_no" class="form-control" value="" maxlength="15" required=""/>
                                                                                                                    </div>
                                                                                                            </div>
													</div>
													<!--/span-->
                                                                                                        <div class="col-md-6">
<!--                                                                                                            <input type="checkbox" class="make-switch" checked data-on-color="success" data-off-color="danger"-->
                                                                                                            <label class="switch"><input type="checkbox" name="act_phone_no_1_reachable" value="1" checked=""><span class="slider round"></span></label>
                                                                                                        </div>
                                                                                                </div>
												<!--/row-->
                                                                                                </div>
                                                                                                
                                                                                                <div id="exs_dealer_view">
                                                                                                  <div class="row">
                                                                                                        <div class="col-md-6">
														<div class="form-group">
                                                                                                                    <label class="control-label col-md-5">BL Code : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                    <div class="col-md-6">
                                                                                                                        <input type="text" name="exs_dealer_bl" id="exs_dealer_bl" class="form-control" required="" onblur="Select_Dealer_Details();">
                                                                                                                    </div>
                                                                                                            </div>
													</div>
													<!--/span-->
                                                                                                </div>
												<!--/row-->  
                                                                                                
                                                                                                <div id="ex_dealer_view"></div>
                                                                                                </div>
                                                                                                
                                                                                                <h4 class="form-section">Call Details</h4>
                                                                                                
                                                                                                <div class="row">
                                                                                                    <div class="col-md-6">
                                                                                                            <div class="form-group">
                                                                                                                <label class="control-label col-md-5">Call Type : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                <div class="col-md-6">
                                                                                                                        <select name="act_call_type" id="act_call_type" class="form-control" required="">
                                                                                                                                <option value="" selected="true" disabled="true">Select</option>
                                                                                                                                <option value="New Lead">New Lead</option>
                                                                                                                                <option value="Inactive Turn around">Inactive Turn around</option>
                                                                                                                                <option value="Email Bounce Feedback">Email Bounce Feedback</option>
                                                                                                                                <option value="Courtesy call">Courtesy call</option>
                                                                                                                                <option value="Sales Call">Sales Call</option>
                                                                                                                                <option value="Information gathering">Information gathering</option>
                                                                                                                        </select>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <!--/span-->
                                                                                                    <div class="col-md-6">
                                                                                                            <div class="form-group">
                                                                                                                    <label class="control-label col-md-5">Outcome   : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                    <div class="col-md-6">
                                                                                                                        <select name="act_outcome" class="select2_category form-control" id="act_outcome" required="">
                                                                                                                            <option value="" selected="true" disabled="">Select</option>
                                                                                                                            <?php
                                                                                                                            foreach ($drop_down_outcomes as $values) {
                                                                                                                            ?>
                                                                                                                            <option value="<?php echo $values; ?>"><?php echo $values; ?></option>
                                                                                                                            <?php } ?>
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                    </div>
                                                                                                    <!--/span-->
                                                                                                </div>
												<!--/row-->
                                                                                                
                                                                                                <div class="row">
                                                                                                    <div class="col-md-6">
                                                                                                            <div class="form-group">
                                                                                                                    <label class="control-label col-md-5">Comments   : </label>
                                                                                                                    <div class="col-md-6">
                                                                                                                        <textarea class="form-control" rows='5' id="act_comments" name="act_comments" placeholder="Enter Your Comment" maxlength="200"></textarea>
                                                                                                                        <br/> 
                                                                                                                        <p id="counter" ></p>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                    </div>
                                                                                                    <!--/span-->
                                                                                                    
                                                                                                </div>
												<!--/row-->
                                                                                                
											</div>
                                                                                        <div class="form-actions">
												<div class="row">
													<div class="col-md-12">
														<div class="row">
															<div class="col-md-offset-2 col-md-8">
                                                                                                                                <div id="actionSave">
                                                                                                                                    <button type="submit" name="add" class="btn green">Save</button>
                                                                                                                                    <input type="reset"  class="btn default" name="reset" id="reset" value="Reset" />
                                                                                                                                </div>
<!--                                                                                                                                <div id="actionConitinue">
                                                                                                                                    <button type="submit" name="continue" class="btn green">Save & Continue</button>
                                                                                                                                    <input type="reset"  class="btn default" name="reset" id="reset" value="Reset" />
                                                                                                                                </div>-->
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
<?php //require("../../includes/views/footer_admin.php"); ?>

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

<script src="<?php echo SITEURL ?>/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo SITEURL ?>/assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo SITEURL ?>/assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
<!-- IMPORTANT! fullcalendar depends on jquery-ui.min.js for drag & drop support -->
<script src="<?php echo SITEURL ?>/assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo SITEURL ?>/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>

<script src="<?php echo SITEURL ?>/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>

<script src="<?php echo SITEURL ?>/assets/global/plugins/select2/select2.min.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<!--<script src="<?php echo SITEURL ?>/assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>-->
<script src="<?php echo SITEURL ?>/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/global/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/global/plugins/bootstrap-markdown/lib/markdown.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo SITEURL ?>/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/admin/layout/scripts/demo.js" type="text/javascript"></script>

<script src="<?php echo SITEURL ?>/assets/admin/pages/scripts/index.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/admin/pages/scripts/tasks.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/admin/pages/scripts/form-validation.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo SITEURL ?>/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script src="<?php echo SITEURL ?>/assets/admin/pages/scripts/table-editable.js"></script>

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
<!-- END FOOTER -->
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

<script type="text/javascript">

$('#counter').text('200 characters left');
$('#act_comments').keyup(function () {
    var max = 200;
    var len = $(this).val().length;
    if (len >= max) {
		$('#counter').addClass('errors');
        $('#counter').text(' you have reached the limit');
		
	 } else {
        var ch = max - len;
		$('#counter').removeClass('errors');
        $('#counter').text(ch + ' characters left');
    }
});
</script>

<?php
//Clear all the Message Session Variables...
if(isset($_SESSION['returnmessage'])) { unset($_SESSION['returnmessage']);}
?>