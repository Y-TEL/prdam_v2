<?php
session_start();
require_once '../../classes/util/connection.php';
require_once '../../classes/marketing/file_upload.php';

define('RDAMS_GRAPHICS_MAIN_CATEGORY', 'rdams_graphics_main_category');
define('RDAMS_GRAPHICS_SUB_CATEGORY', 'rdams_graphics_sub_category');
define('RDAMS_GRAPHICS_BUSINESS_NAME', 'rdams_graphics_business_name');
define('RDAMS_GRAPHICS_PAPER_SIZE', 'rdams_graphics_paper_size');
define('RDAMS_GRAPHICS_UPLOADED_FILES', 'rdams_graphics_uploaded_files');

	$maincategory = $_POST["maincategory"];
    $subCategory = $_POST["subCategory"];
	$businessName = $_POST["businessName"];
	$dealertype = $_POST["dealertype"];
	$carrier = $_POST["carrier"];
	$designedBy = $_POST["designedBy"];
	$name = $_POST["flyer_name"];
	$daterange = $_POST["daterange"];
	
	if(!empty($name)){
		$name = "%".$name."%";
	}

    $file_upload = new gDriveUpload();			             
	$viewUploadedFiles = $file_upload->searchUploadedFiles($maincategory,$subCategory,$businessName,$dealertype,$carrier,$designedBy,$name,$daterange);		
	if(!empty($viewUploadedFiles)){
                                                    foreach ($viewUploadedFiles as $fileList) {
                                                    
                                                     // $imgLocation = "http://www.shop.wirelesscorner.net/api1/images/".$fileList["main_category"]."/".$fileList["file_name"];
													 //$imgLocation = "https://rdams.com/eblast_files/images/".$fileList["main_category"]."/".$fileList["file_name"];
													 $imgLocation = "https://rdams.com/eblast_files/images/".$fileList["main_category"]."/".$fileList["file_name"];
                                                        ?>
        <div class="col-md-2 col-sm-2">            
            <div class="thumbnail">
			<div id="uuu" style="background-image:url(<?php echo $imgLocation; ?>)"></div>
              <!-- <img src="<?php echo $imgLocation; ?>" /> -->
				  <div class="caption" style="text-align:center">      
					<a href="" class="label label-info" data-item-id="<?php echo $fileList["file_name_id"]; ?>" data-item-status="2" data-toggle="modal" data-target="#returninvoiceModal" title="View"><i class="fa fa-eye"></i></a>
					<?php if (isset($_SESSION['user_permissions']['designer_gallery_download_image']) && $_SESSION['user_permissions']['designer_gallery_download_image'] == '1') { ?>
					<a href="download?file=<?php echo $imgLocation; ?>" class="label label-info" rel="tooltip" title="Download"><i class="fa fa-download"></i></a>
					<a href="file_upload_edit.php?id=<?php echo $fileList["file_name_id"]; ?>" class="label label-info" rel="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
					<a href="file_list_folders.php?delete_id=<?php echo $fileList["file_name_id"]; ?>" class="label label-danger" rel="tooltip" title="Delete" onclick="return confirm('Are you sure you want to Delete?')"><i class="fa fa-times"></i></a>                  		
                    <?php } ?>
				  </div>
            </div>
        </div>	    
                                                    <?php
                                                    }
													} else{
														echo "<div style='margin-left:40px;'>No Records Found</div>";
													}
                                                    ?>    

													
												

