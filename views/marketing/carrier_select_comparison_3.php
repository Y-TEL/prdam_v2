<?php 
require_once '../../includes/views/define_include.php';
require '../../classes/marketing/comparison.php';

$comparison = new Comparison();

$comp_carrier_2 = $_POST['comp_carrier_2'];
$comp_plan_2 = $_POST['comp_plan_2'];

$carrier_list_2 = $comparison->viewSelectedSecondCarrier($comp_carrier_2, $comp_plan_2);
?>
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
                        <?php if (isset($carrier_list_2['com_validity'])) { echo $carrier_list_2['com_validity'];}else{ echo "";} ?>
                </td>
            </tr>
            <tr style="height:50px;">
                <td>
                        <?php if (isset($carrier_list_2['com_data'])) { echo $carrier_list_2['com_data'];}else{ echo "";} ?>
                </td>
            </tr>
            <tr style="height:50px;">
                <td>
                        <?php if (isset($carrier_list_2['com_talk'])) { echo $carrier_list_2['com_talk'];}else{ echo "";} ?>
                </td>
            </tr>
            <tr style="height:75px;">
                <td>
                        <?php if (isset($carrier_list_2['com_text'])) { echo $carrier_list_2['com_text'];}else{ echo "";} ?>
                </td>
            </tr>
            <tr style="height:75px;">
                <td>
                        <?php if (isset($carrier_list_2['com_international'])) { echo $carrier_list_2['com_international'];}else{ echo "";} ?>
                </td>
            </tr>
            <tr style="height:150px;">
                <td>
                        <?php if (isset($carrier_list_2['com_features'])) { echo $carrier_list_2['com_features'];}else{ echo "";} ?>
                </td>
            </tr>
            <tr style="height:150px;">
                <td>
                        <?php if (isset($carrier_list_2['com_note'])) { echo $carrier_list_2['com_note'];}else{ echo "";} ?>

                </td>
            </tr>
            </tbody>

</table>
                                
          
<div style="clear:both;"></div> 
          
                    
		
 		
