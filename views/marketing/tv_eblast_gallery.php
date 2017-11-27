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
$page->setTag_line("tv_eblast_gallery");
$page->setMenu_active("dealer_promo");
$page->setMenu_group("Marketing_Department");

$tv_cat = $_GET['id'];
$EblastList = new eBlast(); 
$Eblast_list = $EblastList->viewEblastListSelectedCat($tv_cat);

$drop_downs = new DropDownlist();
$drop_down_tv_category = $drop_downs->getAllTVCategory();
?>
<!DOCTYPE html>

<html lang="en">

<head>

<!-- class head -->
<?php require("../../includes/views/head_1.php") ?>
<!-- class head -->

<!-- Gallery Start -->
<link rel="stylesheet" href="swipebox/swipeboxdemo/normalize.css">
<!--<link rel="stylesheet" href="swipebox/demo/bagpakk.min.css">-->
<link rel="stylesheet" href="swipebox/demo/style.css">
<link rel="stylesheet" href="swipebox/src/css/swipebox.css">
<!-- share buttons -->
<script type="text/javascript">
    (function(doc, script) {
        var js, 
        fjs = doc.getElementsByTagName(script)[0],
        add = function(url, id) {
        if (doc.getElementById(id)) {return;}
        js = doc.createElement(script);
        js.src = url;
        id && (js.id = id);
        fjs.parentNode.insertBefore(js, fjs);
        };add("//connect.facebook.net/en_US/all.js#xfbml=1", "facebook-jssdk");
        add("//platform.twitter.com/widgets.js", "twitter-wjs");
        }(document, "script"));
</script>
<!-- end share buttons -->
<!-- Gallery End -->  

<script type="text/javascript">
/*function Brand_Select()
{ 
    tv_cat = document.getElementById('tv_cat').value;
    
    if(tv_cat =="All"){
        $("#eblast_all_view").show(); 
        $("#eblast_cat_view").hide(); 
      
    }else{
      
        $("#eblast_all_view").hide();
        $("#eblast_cat_view").show();
    
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		 xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		 xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
		
		//alert(item_det_id);
		xmlhttp.onreadystatechange=function()
		{//7
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{//8
			document.getElementById('eblast_cat_view').innerHTML=xmlhttp.responseText;
                        }
		}
		xmlhttp.open("GET","select_eblast_category_view.php?tv_cat="+tv_cat,true);
		xmlhttp.send();
    
    }
}*/
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
			
                        <div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
                                            <h3>E-Blast Gallery</h3>
					</li>
					
				</ul>
                            <div class="page-toolbar" style=" margin-top: 15px;">
                                <a href="tv_eblast_category" class="btn grey-cascade" style="text-decoration:none;" ><i class="fa fa-angle-left"></i> Back</a>
<!--					<label class="col-md-4 control-label" style="margin-top: 5px;">Category</label>
                                        <div class="col-md-8">
                                            <select class="form-control" name="tv_cat" id="tv_cat" onchange="Brand_Select();">                                        
                                                <option value="All" selected="true" >All</option>
                                                <?php foreach ($drop_down_tv_category as $value) { ?>
                                                    <option value="<?php echo $value['tv_cat_id']; ?>"><?php echo $value['tv_cat_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>-->
				</div>
			</div>
			<!-- BEGIN PAGE HEADER-->
			
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
                                    <div id="eblast_all_view">
                                        <?php  foreach ($Eblast_list as $data) { ?>   
                                        <div class="col-md-3 col-sm-4">
                                                <ul id="box-container">
                                                        <li class="box">
                                                                <?php if ($data['tv_eblast_image']!=NULL){ ?>
                                                                <a href="<?php echo SITEURL ?>/uploads/tv_eblast/<?php echo $data['tv_eblast_image']?>" class="swipebox" title="<?php echo $data['tv_eblast_name']; ?>">
                                                                    <img src="<?php echo SITEURL ?>/uploads/tv_eblast/<?php echo $data['tv_eblast_image']?>" alt="image">
                                                                </a>
                                                                <?php }else{ ?> 
                                                                <a href="#" class="swipebox" title="<?php echo $data['tv_eblast_name']; ?>">
                                                                    <img src="<?php echo SITEURL ?>/assets/resources/images/no_image.jpg" alt="image" >
                                                                </a>
                                                                <?php } ?>
                                                        </li>
                                                </ul>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    
                                    <div id="eblast_cat_view">
                                                        
                                    </div>
										
                                    
<!--					<section id="exemple" class="container">
                                                <div class="wrap small-width">
                                                        <div id="try"></div>
                                                        <ul id="box-container">
                                                                <?php  foreach ($Eblast_list as $data) { ?>   
                                                                <li class="box">
                                                                        <a href="<?php echo SITEURL ?>/uploads/tv_eblast/<?php echo $data['tv_eblast_image']?>" class="swipebox" title="<?php echo $data['tv_eblast_name']; ?>">
                                                                                <img src="<?php echo SITEURL ?>/uploads/tv_eblast/<?php echo $data['tv_eblast_image']?>" alt="image">
                                                                        </a>
                                                                </li>
                                                                <?php } ?>
                                                                
                                                        </ul>
                                                </div>
                                        </section>-->
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

<script src="swipebox/lib/ios-orientationchange-fix.js"></script>
<script src="swipebox/lib/jquery-2.1.0.min.js"></script>
<script src="swipebox/src/js/jquery.swipebox.js"></script>
<script type="text/javascript">
$( document ).ready(function() {

    /* Basic Gallery */
    $( '.swipebox' ).swipebox();

    /* Video */
    $( '.swipebox-video' ).swipebox();

    /* Dynamic Gallery */
    $( '#gallery' ).click( function( e ) {
            e.preventDefault();
            $.swipebox( [
                    { href : 'http://swipebox.csag.co/mages/image-1.jpg', title : 'My Caption' },
                    { href : 'http://swipebox.csag.co/images/image-2.jpg', title : 'My Second Caption' }
            ] );
    } );

});
</script>

</body>

<!-- END BODY -->
</html>

