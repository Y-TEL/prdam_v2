<?php

require_once '../../includes/views/define_include.php';
require '../../classes/marketing/pro_updates.php';
include("../mpdf/mpdf.php");

ini_set('max_execution_time', 400); 

date_default_timezone_set('Asia/Colombo');
@$today = date('Y-m-d');

$productList = new Product();	
$id = $_GET['id'];

$detail = $productList->viewSelectedProsuct($id); 

$html = '<div style="border: 1px solid #DFDFDF; padding:25px;">
<div style="margin:2px; text-align: center; font-size: 16px; font-weight:900;">Product Updates
<div style="margin-left:80%; margin-top:5px;"> Date : '; $html .= $detail['news_entered_date']; $html .='</div>';

//#############################################################
$html .= '<div style="margin-left:5px; margin-right:5px;">  
            <div class="view_table_div">
            <table width="100%" border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td width="15%" height="30"><span class="tdtext"><strong>Image : </strong></span></td>
              <td width="85%"><span class="tdtext"><img src="'.SITEURL.'/uploads/pro_updates/'; $html .= $detail['news_image']; $html .='" style="width:100px;height:100px;margin:0px 11px 0px 11px; "></span></td>
            </tr>
            <tr>
              <td width="15%" height="30"><span class="tdtext"><strong>Department : </strong></span></td>
              <td width="85%"><span class="tdtext">'; $html .= $detail['news_dept']; $html .='</span></td>
            </tr>
            <tr>
              <td width="15%" height="30"><span class="tdtext"><strong>Subject : </strong></span></td>
              <td width="85%"><span class="tdtext">'; $html .= $detail['news_subject']; $html .='</span></td>
            </tr>
            <tr>
              <td width="15%" height="30"><span class="tdtext"><strong>Description : </strong></span></td>
              <td width="85%"><span class="tdtext"></span></td>
            </tr>
            <tr>
              <td colspan="2" width="100%"><span class="tdtext">'; $html .= $detail['news_body']; $html .='</span></td>
            </tr>
          </table></div></div>';
//#############################################################
              
$html .= '</div></div><div style=" position:fixed;bottom:0px; clear:both;"></div>';

$mpdf=new mPDF('','A4','9','Arial',3,3,3,3,1,1,'');
$mpdf->SetDisplayMode('fullpage');
// LOAD a stylesheet
$stylesheet = file_get_contents('../../assets/global/css/view_table.css');
$mpdf->WriteHTML($stylesheet,1); // The parameter 1 tells that this is css/style only and no
$mpdf->WriteHTML($html);

$mpdf->Output();
exit;
?>
