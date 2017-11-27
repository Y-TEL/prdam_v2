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

$campaign = new Campaign();
$campaign_list = $campaign->viewCampaignList();

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
<!-- class head -->
<?php require("../../includes/views/head_1.php") ?>
<!-- class head -->
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
								<i class="fa fa-edit"></i>View All Eblast Campaigns
							</div>
							<div class="tools">
                                                             <?php //if(($_SESSION['user_id']=="114")||($_SESSION['user_id']=="47")||($_SESSION['user_id']=="49")||($_SESSION['user_id']=="73")){ 
                                                             if (isset($_SESSION['user_permissions']['Eblast_campaign_add']) && ($_SESSION['user_permissions']['Eblast_campaign_add'] == '1')){?> 
								<a href="campaign_add" class="btn default" style="text-decoration:none; height: 30px;" >Add New</a>
                                                             <?php }?>
                                                        </div>
						</div>
						<div class="portlet-body">
							
                            
							<table class="table table-striped table-hover table-bordered" id="sample_editable_1">
							<thead>
							<tr class="warning">
								<th>
									 NO
								</th>
                                                                <th>
									 Campaign Name 
								</th>
								<th>
									 Date
								</th>
                                                                <th>
									 Time (SL)
								</th>
                                                                <th>
									 Time (USA)
								</th>
                                                                <th>
									 Feedback
								</th>
                                                                 <?php if (isset($_SESSION['user_permissions']['Eblast_campaign_add']) && ($_SESSION['user_permissions']['Eblast_campaign_add'] == '1')){ ?> 
								<th>
									 Edit
								</th>
								<th>
									 Delete
								</th>
                                                                <?php }?>
							</tr>
							</thead>
                                                        <tbody>
                                                        <?php $i=1;
							foreach ($campaign_list as $data) { ?>
							<tr>
                                                                <td>
									<?php echo $i; ?>
								</td>
                                                                <td>
									<?php echo $data['camp_title']; ?>
								</td>
								<td>
									<?php echo date('m-d-Y', strtotime($data['camp_date'])); ?>
								</td>
                                                                <td>
									<?php echo $data['camp_time_sl']; ?>
								</td>
                                                                <td>
									<?php echo $data['camp_time_us']; ?>
								</td>
                                                                <td>
									<a title="Add" href="eblast_add?id=<?php echo $data['camp_id'] ;?>" class="btn default blue-stripe">
									Post a feedback </a>
								</td>
                                                                 <?php if (isset($_SESSION['user_permissions']['Eblast_campaign_add']) && ($_SESSION['user_permissions']['Eblast_campaign_add'] == '1')){ ?> 
								<td>
									<a title="Edit" href="campaign_edit?id=<?php echo $data['camp_id'] ;?>"  style="text-decoration:none;">
									<img src="<?php echo SITEURL ?>/assets/admin/pages/img/edit.png" width="20" height="20" />  </a>
								</td>
								<td>
									<a title="Delete"  href="campaign_edit?iid=<?php echo $data['camp_id'] ;?>" onclick="return confirm('Are you sure you want to delete?')" style="text-decoration:none;">
									<img src="<?php echo SITEURL ?>/assets/admin/pages/img/delete.png" width="20" height="20" /> </a>
								</td>
                                                                <?php }?>
							</tr>
							
                                                        <?php $i++;} ?>
                                                        </tbody>
							</table>
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