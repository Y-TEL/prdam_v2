<?php
/**
 * Description of User
 *
 * @author Nirushika
 */
session_start();
require_once '../../includes/views/define_include.php';
require '../../classes/marketing/deal_comparison.php';
$loginManager = new LoginManager();
$logerHD = new LoggerHD();

if (!$loginManager->confirm_member()) {
    header('Location: ../../index.php');
}

$page = new Page();
$page->setIcon("iconfa-home");
$page->setHeader("Carrier_Deals_Comparison");
$page->setTag_line("View_Carrier_Deal");
$page->setMenu_active("Carrier_Page");
$page->setMenu_group("Marketing_Department");

$comparison = new DealComparison();

date_default_timezone_set('America/New_York');
@$today = date('d-m-Y');

if(isset($_GET['iid'])){
    
$iid = $_GET['iid'];
$delete = $comparison->DeleteCarrierDeal($iid);  

if ($delete=1) {
    header('Location: carrier_deal_comparison_view?iiid='.$delete);
}
    
}else{

$id = $_GET['id'];
$details = $comparison->viewSelectedCarrierDeal($id);                            

$drop_downs = new DropDownlist();
$drop_down_carrier  = $drop_downs->getAllCarrier();
$carrier_name=$details['deal_carrier_id'];
$drop_down_plan = $drop_downs->getSelectedPlans($carrier_name);

if (isset($_POST['update'])) {
	
    $comp_carrier   = filter_input(INPUT_POST, 'comp_carrier', FILTER_SANITIZE_STRING);
    if (isset($_POST['comp_plan'])) {$comp_plan = filter_input(INPUT_POST, 'comp_plan', FILTER_SANITIZE_STRING);} else{ $comp_plan = filter_input(INPUT_POST, 'comp_plan_1', FILTER_SANITIZE_STRING);}
    $deal_sim_price = filter_input(INPUT_POST, 'deal_sim_price', FILTER_SANITIZE_STRING);
    $deal_activation_spiff = filter_input(INPUT_POST, 'deal_activation_spiff', FILTER_SANITIZE_STRING);
    $deal_2nd_spiff = filter_input(INPUT_POST, 'deal_2nd_spiff', FILTER_SANITIZE_STRING);
    $deal_3rd_spiff = filter_input(INPUT_POST, 'deal_3rd_spiff', FILTER_SANITIZE_STRING);
    $deal_residual  = filter_input(INPUT_POST, 'deal_residual', FILTER_SANITIZE_STRING);
    $deal_atr       = filter_input(INPUT_POST, 'deal_atr', FILTER_SANITIZE_STRING);
    $deal_note      = filter_input(INPUT_POST, 'deal_note', FILTER_SANITIZE_STRING);
    
    $msg = $comparison->UpdateCarrierDeal($comp_carrier,$comp_plan,$deal_sim_price,$deal_activation_spiff,$deal_2nd_spiff,$deal_3rd_spiff,$deal_residual,$deal_atr,$deal_note,$id);
            
    if ($msg=1) {
       header('Location: carrier_deal_comparison_view?iid='.$msg);
	}
}
?>
<!DOCTYPE html>

<html lang="en">

<head>
<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery-latest.js"></script>
<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery-ui.min.js"></script>

<!-- class head -->
   <?php require("../../includes/views/head.php") ?>
<!-- class head -->

<script>
        $(document).ready(function(){
            $("#commentForm").validate({
                rules :
                        {
                          comp_plan           : "required",
                          comp_plan_1         : "required",
                        }, 
              messages:  
                        {
                         comp_plan             : "Enter Plan Name",
                         comp_plan_1           : "Enter Plan Name",
                        }
            });
        });
        
</script>
<script>
function Carrier_Type()
{ 
    $("#plan_textbox").hide();
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		 xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		 xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
        
		var carrier_name = document.getElementById('comp_carrier').value;
		//alert(item_det_id);
		xmlhttp.onreadystatechange=function()
		{//7
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{//8
				document.getElementById('carrier_type_textbox').innerHTML=xmlhttp.responseText;
 			}
		}
                
		xmlhttp.open("GET","carrier_select_comp_plan.php?carrier_name="+carrier_name,true);
		xmlhttp.send();
	
}
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
								<div class="portlet box blue-madison">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-gift"></i>Edit Carrier Deal
										</div>
										<div class="tools">* Mandatory fields
											<a href="javascript:;" class="reload">
											</a>
											
										</div>
									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
                                                                                
                                                                                <form id="commentForm" class="form-horizontal" name ="add_new_comp" action="" method="post" enctype="multipart/form-data"> 
											<div class="form-body" >
                                                                                               
                                                                                            
                                                                                                <div class="row">
                                                                                                    
                                                                                                        <div class="col-md-12">
                                                                                                                <div class="form-group">
                                                                                                                        <label class="control-label col-md-4">Carrier Name : <span class="required" > * </span></label>
                                                                                                                        <div class="col-md-4">
                                                                                                                            <select name="comp_carrier" id="comp_carrier" class="select2_category form-control" tabindex="1" onchange="Carrier_Type();" required="">
																<option value="">Select</option>
                                                                                                                                <?php foreach ($drop_down_carrier as $value) {
                                                                                                                                    if ($value['carrier_id'] == $details['deal_carrier_id']) {
                                                                                                                                            $selected = "selected";
                                                                                                                                    } else {
                                                                                                                                            $selected = "";
                                                                                                                                    }
                                                                                                                                    ?>
                                                                                                                                    <option value="<?php echo $value['carrier_id']; ?>" <?php echo $selected; ?>><?php echo $value['carrier_name']; ?></option>
                                                                                                                                <?php } ?>
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
                                                                                                                        <label class="control-label col-md-4">Sim Price ($) : <span class="required" > * </span> </label>
                                                                                                                        <div class="col-md-4">
                                                                                                                            <input type="number" name="deal_sim_price" id="deal_sim_price" class="form-control" required="" value="<?php echo $details['deal_sim_price']; ?>">
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                        <!--/span-->
												</div>
												<!--/row-->
                                                                                                
                                                                                                <div class="row">
                                                                                                    <div class="col-md-12">
                                                                                                    <div id="carrier_type_textbox"></div>
                                                                                                </div>
                                                                                                </div>
                                                                                                <!--/row-->
                                                                                                
                                                                                                <div id="plan_textbox">
                                                                                                <div class="row">
                                                                                                        <div class="col-md-12">
                                                                                                               <div class="form-group">
                                                                                                                       <label class="control-label col-md-4">Plan : <span class="required" > * </span></label>
                                                                                                                       <div class="col-md-4">
                                                                                                                               <select name="comp_plan_1" id="comp_plan_1" class="select2_category form-control" tabindex="1">
                                                                                                                                   <option value="">Select</option>
                                                                                                                                   <?php foreach ($drop_down_plan as $value) { 
                                                                                                                                            if ($value['plan_id'] == $details['deal_plan_id']) {
                                                                                                                                                 $selected = "selected";
                                                                                                                                         } else {
                                                                                                                                                 $selected = "";
                                                                                                                                         }
                                                                                                                                       ?>
                                                                                                                                       <option value="<?php echo $value['plan_id']; ?>" <?php echo $selected; ?>><?php echo $value['plan_name']; ?></option>
                                                                                                                                   <?php } ?>
                                                                                                                               </select> 

                                                                                                                       </div>
                                                                                                               </div>
                                                                                                       </div>
                                                                                                       <!--/span-->
                                                                                                 </div>
                                                                                               <!--/row-->
                                                                                                </div>
                                                                                                
                                                                                                <div class="row">
													<div class="col-md-12">
                                                                                                                <div class="form-group">
                                                                                                                        <label class="control-label col-md-4">Activation Spiff ($) : <span class="required" > * </span> </label>
                                                                                                                        <div class="col-md-4">
                                                                                                                            <input type="number" name="deal_activation_spiff" id="deal_activation_spiff" class="form-control" required="" value="<?php echo $details['deal_activation_spiff']; ?>">
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                        <!--/span-->
												</div>
												<!--/row-->
                                                                                                
                                                                                                <div class="row">
													<div class="col-md-12">
                                                                                                                <div class="form-group">
                                                                                                                        <label class="control-label col-md-4">2nd Month Spiff ($) : </label>
                                                                                                                        <div class="col-md-4">
                                                                                                                            <input type="number" name="deal_2nd_spiff" id="deal_2nd_spiff" class="form-control" value="<?php echo $details['deal_2nd_spiff']; ?>">
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                        <!--/span-->
												</div>
												<!--/row-->
                                                                                                
                                                                                                <div class="row">
													<div class="col-md-12">
                                                                                                                <div class="form-group">
                                                                                                                        <label class="control-label col-md-4">3rd Month Spiff ($) : </label>
                                                                                                                        <div class="col-md-4">
                                                                                                                            <input type="number" name="deal_3rd_spiff" id="deal_3rd_spiff" class="form-control" value="<?php echo $details['deal_3rd_spiff']; ?>">
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                        <!--/span-->
												</div>
												<!--/row-->
                                                                                                
                                                                                                <div class="row">
													<div class="col-md-12">
                                                                                                                <div class="form-group">
                                                                                                                        <label class="control-label col-md-4">Residual (%) : </label>
                                                                                                                        <div class="col-md-4">
                                                                                                                            <input type="number" name="deal_residual" id="deal_residual" class="form-control" value="<?php echo $details['deal_residual']; ?>">
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                        <!--/span-->
												</div>
												<!--/row-->
                                                                                                
                                                                                                <div class="row">
													<div class="col-md-12">
                                                                                                                <div class="form-group">
                                                                                                                        <label class="control-label col-md-4">ATR/RTR (%) : </label>
                                                                                                                        <div class="col-md-4">
                                                                                                                            <input type="number" name="deal_atr" id="deal_atr" class="form-control" value="<?php echo $details['deal_atr']; ?>">
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                        <!--/span-->
												</div>
												<!--/row-->
                                                                                                
                                                                                                <div class="row">
													<div class="col-md-12">
                                                                                                                <div class="form-group">
                                                                                                                        <label class="control-label col-md-4">Note : </label>
                                                                                                                        <div class="col-md-4">
                                                                                                                                <textarea class="form-control" rows='5' id="deal_note" name="deal_note"><?php echo $details['deal_note']; ?></textarea>
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
															<div class="col-md-offset-4 col-md-8">
																<button type="submit" class="btn blue-madison" id="update" name="update">Update</button>
                                                                                                                                <input type="reset"  class="btn default" name="reset" id="reset" value="Reset" />
                                                                                                                                <a href="carrier_deal_comparison_view" class="btn default" style="text-decoration:none;" >Cancel</a>
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

<?php
//Clear all the Message Session Variables...
if(isset($_SESSION['returnmessage'])) { unset($_SESSION['returnmessage']);}
?>
</body>

<!-- END BODY -->
</html>
<?php } ?>