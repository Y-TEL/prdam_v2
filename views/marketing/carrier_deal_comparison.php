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

date_default_timezone_set('America/New_York');
@$today = date('d-m-Y');

$id = $_GET['id'];
$details = $comparison->viewSelectedCarrierDeal($id);                            

$drop_downs = new DropDownlist();
$drop_down_carrier  = $drop_downs->getAllCarrier();
$carrier_name=$details['deal_carrier_id'];
$drop_down_plan = $drop_downs->getSelectedPlans($carrier_name);

?>
<!DOCTYPE html>

<html lang="en">

<head>
<!-- class head -->
<?php require("../../includes/views/head_1.php") ?>
<!-- class head -->

<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery-latest.js"></script>
<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery-ui.min.js"></script>

<style>
.preview1
{
width:200px;
border:solid 1px #dedede;
padding:4px;
height:115px;
}
.bold{
color: #9E0F28;  
font-size: 18px;
}
</style> 

<script>
function Carrier_Type_1()
{ 
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		 xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		 xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
        
		var carrier_name = document.getElementById('comp_carrier_1').value;
		//alert(item_det_id);
		xmlhttp.onreadystatechange=function()
		{//7
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{//8
				document.getElementById('carrier_type_textbox_1').innerHTML=xmlhttp.responseText;
 			}
		}
                
		xmlhttp.open("GET","carrier_select_comparison_plan_1.php?carrier_name="+carrier_name,true);
		xmlhttp.send();
	
}

function Carrier_Type_2()
{ 
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		 xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		 xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
        
		var carrier_name = document.getElementById('comp_carrier_2').value;
		//alert(item_det_id);
		xmlhttp.onreadystatechange=function()
		{//7
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{//8
				document.getElementById('carrier_type_textbox_2').innerHTML=xmlhttp.responseText;
 			}
		}
                
		xmlhttp.open("GET","carrier_select_comparison_plan_2.php?carrier_name="+carrier_name,true);
		xmlhttp.send();
	
}

