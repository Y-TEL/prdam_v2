<?php 
require_once '../../includes/views/define_include.php';
require '../../classes/shipping/orders.php';

if(isset($_GET['order_bl_code']))   {   $order_bl_code = $_GET['order_bl_code']; }     else { $order_bl_code = ""; }
$order = new Orders();
$details = $order->viewSelectedDealerDetails($order_bl_code); 
?>

<div class="row">
        <div class="col-md-6">
                <div class="form-group">
                        <label class="control-label col-md-5">Dealer Code : <span style="font-size:14px; color:#D90000;" >*</span></label>
                        <div class="col-md-6">
                                <input type="text" name="order_dealer_code" id="order_dealer_code" class="form-control" value="<?php if(isset($details['dealer_code'])){ echo $details['dealer_code']; }else { echo "";}?>" readonly="">
                        </div>
                </div>
        </div>
        <!--/span-->

        <div class="col-md-6">
                <div class="form-group">
                        <label class="control-label col-md-5">Market : </label>
                        <div class="col-md-6">
                            <input type="text" name="dealer_market" id="dealer_market" class="form-control" value="<?php if(isset($details['market_name'])){ echo $details['cus_type_name']; }else { echo "";}?>" readonly="">
                        </div>
                </div>
        </div>
        <!--/span-->

  </div>
<!--/row-->

<div class="row">
        <div class="col-md-6">
                <div class="form-group">
                        <label class="control-label col-md-5">Store Name : </label>
                        <div class="col-md-6">
                                <input type="text" name="store_name" id="store_name" class="form-control" value="<?php if(isset($details['dealer_store_name'])){ echo $details['dealer_store_name']; }else { echo "";}?>" readonly="">
                        </div>
                </div>
        </div>
        <!--/span-->

        <div class="col-md-6">
                <div class="form-group">
                        <label class="control-label col-md-5">First Name : </label>
                        <div class="col-md-6">
                            <input type="text" name="contact_name" id="contact_name" class="form-control" value="<?php if(isset($details['dealer_fname'])){ echo $details['dealer_fname']; }else { echo "";}?>" readonly="">
                        </div>
                </div>
        </div>
        <!--/span-->

  </div>
<!--/row-->

<div class="row">
        <div class="col-md-6">
                <div class="form-group">
                        <label class="control-label col-md-5">Contact Number : </label>
                        <div class="col-md-6">
                            <input type="text" name="dealer_cont_no" id="dealer_cont_no" class="form-control" value="<?php if(isset($details['dealer_contact_no'])){ echo $details['dealer_contact_no']; }else { echo "";}?>" readonly="">
                        </div>
                </div>
        </div>
        <!--/span-->

        <div class="col-md-6">
                <div class="form-group">
                        <label class="control-label col-md-5">Email Address : </label>
                        <div class="col-md-6">
                                <input type="text" name="email_address" id="email_address" class="form-control" value="<?php if(isset($details['dealer_email'])){ echo $details['dealer_email']; }else { echo "";}?>" readonly="">
                        </div>
                </div>
        </div>
        <!--/span-->
  </div>
<!--/row-->

<div class="row">
   <div class="col-md-6">
            <div class="form-group">
                    <label class="control-label col-md-5">Billing Address : </label>
                    <div class="col-md-6">
                        <input type="text" name="billing_address" id="billing_address" class="form-control" value="<?php if(isset($details['dealer_billing_addrs'])){ echo $details['dealer_billing_addrs']; }else { echo "";}?>" readonly="">
                    </div>
            </div>
    </div>
    <!--/span-->
    
    <div class="col-md-6">
            <div class="form-group">
                    <label class="control-label col-md-5">Shipping Address : </label>
                    <div class="col-md-6">
                        <input type="text" name="shipping_address" id="shipping_address" class="form-control" value="<?php if(isset($details['dealer_shipping_addrs'])){ echo $details['dealer_shipping_addrs']; }else { echo "";}?>" readonly="">
                    </div>
            </div>
    </div>
    <!--/span-->
     

  </div>
<!--/row-->