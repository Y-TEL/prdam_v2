<?php
/**
 * Description of User
 *
 * @author Nirushika
 */
session_start();

require_once '../../includes/views/define_include.php';

$loginManager = new LoginManager();
$logerHD = new LoggerHD();

if (!$loginManager->confirm_member()) {
    header('Location: ../../index.php');
}

$page = new Page();
$page->setIcon("iconfa-home");
$page->setHeader("View_APN_Device");
$page->setTag_line("apn_device_settings");
$page->setMenu_active("Carrier_Page");
$page->setMenu_group("Marketing_Department");

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
                            <div class="portlet grey-cascade">
                            <div class="portlet-title">
                                    <div class="caption">
                                            <i class=""></i>APN and Device Settings
                                    </div>
                                    <div class="tools">
                                    </div>
                            </div>
                            <div class="portlet-body">
                                
				<div class="col-md-12 well well-lg">
                                        <h1 style="font-weight:500">
                                                 APN Settings for phones with SIM cards (GSM)
                                        </h1
                                                
					<p>Customers who would like to use their own GSM phones to access the ROK Mobile network may need to modify the APN (Access Point Name) settings of their phone manually.</p>
                                        <p>The critical APN information that is required for any GSM phone new to ROK Mobile is:</p>
                                        
					<ul class="list-unstyled margin-top-10 margin-bottom-10">
						<li>
							<i class="fa fa-check icon-default"></i> APN: wholesale
						</li>
						<li>
							<i class="fa fa-check icon-success"></i> MMS URL:http://wholesale.mmsmvno.com/mms/wapenc
						</li>
						<li>
							<i class="fa fa-check icon-danger"></i> All of the other settings are not used during this process
						</li>
					</ul>
					<p>After changing your APN settings please be sure to power down the phone, remove the battery for 60 seconds and then re-power the phone to test the new settings. </p>
				</div>
                            
                                <div class="col-md-12 well well-lg">
                                        <h1 style="font-weight:500">
                                                 Android - Detailed Overview
                                        </h1
                                                
                                        <p></p>
                                        
					<ol class="margin-top-10 margin-bottom-10">
						<li>
							Go to Settings
						</li>
						<li>
							Go to Mobile Data (Some phones say &quot;more&quot; or &quot;Wireless & networks&quot;)
						</li>
						<li>
							Go to Mobile Networks (Some phones have &quot;Access Point Names&quot; instead)
						</li>
                                                <li>
							Go to Access Point Names
						</li>
						<li>
							Press the Menu button and select New APN
						</li>
						<li>
							Use the following profile:
                                                        <ol>
                                                            <li>Name: ROK Mobile</li>
                                                            <li>APN: wholesale</li>
                                                            <li>Proxy:</li>
                                                            <li>Port:</li>
                                                            <li>Username:</li>
                                                            <li>Password:</li>
                                                            <li>Server:</li>
                                                            <li>MMSC: http://wholesale.mmsmvno.com/mms/wapenc</li>
                                                            <li>MMS Proxy:</li>
                                                            <li>MMS Port:</li>
                                                            <li>MCC: 310</li>
                                                            <li>MNC: 260</li>
                                                            <li>APN Type: default,supl,mms,admin</li>
                                                        </ol>
						</li>
                                                
                                                <li>
							Choose Menu, then Save
						</li>
						<li>
							Go back one screen. You will see the APN list
						</li>
						<li>
							Tap on the dot next to the ROK Mobile APN. This will enable the APN
						</li>
                                                <li>
							Restart the phone
						</li>
						<li>
							Test the data connection
						</li>
						<li>
                                                    Full information can be found at <a href="http://support.t-mobile.com/docs/DOC-2090" target="_blank">http://support.t-mobile.com/docs/DOC-2090</a>
						</li>
					</ol>
				</div>
                            
                                <div class="col-md-12 well well-lg">
                                        <h1 style="font-weight:500">
                                                 iOS 6 or Later - Detailed Overview
                                        </h1
                                                
                                        <p></p>
                                        
					<ol class="margin-top-10 margin-bottom-10">
						<li>
							Go to Settings -> WiFi and turn WiFi OFF
						</li>
						<li>
							Go to Settings -> Messages
						</li>
						<li>
							Turn MMS to OFF
						</li>
                                                <li>
							Go to Settings -> General -> Cellular
						</li>
						<li>
							Turn Data Roaming to ON and Enable 3G to OFF
						</li>
                                                <li>
							Go to Cellular Data Network and use the following profile:
						
                                                        <ol>
                                                            <li>Cellular Data APN: wholesale</li>
                                                            <li>MMS APN: wholesale</li>
                                                            <li>MMSC : http://wholesale.mmsmvno.com/mms/wapen</li>
                                                            <li>MMS Max Message Size: 1038576</li>
                                                            <li>MMS UA Prof URL: http://www.apple.com/mms/uaprof.rdf</li>
                                                            <li>Leave other fields blank</li>
                                                            <li>Go to Settings -> Messages and turn it ON</li>
                                                            <li>Send a test MMS to confirm it works</li>
                                                            <li>Go back and</li>
                                                            <li>Turn Data Roaming OFF</li>
                                                            <li>Turn Enable 3G to ON</li>
                                                        </ol>
						</li>
                                                <li>
							Have the user test by visiting a web page in Safari to confirm data is working
						</li>
						<li>
							Turn WiFi back ON.
						</li>
					</ol>
                                        <p> Further resources can be found at <a href="http://support.apple.com/kb/ht2283" target="_blank">http://support.apple.com/kb/ht2283</a></p>
				</div>
                                
                                <div class="col-md-12 well well-lg">
                                        <h1 style="font-weight:500">
                                                 ROK Mobile GSM: APN Settings
                                        </h1
                                                
                                        <p>ROK Mobile recommends performing a master reset on all devices prior to inserting the ROK GSM SIM card. If a master reset is not possible, please delete any carrier/network profiles, and reset the network settings on the device.</p>
                                        <p></p>
                                        <h4><b>Android/IOS Phones</b></h4>
                                        
					<ul class="margin-top-10 margin-bottom-10">
						<li>
							Name: NXTGENPHONE
						</li>
						<li>
							APN: NXTGENPHONE
						</li>
                                                <li>
							MMSC: http://mmsc.mobile.att.net
						</li>
						<li>
							MMS proxy: proxy.mobile.att.net
						</li>
                                                <li>
							MMS port: 80
						</li>
						<li>
							MCC: 310
						</li>
                                                <li>
							MNC: 410
						</li>
                                                <li>
							APN Type: default, mms, supl, hipri
						</li>
                                                <li>
							APN Protocol: IPv4
						</li>
					</ul>
                                        
                                        <p></p>
                                        <h4><b>Windows Phones</b></h4>
                                        
                                        <ul class="margin-top-10 margin-bottom-10">
						<li>
							APN: NXTGENPHONE
						</li>
						<li>
							APN Type: IPv4v6
						</li>
                                                <li>
							WAP Gateway: proxy.mobile.att.net
						</li>
						<li>
							WAP Gateway Port: 80
						</li>
                                                <li>
							MMSC: http://mmsc.mobile.att.net
						</li>
						<li>
							Max Message Size: 600k
						</li>
                                                <li>
							IP Type: IPv4v6
						</li>
					</ul>
                                        
                                        <p></p>
                                        <h4><b>Tablets</b></h4>
                                        
                                        <ul class="margin-top-10 margin-bottom-10">
						<li>
							Name: ATT Broadband
						</li>
						<li>
							APN: Broadband
						</li>
                                                <li>
							MCC: 310
						</li>
						<li>
							MNC: 410
						</li>
                                                <li>
							APN Type: default, mms, supl, hipri, fota
						</li>
						<li>
							APN Protocol: enabled
						</li>
					</ul>
                                        <p>ROK Mobile Dealer Support: 909.597.7300</p>
				</div>
                                
                              </div>
                            </div>
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