<?php
require_once '../../includes/views/define_include.php';
require '../../classes/marketing/dealer.php';

$dealer = new Dealer();

$user_name = $_POST['username'];

if(isset($user_name)){
    
$msg = $dealer->verifyUsername($user_name);
	if($msg>='1'){
		echo 'no';
	}else {
		echo 'yes';
	}
}

?>
