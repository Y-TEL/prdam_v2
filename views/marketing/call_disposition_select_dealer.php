<?php 
require_once '../../includes/views/define_include.php';
require '../../classes/marketing/call_disposition.php';

$drop_downs = new DropDownlist();
$drop_down_market   = $drop_downs->getAllMarket();

if(isset($_GET['exs_dealer_bl'])){   
    $dealer_bl_code = $_GET['exs_dealer_bl']; 

$call_disp = new CLDisposition();
$details = $call_disp->viewSelectedDealerDetails($dealer_bl_code); 
if($_GET['exs_dealer_bl'] != ""){
?>

<div class="row">
        <div class="col-md-6">
                <div class="form-group">
                        <label class="control-label col-md-5">Market : <span style="font-size:14px; color:#D90000;" >*</span></label>
                        <div class="col-md-6">
                            <select name="exs_market" id="exs_market" class="form-control select2me" required="">
                                <option value="" selected="true" disabled="true">SELECT</option>
                                <?php foreach ($drop_down_market as $value) { 
                                    if ($value['market_name'] == $details['market_name']) {
                                            $selected = "selected";
                                    } else {
                                            $selected = "";
                                    }
                                    ?>
                                    <option value="<?php echo $value['market_id']; ?>" <?php echo $selected; ?>><?php echo $value['market_name']; ?></option><?php } ?>
                            </select> 
                        </div>
                </div>
        </div>
        <!--/span-->
         <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-5">Market Category : <span style="font-size:14px; color:#D90000;" >*</span></label>
                    <div class="col-md-6">
                            <select name="exs_market_cat" id="exs_market_cat" class="form-control" required="">
                                    <option value="" selected="true" disabled="true">Select</option>
                                    <option value="Remote market">Remote market</option>
                                    <option value="Represented ">Represented </option>
                            </select>
                    </div>
            </div>
        </div>
        <!--/span-->
</div>
<!--/row-->
<div class="row">
        <div class="col-md-6">
                <div class="form-group">
                        <label class="control-label col-md-5">Store Name : <span style="font-size:14px; color:#D90000;" >*</span></label>
                        <div class="col-md-6">
                            <input type="text" name="exs_store_name" id="exs_store_name" class="form-control" value="<?php echo $details['dealer_store_name'];?>" required="">
                        </div>
                </div>
        </div>
        <!--/span-->  
</div>
<!--/row-->
<div class="row">
        <div class="col-md-6">
            <div class="form-group">
                    <label class="control-label col-md-5"></label>
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-1">Calling No</div>
            </div>
        </div> 
        <div class="col-md-2">
        Unreachable/Reachable
        </div>
        <div class="col-md-3">
        Last Checked Date 
        </div>
</div>
<!--/row-->
<div class="row">
        <div class="col-md-6">
            <div class="form-group">
                    <label class="control-label col-md-5">Cell : </label>
                    <div class="col-md-6">
                        <input type="text" name="exs_phone_no_1" id="exs_phone_no_1" class="form-control" value="<?php echo $details['dealer_contact_no'];?>" readonly="">
                    </div>
                    <div class="col-md-1">
                        <div class="form-md-radios">
                                <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" id="radio5" name="exs_phone_no_active" id="no_1" class="md-radiobtn" value="1" checked>
                                                <label for="radio5">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                                </label>
                                        </div>
                                </div>
                        </div>
                    </div>
            </div>
        </div> 
        <div class="col-md-2">
            <label class="switch"><input type="checkbox" name="exs_phone_no_1_reachable" value="1" <?php if($details['dealer_contact_no1_reachable']==1){?>  checked="" <?php }?>><span class="slider round"></span></label>
        </div>
        <div class="col-md-3">
        <?php if($details['dealer_contact_no1_check_date'] != ""){ ?>
        <ul class="feeds"><li>
        <div class="date"><?php echo date("m-d-Y", strtotime($details['dealer_contact_no1_check_date'])); ?></div>
        </li></ul>
        <?php }?>
        </div>
</div>
<!--/row-->
<div class="row">
        <div class="col-md-6">
            <div class="form-group">
                    <label class="control-label col-md-5">Phone 1 : </label>
                    <div class="col-md-6">
                        <input type="text" name="exs_phone_no_2" id="exs_phone_no_2" class="form-control" value="<?php echo $details['dealer_contact_no2'];?>" readonly="">
                    </div>
                    <div class="col-md-1">
                        <div class="form-md-radios">
                                <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" id="radio6" name="exs_phone_no_active" id="no_2" class="md-radiobtn" value="2">
                                                <label for="radio6">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                                </label>
                                        </div>
                                </div>
                        </div>
                    </div>
            </div>
        </div> 
        <div class="col-md-2">
        <label class="switch"><input type="checkbox" name="exs_phone_no_2_reachable" value="1" <?php if($details['dealer_contact_no2_reachable']==1){?>  checked="" <?php }?>><span class="slider round"></span></label>
        </div>
        <div class="col-md-3">
        <?php if($details['dealer_contact_no2_check_date'] != ""){ ?>
        <ul class="feeds"><li>
        <div class="date"><?php echo date("m-d-Y", strtotime($details['dealer_contact_no2_check_date'])); ?></div>
        </li></ul>
        <?php }?>
        </div>
</div>
<!--/row-->
<div class="row">
        <div class="col-md-6">
            <div class="form-group">
                    <label class="control-label col-md-5">Phone 2 : </label>
                    <div class="col-md-6">
                        <input type="text" name="exs_phone_no_3" id="exs_phone_no_3" class="form-control" value="<?php echo $details['dealer_contact_no3'];?>" readonly="">
                    </div>
                    <div class="col-md-1">
                        <div class="form-md-radios">
                                <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" id="radio7" name="exs_phone_no_active" id="no_3" class="md-radiobtn" value="3">
                                                <label for="radio7">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                                </label>
                                        </div>
                                </div>
                        </div>
                    </div>
            </div>
        </div> 
        <div class="col-md-2">
            <label class="switch"><input type="checkbox" name="exs_phone_no_3_reachable" value="1" <?php if($details['dealer_contact_no3_reachable']==1){?>  checked="" <?php }?>><span class="slider round"></span></label>
        </div>
        <div class="col-md-3">
        <?php if($details['dealer_contact_no3_check_date'] != ""){ ?>
        <ul class="feeds"><li>
        <div class="date"><?php echo date("m-d-Y", strtotime($details['dealer_contact_no3_check_date'])); ?></div>
        </li></ul>
        <?php }?>
        </div>
</div>
<!--/row-->
<div class="row">
        <div class="col-md-6">
            <div class="form-group">
                    <label class="control-label col-md-5">New Number : </label>
                    <div class="col-md-6">
                        <input type="text" name="exs_phone_no_4" id="exs_phone_no_4" class="form-control">
                    </div>
                    <div class="col-md-1">
                        <div class="form-md-radios">
                                <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" id="radio8" name="exs_phone_no_active" id="no_4" class="md-radiobtn" value="4">
                                                <label for="radio8">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                                </label>
                                        </div>
                                </div>
                        </div>
                    </div>
            </div>
        </div> 
        <div class="col-md-2">
        <label class="switch"><input type="checkbox" name="exs_phone_no_4_reachable" value="1"><span class="slider round"></span></label>
        </div>
</div>
<!--/row-->
            
<?php }} ?>
