<?php
/**
 * Description of User
 *
 * @author Nirushika
 */
session_start();

require_once '../../includes/views/define_include.php';
require '../../classes/marketing/pro_updates.php';

$loginManager = new LoginManager();
$logerHD = new LoggerHD();

if (!$loginManager->confirm_member()) {
    header('Location: ../../index.php');
}

$page = new Page();
$page->setIcon("iconfa-home");
$page->setHeader("Product View");
$page->setTag_line("Product_View Page");
$page->setMenu_active("View_Pro_updates_Page");
$page->setMenu_group("Marketing_Department");

if(isset($_SESSION['image'])){unset($_SESSION['image']);}

$productList = new Product(); 
$product_list = $productList->viewProductList();

if (isset($_POST['email_submit'])) {

    $id    = filter_input(INPUT_POST, 'pro_id', FILTER_SANITIZE_STRING);
    $email_to  = filter_input(INPUT_POST, 'email_to', FILTER_SANITIZE_STRING);
    $email_cc  = filter_input(INPUT_POST, 'email_cc', FILTER_SANITIZE_STRING);

    $details = $productList->viewSelectedProsuct($id); 
    $subject = $details['news_subject'];
    $content = $details['news_body'];
    $date    = $details['news_entered_date'];
    
        //<-----------------------========== Start send email===========-------------------------------------------->
                        $from = $_SESSION['user_name'];

                        $to = $email_to;
                        //$to .= "nirushika@witellsolutions.com";

                        $headers .= "From: " . $from. "\r\n";

                        $headers .= "CC: " . $email_cc. "\r\n";

                        $headers .= "MIME-Version: 1.0\r\n";

                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                        $email_subject= $subject;
                        
                        $email_message .= '<div style="border: 5px solid #990000; width: 100%;padding:3%;">';

                                                
                        $email_message .= '<h3  style="color: #2196f3;">'.$subject.'</h3>';
                        
                        $email_message .= '<strong>Date : </strong>'.$date;

                        $email_message .= '<table rules="all" style="border:5px solid #999999;" cellpadding="10" width="94%">';
                        
                        $email_message .= "<tr style='background: #F5F5F5;'><td>".$content."</td></tr>";

                        $email_message .= "</table></div>";
                        
                        mail($to, $email_subject, $email_message, $headers); 
        //<-----------------------========== End send email===========-------------------------------------------->
    
$success = "1";
header("Location:pro_updates_view.php?success=".$success);
}
@$success = $_GET["success"];

if(isset($_GET['id'])){
$add = $_GET['id'];
 if ($add=1) {
	       // : RETURN MESSAGE.
			$returnmessage = array();
			array_push($returnmessage, array("type"=>"success"));	//succes | warning | error | information
			array_push($returnmessage , array("message"=>SUCCESS));
			$_SESSION['returnmessage'] = $returnmessage; 
 }else {
			// : RETURN MESSAGE.
			$returnmessage = array();
			array_push($returnmessage, array("type"=>"error"));		//succes | warning | error | information
			array_push($returnmessage , array("message"=>ERROR));
			$_SESSION['returnmessage'] = $returnmessage;
 }
}

if(isset($_GET['iid'])){
$update = $_GET['iid'];
 if ($update=1) {
	       // : RETURN MESSAGE.
			$returnmessage = array();
			array_push($returnmessage, array("type"=>"information"));		//succes | warning | error | information
			array_push($returnmessage , array("message"=>UPDATE));
			$_SESSION['returnmessage'] = $returnmessage;
		  }
	   else
		  {
			// : RETURN MESSAGE.
			$returnmessage = array();
			array_push($returnmessage, array("type"=>"stop"));		//succes | warning | error | information
			array_push($returnmessage , array("message"=>ERROR));
			$_SESSION['returnmessage'] = $returnmessage;
		  }
}

