<?php
/**
 * Description of User
 *
 * @author Nirushika
 */
session_start();
require_once '../../includes/views/define_include.php';
require '../../classes/marketing/campaign.php';
$loginManager = new LoginManager();
$logerHD = new LoggerHD();

if (!$loginManager->confirm_member()) {
    header('Location: ../../index.php');
}

$page = new Page();
$page->setIcon("iconfa-home");
$page->setHeader("View Campaign");
$page->setTag_line("View_Campaigns");
$page->setMenu_active("Eblast_Page");
$page->setMenu_group("Marketing_Department");

date_default_timezone_set('Asia/Colombo');
@$today = date('Y-m-d');

$campaign = new Campaign();

$drop_downs = new DropDownlist();
$drop_down_camp_title = $drop_downs->getAllCampTitle();

if (isset($_POST['add'])) {

    $cam_title    = filter_input(INPUT_POST, 'cam_title', FILTER_SANITIZE_STRING);
    $cam_date     = date('Y-m-d', strtotime(filter_input(INPUT_POST, 'cam_date', FILTER_SANITIZE_STRING)));
    $cam_time_sl  = filter_input(INPUT_POST, 'cam_time', FILTER_SANITIZE_STRING);
    
    $cam_time_us = (\strtotime("-9 hours-30 minutes",\strtotime($cam_time_sl)));
    $USTime = date('h:i A', $cam_time_us);
    
        $msg = $campaign->addNewCampaign($cam_title,$cam_date,$cam_time_sl,$USTime);
        
				  
  if ($msg=1) {
    header('Location: campaign_view?id='.$msg);
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

<script language="javascript">
    
    jQuery(function() {
        jQuery( "#datepicker" ).datepicker({
          maxDate: '0',
          dateFormat: 'mm/dd/yy',
          changeMonth: true,
          changeYear: true
        });
});
</script>
<script language="javascript">
    jQuery(function() {
     $('#timepicker1').timepicker();
    
    $('#timepicker1').on('click', function () {
    var d8To = new Date();
    d8To.setHours(23);
    d8To.setMinutes(59);
    d8To.setSeconds(59);
    alert ($('#timepicker1').val(convTo.format(d8To)));
     });
 });
</script>

<script>
        $(document).ready(function(){
            $("#commentForm").validate({
                rules :
                        {
                         
                          cam_title        : "required",
                          cam_date         : "required",
                          cam_time         : "required",
                        }, 
              messages:  
                        {
                         
                         cam_title          : "Select Campaign Title",
                         cam_date           : "Select Date",
                         cam_time           : "Select Time",
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
											<i class="fa fa-gift"></i>Add New Campaign
										</div>
										<div class="tools">* Mandatory fields
											<a href="javascript:;" class="reload">
											</a>
											
										</div>
									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
                                                                                
                                                                                 <form id="commentForm" class="form-horizontal" name ="add_campaign" action="" method="post" enctype="multipart/form-data"> 
											<div class="form-body" >
                                                                                               
                                                                                                
                                                                                                
                                                                                                <div class="row">
                                                                                                        <div class="col-md-12">
														<div class="form-group">
                                                                                                                    <label class="control-label col-md-4">Campaign Date : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                    <div class="col-md-4">
                                                                                                                        <div class="input-group date date-picker" id="datepicker">
                                                                                                                        <input type="text" class="form-control" id="datepicker" readonly name="cam_date" value="<?php if (isset($_POST['cam_date'])) {echo $_POST['cam_date']; }else{echo date('m/d/Y');} ?>">
                                                                                                                        <span class="input-group-btn">
                                                                                                                        <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                                                                                                        </span>
                                                                                                                        </div>
                                                                                                                 </div>
                                                                                                            </div>
													</div>
													<!--/span-->
                                                                                                </div>
												<!--/row-->
                                                                                                
                                                                                                <div class="row">
                                                                                                        <div class="col-md-12">
                                                                                                                <div class="form-group">
                                                                                                                        <label class="control-label col-md-4">Campaign Time (SL) : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                        <div class="col-md-4">
                                                                                                                            <div class="input-append bootstrap-timepicker">
                                                                                                                                <input id="timepicker1" type="text" class="input-small" name="cam_time" value="<?php if (isset($_POST['cam_time'])) {echo $_POST['cam_time']; }else{echo date('h:i A');} ?>">
                                                                                                                                <span class="add-on"><i class="fa fa-clock-o"></i></span>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                        <!--/span-->
                                                                                                  </div>
												<!--/row-->
                                                                                                
                                                                                                <div class="row">
													<div class="col-md-12">
                                                                                                                <div class="form-group">
                                                                                                                        <label class="control-label col-md-4">Campaign Title : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                        <div class="col-md-4">
                                                                                                                                <input type="text" name="cam_title" id="cam_title" class="form-control" list="mylist" />
                                                                                                                                <datalist id="mylist">
                                                                                                                                    <?php  foreach ($drop_down_camp_title as $values) {?>
                                                                                                                                        <option><?php echo $values['camp_title']; ?></option>
                                                                                                                                    <?php }?>
                                                                                                                                </datalist>
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
																<button type="submit" name="add" class="btn green">Submit</button>
                                                                                                                                <input type="reset"  class="btn default" name="reset" id="reset" value="Reset" />
                                                                                                                                <a href="campaign_view" class="btn default" style="text-decoration:none;" >Cancel</a>
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