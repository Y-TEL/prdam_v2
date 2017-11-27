<?php 
require_once '../../includes/views/define_include.php';
require '../../classes/marketing/tv_eblast.php';


if(isset($_GET['tv_cat']))   {   $tv_cat = $_GET['tv_cat']; }     else { $tv_cat = ""; }

$EblastList = new eBlast(); 
$Eblast_list = $EblastList->viewEblastListSelectedCat($tv_cat);
?>

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