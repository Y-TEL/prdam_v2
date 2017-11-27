<?php
session_start();
require_once '../../includes/views/define_include.php';
require '../../classes/marketing/dealer.php';

$dealer = new Dealer();

$email = $_GET['email']; 
$pass  = $_GET['pass']; 

if(($email!= "")&($pass!= "")){ 

$conf_code = mt_rand(10000,99999);
$_SESSION['verify_code'] = $conf_code;     
//<-----------------------========== Start send email===========-------------------------------------------->
        $from = "info@rdams.com";

        $to = $email;
        //$to = "nirushika@witellsolutions.com";

        $headers = "From: " . $from. "\r\n";

        $headers .= "Reply-To: ".$from. "\r\n";

        $headers .= "MIME-Version: 1.0\r\n";

        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $email_subject="Wireless Shop - Dealer Login Info";
        
        $email_message .= "<p>Hi,</p>";
        
        $email_message .= "<p>Please verify your account with this loging information (http://portal.wirelessshoponline.com/).</p>";

        $email_message .= '<table rules="all" style="border-color: #fff;" border="1" cellpadding="10" width="100%">';
        
        $email_message .= "<tr style='background: #F5F5F5;'><td width='25%'><strong>Username : </strong> </td><td>".$email."</td></tr>";
        
        $email_message .= "<tr style='background: #F5F5F5;'><td width='25%'><strong>Password : </strong> </td><td>".$pass."</td></tr>";

        $email_message .= "<tr style='background: #F5F5F5;'><td width='25%'><strong>Verification Code : </strong> </td><td>".$conf_code."</td></tr>";

        $email_message .= "</table>";
        
        $email_message .= "<p>Thanks!</p>";

    mail($to, $email_subject, $email_message, $headers); 
//<-----------------------========== End send email===========-------------------------------------------->

echo '<span class="label label-success"> Success </span>';

}else{
echo '<span class="label label-danger"> Enter Email </span>';   
}

?>
