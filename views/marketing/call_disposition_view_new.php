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
$page->setTag_line("view_call_disposition");
$page->setMenu_active("call_disposition");
$page->setMenu_group("Marketing_Department");

$call_disp = new CLDisposition();

date_default_timezone_set('America/New_York');

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

if (isset($_POST['add'])) {

    $start_from  = filter_input(INPUT_POST, 'start_from', FILTER_SANITIZE_STRING);
    $end_to      = filter_input(INPUT_POST, 'end_to', FILTER_SANITIZE_STRING);
    
    $call_list = $call_disp->viewActivationListRange($start_from, $end_to);
	
}else{
    $call_list = $call_disp->viewActivationList();

}

if(isset($_POST['start_from'])){$start_from  = filter_input(INPUT_POST, 'start_from', FILTER_SANITIZE_STRING);} else {$start_from  = date("Y-m-d");}
if(isset($_POST['end_to']))    {$end_to      = filter_input(INPUT_POST, 'end_to', FILTER_SANITIZE_STRING);    } else {$end_to  = date('Y-m-d');}

?>
<!DOCTYPE html>

<html lang="en">

<head>
<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery-latest.js"></script>
<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery-ui.min.js"></script>
    
<!-- class head -->
<?php require("../../includes/views/head_1.php") ?>
<!-- class head -->
 
<script type="text/javascript">
function myFunction() {
var msg="<?php echo $start_from ?>";
var msg_1="<?php echo $end_to ?>";
window.location.href = 'call_disposition_export_excel.php?start_from='+msg+ "&end_to=" + msg_1;
}
</script>

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
			
                        <div id="hide"><?php include ("../../includes/views/messager.php"); //Display  Messages for Entered Data  ?></div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet box yellow">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-edit"></i>View Call Disposition
							</div>
							<div class="tools">
                                                            <form id="commentForm" class="stdform" name ="check_date" action="" method="post" enctype="multipart/form-data"> 
                                                            <div class="input-group" style="float:right;">
                                                                <span>Start From : </span>
                                                                    <input type="date" name="start_from" id="start_from" class="input-small" value="<?php if (isset($_POST['start_from'])) {echo $_POST['start_from']; }else{echo date("Y-m-d");} ?>" style="border:solid 1px #DDD;background-color:#666F73;line-height:20px;padding:2px 3px 2px 3px;"/>

                                                                <span>End To : </span>
                                                                    <input type="date" name="end_to" id="end_to" class="input-small" value="<?php if (isset($_POST['end_to'])) {echo $_POST['end_to']; }else{echo date('Y-m-d');} ?>" style="border:solid 1px #DDD;background-color:#666F73;line-height:20px;padding:2px 3px 2px 3px;"/>

                                                                <input type="submit" name="add" value="Submit" class="btn btn-primary" style="background-color:#09F; margin:0px 0px 10px 30px;"/>
                                                            </div>
                                                            </form>
                                                        </div>
						</div>
						<div class="portlet-body">
                                                        <!--/row-->
							<table class="table table-striped table-hover table-bordered" id="sample_editable_1">
							<thead>
							<tr>
								<th>
									 ID
								</th>
                                                                <th>
									 Agent Name 
								</th>
                                                                <th>
									 Dealer Name
								</th>
                                                                <th>
									 Phone Number
								</th>
                                                                <th>
									 Outcome
								</th>
                                                                <th>
									 Date
								</th>
                                                                <th>
									 Time
								</th>
                                                                <th>
									 View
								</th>
                                                                <th>
									 Delete
								</th>
                                                                
							</tr>
							</thead>
                                                        
							<tbody>
                                                         <?php $i=1;
								foreach ($call_list as $data) { ?>   
							<tr>
                                                                <td>
									<?php echo $data['activation_id']; ?>
								</td>
                                                                <td>
									<?php echo $data['activation_agent_name'];  ?>
								</td>
                                                                <td>
									<?php echo $data['activation_store_name'];  ?>
								</td>
                                                                <td>
									<?php echo $data['activation_phone_no'];  ?>
								</td>
                                                                <td>
									<?php echo $data['activation_outcome'];  ?>
								</td>
                                                                <td>
									<?php echo $data['activation_entered_date'];  ?>
								</td>
                                                                <td>
									<?php echo $data['activation_entered_time'];  ?>
								</td>
                                                                <td>
									<a title="View" href="call_disposition_details.php?id=<?php echo $data['activation_id'] ;?>"  style="text-decoration:none;">
									<img src="<?php echo SITEURL ?>/assets/admin/pages/img/search.png" width="20" height="20" /> </a>
								</td>
                                                                <td>
									<a title="Delete"  href="call_disposition_delete?iid=<?php echo $data['activation_id'] ;?>" onclick="return confirm('Are you sure you want to delete?')" style="text-decoration:none;">
									<img src="<?php echo SITEURL ?>/assets/admin/pages/img/delete.png" width="20" height="20" /> </a>
								</td>
                                                                
							</tr>
							<?php $i++;} ?>
							</tbody>
                                                         
							</table><button id="btnExport" onClick="myFunction()" >Export to excel</button>
						</div>
                                             
					</div>
                   
					<!-- END EXAMPLE TABLE PORTLET-->
				</div>
                
			</div>
			<!-- END PAGE CONTENT -->
		</div>
	</div>
	<!-- END CONTENT -->
	
</div>
<!-- END CONTAINER -->

<!-- BEGIN FOOTER -->
<?php require("../../includes/views/footer_admin_1.php"); ?>
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

<?php
//Clear all the Message Session Variables...
if(isset($_SESSION['returnmessage'])) { unset($_SESSION['returnmessage']);}
?>