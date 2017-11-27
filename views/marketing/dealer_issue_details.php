<?php
session_start();
require_once '../../includes/views/define_include.php';
require '../../classes/marketing/dealer_issue.php';

$loginManager = new LoginManager();
$logerHD = new LoggerHD();

if (!$loginManager->confirm_member()) {
    header('Location: ../../index.php');
}

$page = new Page();
$page->setIcon("iconfa-home");
$page->setHeader("Other_Add_Page");
$page->setTag_line("User_View");
$page->setMenu_active("dealer_detail_add");
$page->setMenu_group("Marketing_Department");

$issue = new DealerIssue();

$id = $_GET['id'];
if(isset($_GET['id_1'])){$action = $_GET['id_1'];}else{ $action = ""; }
$details = $issue->viewSelectedDealerIssue($id); 
$entered_by = $details['issue_note_taken_by'];
$data = $issue->SelectUserDetails($entered_by); 
$supervisor_id = $data['emp_suprvisor'];
?>
<!DOCTYPE html>
<html lang="en">

<!-- BEGIN HEAD -->
<head>
<link href="<?php echo SITEURL ?>/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo SITEURL ?>/assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css"/>

<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery-latest.js"></script>
<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery-ui.min.js"></script>

<!-- class head -->
   <?php require("../../includes/views/head.php") ?>
<!-- class head -->

<script>
///////////////////// add issue resolved note ////////////////

        jQuery(document).ready(function () {

            jQuery('#issueResolved').on('show.bs.modal', function (e) {
                $('.modal-backdrop').fadeIn(150);
                var item_id = jQuery(e.relatedTarget).data('item-id');
                // And if you wish to pass the productid to modal's 'Yes' button for further processing
            });

            jQuery('#issueResolved').on('hide.bs.modal', function (e) {
                $('.modal-backdrop').fadeOut(150);
            });

            jQuery("#frm_issue_resolved").validate({
                rules: {
                    issue_resolved_note: "required"
                },
                submitHandler: function () {

                    jQuery("#issueResolved").modal('hide');

                    var issue_id = jQuery(".issue_id").val();
                    var resolved_note = jQuery('#issue_resolved_note').val();
                    
                    jQuery.ajax({
                        type: "POST",
                        url: "dealer_issue_ajax_resolved_note.php",
                        cache: false,
                        data: {id: issue_id, resolved_note: resolved_note},
                        
                        success: function () {
                            window.location.href = "dealer_issue_view.php";
                        }
                           
                    });
                }
            });
        });

///////////////////// end /////////////////////

///////////////////// add issue closed note ////////////////

        jQuery(document).ready(function () {

            jQuery('#issueClosed').on('show.bs.modal', function (e) {
                $('.modal-backdrop').fadeIn(150);
                var item_id = jQuery(e.relatedTarget).data('item-id');
                // And if you wish to pass the productid to modal's 'Yes' button for further processing
            });

            jQuery('#issueClosed').on('hide.bs.modal', function (e) {
                $('.modal-backdrop').fadeOut(150);
            });

            jQuery("#frm_issue_closed").validate({
                rules: {
                    issue_closed_note: "required"
                },
                submitHandler: function () {

                    jQuery("#issueClosed").modal('hide');

                    var issue_id = jQuery(".issue_id").val();
                    var closed_note = jQuery('#issue_closed_note').val();
                    
                    jQuery.ajax({
                        type: "POST",
                        url: "dealer_issue_ajax_resolved_note.php",
                        cache: false,
                        data: {id: issue_id, closed_note: closed_note},
                        
                        success: function () {
                            window.location.href = "dealer_issue_view.php";
                        }
                           
                    });
                }
            });
        });

///////////////////// end /////////////////////
</script>

</head>


<!-- BEGIN HEADER -->
<div>
   <?php require("../../includes/views/header_admin.php") ?>
