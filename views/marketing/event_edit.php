<?php
/**
 * Description of User
 *
 * @author Nirushika
 */
session_start();
require_once '../../includes/views/define_include.php';
require '../../classes/marketing/event.php';

$loginManager = new LoginManager();
$logerHD = new LoggerHD();

if (!$loginManager->confirm_member()) {
    header('Location: ../../index.php');
}

$page = new Page();
$page->setIcon("iconfa-home");
$page->setHeader("Event Page");
$page->setTag_line("Event Add Page");
$page->setMenu_active("View_Event_Page");
$page->setMenu_group("Marketing_Department");

$event = new Event();

date_default_timezone_set('America/New_York');
@$today = date('Y-m-d');

if(isset($_GET['iid'])){
    
$iid = $_GET['iid'];
$delete = $event->DeleteEvent($iid);  

if ($delete=1) {
     header('Location: events_view?iiid='.$delete);
}
    
}else{

$id = $_GET['id'];
$details = $event->viewSelectedEvent($id);  


if (isset($_POST['update'])) {
	
    $event_name    = filter_input(INPUT_POST, 'event_name', FILTER_SANITIZE_STRING);
    $event_date    = filter_input(INPUT_POST, 'event_date', FILTER_SANITIZE_STRING);
    $event_time_us = filter_input(INPUT_POST, 'event_time_us', FILTER_SANITIZE_STRING);
    
    $event_time_sl = (\strtotime("+9 hours+30 minutes",\strtotime($event_time_us)));
    $SLTime = date('h:i A', $event_time_sl);
    
    $msg = $event->updateEvent($event_name,$event_date,$event_time_us,$SLTime,$id);
            
   if ($msg=1) {
       header('Location: events_view?iid='.$msg);
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
	$("#commentForm").validate({ //common validation start
            rules:  {
                        event_name  : "required",
                    },

           messages: {
                        event_name  : "Enter Event.",
                      }
        }); ///common validation end

 });
 
</script>
<script language="javascript">
    
    jQuery(function() {
        jQuery( "#datepicker" ).datepicker({
          maxDate: '0',
          dateFormat: 'mm-dd-yy',
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
<style>   
.input-append .add-on, .input-prepend .add-on {
/*display: inline-block;*/
width: auto;
/*height: 20px;*/
min-width: 16px;
padding: 4px 5px;
font-size: 14px;
font-weight: normal;
line-height: 20px;
text-align: center;
text-shadow: 0 1px 0 #fff;
background-color: #eee;
border: 1px solid #ccc;
}
</style>

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
											<i class="fa fa-gift"></i>Update Event
										</div>
										<div class="tools">* Mandatory fields
											<a href="javascript:;" class="reload">
											</a>
											
										</div>
									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
                                                                           
                                                                                
                                                                                <form id="commentForm" class="form-horizontal" name ="update_event" action="" method="post" enctype="multipart/form-data"> 
											<div class="form-body" >
                                                                                                
                                                                                            <div class="row">   
                                                                                                        <div class="col-md-12">
														<div class="form-group">
															<label class="control-label col-md-2">Event : <span style="font-size:14px; color:#D90000;" >*</span></label>
															<div class="col-md-5">
                                                                                                                            <textarea class="form-control" rows='5' id="event_name" name="event_name" placeholder="Your Event"><?php echo $details['event_name']; ?></textarea>
															</div>
														</div>
													</div>
													<!--/span-->
                                                                                                  </div>
                                                                                                <!--/row-->
                                                                                                
                                                                                                <div class="row">
                                                                                                        <div class="col-md-12">
														<div class="form-group">
                                                                                                                    <label class="control-label col-md-2">Event Date : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                    <div class="col-md-5">
                                                                                                                        <div class="input-group date date-picker" id="datepicker" data-date-format="mm-dd-yyyy">
                                                                                                                        <input type="text" class="form-control" id="datepicker" readonly name="event_date" value="<?php if (isset($_POST['event_date'])) {echo $_POST['event_date']; }else{echo $details['event_date'];} ?>">
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
                                                                                                                        <label class="control-label col-md-2">Event Time (USA) : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                        <div class="col-md-5">
                                                                                                                            <div class="input-append bootstrap-timepicker">
                                                                                                                                <input id="timepicker1" type="text" class="input-small" name="event_time_us" value="<?php if (isset($_POST['event_time_us'])) {echo $_POST['event_time_us']; }else{echo $details['event_time_usa'];} ?>">
                                                                                                                                <span class="add-on"><i class="fa fa-clock-o"></i></span>
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
															<div class="col-md-offset-2 col-md-8">
																<button type="submit" class="btn blue-madison" id="update" name="update">Update</button>
                                                                                                                                <input type="reset"  class="btn default" name="reset" id="reset" value="Reset" />
                                                                                                                                <a href="events_view" class="btn default" style="text-decoration:none;" >Cancel</a>
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