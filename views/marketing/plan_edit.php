<?php
/**
 * Description of User
 *
 * @author Nirushika
 */
session_start();
require_once '../../includes/views/define_include.php';
require '../../classes/marketing/plan.php';
$loginManager = new LoginManager();
$logerHD = new LoggerHD();

if (!$loginManager->confirm_member()) {
    header('Location: ../../index.php');
}

$page = new Page();
$page->setIcon("iconfa-home");
$page->setHeader("View_All_Plans");
$page->setTag_line("View_Carrier");
$page->setMenu_active("Carrier_Page");
$page->setMenu_group("Marketing_Department");

$plan = new Plan();

$drop_downs = new DropDownlist();
$drop_down_carrier  = $drop_downs->getAllCarrier();

if(isset($_GET['iid'])){
    
$iid = $_GET['iid'];
$delete = $plan->DeletePlan($iid);  

if ($delete=1) {
    header('Location: plan_view?iiid='.$delete);
}
    
}else{

$id = $_GET['id'];
$details = $plan->viewSelectedPlan($id);                            

if (isset($_POST['update'])) {
	
    $carrier_name    = filter_input(INPUT_POST, 'carrier_name', FILTER_SANITIZE_STRING);
    $plan_name       = filter_input(INPUT_POST, 'plan_name', FILTER_SANITIZE_STRING);
    
	 $msg = $plan->UpdatePlan($carrier_name,$plan_name, $id);
            
   if ($msg=1) {
       header('Location: plan_view?iid='.$msg);
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

                  carrier_name        : "required",
                  plan_name           : "required",
                }, 
      messages:  
                {

                 carrier_name          : "Select Carrier Name",
                 plan_name             : "Enter Plan Name",
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
								<div class="portlet box blue-madison">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-gift"></i>Edit Plan Form
										</div>
										<div class="tools">* Mandatory fields
											<a href="javascript:;" class="reload">
											</a>
											
										</div>
									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
                                                                                
                                                                                <form id="commentForm" class="form-horizontal" name ="edit_plan" action="" method="post" enctype="multipart/form-data"> 
											<div class="form-body" >
                                                                                                
												<div class="row">
                                                                                                    
                                                                                                        <div class="col-md-12">
                                                                                                                <div class="form-group">
                                                                                                                        <label class="control-label col-md-4">Carrier Name : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                        <div class="col-md-4">
                                                                                                                                <select name="carrier_name" class="select2_category form-control" tabindex="1" data-placeholder="Enter Carrier Name">
																<option value="">Select</option>
                                                                                                                                <?php foreach ($drop_down_carrier as $value) { 
                                                                                                                                    if ($value['carrier_id'] == $details['plan_carrier_id']) {
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
                                                                                                                        <label class="control-label col-md-4">Plan Name : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                        <div class="col-md-4">
                                                                                                                                <input type="text" name="plan_name" id="plan_name" class="form-control" value="<?php echo $details['plan_name']; ?>">
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
                                                                                                                <div class="col-md-offset-4 col-md-8">
                                                                                                                        <button type="submit" class="btn blue-madison" id="update" name="update">Update</button>
                                                                                                                        <input type="reset"  class="btn default" name="reset" id="reset" value="Reset" />
                                                                                                                        <a href="plan_view" class="btn default" style="text-decoration:none;" >Cancel</a>
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