jQuery(document).ready(function() {
    
jQuery("body").on("change", "#comp_plan_1", function(e) { 
    var comp_carrier_1 = jQuery("#comp_carrier_1").val();
    var comp_plan_1 = jQuery("#comp_plan_1").val();
    
jQuery.ajax({ 
    
            url: 'carrier_deal_select_comparison_2.php',
            type: 'POST',
            data: {comp_carrier_1: comp_carrier_1, comp_plan_1: comp_plan_1},
            cache: false,
            beforeSend: function() {

            },
            success: function(response) {  
                jQuery("#plan_type_1").html(response);
            },
            error: function() {
                jQuery("#error").text("Warning : Error Occured");
            }
 });
});

jQuery("body").on("change", "#comp_plan_2", function(e) { 
    var comp_carrier_2 = jQuery("#comp_carrier_2").val();
    var comp_plan_2 = jQuery("#comp_plan_2").val();
    
jQuery.ajax({ 
            url: 'carrier_deal_select_comparison_3.php',
            type: 'POST',
            data: {comp_carrier_2: comp_carrier_2, comp_plan_2: comp_plan_2},
            cache: false,
            beforeSend: function() {

            },
            success: function(response) {  
                jQuery("#plan_type_2").html(response);
            },
            error: function() {
                jQuery("#error").text("Warning : Error Occured");
            }
 });
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
                        
                        
			<!-- BEGIN PAGE HEADER-->
			<div id="hide"><?php include ("../../includes/views/messager.php"); //Display  Messages for Entered Data  ?></div>
            		<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="top-news" style="padding-right: 0px;">
                                        <a href="#" class="btn blue-steel">
                                        <span>Carrier Deal Comparison </span>
                                        <i class="fa fa-globe top-news-icon"></i>
                                        </a>
                                </div>
                            </div>
                            
                               <form id="commentForm" name ="select_carrier_1" action="" method="post" enctype="multipart/form-data"> 
                                <div class="col-md-12">   
                                   <div class="col-md-3">
                                    
                                       <div style=" height: 80px;margin-bottom:5px;">
                                            
                                        </div> 
                                       
                                        <table class="table table-hover table-bordered alert alert-info">
                                            <thead>
							<tr style="height:50px;">
                                                            <td class="bold" style="border:0px;">
                                                                     
                                                            </td>
							</tr>
					    </thead>
                                            <tbody>
                                                        <tr style="height:150px;">
                                                            <td class="bold" style="text-align: center; border:0px;">
                                                                 Carrier Name   
                                                            </td>
							</tr>
                                                        <tr style="height:50px;">
                                                            <td class="bold" style=" text-align: center;"> 
                                                                    Plan
                                                            </td>
							</tr>
                                                        <tr style="height:50px;">
                                                            <td class="bold" style=" text-align: center;">
                                                                    Sim Price
                                                            </td>
							</tr>
                                                        <tr style="height:50px;">
                                                            <td class="bold" style=" text-align: center;">
                                                                    Activation Spiff
                                                            </td>
							</tr>
                                                        <tr style="height:50px;">
                                                            <td class="bold" style=" text-align: center;">
                                                                    2nd Month Spiff
                                                            </td>
							</tr>
                                                        <tr style="height:75px;">
                                                            <td class="bold" style=" text-align: center;">
                                                                    3rd Month Spiff
                                                            </td>
							</tr>
                                                        <tr style="height:75px;">
                                                            <td class="bold" style=" text-align: center;">
                                                                    Residual
                                                            </td>
							</tr>
                                                        <tr style="height:150px;">
                                                            <td class="bold" style=" text-align: center;">
                                                                    ATR/RTR
                                                            </td>
							</tr>
                                                        <tr style="height:150px;">
                                                            <td class="bold" style=" text-align: center;">
                                                                    Note
                                                            </td>
							</tr>
							</tbody>
                                                         
					</table>
				</div>
                            
                                <div class="col-md-3">
                                    
                                        <div style=" height: 80px;margin-bottom:5px;">
                                            
                                        </div> 
                                    
                                        <table class="table table-striped table-hover table-bordered">
                                            <thead>
							<tr style="height:50px;">
                                                            <th class="well">
                                                               <?php echo $details['carrier_name']; ?>     
                                                            </th>
							</tr>
					    </thead>
                                            <tbody>
                                                <tr style="height:150px;">
                                                            <td style="padding:5% 20% 0% 20%;">
                                                                <?php if ($details['carrier_image']!=NULL){ ?>
                                                                <a class="fancybox-button" data-rel="fancybox-button" <?php echo "href='".SITEURL."/uploads/carriers/".$details['carrier_image']."' "; ?> ><?php echo "<img src='".SITEURL."/uploads/carriers/".$details['carrier_image']."'  class='preview1'>"; ?></a>
                                                                <?php }else{ ?>      
                                                                <img src="<?php echo SITEURL ?>/assets/resources/images/default_carrier.png" alt="" width='100%' height='auto' align='left' />
                                                                <?php } ?>    
                                                            </td>
							</tr>
                                                        <tr style="height:50px;">
                                                            <td>
                                                                    <?php echo $details['plan_name']; ?>
                                                            </td>
							</tr>
                                                        <tr style="height:50px;">
                                                            <td>
                                                                    $<?php echo $details['deal_sim_price']; ?> 
                                                            </td>
							</tr>
                                                        <tr style="height:50px;">
                                                            <td>
                                                                    $<?php echo $details['deal_activation_spiff']; ?>
                                                            </td>
							</tr>
                                                        <tr style="height:50px;">
                                                            <td>
                                                                    $<?php echo $details['deal_2nd_spiff']; ?>
                                                            </td>
							</tr>
                                                        <tr style="height:75px;">
                                                            <td>
                                                                    $<?php echo $details['deal_3rd_spiff']; ?>
                                                            </td>
							</tr>
                                                        <tr style="height:75px;">
                                                            <td>
                                                                    <?php echo $details['deal_residual']; ?> % 
                                                            </td>
							</tr>
                                                        <tr style="height:150px;">
                                                            <td>
                                                                    <?php echo $details['deal_atr']; ?> %
                                                            </td>
							</tr>
                                                        <tr style="height:150px;">
                                                            <td>
                                                                    <?php echo $details['deal_note']; ?>
                                                            </td>
							</tr>
							</tbody>
                                                         
					</table>
                                    </div>
                            
                                
                                    <div class="col-md-3">
                                    
                                        <div style=" height: 80px; margin-bottom:5px;" class="alert-info table-bordered">
                                            <div class="col-md-12"> <span class="caption-subject font-green-sharp uppercase">COMPARE WITH</span></div>
                                            <div class="col-md-8"> 
                                            <span class="font-green-sharp">Carrier</span>
                                            <select name="comp_carrier_1" id="comp_carrier_1" class="select2_category form-control" tabindex="1" onchange="Carrier_Type_1();">
                                                <option value="">Select</option>
                                                <?php foreach ($drop_down_carrier as $value) { ?>
                                                    <option value="<?php echo $value['carrier_id']; ?>"><?php echo $value['carrier_name']; ?></option>
                                                <?php } ?>
                                            </select> 
                                            </div>

                                            <div class="col-md-4" style=" padding-left: 0px;">
                                                <div id="carrier_type_textbox_1"></div>
                                            </div>
                                        </div>   
                                        
                                        <div id="plan_type_1">
                                        <table class="table table-hover table-bordered">
                                            <thead>
							<tr style="height:50px;">
                                                            <th class="well">
                                                                  <?php if (isset($carrier_list_1['carrier_name'])) { echo $carrier_list_1['carrier_name'];}else{ echo "";} ?>  
                                                            </th>
							</tr>
					    </thead>
                                            
                                            
                                              <tbody>
                                                  
                                                <tr style="height:150px;">
                                                <td style="padding:5% 20% 0% 20%;">
                                                        <?php if (isset($carrier_list_1['carrier_image'])) { ?>
                                                        <a class="fancybox-button" data-rel="fancybox-button" <?php echo "href='".SITEURL."/uploads/carriers/".$carrier_list_1['carrier_image']."' "; ?> ><?php echo "<img src='".SITEURL."/uploads/carriers/".$carrier_list_1['carrier_image']."'  class='preview1'>"; ?></a>
                                                        <?php }else{ ?>      
                                                        <img src="<?php echo SITEURL ?>/assets/resources/images/default_carrier.png" alt="" width='100%' height='auto' align='left' />
                                                        <?php } ?>    
                                                    </td>
                                                </tr>
                                                <tr style="height:50px;">
                                                    <td>
                                                            <?php if (isset($carrier_list_1['plan_name'])) { echo $carrier_list_1['plan_name'];}else{ echo "";} ?>
                                                    </td>
                                                </tr>
                                                <tr style="height:50px;">
                                                    <td>
                                                        <?php if (isset($carrier_list_1['deal_sim_price'])) { echo $carrier_list_1['deal_sim_price'];}else{ echo "";} ?>    
                                                    </td>
                                                </tr>
                                                <tr style="height:50px;">
                                                    <td>
                                                        <?php if (isset($carrier_list_1['deal_activation_spiff'])) { echo $carrier_list_1['deal_activation_spiff'];}else{ echo "";} ?>    
                                                    </td>
                                                </tr>
                                                <tr style="height:50px;">
                                                    <td>
                                                        <?php if (isset($carrier_list_1['deal_2nd_spiff'])) { echo $carrier_list_1['deal_2nd_spiff'];}else{ echo "";} ?>    
                                                    </td>
                                                </tr>
                                                <tr style="height:75px;">
                                                    <td>
                                                        <?php if (isset($carrier_list_1['deal_3rd_spiff'])) { echo $carrier_list_1['deal_3rd_spiff'];}else{ echo "";} ?>    
                                                    </td>
                                                </tr>
                                                <tr style="height:75px;">
                                                    <td>
                                                        <?php if (isset($carrier_list_1['deal_residual'])) { echo $carrier_list_1['deal_residual'];}else{ echo "";} ?>    
                                                    </td>
                                                </tr>
                                                <tr style="height:150px;">
                                                    <td>
                                                        <?php if (isset($carrier_list_1['deal_atr'])) { echo $carrier_list_1['deal_atr'];}else{ echo "";} ?>    
                                                    </td>
                                                </tr>
                                                <tr style="height:150px;">
                                                    <td>
                                                        <?php if (isset($carrier_list_1['deal_note'])) { echo $carrier_list_1['deal_note'];}else{ echo "";} ?>    
                                                    </td>
                                                </tr>
                                            </tbody>
                                                       
					</table>
                                         </div> 	
                                             
                                    </div>
                            
                                    <div class="col-md-3">
                                    
                                        <div style=" height: 80px; margin-bottom:5px;" class="alert-info table-bordered">
                                            <div class="col-md-12"> <span class="caption-subject font-green-sharp uppercase">COMPARE WITH</span></div>
                                            <div class="col-md-8">    
                                            <span class="font-green-sharp">Carrier</span>
                                            <select name="comp_carrier_2" id="comp_carrier_2" class="select2_category form-control" tabindex="1" onchange="Carrier_Type_2();">
                                                <option value="">Select</option>
                                                <?php foreach ($drop_down_carrier as $value) { ?>
                                                    <option value="<?php echo $value['carrier_id']; ?>"><?php echo $value['carrier_name']; ?></option>
                                                <?php } ?>
                                            </select> 
                                            </div>

                                            <div class="col-md-4" style=" padding-left: 0px;">
                                                <div id="carrier_type_textbox_2"></div>
                                            </div>
                                        </div>   
                                    
                                        <div id="plan_type_2">
                                        <table class="table table-hover table-bordered">
                                            <thead>
							<tr style="height:50px;">
                                                            <th class="well">
                                                                 <?php if (isset($carrier_list_2['carrier_name'])) { echo $carrier_list_2['carrier_name'];}else{ echo "";} ?>   
                                                            </th>
							</tr>
					    </thead>
                                            <tbody>
                                                <tr style="height:150px;">
                                                    <td style="padding:5% 20% 0% 20%;">
                                                                <?php if (isset($carrier_list_2['carrier_image'])) { ?>
                                                                <a class="fancybox-button" data-rel="fancybox-button" <?php echo "href='".SITEURL."/uploads/carriers/".$carrier_list_2['carrier_image']."' "; ?> ><?php echo "<img src='".SITEURL."/uploads/carriers/".$carrier_list_2['carrier_image']."'  class='preview1'>"; ?></a>
                                                                <?php }else{ ?>      
                                                                <img src="<?php echo SITEURL ?>/assets/resources/images/default_carrier.png" alt="" width='100%' height='auto' align='left' />
                                                                <?php } ?>    
                                                            </td>
							</tr>
                                                        <tr style="height:50px;">
                                                            <td>
                                                                    <?php if (isset($carrier_list_2['plan_name'])) { echo $carrier_list_2['plan_name'];}else{ echo "";} ?>
                                                                
                                                            </td>
							</tr>
                                                        <tr style="height:50px;">
                                                            <td>
                                                                    <?php if (isset($carrier_list_2['deal_sim_price'])) { echo $carrier_list_2['deal_sim_price'];}else{ echo "";} ?>
                                                            </td>
							</tr>
                                                        <tr style="height:50px;">
                                                            <td>
                                                                    <?php if (isset($carrier_list_2['deal_activation_spiff'])) { echo $carrier_list_2['deal_activation_spiff'];}else{ echo "";} ?>
                                                            </td>
							</tr>
                                                        <tr style="height:50px;">
                                                            <td>
                                                                    <?php if (isset($carrier_list_2['deal_2nd_spiff'])) { echo $carrier_list_2['deal_2nd_spiff'];}else{ echo "";} ?>
                                                            </td>
							</tr>
                                                        <tr style="height:75px;">
                                                            <td>
                                                                    <?php if (isset($carrier_list_2['deal_3rd_spiff'])) { echo $carrier_list_2['deal_3rd_spiff'];}else{ echo "";} ?>
                                                            </td>
							</tr>
                                                        <tr style="height:75px;">
                                                            <td>
                                                                    <?php if (isset($carrier_list_2['deal_residual'])) { echo $carrier_list_2['deal_residual'];}else{ echo "";} ?>
                                                            </td>
							</tr>
                                                        <tr style="height:150px;">
                                                            <td>
                                                                    <?php if (isset($carrier_list_2['deal_atr'])) { echo $carrier_list_2['deal_atr'];}else{ echo "";} ?>
                                                            </td>
							</tr>
                                                        <tr style="height:150px;">
                                                            <td>
                                                                    <?php if (isset($carrier_list_2['deal_note'])) { echo $carrier_list_2['deal_note'];}else{ echo "";} ?>

                                                            </td>
							</tr>
							</tbody>
                                                         
					</table>
                                    </div>
				</div>
                                    
                                </div>
                                </form>
                                <div class="clearfix"></div>
                                </div>
				
			</div>
			<!-- END PAGE CONTENT-->
		</div>
	</div>
<!-- END CONTENT -->
        
<!-- BEGIN FOOTER -->
<?php require("../../includes/views/footer_admin_1.php"); ?>
<!-- END FOOTER -->
<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js"></script>

<?php
//Clear all the Message Session Variables...
if(isset($_SESSION['returnmessage'])) { unset($_SESSION['returnmessage']);}
?>
 
</body>

<!-- END BODY -->
</html>
