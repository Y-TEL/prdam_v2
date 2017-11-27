<?php
/**
 * Description of User
 *
 * @author Nirushika
 */
session_start();
require_once '../../includes/views/define_include.php';
require '../../classes/marketing/market_allocation.php';

$loginManager = new LoginManager();
$logerHD = new LoggerHD();

if (!$loginManager->confirm_member()) {
   header('Location: ../../index.php');
}

$page = new Page();
$page->setIcon("iconfa-home");
$page->setHeader("Market Allocation Page");
$page->setTag_line("Market Allocation View Page");
$page->setMenu_active("Market_Allocation_view");
$page->setMenu_group("Marketing_Department");

$market = new Market();
$market_list = $market->viewMarketList();

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
								<i class="fa fa-edit"></i>MARKET ALLOCATION STRUCTURE
							</div>
							<div class="tools">
                                                            <?php if (isset($_SESSION['user_permissions']['market_allocation_add']) && ($_SESSION['user_permissions']['market_allocation_add'] == '1')){?>
								<a href="market_allocation_add" class="btn default" style="text-decoration:none; height: 30px;" >Add New</a>
                                                            <?php } ?>
                                                        </div>
						</div>
						<div class="portlet-body">
                                                        <!--/row-->
							<table class="table table-striped table-hover table-bordered" id="sample_editable_1">
							<thead>
							<tr>
								<th>
									 NO
								</th>
                                                                <th>
									 Market 
								</th>
                                                                <th>
									 RM
								</th>
                                                                <th>
									 Region
								</th>
                                                                <th>
									 Territory
								</th>
                                                                <th>
									 Territory Code
								</th>
                                                                
                                                                <th>
									 ACM 
								</th>
                                                                <th>
									 AM
								</th>
                                                                <th>
									 Supervisor
								</th>
                                                                <th>
									 ME 
								</th>
                                                                <th>
									 Market Type
								</th>
                                                                <th>
									 Active Dealers
								</th>
                                                                <th>
									 Inactive Dealers
								</th>
                                                                <?php if (isset($_SESSION['user_permissions']['market_allocation_add']) && ($_SESSION['user_permissions']['market_allocation_add'] == '1')){?>
                                                                <th>
                                                                    Option
                                                                </th>
                                                                <?php } ?>
                                                                
							</tr>
							</thead>
                                                        
							<tbody>
                                                        <?php $i=1;
								foreach ($market_list as $data) { 
                                                                $RM= $data['market_RM'];
                                                                $value = $market->selectDealerRM($RM);
                                                                
                                                                $ACM= $data['market_ACM'];
                                                                $values = $market->selectDealerACM($ACM);
                                                                
                                                                $AM= $data['market_AM'];
                                                                $valuess = $market->selectDealerAM($AM);
                                                                
                                                                $SUP= $data['market_supervisor'];
                                                                $valuesss = $market->selectDealerSup($SUP);
                                                                
                                                        ?>   
							<tr>
                                                                <td>
									<?php echo $i; ?>
								</td>
                                                                <td>
									<?php echo $data['market_name'];  ?>
								</td>
                                                                <td>
                                                                        <?php if($value['user_calling_name']!=""){ echo $value['user_calling_name'];}else{ echo "No RM";}  ?>
								</td>
                                                                <td>
									<?php echo $data['market_region'];  ?>
								</td>
                                                                <td>
									<?php echo $data['market_territory'];  ?>
								</td>
                                                                <td>
									<?php echo $data['market_territory_code'];  ?>
								</td>
                                                                <td>
                                                                        <?php if($values['user_calling_name']!=""){ echo $values['user_calling_name'];}else{ echo "No ACM";}  ?>
								</td>
                                                                <td>
                                                                        <?php if($valuess['user_calling_name']!=""){ echo $valuess['user_calling_name'];}else{ echo "No AM";}  ?>
								</td>
                                                                <td>
                                                                        <?php if($valuesss['user_calling_name']!=""){ echo $valuesss['user_calling_name'];}else{ echo "No SUP";}  ?>
								</td>
                                                                <td>
                                                                        <?php if($data['user_calling_name']!=""){ echo $data['user_calling_name'];}else{ echo "No ME";}  ?>
								</td>
                                                                <td>
									<?php echo $data['market_type'];  ?>
								</td>
                                                                <td>
									<?php echo $data['market_active_dealers'];  ?>
								</td>
                                                                <td>
									<?php echo $data['market_inactive_dealers'];  ?>
								</td>
                                                                <?php if (isset($_SESSION['user_permissions']['market_allocation_add']) && ($_SESSION['user_permissions']['market_allocation_add'] == '1')){?>
                                                                <td>
                                                                        <a title="Edit" href="market_allocation_edit.php?id=<?php echo $data['market_id']; ?>"  class="btn btn-xs default btn-editable"> 
                                                                        <li class="glyphicon glyphicon-edit"></li></a>

                                                                        <a title="Delete" href="market_allocation_edit.php?iid=<?php echo $data['market_id']; ?>" onclick="return confirm('Are you sure you want to block this dealer?')" class="btn btn-xs red btn-editable"> 
                                                                        <li class="glyphicon glyphicon-off"></li></a>
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


</body>

<!-- END BODY -->
</html>