</div>
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
                   	
                <div class="row">
				<div class="col-md-12">
                                    <div class="tabbable tabbable-custom boxless tabbable-reversed">
						
                                        <div class="tab-pane active" id="tab_2">
					<!-- BEGIN VALIDATION STATES-->
					<div class="portlet box purple-soft">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-gift"></i>View Dealer Issue Details
							</div>
						</div>
						<div class="portlet-body form">
							<!-- BEGIN FORM-->
								<div class="form-body">
                                                                    
                                                                        <fieldset style="margin-left:8px; margin-top:10px; background-color:#FFF; border-width: medium; border-color: #000;"><legend>Dealer Details</legend>
                                                                              
                                                                                <div class="row">
                                                                                        <div class="form-group col-md-6">
                                                                                            <label class="control-label col-md-4"><strong>Issue For Rep</strong></label>
                                                                                                <div class="col-md-8">
                                                                                                    <label class="control-label-left">
                                                                                                        <div class="form-md-radios">
                                                                                                                <div class="md-radio-inline">:
                                                                                                                        <div class="md-radio">
                                                                                                                            <input type="radio" id="radio1" name="issue_rep" id="no" class="md-radiobtn" value="No" <?php if($details['issue_rep']=="No"){ echo "checked"; } ?>>
                                                                                                                                <label for="radio1">
                                                                                                                                <span></span>
                                                                                                                                <span class="check"></span>
                                                                                                                                <span class="box"></span>
                                                                                                                                No</label>
                                                                                                                        </div>
                                                                                                                        <div class="md-radio">
                                                                                                                                <input type="radio" id="radio2" name="issue_rep" id="yes" class="md-radiobtn" value="Yes" <?php if($details['issue_rep']=="Yes"){ echo "checked"; } ?>>
                                                                                                                                <label for="radio2">
                                                                                                                                <span></span>
                                                                                                                                <span class="check"></span>
                                                                                                                                <span class="box"></span>
                                                                                                                                Yes</label>
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                    </label>
                                                                                                </div>
                                                                                        </div>
                                                                                        <div class="form-group col-md-6">
                                                                                            <label class="control-label col-md-4"><strong>BL Code</strong></label>
                                                                                                <div class="col-md-8">
                                                                                                <label class="control-label-left">: <?php echo $details['dealer_bl_code']; ?> </label>
                                                                                                </div>
                                                                                        </div>
                                                                                </div>
                                                                                <!--/row-->
                                                                              
                                                                                <div class="row">
                                                                                        <div class="form-group col-md-6">
                                                                                            <label class="control-label col-md-4"><strong>Dealer Code</strong></label>
                                                                                                <div class="col-md-8">
                                                                                                <label class="control-label-left">: <?php echo $details['issue_dealer_code']; ?> </label>
                                                                                                </div>
                                                                                        </div>
                                                                                        <div class="form-group col-md-6">
                                                                                            <label class="control-label col-md-4"><strong>Market</strong></label>
                                                                                                <div class="col-md-8">
                                                                                                <label class="control-label-left">: <?php echo $details['market_name']; ?> </label>
                                                                                                </div>
                                                                                        </div>
                                                                                </div>
                                                                                <!--/row-->
                                                                                
                                                                                <div class="row">
                                                                                        <div class="form-group col-md-6">
                                                                                            <label class="control-label col-md-4"><strong>Store Name</strong></label>
                                                                                                <div class="col-md-8">
                                                                                                <label class="control-label-left">: <?php echo $details['dealer_store_name']; ?> </label>
                                                                                                </div>
                                                                                        </div>
                                                                                        <div class="form-group col-md-6">
                                                                                            <label class="control-label col-md-4"><strong>First Name</strong></label>
                                                                                                <div class="col-md-8">
                                                                                                <label class="control-label-left">: <?php echo $details['dealer_fname']; ?> </label>
                                                                                                </div>
                                                                                        </div>
                                                                                </div>
                                                                                <!--/row-->
                                                                                
                                                                                <div class="row">
                                                                                        <div class="form-group col-md-6">
                                                                                            <label class="control-label col-md-4"><strong>Contact Number</strong></label>
                                                                                                <div class="col-md-8">
                                                                                                <label class="control-label-left">: <?php echo $details['dealer_contact_no']; ?> </label>
                                                                                                </div>
                                                                                        </div>
                                                                                        <div class="form-group col-md-6">
                                                                                            <label class="control-label col-md-4"><strong>Email Address</strong></label>
                                                                                                <div class="col-md-8">
                                                                                                <label class="control-label-left">: <?php echo $details['dealer_email']; ?> </label>
                                                                                                </div>
                                                                                        </div>
                                                                                </div>
                                                                                <!--/row-->
                                                                                
                                                                                <div class="row">
                                                                                        <div class="form-group col-md-6">
                                                                                            <label class="control-label col-md-4"><strong>Billing Address</strong></label>
                                                                                                <div class="col-md-8">
                                                                                                <label class="control-label-left">: <?php echo $details['dealer_billing_addrs']; ?> </label>
                                                                                                </div>
                                                                                        </div>
                                                                                        <div class="form-group col-md-6">
                                                                                            <label class="control-label col-md-4"><strong>Shipping Address</strong></label>
                                                                                                <div class="col-md-8">
                                                                                                <label class="control-label-left">: <?php echo $details['dealer_shipping_addrs']; ?> </label>
                                                                                                </div>
                                                                                        </div>
                                                                                </div>
                                                                                <!--/row-->

                                                                            </fieldset>

                                                                            <fieldset style="margin-left:8px; margin-top:20px; background-color:#FFF; border-width: medium; border-color: #000;"><legend>Other Details</legend>

                                                                                <div class="row">
                                                                                        <div class="form-group col-md-6">
                                                                                            <label class="control-label col-md-4"><strong>Date</strong></label>
                                                                                                <div class="col-md-8">
                                                                                                <label class="control-label-left">: <?php echo $details['issue_date']; ?> </label>
                                                                                                </div>
                                                                                        </div>
                                                                                        <div class="form-group col-md-6">
                                                                                            <label class="control-label col-md-4"><strong>Issue Category</strong></label>
                                                                                                <div class="col-md-8">
                                                                                                <label class="control-label-left">: <?php echo $details['issue_category']; ?> </label>
                                                                                                </div>
                                                                                        </div>
                                                                                </div>
                                                                                <!--/row-->
                                                                                
                                                                                <div class="row">
                                                                                        <div class="form-group col-md-6">
                                                                                            <label class="control-label col-md-4"><strong>Issue Details</strong></label>
                                                                                                <div class="col-md-8">
                                                                                                <label class="control-label-left">: <?php echo $details['issue_details']; ?> </label>
                                                                                                </div>
                                                                                        </div>
                                                                                        <div class="form-group col-md-6">
                                                                                            <label class="control-label col-md-4"><strong>Note Taken By</strong></label>
                                                                                                <div class="col-md-8">
                                                                                                <label class="control-label-left">: <?php echo $details['user_calling_name']; ?> </label>
                                                                                                </div>
                                                                                        </div>
                                                                                </div>
                                                                                <!--/row-->
                                                                                
                                                                                <div class="row">
                                                                                        <div class="form-group col-md-6">
                                                                                            <label class="control-label col-md-4"><strong>Email To</strong></label>
                                                                                                <div class="col-md-8">
                                                                                                <label class="control-label-left">: <?php echo $details['issue_to']; ?> </label>
                                                                                                </div>
                                                                                        </div>
                                                                                        <div class="form-group col-md-6">
                                                                                            <label class="control-label col-md-4"><strong>Email CC</strong></label>
                                                                                                <div class="col-md-8">
                                                                                                <label class="control-label-left">: <?php echo $details['issue_cc']; ?> </label>
                                                                                                </div>
                                                                                        </div>
                                                                                </div>
                                                                                <!--/row-->
                                                                                
                                                                                <div class="row">
                                                                                        <div class="form-group col-md-6">
                                                                                            <label class="control-label col-md-4"><strong>Resolved Note</strong></label>
                                                                                                <div class="col-md-8">
                                                                                                <label class="control-label-left">: <?php echo $details['issue_resolved_note']; ?> </label>
                                                                                                </div>
                                                                                        </div>
                                                                                        <div class="form-group col-md-6">
                                                                                            <label class="control-label col-md-4"><strong>Resolved Note Entered</strong></label>
                                                                                                <div class="col-md-8">
                                                                                                <label class="control-label-left">: <?php echo $details['resolved_note_entered']; ?> </label>
                                                                                                </div>
                                                                                        </div>
                                                                                </div>
                                                                                <!--/row-->
                                                                                <div class="row">
                                                                                        <div class="form-group col-md-6">
                                                                                            <label class="control-label col-md-4"><strong>Closed Note</strong></label>
                                                                                                <div class="col-md-8">
                                                                                                <label class="control-label-left">: <?php echo $details['issue_closed_note']; ?> </label>
                                                                                                </div>
                                                                                        </div>
                                                                                        <div class="form-group col-md-6">
                                                                                            <label class="control-label col-md-4"><strong>Closed Note Entered</strong></label>
                                                                                                <div class="col-md-8">
                                                                                                <label class="control-label-left">: <?php echo $details['closed_note_entered']; ?> </label>
                                                                                                </div>
                                                                                        </div>
                                                                                </div>
                                                                                <!--/row-->
                                                                                
                                                                        </fieldset>

                                                                    <div class="form-actions">
                                                                        <div class="row">
                                                                                <div class="col-md-12" style="margin: 10px 0px 0px 15px;">
                                                                                        <div class="row">
                                                                                                <div class="col-md-12">
                                                                                                     <a href="dealer_issue_view.php" class="btn default" style="text-decoration:none;" >Back</a>
                                                                                                     
                                                                                                     <?php if($action=="resolved"){
                                                                                                       $to = explode(',', strtolower($details['issue_to']));
                                                                                                            foreach($to as $key=>$mail_to) { 
                                                                                                            if ($_SESSION['user_name'] == $mail_to) {
                                                                                                     ?>
                                                                                                     <a title="edit" id="<?php echo $details["issue_id"]; ?>" href="#" class="btn btn-circle btn-sm green" data-item-id="<?php echo $details["issue_id"]; ?>" data-item-status="2" data-toggle="modal" data-target="#issueResolved">
                                                                                                     <i class="fa fa-check"></i> Resolved </a>
                                                                                                     <?php 
                                                                                                            }}
                                                                                                     } else if($action=="closed"){
                                                                                                         if($supervisor_id==$_SESSION['user_id']){
                                                                                                     ?>
                                                                                                     
                                                                                                     <a title="edit" id="<?php echo $details["issue_id"]; ?>" href="#" class="btn btn-circle btn-sm yellow" data-item-id="<?php echo $details["issue_id"]; ?>" data-item-status="2" data-toggle="modal" data-target="#issueClosed">
                                                                                                     <i class="fa fa-check"></i> Closed </a>
                                                                                                         <?php }
                                                                                                         
                                                                                                    }else{} ?>
                                                                                                </div>
                                                                                        </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                </div>
                                                                        </div>
                                                                    </div>
                                                                  <!-- END FORM-->
                                                                </div>
								
							<!-- END FORM-->
						</div>
					</div>
					<!-- END VALIDATION STATES-->
				</div>
			</div>  
                   </div>  
               </div>  
    </div>
