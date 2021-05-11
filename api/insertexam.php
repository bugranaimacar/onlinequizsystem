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
	  $examid = mysqli_real_escape_string($link, $_POST["examid"]);
      $newquestioncount = mysqli_real_escape_string($link, $_POST["newquestioncount"]);  
      $newstartdate = mysqli_real_escape_string($link, $_POST["newstartdate"]);  
      $newdeadline = mysqli_real_escape_string($link, $_POST["newdeadline"]);
	  $newanswerkey = mysqli_real_escape_string($link, $_POST["newanswerkey"]);
	  $newactive = mysqli_real_escape_string($link, $_POST["newactive"]);
      if($_POST["examid"] != '')  
      {  
           $query = "  
           UPDATE exams   
           SET questioncount='$newquestioncount', 
           startdate='$newstartdate',
		   deadline='$newdeadline',
		   answerkey='$newanswerkey',
           active='$newactive'
           WHERE examid='".$_POST["examid"]."'";
      }  
      else  
      {  
           $query = "  
           INSERT INTO exams(questioncount, startdate, deadline, answerkey, active)  
           VALUES('$newquestioncount', '$newstartdate', '$newdeadline', '$newanswerkey', '$newactive');  
           ";  
      }  
      if(mysqli_query($link, $query))  
      {                      
           $output .= "tamam";  
      }
	   else
	   {
		   echo("Error description: " . $link -> error);  
	   }
      echo $output;  
 }  
 ?>
 