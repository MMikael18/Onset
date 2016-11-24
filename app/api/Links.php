<?php
// USER INPUT
class Links extends aApiBackend{

    function start (){
        if (!isset($_SESSION['USER'])) {            
           header("Location:../login");
        }
    }

    public function index($p) {}

    public function setLink() {
        if(isset($_POST['data'])){            
            
            $url = $_POST['data']['url'];
            $title = $_POST['data']['title'];
            $decs = $_POST['data']['description'];
            $userid = $_SESSION['USER']['id'];

            $q = "INSERT INTO pages (title,url,description) VALUES ('".$title."','".$url."','".$decs."');
                  SET @page_id = LAST_INSERT_ID();
                  INSERT INTO user_to_pages (userid,pageid) VALUES(".$userid.", @page_id);";        

            try{
                $conn = $this->getDataDB("onset");
                $conn->exec($q);
                echo json_encode(array("msg" => 'Successfully added link '.$title));                
            }catch(PDOException $e)
            {
                echo json_encode(array("Error" => $e->getMessage()));
            }
    
        }else{
            echo json_encode(array("Error" => 'no data'));
        }
        
    }

    public function getLinks() {
        try{
            $conn = $this->getDataDB("onset");
            $q = "SELECT * FROM pages";
            $STH = $conn->query($q);
            # setting the fetch mode
            $STH->setFetchMode(PDO::FETCH_OBJ);
            $rows = $STH->fetchAll();

            echo json_encode($rows);

        }catch(PDOException $e)
        {
            //trigger_error("{" . $e->getMessage(). "}", E_USER_NOTICE);
            echo json_encode(array("Error" => $e->getMessage()));  
        }
    }

}