</div>
<!-- END CONTENT -->
 
</div>
<!-- END CONTAINER -->

<!-- add resolved issue modal  -->
<div class="modal" id="issueResolved" role="dialog" aria-labelledby="issueResolved" style="display:none; ">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&amp;times;</button>
                <h4 class="modal-title" id="myModalLabel">Issue Resolved Note</h4>
            </div>
            <form class="contact" id="frm_issue_resolved" name="contact">
                <div class="modal-body">
                    <textarea class="form-control" rows='5' id="issue_resolved_note" name="issue_resolved_note"></textarea>
                    <input type="hidden" class="issue_id" value="<?php echo $details['issue_id']; ?>"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary pull-left" id="submit" name="">Submit</button>
                </div>
            </form>    
        </div>
    </div>
</div>
<!-- end -->

<!-- add closed issue modal  -->
<div class="modal" id="issueClosed" role="dialog" aria-labelledby="issueClosed" style="display:none; ">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&amp;times;</button>
                <h4 class="modal-title" id="myModalLabel">Issue Closed Note</h4>
            </div>
            <form class="contact" id="frm_issue_closed" name="contact">
                <div class="modal-body">
                    <textarea class="form-control" rows='5' id="issue_closed_note" name="issue_closed_note"></textarea>
                    <input type="hidden" class="issue_id" value="<?php echo $details['issue_id']; ?>"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary pull-left" id="submit" name="">Submit</button>
                </div>
            </form>    
        </div>
    </div>
</div>
<!-- end -->

<!-- BEGIN FOOTER -->
<?php require("../../includes/views/footer_admin.php"); ?>
<!-- END FOOTER -->
<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js"></script> 


<script>
/* Delete  Entered Data display message ======-------------------->>>>>>*/
$(document).ready(function() {
  $('#hide div').live('click',function() { 
    $(this).parent().parent().remove(); 
  });
});  

/* Delete  image upload display message ======-------------------->>>>>>*/
$(document).ready(function() {
  $('span#delete ').live('click',function() { 
    $(this).parent().parent().remove(); 
  });
});  
 </script> 
 
</body>

<!-- END BODY -->
</html>