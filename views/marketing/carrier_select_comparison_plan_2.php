<?php 
require_once '../../includes/views/define_include.php';

if(isset($_GET['carrier_name'])) {   $carrier_name  = $_GET['carrier_name']; }   else { $carrier_name =""; }
 
//$activation = new Activation();
if(isset($_GET['carrier_name'])){
    
$drop_downs = new DropDownlist();
$drop_down_plan = $drop_downs->getSelectedPlans($carrier_name);
?>

<span class="font-green-sharp">Plan</span>
<select name="comp_plan_2" id="comp_plan_2" class="select2_category form-control" tabindex="1">
    <option value="">Select</option>
    <?php foreach ($drop_down_plan as $value) { ?>
        <option value="<?php echo $value['plan_id']; ?>"><?php echo $value['plan_name']; ?></option>
    <?php } ?>
</select> 
                            
<?php } ?>
          
<div style="clear:both;"></div> 
          
                    
		
 		
