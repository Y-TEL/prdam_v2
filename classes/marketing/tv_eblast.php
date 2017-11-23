<?php

/**
 * Description of User
 *
 * @author Nirushika
 */

date_default_timezone_set('America/New_York');

class eBlast {

   private $db;

    public function __construct() {

    try {
            $this->db = new Connection();
            $this->db = $this->db->dbConnect();
        } catch (PDOException $e) {
            die('ERROR:' . $e->getMessage());
        }
    }
    
    public function addNewEblast($eblast_name,$eblast_image,$eblast_category,$eblast_date){
              
        $query = "INSERT INTO ".RDAMS_TV_EBLAST." (tv_eblast_name,tv_eblast_image,tv_eblast_cat_id,tv_eblast_date) VALUES (?,?,?,?)";
				
        $stmt = $this->db->prepare($query);
        
         //echo var_export($stmt->errorInfo());
        
        $stmt->bindParam(1, $eblast_name);
        $stmt->bindParam(2, $eblast_image);
        $stmt->bindParam(3, $eblast_category);
        $stmt->bindParam(4, $eblast_date);
       
        $stmt->execute();
       
        $logerHD = new LoggerHD();
        $logerHD->WriteLog('|-|'.'['.date('Y-m-d h:i:s a').' -- Create (E-Blast - '.$_SESSION['first_name'].' :-: '.$_SESSION['user_name'].' :-: '.date('Y-m-d h:i:s').' :-: '.'Eblast Name='.$eblast_name.' :-: '.'Image= :-::-:)]'.'|-|');

        $results = $stmt->rowCount();
        
        if ($results > 0) {
            return $msg = "Successfully Added";
        } else {
            return $msg = "Something went wrong. Try again";
        }
    }
    
    public function viewEblastList() {
        
        $query = "SELECT * FROM ".RDAMS_TV_EBLAST." "
                . "LEFT  JOIN ".RDAMS_TV_CATEGORY." ON  (".RDAMS_TV_EBLAST.".tv_eblast_cat_id = ".RDAMS_TV_CATEGORY.".tv_cat_id)"
                . "WHERE tv_eblast_active=1 ORDER BY tv_eblast_id DESC";
        
        $stmt = $this->db->prepare($query);

        $stmt->execute();
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();
        
        $rows = $stmt->fetchAll();
        return $rows;
    }
    
    public function viewEblastListSelectedCat($tv_cat){
        
        $query = "SELECT * FROM ".RDAMS_TV_EBLAST." "
                . "LEFT  JOIN ".RDAMS_TV_CATEGORY." ON  (".RDAMS_TV_EBLAST.".tv_eblast_cat_id = ".RDAMS_TV_CATEGORY.".tv_cat_id)"
                . "WHERE tv_eblast_active=1 AND tv_eblast_cat_id=? ORDER BY tv_eblast_id DESC";
        
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $tv_cat);
        $stmt->execute();
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();
        
        $rows = $stmt->fetchAll();
        return $rows;
    }
    
    public function viewSelectedEblast($id){
        
      $query = "SELECT * FROM ".RDAMS_TV_EBLAST." "
              . "LEFT  JOIN ".RDAMS_TV_CATEGORY." ON  (".RDAMS_TV_EBLAST.".tv_eblast_cat_id = ".RDAMS_TV_CATEGORY.".tv_cat_id)"
              . "WHERE tv_eblast_id=? ";
        
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

   public function UpdateEblast($eblast_name,$eblast_image,$eblast_category,$eblast_date,$id){

        $query = "UPDATE ".RDAMS_TV_EBLAST." SET tv_eblast_name=?,tv_eblast_image=?,tv_eblast_cat_id=?,tv_eblast_date=? WHERE tv_eblast_id=?";
		
        $stmt = $this->db->prepare($query);
		
        $stmt->bindParam(1, $eblast_name);
        $stmt->bindParam(2, $eblast_image);
        $stmt->bindParam(3, $eblast_category);
        $stmt->bindParam(4, $eblast_date);
        $stmt->bindParam(5, $id); 
        
        $stmt->execute();
        
        $logerHD = new LoggerHD();
        $logerHD->WriteLog('|-|'.'['.date('Y-m-d h:i:s a').' -- Update (E-Blast - '.$_SESSION['first_name'].' :-: '.$_SESSION['user_name'].' :-: '.date('Y-m-d h:i:s').' :-: '.'E-Blast ID='.$id.' :-: '.'E-Blast Name='.$eblast_name.' :-: '.'Image= :-::-:)]'.'|-|');

        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();

        if ($results > 0) {
            return $msg = "Updated " . $results . " record";
        } else {
            return $rows = "";
        }
    }
	
    public function DeleteEblast($iid) {

        $query = "UPDATE ".RDAMS_TV_EBLAST." SET tv_eblast_active=0 WHERE tv_eblast_id=?";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $iid);
		
        $stmt->execute();
        
        $logerHD = new LoggerHD();
        $logerHD->WriteLog('|-|'.'['.date('Y-m-d h:i:s a').' -- Delete (E-Blast - '.$_SESSION['first_name'].' :-: '.$_SESSION['user_name'].' :-: '.date('Y-m-d h:i:s').' :-: '.'E-Blast ID='.$iid.':-::-:)]'.'|-|');

        $results = $stmt->rowCount();
    }
  
}
?>
