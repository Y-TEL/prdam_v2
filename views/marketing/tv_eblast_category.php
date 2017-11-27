<?php
/**
 * Description of User
 *
 * @author Nirushika
 */
session_start();

require_once '../../includes/views/define_include.php';
require '../../classes/marketing/tv_eblast.php';

$loginManager = new LoginManager();
$logerHD = new LoggerHD();

if (!$loginManager->confirm_member()) {
    header('Location: ../../index.php');
}

$page = new Page();
$page->setIcon("iconfa-home");
$page->setHeader("Eblast Page");
$page->setTag_line("tv_eblast_view");
$page->setMenu_active("dealer_promo");
$page->setMenu_group("Marketing_Department");

$drop_downs = new DropDownlist();
$drop_down_tv_category = $drop_downs->getAllTVCategory();

?>
<!DOCTYPE html>

<html lang="en">

<head>
    
<link href="<?php echo SITEURL ?>/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo SITEURL ?>/assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css"/>
<!-- class head -->
<?php require("../../includes/views/head_1.php") ?>
<!-- class head -->  

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-54229307-6', 'auto');
  ga('send', 'pageview');

</script>

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
                                        <div class="col-md-4 col-sm-4"></div>
                                        
					<div class="col-md-4 col-sm-4">
					<div class="portlet box blue-steel">
						<div class="portlet-title">
							<div class="caption">
							Select E-Blast Category
							</div>
							
						</div>
                                                <div class="portlet-body">
                                                            <?php foreach ($drop_down_tv_category as $value) { ?>
                                                            <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="top-news" style="width: 60%; margin-left: 20%; margin-right: 20%;">
                                                                            <a href="tv_eblast_gallery?id=<?php echo $value['tv_cat_id'] ;?>" class="btn green">
                                                                            <span>
                                                                            <?php echo $value['tv_cat_name']; ?> </span>
<!--                                                                            <i class="fa fa-globe top-news-icon"></i>-->
                                                                            </a>
                                                                    </div>
                                                                    </div>
                                                                    <div class="margin-bottom-10 visible-sm">
                                                                    </div>
                                                            </div>
                                                            <?php } ?>
                                                            

                                                    </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4 col-sm-4"></div>
                   
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
