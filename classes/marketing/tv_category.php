<?php

/**
 * Description of User
 *
 * @author Nirushika
 */

date_default_timezone_set('America/New_York');

class Category {

   private $db;

    public function __construct() {

    try {
            $this->db = new Connection();
            $this->db = $this->db->dbConnect();
        } catch (PDOException $e) {
            die('ERROR:' . $e->getMessage());
        }
    }

    public function addCategory($cat_name){
              
        $query = "INSERT INTO ".RDAMS_TV_CATEGORY." (tv_cat_name) VALUES (?)";
				
        $stmt = $this->db->prepare($query);
        
         //echo var_export($stmt->errorInfo());
        
        $stmt->bindParam(1, $cat_name);
        
        $stmt->execute();
       
        $logerHD = new LoggerHD();
        $logerHD->WriteLog('|-|'.'['.date('Y-m-d h:i:s a').' -- Create (TV Ctegory - '.$_SESSION['first_name'].' :-: '.$_SESSION['user_name'].' :-: '.date('Y-m-d h:i:s').' :-: '.'Category='.$cat_name.':-::-:)]'.'|-|');

        $results = $stmt->rowCount();
        
        if ($results > 0) {
            return $msg = "Successfully Added";
        } else {
            return $msg = "Something went wrong. Try again";
        }
    }
    
    public function viewCategoryList() {
        
        $query = "SELECT * FROM ".RDAMS_TV_CATEGORY." WHERE tv_cat_active=1 ORDER BY tv_cat_id DESC";
        
        $stmt = $this->db->prepare($query);

        $stmt->execute();
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();
        
        $rows = $stmt->fetchAll();
        return $rows;
    }
    

    public function viewSelectedcategory($id){
        
      $query = "SELECT * FROM ".RDAMS_TV_CATEGORY." WHERE tv_cat_id=? ";
        
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

   public function updateCategory($cat_name,$id){

        $query = "UPDATE ".RDAMS_TV_CATEGORY." SET tv_cat_name=? WHERE tv_cat_id=?";
		
        $stmt = $this->db->prepare($query);
		
        $stmt->bindParam(1, $cat_name);
        $stmt->bindParam(2, $id); 
        
        $stmt->execute();
        
        $logerHD = new LoggerHD();
        $logerHD->WriteLog('|-|'.'['.date('Y-m-d h:i:s a').' -- Update (TV Ctegory - '.$_SESSION['first_name'].' :-: '.$_SESSION['user_name'].' :-: '.date('Y-m-d h:i:s').' :-: '.'Category='.$cat_name.':-::-:)]'.'|-|');

        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();

        if ($results > 0) {
            return $msg = "Updated " . $results . " record";
        } else {
            return $rows = "";
        }
    }
    
    public function DeleteCategory($iid) {

        $query = "UPDATE ".RDAMS_TV_CATEGORY." SET tv_cat_active=0 WHERE tv_cat_id=?";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $iid);
		
        $stmt->execute();
        
        $logerHD = new LoggerHD();
        $logerHD->WriteLog('|-|'.'['.date('Y-m-d h:i:s a').' -- Delete (TV Ctegory - '.$_SESSION['first_name'].' :-: '.$_SESSION['user_name'].' :-: '.date('Y-m-d h:i:s').' :-: '.'Category ID='.$iid.':-::-:)]'.'|-|');

        $results = $stmt->rowCount();
    }
   
}
?>
