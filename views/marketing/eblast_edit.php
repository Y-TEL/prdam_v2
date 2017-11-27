<?php
/**
 * Description of User
 *
 * @author Nirushika
 */
session_start();
require_once '../../includes/views/define_include.php';
require '../../classes/marketing/eblast.php';

$loginManager = new LoginManager();
$logerHD = new LoggerHD();

if (!$loginManager->confirm_member()) {
    header('Location: ../../index.php');
}

$page = new Page();
$page->setIcon("iconfa-home");
$page->setHeader("View Eblast");
$page->setTag_line("Eblast_feedback_Page");
$page->setMenu_active("Eblast_Page");
$page->setMenu_group("Marketing_Department");

$eblast = new Eblast();

date_default_timezone_set('Asia/Colombo');
@$today = date('Y-m-d');

if(isset($_GET['iid'])){
    
$iid = $_GET['iid'];
$delete = $eblast->DeleteEblast($iid);  

if ($delete=1) {
    header('Location: eblast_feedbacks_view.php?iiid='.$delete);
}
    
}else{

$id = $_GET['id'];
$details = $eblast->viewSelectedEblast($id);  

$drop_downs = new DropDownlist();
$drop_down_camp_title = $drop_downs->getAllCampTitle();

if (isset($_POST['update'])) {
	
    $cam_title           = filter_input(INPUT_POST, 'camp_title', FILTER_SANITIZE_STRING);
    $eblast_product      = filter_input(INPUT_POST, 'eblast_product', FILTER_SANITIZE_STRING);
    $eblast_respond      = filter_input(INPUT_POST, 'eblast_respond', FILTER_SANITIZE_STRING);
    $eblast_dealer       = filter_input(INPUT_POST, 'eblast_dealer', FILTER_SANITIZE_STRING);
    $eblast_date         = date('Y-m-d', strtotime(filter_input(INPUT_POST, 'eblast_date', FILTER_SANITIZE_STRING)));
    $eblast_time_sl         = filter_input(INPUT_POST, 'eblast_time', FILTER_SANITIZE_STRING);
    $dealer_satisfaction = filter_input(INPUT_POST, 'dealer_satisfaction', FILTER_SANITIZE_STRING);
    
    $eblast_time_us = (\strtotime("-9 hours-30 minutes",\strtotime($eblast_time_sl)));
    $USTime = date('h:i A', $eblast_time_us);
    
    $msg = $eblast->UpdateEblast($cam_title,$eblast_product,$eblast_respond,$eblast_dealer,$eblast_date,$eblast_time_sl,$USTime,$dealer_satisfaction,$id);
            
   if ($msg=1) {
       header('Location: eblast_feedbacks_view?iid='.$msg);
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
                         
                        camp_title           : "required",
                        eblast_product       : "required",
                        eblast_respond       : "required",
                        eblast_dealer        : "required",
                        dealer_satisfaction  : "required",
                        eblast_date          : "required",
                        eblast_time          : "required",
                        }, 
              messages:  
                        {
                         
                        camp_title           : "Select Campaign Title",
                        eblast_product       : "Enter Product",
                        eblast_respond       : "Enter Respond",
                        eblast_dealer        : "Enter Dealer",
                        dealer_satisfaction  : "Select Dealer Satisfaction",
                        eblast_date          : "Select Date",
                        eblast_time          : "Select Time",
                        }
            });
        });
        
