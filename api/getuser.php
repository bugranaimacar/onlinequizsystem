
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
  
 if(isset($_POST["userid"]))  
 {  
      $query = "SELECT * FROM users WHERE id = '".$_POST["userid"]."'";  
      $result = mysqli_query($link, $query);  
      $row = mysqli_fetch_array($result);  
      echo json_encode($row);  
 }  
 ?>
 