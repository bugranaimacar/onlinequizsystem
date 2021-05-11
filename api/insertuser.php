<?php  

 if (!isset($_SESSION)) {
    session_start();
}

  if($_SESSION["admin"] == false){
    header("location: /login.php");
    exit;
} 

define('BASE_DIR', $_SERVER['DOCUMENT_ROOT']);
  include BASE_DIR . '/config.php';
 
 if(!empty($_POST))  
 {  
      $output = '';   
	  $userid = mysqli_real_escape_string($link, $_POST["userid"]);
      $newusername = mysqli_real_escape_string($link, $_POST["newusername"]);  
      $newpassword = mysqli_real_escape_string($link, $_POST["newpassword"]);  
      $newisadmin = mysqli_real_escape_string($link, $_POST["newisadmin"]);  
      if($_POST["userid"] != '')  
      {  
           $query = "  
           UPDATE users   
           SET username='$newusername',   
           password='$newpassword',   
           isadmin='$newisadmin'    
           WHERE id='".$_POST["userid"]."'";
      }  
      else  
      {  
           $query = "  
           INSERT INTO users(username, password, isadmin)  
           VALUES('$newusername', '$newpassword', '$newisadmin');  
           ";  
      }  
      if(mysqli_query($link, $query))  
      {                      
           $output .= "tamam";  
      }  
      echo $output;  
 }  
 ?>
 