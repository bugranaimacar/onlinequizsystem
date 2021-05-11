<?php  

 if (!isset($_SESSION)) {
    session_start();
}

  if($_SESSION["admin"] == false){
    header("location: /login.php");
    exit;
} 


$anadizin = $_SERVER['DOCUMENT_ROOT'];
define('BASE_DIR', $_SERVER['DOCUMENT_ROOT']);
  include BASE_DIR . '/config.php';
 
 
 function deleteDir($path) {
    return is_file($path) ?
            @unlink($path) :
            array_map(__FUNCTION__, glob($path.'/*')) == @rmdir($path);
}


 if(!empty($_POST))  
 {  
      $output = '';   
	  $examid = mysqli_real_escape_string($link, $_POST["examid"]);
      if($_POST["examid"] != '')  
      {  
  
		$query = "DELETE FROM exams WHERE examid='".$_POST["examid"]."'";
		$query2 = "DELETE FROM results WHERE examid='".$_POST["examid"]."'";
		$query3 = "DELETE FROM answers WHERE answerto='".$_POST["examid"]."'";
      }  
      else  
      {  
			exit;
      }  
      if(mysqli_query($link, $query) && mysqli_query($link, $query2) && mysqli_query($link, $query3))  
      {
		$silyol = "$anadizin/images/exams/$examid";
		 if(file_exists($silyol)) {
				deleteDir($silyol);
			}		  
           $output .= "tamam";  
      }  
      echo $output;  
 }  
 ?>
 