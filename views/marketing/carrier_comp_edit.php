<?php
/**
 * Description of User
 *
 * @author Nirushika
 */
session_start();
require_once '../../includes/views/define_include.php';
require '../../classes/marketing/comparison.php';
$loginManager = new LoginManager();
$logerHD = new LoggerHD();

if (!$loginManager->confirm_member()) {
    header('Location: ../../index.php');
}

$page = new Page();
$page->setIcon("iconfa-home");
$page->setHeader("View_All_Comparison");
$page->setTag_line("View_Carrier");
$page->setMenu_active("Carrier_Page");
$page->setMenu_group("Marketing_Department");

$comparison = new Comparison();

date_default_timezone_set('America/New_York');
@$today = date('d-m-Y');

if(isset($_GET['iid'])){
    
$iid = $_GET['iid'];
$delete = $comparison->DeleteCarrierComparison($iid);  

if ($delete=1) {
    header('Location: carrier_comparison_view?iiid='.$delete);
}
    
}else{

$id = $_GET['id'];
$details = $comparison->viewSelectedCarrierComparison($id);                            

$drop_downs = new DropDownlist();
$drop_down_carrier  = $drop_downs->getAllCarrier();
$carrier_name=$details['com_carrier_id'];
$drop_down_plan = $drop_downs->getSelectedPlans($carrier_name);

if (isset($_POST['update'])) {
	
    $comp_carrier   = filter_input(INPUT_POST, 'comp_carrier', FILTER_SANITIZE_STRING);
    if (isset($_POST['comp_plan'])) {$comp_plan      = filter_input(INPUT_POST, 'comp_plan', FILTER_SANITIZE_STRING);}
    else{ $comp_plan      = filter_input(INPUT_POST, 'comp_plan_1', FILTER_SANITIZE_STRING);}
    $com_validity   = filter_input(INPUT_POST, 'com_validity', FILTER_SANITIZE_STRING);
    $com_data       = filter_input(INPUT_POST, 'com_data', FILTER_SANITIZE_STRING);
    $com_talk       = filter_input(INPUT_POST, 'com_talk', FILTER_SANITIZE_STRING);
    $com_text       = filter_input(INPUT_POST, 'com_text', FILTER_SANITIZE_STRING);
    $com_interntnl  = filter_input(INPUT_POST, 'com_interntnl', FILTER_SANITIZE_STRING);
    $com_features   = filter_input(INPUT_POST, 'com_features', FILTER_SANITIZE_STRING);
    $com_note       = filter_input(INPUT_POST, 'com_note', FILTER_SANITIZE_STRING);
    $created_date = date('m-d-Y');
    
    $msg = $comparison->UpdateCarrierCopmarison($comp_carrier,$comp_plan,$com_validity,$com_data,$com_talk,$com_text,$com_interntnl,$com_features,$com_note,$created_date, $id);
            
    if ($msg=1) {
       header('Location: carrier_comparison_view?iid='.$msg);
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
                         
                          comp_carrier        : "required",
                          comp_plan           : "required",
                          comp_plan_1         : "required",
                        }, 
              messages:  
                        {
                         
                         comp_carrier          : "Select Carrier Name",
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
											<i class="fa fa-gift"></i>Edit Carrier Comparison
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
                                                                                                                        <label class="control-label col-md-4">Carrier Name : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                        <div class="col-md-4">
                                                                                                                            <select name="comp_carrier" id="comp_carrier" class="select2_category form-control" tabindex="1" onchange="Carrier_Type();">
																<option value="">Select</option>
                                                                                                                                <?php foreach ($drop_down_carrier as $value) {
                                                                                                                                    if ($value['carrier_id'] == $details['com_carrier_id']) {
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
                                                                                                    <div id="carrier_type_textbox"></div>
                                                                                                </div>
                                                                                                </div>
                                                                                                <!--/row-->
                                                                                                
                                                                                                <div id="plan_textbox">
                                                                                                <div class="row">
                                                                                                        <div class="col-md-12">
                                                                                                               <div class="form-group">
                                                                                                                       <label class="control-label col-md-4">Plan : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                       <div class="col-md-4">
                                                                                                                               <select name="comp_plan_1" id="comp_plan_1" class="select2_category form-control" tabindex="1">
                                                                                                                                   <option value="">Select</option>
                                                                                                                                   <?php foreach ($drop_down_plan as $value) { 
                                                                                                                                            if ($value['plan_id'] == $details['com_plan_id']) {
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
                                                                                                                        <label class="control-label col-md-4">Validity : </label>
                                                                                                                        <div class="col-md-4">
                                                                                                                                <input type="text" name="com_validity" id="com_validity" class="form-control" value="<?php echo $details['com_validity']; ?>">
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                        <!--/span-->
												  </div>
												<!--/row-->
                                                                                                <div class="row">
													<div class="col-md-12">
                                                                                                                <div class="form-group">
                                                                                                                        <label class="control-label col-md-4">Data : </label>
                                                                                                                        <div class="col-md-4">
                                                                                                                                <input type="text" name="com_data" id="com_data" class="form-control" value="<?php echo $details['com_data']; ?>">
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                        <!--/span-->
												</div>
												<!--/row-->
                                                                                                <div class="row">
													<div class="col-md-12">
                                                                                                                <div class="form-group">
                                                                                                                        <label class="control-label col-md-4">Talk : </label>
                                                                                                                        <div class="col-md-4">
                                                                                                                                <input type="text" name="com_talk" id="com_talk" class="form-control" value="<?php echo $details['com_talk']; ?>">
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                        <!--/span-->
												</div>
												<!--/row-->
                                                                                                <div class="row">
													<div class="col-md-12">
                                                                                                                <div class="form-group">
                                                                                                                        <label class="control-label col-md-4">Text : </label>
                                                                                                                        <div class="col-md-4">
                                                                                                                                <input type="text" name="com_text" id="com_text" class="form-control" value="<?php echo $details['com_text']; ?>">
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                        <!--/span-->
												</div>
												<!--/row-->
                                                                                                <div class="row">
													<div class="col-md-12">
                                                                                                                <div class="form-group">
                                                                                                                        <label class="control-label col-md-4">International : </label>
                                                                                                                        <div class="col-md-4">
                                                                                                                                <input type="text" name="com_interntnl" id="com_interntnl" class="form-control" value="<?php echo $details['com_international']; ?>">
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                        <!--/span-->
												</div>
												<!--/row-->
                                                                                                <div class="row">
													<div class="col-md-12">
                                                                                                                <div class="form-group">
                                                                                                                        <label class="control-label col-md-4">Features : </label>
                                                                                                                        <div class="col-md-4">
                                                                                                                                <input type="text" name="com_features" id="com_features" class="form-control" value="<?php echo $details['com_features']; ?>">
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
                                                                                                                                <textarea class="form-control" rows='5' id="com_note" name="com_note"><?php echo $details['com_note']; ?></textarea>
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
                                                                                                                                <a href="carrier_comparison_view" class="btn default" style="text-decoration:none;" >Cancel</a>
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