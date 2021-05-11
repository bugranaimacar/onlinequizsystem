<?PHP

if (!isset($_SESSION)) {
    session_start();
}
  
  if($_SESSION["admin"] == false){
    header("location: /login.php");
    exit;
} 

$anadizin = $_SERVER['DOCUMENT_ROOT'];
 
 if(isset($_GET["examid"]))  
 {
	 $examid = $_GET["examid"];
	 $olusturyol = "$anadizin/images/exams/$examid/";
	 if(!file_exists($olusturyol)) {
		  mkdir($olusturyol, 0777, true);
	 }
	 
	 foreach($_FILES["photos"]["tmp_name"] as $key => $value) {
		 $targetPath = "$anadizin/images/exams/$examid/" . basename($_FILES["photos"]["name"][$key]);
		 		 if (file_exists($targetPath)) {
				 unlink($targetPath); }
		$extension = pathinfo($_FILES["photos"]["name"][$key], PATHINFO_EXTENSION);

	if($extension !=='png')
	{
		echo "nopng";
		exit;
	}

	move_uploaded_file($value, $targetPath);
	
	echo "ok";
	 }
	 
}

 
 ?>