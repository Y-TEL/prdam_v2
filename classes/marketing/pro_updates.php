<?php

/**
 * Description of User
 *
 * @author Nirushika
 */

date_default_timezone_set('America/New_York');

class Product {

   private $db;

    public function __construct() {

    try {
            $this->db = new Connection();
            $this->db = $this->db->dbConnect();
        } catch (PDOException $e) {
            die('ERROR:' . $e->getMessage());
        }
    }
    
    public function addNewProduct($news,$subject,$department,$news_image,$entered_by,$created_date,$created_time){
              
        $query = "INSERT INTO ".RDAMS_PRODUCT_UPDATE." (news_body,news_subject,news_dept,news_image,news_entered_by,news_entered_date,news_entered_time) VALUES (?,?,?,?,?,?,?)";
				
        $stmt = $this->db->prepare($query);
        
         //echo var_export($stmt->errorInfo());
        
        $stmt->bindParam(1, $news);
        $stmt->bindParam(2, $subject);
        $stmt->bindParam(3, $department);
        $stmt->bindParam(4, $news_image);
        $stmt->bindParam(5, $entered_by); 
        $stmt->bindParam(6, $created_date); 
        $stmt->bindParam(7, $created_time);
        
        $stmt->execute();
       
        $logerHD = new LoggerHD();
        $logerHD->WriteLog('|-|'.'['.date('Y-m-d h:i:s a').' -- Create (Product - '.$_SESSION['first_name'].' :-: '.$_SESSION['user_name'].' :-: '.date('Y-m-d h:i:s').' :-: '.'Subject='.$subject.' :-: '.'Product Update= :-::-:)]'.'|-|');

        $results = $stmt->rowCount();
        
        if ($results > 0) {
            return $msg = "Successfully Added";
        } else {
            return $msg = "Something went wrong. Try again";
        }
    }
    
    public function viewProductList() {
        
        $query = "SELECT * FROM ".RDAMS_PRODUCT_UPDATE." WHERE news_active=1 ORDER BY news_id DESC";
        
        $stmt = $this->db->prepare($query);

        $stmt->execute();
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();
        
        $rows = $stmt->fetchAll();
        return $rows;
    }
    
    public function viewProductListlatest() {
        
        $query = "SELECT * FROM ".RDAMS_PRODUCT_UPDATE." WHERE news_active=1 ORDER BY news_id DESC LIMIT 15";
        
        $stmt = $this->db->prepare($query);

        $stmt->execute();
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();
        
        $rows = $stmt->fetchAll();
        return $rows;
    }

    public function viewSelectedProsuct($id){
        
      $query = "SELECT * FROM ".RDAMS_PRODUCT_UPDATE." "
              . "LEFT  JOIN ".RDAMS_EMP_DEPARTMENT." ON  (".RDAMS_PRODUCT_UPDATE.".news_dept = ".RDAMS_EMP_DEPARTMENT.".dep_id)"
              . "WHERE news_id=? ";
        
        $stmt = $this->db->prepare($query);
   
        $stmt->bindParam(1, $id);
        $stmt->execute();
     
        $results = $stmt->rowCount();

        if ($results > 0) {
            $rows = $stmt->fetch();
            return $rows;
        } else {
            return $rows = "No records found";
        }
    } 

   public function UpdateNews($news, $subject, $department, $news_image,$id){

        $query = "UPDATE ".RDAMS_PRODUCT_UPDATE." SET news_body=?,news_subject=?,news_dept=?,news_image=? WHERE news_id=?";
		
        $stmt = $this->db->prepare($query);
		
        $stmt->bindParam(1, $news);
        $stmt->bindParam(2, $subject);
        $stmt->bindParam(3, $department);
        $stmt->bindParam(4, $news_image);
        $stmt->bindParam(5, $id); 
        
        $stmt->execute();
        
        $logerHD = new LoggerHD();
        $logerHD->WriteLog('|-|'.'['.date('Y-m-d h:i:s a').' -- Update (Product - '.$_SESSION['first_name'].' :-: '.$_SESSION['user_name'].' :-: '.date('Y-m-d h:i:s').' :-: '.'Product ID='.$id.' :-: '.'Subject='.$subject.' :-: '.'Product Update= :-::-:)]'.'|-|');

        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();

        if ($results > 0) {
            return $msg = "Updated " . $results . " record";
        } else {
            return $rows = "";
        }
    }
	
    public function DeleteProductUpdate($iid) {

        $query = "UPDATE ".RDAMS_PRODUCT_UPDATE." SET news_active=0 WHERE news_id=?";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $iid);
		
        $stmt->execute();
        
        $logerHD = new LoggerHD();
        $logerHD->WriteLog('|-|'.'['.date('Y-m-d h:i:s a').' -- Delete (Product - '.$_SESSION['first_name'].' :-: '.$_SESSION['user_name'].' :-: '.date('Y-m-d h:i:s').' :-: '.'Product ID='.$iid.':-::-:)]'.'|-|');

        $results = $stmt->rowCount();
    }
  
}
?>
