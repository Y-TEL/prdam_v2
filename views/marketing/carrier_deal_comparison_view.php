<?php
/**
 * Description of User
 *
 * @author Nirushika
 */
session_start();

require_once '../../includes/views/define_include.php';
require '../../classes/marketing/deal_comparison.php';

$loginManager = new LoginManager();
$logerHD = new LoggerHD();

if (!$loginManager->confirm_member()) {
    header('Location: ../../index.php');
}

$page = new Page();
$page->setIcon("iconfa-home");
$page->setHeader("Carrier_Deals_Comparison");
$page->setTag_line("View_Carrier_Deal");
$page->setMenu_active("Carrier_Page");
$page->setMenu_group("Marketing_Department");

$comparison = new DealComparison();
$comp_list = $comparison->viewAllCarrierDeals();

if(isset($_SESSION['comp_carrier_1'])){unset($_SESSION['comp_carrier_1']);}
if(isset($_SESSION['comp_plan_1'])){unset($_SESSION['comp_plan_1']);}
if(isset($_SESSION['comp_carrier_2'])){unset($_SESSION['comp_carrier_2']);}
if(isset($_SESSION['comp_plan_2'])){unset($_SESSION['comp_plan_2']);}

date_default_timezone_set('America/New_York');
@$today = date('d-m-Y');

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
<link href="<?php echo SITEURL ?>/assets/admin/pages/css/pricing-table.css" rel="stylesheet" type="text/css"/>
</head>

<style>
.preview1
{
width:200px;
border:solid 1px #dedede;
padding:4px;
height:115px;
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
					<div class="portlet box blue-sharp">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-edit"></i>All Carrier Deals
							</div>
							<div class="tools">
                                                            <?php if (isset($_SESSION['user_permissions']['Carrier_deal_comparison_add']) && ($_SESSION['user_permissions']['Carrier_deal_comparison_add'] == '1')){?> 
								<a href="carrier_deal_comp_add.php" class="btn default" style="text-decoration:none; height: 30px;" >Add New</a>
                                                            <?php } ?>
                                                        </div>
						</div>
						<div class="portlet-body">
							<div class="form-body" >
                                                            
                                                                

                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <?php $i=1;
                                                                        foreach ($comp_list as $data) { ?>
                                                                        
                                                                        <div class="col-md-3">
                                                                            <div class="pricing hover-effect">
										<div class="pricing-head">
											<h4>
                                                                                        <?php if ($data['carrier_image']!=NULL){ ?>
                                                                                        <?php echo "<img src='".SITEURL."/uploads/carriers/".$data['carrier_image']."'  class='preview1'>"; ?>
                                                                                        <?php }else{ ?>      
                                                                                        <img src="<?php echo SITEURL ?>/resources/images/default_carrier.png" alt="" class="img-polaroid" width='200px' height='115px' align='left' />
                                                                                        <?php } ?>
                                                                                        
											</h4>
											
										</div>
                                                                                <ul class="pricing-content list-unstyled" style=" padding: 10px 0px 50px 0px; height: 150px;">
											<li>
                                                                                                <div class="col-md-12"> 
                                                                                                <label class="control-label col-md-6"><strong>Carrier</strong></label>
                                                                                                <div class="col-md-6"><?php echo $data['carrier_name']; ?></div>
                                                                                                </div>
											</li>
											<li>
												<div class="col-md-12"> 
                                                                                                <label class="control-label col-md-6"><strong>Plan</strong> </label>
                                                                                                <div class="col-md-6"><?php echo $data['plan_name']; ?></div>
                                                                                                </div>
											</li>
											<li>
                                                                                                <div class="col-md-12">
                                                                                                <label class="control-label col-md-6"><strong>Sim Price</strong> </label>
                                                                                                <div class="col-md-6"><?php echo $data['deal_sim_price']; ?></div>
                                                                                                </div>
											</li>
											
										</ul>
                                                                                <div class="pricing-footer" style=" padding-left: 0; padding-right: 0;">
											<a title="Compare" href="carrier_deal_comparison?id=<?php echo $data['deal_id'] ;?>" class="btn yellow-gold">
											Compare <i class="m-icon-swapright m-icon-white"></i>
											</a>
                                                                                        <?php if (isset($_SESSION['user_permissions']['Carrier_deal_comparison_add']) && ($_SESSION['user_permissions']['Carrier_deal_comparison_add'] == '1')){ ?>
                                                                                        <a title="Edit" href="carrier_deal_comp_edit?id=<?php echo $data['deal_id'] ;?>"  class="btn blue-madison">Edit </a>
                                                                                        <a title="Delete"  href="carrier_deal_comp_edit?iid=<?php echo $data['deal_id'] ;?>" onclick="return confirm('Are you sure you want to delete?')" class="btn blue-madison">Delete </a>
                                                                                        <?php } ?>
										</div>
									</div>
                                                                            
                                                                        </div>
                                                                        <!--/span-->
                                                                        
                                                                        <?php $i++;} ?>
                                                                        
                                                                    </div>
                                                                </div>
                                                                <!--/row-->
                                                        </div>
                            
							
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