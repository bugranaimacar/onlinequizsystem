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
      if($_POST["userid"] != '')  
      {  
  
		$query = "DELETE FROM users WHERE id='".$_POST["userid"]."'";
      }  
      else  
      {  
			exit;
      }  
      if(mysqli_query($link, $query))  
      {                      
           $output .= "tamam";  
      }  
      echo $output;  
 }  
 ?>
 