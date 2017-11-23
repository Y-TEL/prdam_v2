<?php

/**
 * Description of User
 *
 * @author Nirushika
 */

date_default_timezone_set('America/New_York');

class DepUpdates {

   private $db;

    public function __construct() {

    try {
            $this->db = new Connection();
            $this->db = $this->db->dbConnect();
        } catch (PDOException $e) {
            die('ERROR:' . $e->getMessage());
        }
    }

    
    public function addDepUpdates($news,$subject,$department,$news_image,$entered_by,$created_date,$created_time){
              
        $query = "INSERT INTO ".RDAMS_DEPARTMENT_UPDATES." (dep_updates_body,dep_updates_subject,dep_updates_dept,dep_updates_image,dep_updates_entered_by,dep_updates_entered_date,dep_updates_entered_time) VALUES (?,?,?,?,?,?,?)";
				
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
        $logerHD->WriteLog('|-|'.'['.date('Y-m-d h:i:s a').' -- Create (Department Updates - '.$_SESSION['first_name'].' :-: '.$_SESSION['user_name'].' :-: '.date('Y-m-d h:i:s').' :-: '.'Subject='.$subject.' :-: '.'News= :-::-:)]'.'|-|');

        $results = $stmt->rowCount();
   
        
        if ($results > 0) {
            return $msg = "Successfully Added";
        } else {
            return $msg = "Something went wrong. Try again";
        }
    }
    
    
    public function viewDepUpdatesList() {
        
        $query = "SELECT * FROM ".RDAMS_DEPARTMENT_UPDATES." "
                . " LEFT  JOIN ".RDAMS_EMP_DEPARTMENT." ON  (".RDAMS_DEPARTMENT_UPDATES.".dep_updates_dept = ".RDAMS_EMP_DEPARTMENT.".dep_id)"
                . "WHERE dep_updates_active=1 ORDER BY dep_updates_id DESC";
        
        $stmt = $this->db->prepare($query);

        $stmt->execute();
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();
        
        $rows = $stmt->fetchAll();
        return $rows;
    }
    
    public function viewDepUpdatesListLatest() {
        
        $query = "SELECT * FROM ".RDAMS_DEPARTMENT_UPDATES." "
                . " LEFT  JOIN ".RDAMS_EMP_DEPARTMENT." ON  (".RDAMS_DEPARTMENT_UPDATES.".dep_updates_dept = ".RDAMS_EMP_DEPARTMENT.".dep_id)"
                . "WHERE dep_updates_active=1 ORDER BY dep_updates_id DESC LIMIT 15";
        
        $stmt = $this->db->prepare($query);

        $stmt->execute();
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();
        
        $rows = $stmt->fetchAll();
        return $rows;
    }
    

    public function viewSelectedDepUpdates($id){
        
      $query = "SELECT * FROM ".RDAMS_DEPARTMENT_UPDATES." "
              . " LEFT  JOIN ".RDAMS_EMP_DEPARTMENT." ON  (".RDAMS_DEPARTMENT_UPDATES.".dep_updates_dept = ".RDAMS_EMP_DEPARTMENT.".dep_id)"
              . " WHERE dep_updates_id=? ";
        
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

   public function UpdateDepUpdates($news, $subject, $department, $news_image,$id){

        $query = "UPDATE ".RDAMS_DEPARTMENT_UPDATES." SET dep_updates_body=?,dep_updates_subject=?,dep_updates_dept=?,dep_updates_image=? WHERE dep_updates_id=?";
		
        $stmt = $this->db->prepare($query);
		
        $stmt->bindParam(1, $news);
        $stmt->bindParam(2, $subject);
        $stmt->bindParam(3, $department);
        $stmt->bindParam(4, $news_image);
        $stmt->bindParam(5, $id); 
        
        $stmt->execute();
        
        $logerHD = new LoggerHD();
        $logerHD->WriteLog('|-|'.'['.date('Y-m-d h:i:s a').' -- Update (Department Updates - '.$_SESSION['first_name'].' :-: '.$_SESSION['user_name'].' :-: '.date('Y-m-d h:i:s').' :-: '.'News ID='.$id.' :-: '.'Subject='.$subject.' :-: '.'News= :-::-:)]'.'|-|');

        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();

        if ($results > 0) {
            return $msg = "Updated " . $results . " record";
        } else {
            return $rows = "";
        }
        
    }
    
    
	
    public function DeleteDepUpdates($iid) {

        $query = "UPDATE ".RDAMS_DEPARTMENT_UPDATES." SET dep_updates_active=0 WHERE dep_updates_id=?";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $iid);
		
        $stmt->execute();
        
        $logerHD = new LoggerHD();
        $logerHD->WriteLog('|-|'.'['.date('Y-m-d h:i:s a').' -- Delete (Department Updates - '.$_SESSION['first_name'].' :-: '.$_SESSION['user_name'].' :-: '.date('Y-m-d h:i:s').' :-: '.'News ID='.$iid.':-::-:)]'.'|-|');

        $results = $stmt->rowCount();
    }
    
    
    
  
}
?>
