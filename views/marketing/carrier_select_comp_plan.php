<?php 
require_once '../../includes/views/define_include.php';

if(isset($_GET['carrier_name'])) {   $carrier_name  = $_GET['carrier_name']; }   else { $carrier_name =""; }
 
//$activation = new Activation();
if(isset($_GET['carrier_name'])){
    
$drop_downs = new DropDownlist();
$drop_down_plan = $drop_downs->getSelectedPlans($carrier_name);
?>

<div class="row">
         <div class="col-md-12">
                <div class="form-group">
                        <label class="control-label col-md-4">Plan : <span style="font-size:14px; color:#D90000;" >*</span></label>
                        <div class="col-md-4">
                                <select name="comp_plan" id="comp_plan" class="select2_category form-control" tabindex="1">
                                    <option value="">Select</option>
                                    <?php foreach ($drop_down_plan as $value) { ?>
                                        <option value="<?php echo $value['plan_id']; ?>"><?php echo $value['plan_name']; ?></option>
                                    <?php } ?>
                                </select> 
                                
                        </div>
                </div>
        </div>
        <!--/span-->
  </div>
<!--/row-->

<?php } ?>
          
<div style="clear:both;"></div> 
          
                    
		
 		