</script>

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
											<i class="fa fa-gift"></i>Edit Eblast Feedback
										</div>
										<div class="tools">* Mandatory fields
											<a href="javascript:;" class="reload">
											</a>
											
										</div>
									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
                                                                                
                                                                                <form id="commentForm" class="form-horizontal" name ="edit_eblast" action="" method="post" enctype="multipart/form-data"> 
											<div class="form-body" >
                                                                                                
                                                                                                <div class="row">
													<div class="col-md-12">
                                                                                                                <div class="form-group">
                                                                                                                        <label class="control-label col-md-4">Campaign Title : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                        <div class="col-md-4">
                                                                                                                                <select name="camp_title" id="camp_title" class="form-control" >
                                                                                                                                    <option value="" selected="true" disabled="true">Select</option>
                                                                                                                                    <?php  foreach ($drop_down_camp_title as $value) {
                                                                                                                                        if ($value['camp_id'] == $details['eblast_camp_id']) {
                                                                                                                                                $selected = "selected";
                                                                                                                                        } else {
                                                                                                                                                $selected = "";
                                                                                                                                        }
                                                                                                                                        ?>
                                                                                                                                    <option value="<?php echo $value['camp_id'];?>" <?php echo $selected; ?>><?php echo $value['camp_title']." (".$value['camp_date']." ".$value['camp_time_sl'].")";?></option>
                                                                                                                                    <?php }?>
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
                                                                                                                        <label class="control-label col-md-4">Product : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                        <div class="col-md-4">
                                                                                                                                <input type="text" name="eblast_product" id="eblast_product" class="form-control" value="<?php echo $details['eblast_product']; ?>">
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                        <!--/span-->
												  </div>
												<!--/row-->
                                                                                                
                                                                                                <div class="row">
													<div class="col-md-12">
                                                                                                                <div class="form-group">
                                                                                                                        <label class="control-label col-md-4">Respond : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                        <div class="col-md-4">
                                                                                                                                <input type="text" name="eblast_respond" id="eblast_respond" class="form-control" value="<?php echo $details['eblast_respond']; ?>">
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                        <!--/span-->
												  </div>
												<!--/row-->
                                                                                                
                                                                                                <div class="row">
													<div class="col-md-12">
                                                                                                                <div class="form-group">
                                                                                                                        <label class="control-label col-md-4">Dealer : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                        <div class="col-md-4">
                                                                                                                                <input type="text" name="eblast_dealer" id="eblast_dealer" class="form-control" value="<?php echo $details['eblast_dealer']; ?>">
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                        <!--/span-->
												  </div>
												<!--/row-->
                                                                                                 <div class="row">
													<div class="col-md-12">
                                                                                                                <div class="form-group">
                                                                                                                        <label class="control-label col-md-4">Agent : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                        <div class="col-md-4">
                                                                                                                            <input type="text" name="eblast_agent" id="eblast_agent" class="form-control" value="<?php echo $_SESSION['first_name'].' '.$_SESSION['last_name'];?>" readonly="">
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                        <!--/span-->
												  </div>
												<!--/row-->
                                                                                                
                                                                                                <div class="row">
                                                                                                        <div class="col-md-12">
														<div class="form-group">
                                                                                                                    <label class="control-label col-md-4">Sent Date : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                    <div class="col-md-4">
                                                                                                                        <div class="input-group date date-picker" id="datepicker">
                                                                                                                        <input type="text" class="form-control" id="datepicker" readonly name="eblast_date" value="<?php if (isset($_POST['eblast_date'])) {echo $_POST['eblast_date']; }else{echo date('m-d-Y', strtotime($details['eblast_date']));} ?>">
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
                                                                                                                        <label class="control-label col-md-4">Sent Time (SL) : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                        <div class="col-md-4">
                                                                                                                            <div class="input-append bootstrap-timepicker">
                                                                                                                                <input id="timepicker1" type="text" class="input-small" name="eblast_time" value="<?php if (isset($_POST['eblast_time'])) {echo $_POST['eblast_time']; }else{echo $details['eblast_time_sl'];} ?>">
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
                                                                                                                        <label class="control-label col-md-4">Dealer satisfaction : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                        <div class="col-md-4">
                                                                                                                            
                                                                                                                                <div class="form-md-radios">
                                                                                                                                    <div class="md-radio-inline">
                                                                                                                                            <div class="md-radio col-md-12">
                                                                                                                                                <input type="radio" id="radio1" name="dealer_satisfaction" class="md-radiobtn" value="Turnaround" <?php if($details['eblast_dealer_satis']=="Turnaround"){?>  checked="checked" <?php }?>>
                                                                                                                                                    <label for="radio1">
                                                                                                                                                    <span></span>
                                                                                                                                                    <span class="check"></span>
                                                                                                                                                    <span class="box"></span>
                                                                                                                                                    Turnaround <img src="<?php echo SITEURL ?>/assets/global/img/emotion/smiles_1.png" width="20" height="20" /> </label>
                                                                                                                                            </div>
                                                                                                                                            <div class="md-radio col-md-12">
                                                                                                                                                    <input type="radio" id="radio2" name="dealer_satisfaction" class="md-radiobtn" value="Excited" <?php if($details['eblast_dealer_satis']=="Excited"){?>  checked="checked" <?php }?>>
                                                                                                                                                    <label for="radio2">
                                                                                                                                                    <span></span>
                                                                                                                                                    <span class="check"></span>
                                                                                                                                                    <span class="box"></span>
                                                                                                                                                    Excited <img src="<?php echo SITEURL ?>/assets/global/img/emotion/smiles_2.png" width="20" height="20" /></label>
                                                                                                                                            </div>
                                                                                                                                            <div class="md-radio col-md-12">
                                                                                                                                                    <input type="radio" id="radio3" name="dealer_satisfaction" class="md-radiobtn" value="Interested" <?php if($details['eblast_dealer_satis']=="Interested"){?>  checked="checked" <?php }?>>
                                                                                                                                                    <label for="radio3">
                                                                                                                                                    <span></span>
                                                                                                                                                    <span class="check"></span>
                                                                                                                                                    <span class="box"></span>
                                                                                                                                                    Interested <img src="<?php echo SITEURL ?>/assets/global/img/emotion/smiles_3.png" width="20" height="20" /></label>
                                                                                                                                            </div>
                                                                                                                                            <div class="md-radio col-md-12">
                                                                                                                                                    <input type="radio" id="radio4" name="dealer_satisfaction" class="md-radiobtn" value="Unsatisfied" <?php if($details['eblast_dealer_satis']=="Unsatisfied"){?>  checked="checked" <?php }?>>
                                                                                                                                                    <label for="radio4">
                                                                                                                                                    <span></span>
                                                                                                                                                    <span class="check"></span>
                                                                                                                                                    <span class="box"></span>
                                                                                                                                                    Unsatisfied <img src="<?php echo SITEURL ?>/assets/global/img/emotion/smiles_4.png" width="20" height="20" /></label>
                                                                                                                                            </div>
                                                                                                                                            <div class="md-radio col-md-12">
                                                                                                                                                    <input type="radio" id="radio5" name="dealer_satisfaction" class="md-radiobtn" value="Unsubscribe" <?php if($details['eblast_dealer_satis']=="Unsubscribe"){?>  checked="checked" <?php }?>>
                                                                                                                                                    <label for="radio5">
                                                                                                                                                    <span></span>
                                                                                                                                                    <span class="check"></span>
                                                                                                                                                    <span class="box"></span>
                                                                                                                                                    Unsubscribe<img src="<?php echo SITEURL ?>/assets/global/img/emotion/smiles_5.png" width="20" height="20" /></label>
                                                                                                                                            </div>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            
                                                                                                                            
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
                                                                                                                                <a href="eblast_feedbacks_view" class="btn default" style="text-decoration:none;" >Cancel</a>
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