
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
  
 if(isset($_POST["answerby"]))  
 {  
      $output = '';   
      $query = "SELECT * FROM results WHERE resultid = '".$_POST["answerby"]."'";  
      $result = mysqli_query($link, $query);  
      $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';  
      while($row = mysqli_fetch_array($result))  
      {  
           $output .= '  
                <tr>  
                     <td width="30%"><label>Name</label></td>  
                     <td width="70%">'.$row["answerby"].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Correct Answer</label></td>  
                     <td width="70%">'.$row["correct"].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Wrong Answer</label></td>  
                     <td width="70%">'.$row["wrong"].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Empty Answer</label></td>  
                     <td width="70%">'.$row["empty"].'</td>  
                </tr> 				
                <tr>  
                     <td width="30%"><label>Score</label></td>  
                     <td width="70%">'.$row["score"].'</td>  
                </tr> 
				<tr>  
                     <td width="30%"><label>Info</label></td>  
                     <td width="70%">'.$row["report"].'</td>  
                </tr> 				
           ';  
      }  
      $output .= '  
           </table>  
      </div>  
      ';  
      echo $output;  
 }  
 ?>
 