if(isset($_GET['iiid'])){
$delete = $_GET['iiid'];
 if ($delete=1) {
	       // : RETURN MESSAGE.
			$returnmessage = array();
			array_push($returnmessage, array("type"=>"information"));		//succes | warning | error | information
			array_push($returnmessage , array("message"=>DELETE));
			$_SESSION['returnmessage'] = $returnmessage;
		  }
	   else
		  {
			// : RETURN MESSAGE.
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
    
<link href="<?php echo SITEURL ?>/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo SITEURL ?>/assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css"/>

<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery-latest.js"></script>
<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery-ui.min.js"></script>
<!-- class head -->
<?php require("../../includes/views/head_1.php") ?>
<!-- class head -->	
<link href="<?php echo SITEURL ?>/assets/admin/pages/css/pricing-table.css" rel="stylesheet" type="text/css"/>

<script type="text/javascript">
    function print_comfirm(url) {
     popupWindow = window.open(
     url,'popUpWindow','left=10,top=10,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=no')
    }
</script>
            
<style>
.preview1
{
width:100px;
border:solid 1px #dedede;
padding:4px;
height:100px;
}
</style>   

</head>


<!-- BEGIN HEADER -->
<div>
   <?php require("../../includes/views/header_admin.php");?>
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
			
			<!-- BEGIN PAGE HEADER-->
			<div id="">
                                <?php if (isset($success) AND $success = "1") { ?>
                                    <div class="alert alert-success">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    Email Sent Successfully 
                                </div>
                          <?php } ?>
                          </div>
                        <div id="hide"><?php include ("../../includes/views/messager.php"); //Display  Messages for Entered Data  ?></div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet box yellow">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-edit"></i>View Product Update
							</div>
							<div class="tools">
                                                            <?php //if (($_SESSION['user_id']=="68")||($_SESSION['user_id']=="47")||($_SESSION['user_id']=="49")||($_SESSION['user_id']=="77")||($_SESSION['user_id']=="8")||($_SESSION['user_id']=="44")||($_SESSION['user_id']=="83")||($_SESSION['user_id']=="90")||($_SESSION['user_id']=="64")||($_SESSION['user_id']=="84")
                                                                  //||($_SESSION['user_id']=="89")||($_SESSION['user_id']=="5")||($_SESSION['user_id']=="3")||($_SESSION['user_id']=="120")||($_SESSION['user_id']=="74")||($_SESSION['user_id']=="17")||($_SESSION['user_id']=="45")||($_SESSION['user_id']=="124")||($_SESSION['user_id']=="125")||($_SESSION['user_id']=="79")){
                                                                  if (isset($_SESSION['user_permissions']['Product_updates_add']) && ($_SESSION['user_permissions']['Product_updates_add'] == '1')){?>
								<a href="pro_updates_add" class="btn default" style="text-decoration:none; height: 30px;" >Add New</a>
                                                            <?php } ?>
                                                        </div>
						</div>
						<div class="portlet-body">

                                                        <!--/row-->
                                                        <?php $i=1;
                                                        foreach ($product_list as $data) { ?>
                                                        <div class="pricing hover-effect" style=" padding: 10px;">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="col-md-2">
											<h4>
                                                                                        <?php if ($data['news_image']!=NULL){ ?>
                                                                                        <?php echo "<img src='".SITEURL."/uploads/pro_updates/".$data['news_image']."'  class='preview1'>"; ?>
                                                                                        <?php }else{ ?>      
                                                                                        <img src="<?php echo SITEURL ?>/assets/resources/images/default_news.png" alt="" class="img-polaroid" width='100px' height='100px'/>
                                                                                        <?php } ?>
											</h4>
									</div>
                                                                       
                                                                        
                                                                        <div class="col-md-4">
                                                                                <ul class="pricing-content list-unstyled">
											<li>
                                                                                                <div class="col-md-12"> 
                                                                                                <label class="control-label col-md-4"><strong>Department</strong></label>
                                                                                                <div class="col-md-8"><?php echo $data['news_dept']; ?></div>
                                                                                                </div>
											</li>
											<li>
												<div class="col-md-12"> 
                                                                                                <label class="control-label col-md-4"><strong>Subject</strong> </label>
                                                                                                <div class="col-md-8"><?php echo $data['news_subject']; ?></div>
                                                                                                </div>
											</li>
										</ul>
                                                                        </div>
                                                                        
                                                                        <div class="col-md-3">
                                                                                <ul class="pricing-content list-unstyled">
											<li>
                                                                                                <div class="col-md-12"> 
                                                                                                <label class="control-label col-md-6"><strong>Date</strong></label>
                                                                                                <div class="col-md-6"><?php echo $data['news_entered_date']; ?></div>
                                                                                                </div>
											</li>
											<li>
												<div class="col-md-12"> 
                                                                                                <label class="control-label col-md-6"><strong>Time</strong> </label>
                                                                                                <div class="col-md-6"><?php echo $data['news_entered_time']; ?></div>
                                                                                                </div>
											</li>
                                                                                        <li>
												<div class="col-md-12"> 
                                                                                                <label class="control-label col-md-6"><strong>Entered By</strong> </label>
                                                                                                <div class="col-md-6"><?php echo $data['news_entered_by']; ?></div>
                                                                                                </div>
											</li>
										</ul>
                                                                        </div>
                                                                        
                                                                        <div class="col-md-3">
                                                                                <h4>
                                                                                        <a href="" title="Print" onClick="JavaScript:print_comfirm('pro_updates_export_pdf.php?id=<?php echo $data['news_id']; ?>');" class="btn purple"><i class="fa fa-print"></i></a>
                                                                                        <a title="Email" id="<?php echo $data["news_id"]; ?>" href="#" data-item-id="<?php echo $data["news_id"]; ?>" data-item-status="1" data-toggle="modal" data-target="#popModal" class="btn yellow"><i class="fa fa-envelope"></i></a>	
                                                                                        <?php if (isset($_SESSION['user_permissions']['Product_updates_add']) && ($_SESSION['user_permissions']['Product_updates_add'] == '1')){?>
                                                                                        <a title="Edit" href="pro_updates_edit?id=<?php echo $data['news_id'] ;?>"  class="btn blue-madison"><i class="fa fa-pencil"></i></a>
                                                                                        <a title="Delete"  href="pro_updates_edit?iid=<?php echo $data['news_id'] ;?>" onclick="return confirm('Are you sure you want to delete?')" class="btn btn-danger"><i class="fa fa-times"></i> </a>
                                                                                        <?php } ?>
										</h4>
                                                                        </div>
                                                                        <!--/span-->
                                                                    </div>
                                                                </div> 
                                                        
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <label class="control-label col-md-4"><strong>Description</strong> </label></br>
                                                                        <?php  echo $data['news_body'];  ?>
                                                                    </div>
                                                                </div> 
                                                         </div>
                                                        <?php $i++;} ?>
                                                                        
                                                                    
						</div>
					</div>
                   
					<!-- END EXAMPLE TABLE PORTLET-->
				</div>
                
			</div>
			<!-- END PAGE CONTENT -->
		</div>
	</div>
	<!-- END CONTENT -->
        
            <!-- pop up -->
            <?php require "pro_update_email_popup.php"; ?>
            <!-- end -->
</div>
<!-- END CONTAINER -->

<!-- BEGIN FOOTER -->
<?php require("../../includes/views/footer_admin.php"); ?>
<!-- END FOOTER -->
<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js"></script>
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