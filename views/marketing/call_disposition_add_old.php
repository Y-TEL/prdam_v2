<?php
/**
 * Description of User
 *
 * @author Nirushika
 */
session_start();
require_once '../../includes/views/define_include.php';
require '../../classes/marketing/call_disposition.php';

//$loginManager = new LoginManager();
//$logerHD = new LoggerHD();

//if (!$loginManager->confirm_member()) {
//    header('Location: ../../index.php');
//}

$page = new Page();
$page->setIcon("iconfa-home");
$page->setHeader("Call Disposition");
$page->setTag_line("add_call_disposition");
$page->setMenu_active("call_disposition");
$page->setMenu_group("Marketing_Department");

$call_disp = new CLDisposition();

date_default_timezone_set('America/New_York');
@$today = date('d-m-Y');

$drop_downs = new DropDownlist();
$drop_down_outcomes = $drop_downs->getAllOutcomes();
$drop_down_agents   = $drop_downs->getAllAgents();
$drop_down_market   = $drop_downs->getAllMarket();

if (isset($_POST['add'])) {

    $act_agent_name  = filter_input(INPUT_POST, 'act_agent_name', FILTER_SANITIZE_STRING);
    $act_store_name  = filter_input(INPUT_POST, 'act_store_name', FILTER_SANITIZE_STRING);
    $act_market_name = filter_input(INPUT_POST, 'act_market_name', FILTER_SANITIZE_STRING);
    $act_market      = filter_input(INPUT_POST, 'act_market', FILTER_SANITIZE_STRING);
    $act_dealer_type = filter_input(INPUT_POST, 'act_dealer_type', FILTER_SANITIZE_STRING);
    $act_phone_no    = filter_input(INPUT_POST, 'act_phone_no', FILTER_SANITIZE_STRING);
    $act_outcome     = filter_input(INPUT_POST, 'act_outcome', FILTER_SANITIZE_STRING);
    $act_comments    = filter_input(INPUT_POST, 'act_comments', FILTER_SANITIZE_STRING);
    $created_date = date('Y-m-d');
    $created_time = date('h:i a');
    
    $msg = $call_disp->addActivation($act_agent_name,$act_store_name,$act_market_name,$act_market,$act_dealer_type,$act_phone_no,$act_outcome,$act_comments,$created_date,$created_time);
    
    if (isset($msg)){ 
	$returnmessage = array();
        array_push($returnmessage, array("type"=>"success"));	//succes | warning | error | information
        array_push($returnmessage , array("message"=>SUCCESS));
        $_SESSION['returnmessage'] = $returnmessage; 
    }else{
        $returnmessage = array();
        array_push($returnmessage, array("type"=>"error"));		//succes | warning | error | information
        array_push($returnmessage , array("message"=>ERROR));
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

<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?php echo SITEURL ?>/assets/global/plugins/select2/select2.css"/>
<!-- BEGIN THEME STYLES -->

<!-- class head -->
   <?php require("../../includes/views/head.php") ?>
<!-- class head -->

<script>
$(document).ready(function(){
	$("#commentForm").validate({
	    rules :
				{
				  act_agent_name  : "required",
				  act_store_name  : "required",
                                  act_market_name : "required",
                                  act_market      : "required",
                                  act_dealer_type : "required",
				  act_phone_no    :{  
                                                    required: true,
                                                    number: false,
                                                    minlength:10,
                                                    maxlength:15
                                                   },
				  act_outcome     : "required",
				},
	  messages:  
				{
				 act_agent_name  : "Select Agent Name",
				 act_store_name  : "Enter Store Name",
                                 act_market_name : "Select Market Type",
                                 act_market      : "Select Market",
                                 act_dealer_type : "Select Call Type",
				 act_phone_no    : {
                                                    required:"Enter Telephone No.",
                                                    number:"Enter number.",
                                                    minlength: $.validator.format("Please enter 10 characters."),
                                                    maxlength: $.validator.format("Please enter 10 characters."),
                                                    }, 
				 act_outcome     : "Select Outcome",
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
                                                                                                
                                                                                                <div class="row">   
                                                                                                        <div class="col-md-12">
														<div class="form-group">
															<label class="control-label col-md-2">Agent Name : <span style="font-size:14px; color:#D90000;" >*</span></label>
															<div class="col-md-5">
                                                                                                                            <input type="text" name="act_agent_name" id="act_agent_name" class="form-control" value="<?php echo $_SESSION['user_calling_name'];?>" readonly="" />
															</div>
														</div>
													</div>
													<!--/span-->
                                                                                                  </div>
                                                                                                <!--/row-->
                                                                                                
                                                                                                <div class="row">
                                                                                                        <div class="col-md-12">
														<div class="form-group">
                                                                                                                    <label class="control-label col-md-2">Call Type : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                    <div class="col-md-5">
                                                                                                                            <select name="act_dealer_type" id="act_dealer_type" class="form-control" >
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
                                                                                                </div>
												<!--/row-->
                                                                                                
                                                                                                <div class="row">
                                                                                                        <div class="col-md-12">
														<div class="form-group">
                                                                                                                    <label class="control-label col-md-2">Store Name : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                    <div class="col-md-5">
                                                                                                                            <input type="text" name="act_store_name" id="act_store_name" class="form-control" value="" />
                                                                                                                    </div>
                                                                                                            </div>
													</div>
													<!--/span-->
                                                                                                </div>
												<!--/row-->
                                                                                                
                                                                                                <div class="row">
                                                                                                        <div class="col-md-12">
														<div class="form-group">
                                                                                                                    <label class="control-label col-md-2">Phone Number : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                    <div class="col-md-5">
                                                                                                                            <input type="text" name="act_phone_no" id="act_phone_no" class="form-control" value="" maxlength="15"/>
                                                                                                                    </div>
                                                                                                            </div>
													</div>
													<!--/span-->
                                                                                                </div>
												<!--/row-->
                                                                                                
                                                                                                <div class="row">
                                                                                                        <div class="col-md-12">
														<div class="form-group">
                                                                                                                    <label class="control-label col-md-2">Market Category : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                    <div class="col-md-5">
                                                                                                                            <select name="act_market_name" id="act_market_name" class="form-control" >
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
                                                                                                        <div class="col-md-12">
														<div class="form-group">
                                                                                                                    <label class="control-label col-md-2">Market : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                    <div class="col-md-5">
                                                                                                                            <select name="act_market" id="act_market" class="form-control select2me">
                                                                                                                                <option value="" selected="true" disabled="true">SELECT</option>
                                                                                                                                <?php foreach ($drop_down_market as $value) { ?>
                                                                                                                                    <option value="<?php echo $value['market_id']; ?>"><?php echo $value['market_name']; ?></option><?php } ?>
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
                                                                                                                        <label class="control-label col-md-2">Outcome   : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                        <div class="col-md-5">
                                                                                                                            <select name="act_outcome" class="select2_category form-control" id="act_outcome">
                                                                                                                                <option value="" selected="true" disabled="">--- Select ---</option>
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
                                                                                                        <div class="col-md-12">
                                                                                                                <div class="form-group">
                                                                                                                        <label class="control-label col-md-2">Comments   : </label>
                                                                                                                        <div class="col-md-5">
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
																<button type="submit" name="add" class="btn green">Submit</button>
                                                                                                                                <input type="reset"  class="btn default" name="reset" id="reset" value="Reset" />
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