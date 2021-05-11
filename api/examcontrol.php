<?php
date_default_timezone_set('Europe/Istanbul');

// Initialize the session
if (!isset($_SESSION)) {
    session_start();
}

$filepath =  $_SERVER['DOCUMENT_ROOT'];
 require_once("$filepath/config.php");

 
if($_SESSION["loggedin"] == false){
    header("location: /login.php");
    exit;
}

$examnumber = null;
if(isset($_POST['ExamID'])){
    $examnumber = $_POST['ExamID'];
}

$Username = null;
if(isset($_SESSION['Username'])){
    $Username = $_SESSION['Username'];
}

$sql = "SELECT * FROM `exams` WHERE `examid` = '$examnumber' AND `active` = '1'";

$result = mysqli_query($link, $sql);

$sql2 = "SELECT * FROM `answers` WHERE `answerby` = '$Username' AND `answerto` = '$examnumber'";

$result2 = mysqli_query($link, $sql2);

$deadline = null;
$getdeadline = mysqli_fetch_assoc(mysqli_query($link, "SELECT deadline FROM exams WHERE examid = '$examnumber'"));
$deadline = $getdeadline['deadline'];

$startline = null;
$startdate = mysqli_fetch_assoc(mysqli_query($link, "SELECT startdate FROM exams WHERE examid = '$examnumber'"));
$startline = $startdate['startdate'];

$diff = abs(strtotime($startline)); 
$diff2 = abs(strtotime($deadline)); 

if(date("y-m-d H:i:s", $diff) > date("y-m-d H:i:s"))
{
	echo("Exam is not active!");
	$_SESSION["uyari"] = "1";
	 header("Location: /exams.php");
	 mysqli_close($link);
	 exit;
}

if(date("y-m-d H:i:s", $diff2) < date("y-m-d H:i:s"))
{
	echo("Exam is not active!");
	$_SESSION["uyari"] = "1";
	 header("Location: /exams.php");
	 mysqli_close($link);
	 exit;
}

if(mysqli_num_rows($result) > 0){
	unset($_SESSION['examid']);
	$_SESSION['examid'] = $examnumber;
	echo("Exam is active!");
	if(mysqli_num_rows($result2) == 0){
	$naimhave = "INSERT INTO answers(answerby, answerto) VALUES ('$Username', '$examnumber')";
	mysqli_query($link, $naimhave);
	}
	mysqli_close($link);
	 header("Location: /exampage.php?q=1");
}
else
{
	echo("Exam is not active!");
	$_SESSION["uyari"] = "1";
	 header("Location: /exams.php");
	 mysqli_close($link);
	 exit;
}
mysqli_close($link);
exit;
?>