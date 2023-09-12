<?php 

namespace App\Controllers;
use App\Controllers\MainController;
use App\Utility\DataBase;

class ContactController extends MainController {

    public function renderContact(){
        if(!empty($_POST)){
            $this->checkForm();       
        }else{
            $this->render();   
        }
        // $this->checkForm();
    }
    
    public function checkForm(){
            
    $mail = filter_input(INPUT_POST, 'mail');
    $object = filter_input(INPUT_POST, 'object');
    $text = filter_input(INPUT_POST, 'text');
    
    if ($mail) 
    {
        
        $data = [
            "status" => true,
            "error" => []
        ];
        
        if (!$mail || !$object || !$text)
        {
            $data["status"] = false;
            array_push($data["error"], 'Tous les champs sont obligatoires');
        }
        
        $mail = filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL);
        if (!$mail) 
        {
            $data["status"] = false;
            array_push($data["error"], 'Le format de l\'email n\'est pas valide.');
        }
    
       // echo json_encode($data);
        $dbh = DataBase::connectPDO();
        /*$sth = $dbh->prepare("INSERT INTO contact (mail, object, text) VALUES (:mail, :object, :text)");*/
        $sth = $dbh->prepare("INSERT INTO `contact`(`mail`, `object`, `text`) VALUES (:mail, :object, :text)");
       
        $params = [
            'mail'=>$mail,
            'object' => $object,
            'text' => $text
        ];
    
        $sth->execute($params);
        echo(json_encode($data));
    }
    }


}

?>