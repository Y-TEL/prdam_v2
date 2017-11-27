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

<script type="text/javascript">
    function print_comfirm(url) {
     popupWindow = window.open(
     url,'popUpWindow','left=10,top=10,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=no')
    }
</script>
            
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
        <div class="page-content-wrapper" style=" width: auto;">
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
                                                                <?php if (isset($_SESSION['user_permissions']['Product_updates_add']) && ($_SESSION['user_permissions']['Product_updates_add'] == '1')){?>
								<th>
                                                                        Option
								</th>
                                                                <?php } ?>
							</tr>
							</thead>
                                                        
							<tbody>
                                                        <?php $i=1;
							foreach ($product_list as $data) { ?>   
							<tr>
                                                                <td>
									<?php echo $i; ?>
								</td>
                                                                <td>
                                                                  <?php if ($data['news_image']!=NULL){ ?>
                                                                  <a class="fancybox-button" data-rel="fancybox-button" <?php echo "href='".SITEURL."/uploads/pro_updates/".$data['news_image']."' "; ?> ><?php echo "<img src='".SITEURL."/uploads/pro_updates/".$data['news_image']."'  class='preview1'>"; ?></a>
                                                                  <?php }else{ ?>      
                                                                  <img src="<?php echo SITEURL ?>/assets/resources/images/default_news.png" alt="" class="img-polaroid" width='150px' height='150px' align='left' />
                                                                  <?php } ?>
                            
								</td>
                                                                <td>
									<?php echo $data['news_dept']; ?>
								</td>
								<td>
									<?php echo $data['news_subject']; ?>
								</td>
                                                                <td>
                                                                    <div class="img-responsive">
                                                                    <?php  //echo substr($data['news_body'],0,100)."....</br>";
                                                                        echo $data['news_body']."</br>";  ?>
                                                                    </div>
                                                                    <div style=" text-align: right;"> <?php echo "(".$data['news_entered_by']." - ".$data['news_entered_date']." ".$data['news_entered_time'].")";?></div>
								</td>
                                                                
                                                                <td>
                                                                <a href="" title="Export to PDF" onClick="JavaScript:print_comfirm('pro_updates_export_pdf.php?id=<?php echo $data['news_id']; ?>');" class="btn btn-xs btn-purple"><i class="fa fa-print"></i></a>
                                                                <?php if (isset($_SESSION['user_permissions']['Product_updates_add']) && ($_SESSION['user_permissions']['Product_updates_add'] == '1')){?>
                                                                    
									<a title="Edit" href="pro_updates_edit?id=<?php echo $data['news_id'] ;?>"  style="text-decoration:none;">
									<img src="<?php echo SITEURL ?>/assets/admin/pages/img/edit.png" width="20" height="20" /> </a>
								
									<a title="Delete"  href="pro_updates_edit?iid=<?php echo $data['news_id'] ;?>" onclick="return confirm('Are you sure you want to delete?')" style="text-decoration:none;">
									<img src="<?php echo SITEURL ?>/assets/admin/pages/img/delete.png" width="20" height="20" /> </a>
								<?php } ?>
                                                                </td>
                                                                
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