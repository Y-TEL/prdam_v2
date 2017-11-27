<?php
/**
 * Description of User
 *
 * @author Nirushika
 */
session_start();

require_once '../../includes/views/define_include.php';
require '../../classes/marketing/dep_updates.php';

$loginManager = new LoginManager();
$logerHD = new LoggerHD();

if (!$loginManager->confirm_member()) {
    header('Location: ../../index.php');
}

$page = new Page();
$page->setIcon("iconfa-home");
$page->setHeader("Dep Updates View");
$page->setTag_line("Dep_Updates_Page");
$page->setMenu_active("View_Dep_Update_Page");
$page->setMenu_group("Marketing_Department");
  
if(isset($_SESSION['image'])){unset($_SESSION['image']);}

$depupdates = new DepUpdates(); 
$dep_updates_list = $depupdates->viewDepUpdatesList();

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
<!-- class head -->
<?php require("../../includes/views/head_1.php") ?>
<!-- class head -->
<style>
.preview1
{
width:150px;
border:solid 1px #dedede;
padding:4px;
height:150px;
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
			
                        <div id="hide"><?php include ("../../includes/views/messager.php"); //Display  Messages for Entered Data  ?></div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet box yellow">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-edit"></i>Department Updates
							</div>
							<div class="tools">
                                                             <?php //if (($_SESSION['user_type_id']=="1")||($_SESSION['user_type_id']=="2")||($_SESSION['user_type_id']=="3")||($_SESSION['user_type_id']=="4")||($_SESSION['user_type_id']=="6")||($_SESSION['user_type_id']=="17")||($_SESSION['user_type_id']=="18")||($_SESSION['user_type_id']=="22")||($_SESSION['user_id']=="71")||($_SESSION['user_id']=="46")||($_SESSION['user_id']=="47")||($_SESSION['user_id']=="49")){
                                                                if (isset($_SESSION['user_permissions']['Department_update_add']) && ($_SESSION['user_permissions']['Department_update_add'] == '1')){ ?>
								<a href="dep_updates_add.php" class="btn default" style="text-decoration:none; height: 30px;" >Add Department Updates</a>
                                                            <?php } ?>
                                                        </div>
						</div>
						<div class="portlet-body">
                                                <!--/row-->
							<table class="table table-striped table-hover table-bordered" id="sample_editable_1">
							<thead>
                                                            <tr class="warning">
								<th>
									 NO
								</th>
                                                                <th>
									 Image  
								</th>
                                                                <th>
									 Department  
								</th>
                                                                <th>
									 Subject  
								</th>
                                                                <th>
									 Description 
								</th>
                                                                <?php if (isset($_SESSION['user_permissions']['Department_update_add']) && ($_SESSION['user_permissions']['Department_update_add'] == '1')){?>
								<th>
									 Edit
								</th>
								<th>
									 Delete
								</th>
                                                                <?php } ?>
							</tr>
							</thead>
                                                        
							<tbody>
                                                         <?php $i=1;
								foreach ($dep_updates_list as $data) { ?>   
							<tr>
                                                                <td>
									<?php echo $i; ?>
								</td>
                                                                <td>
                                                                  <?php if ($data['dep_updates_image']!=NULL){ ?>
                                                                  <a class="fancybox-button" data-rel="fancybox-button" <?php echo "href='".SITEURL."/uploads/dep_update/".$data['dep_updates_image']."' "; ?> ><?php echo "<img src='".SITEURL."/uploads/dep_update/".$data['dep_updates_image']."'  class='preview1'>"; ?></a>
                                                                  <?php }else{ ?>      
                                                                  <img src="<?php echo SITEURL ?>/assets/resources/images/default_news.png" alt="" class="img-polaroid" width='150px' height='150px' align='left' />
                                                                  <?php } ?>
                            
								</td>
                                                                <td>
									<?php echo $data['dep_name']; ?>
								</td>
								<td>
									<?php echo $data['dep_updates_subject']; ?>
								</td>
                                                                <td>
									<?php echo $data['dep_updates_body']."</br>";  ?>
                                                                    <div style=" text-align: right;"> <?php echo "(".$data['dep_updates_entered_by']." - ".$data['dep_updates_entered_date']." ".$data['dep_updates_entered_time'].")";?></div>
								</td>
                                                                <?php if (isset($_SESSION['user_permissions']['Department_update_add']) && ($_SESSION['user_permissions']['Department_update_add'] == '1')){?>
								<td>
									<a title="Edit" href="dep_updates_edit.php?id=<?php echo $data['dep_updates_id'] ;?>"  style="text-decoration:none;">
									Edit </a>
								</td>
								<td>
									<a title="Delete"  href="dep_updates_edit.php?iid=<?php echo $data['dep_updates_id'] ;?>" onclick="return confirm('Are you sure you want to delete?')" style="text-decoration:none;">
									Delete </a>
								</td>
                                                                <?php } ?>
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