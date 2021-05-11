<?php
date_default_timezone_set('Europe/Istanbul');

// Initialize the session
if (!isset($_SESSION)) {
    session_start();
}
define('BASE_DIR', $_SERVER['DOCUMENT_ROOT']);
  include BASE_DIR . '/config.php';

if($_SESSION["loggedin"] == false){
    header("location: /login.php");
    exit;
}

$examnumber = null;
if(isset($_POST['ExamID'])){
    $examnumber = $_POST['ExamID'];
}

$answer = null;
if(isset($_POST['answer'])){
    $answer = $_POST['answer'];
}

$Username = null;
if(isset($_SESSION['Username'])){
    $Username = $_SESSION['Username'];
}

$questionnumber = null;
if(isset($_POST['questionnumber'])){
    $questionnumber = $_POST['questionnumber'];
}

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
	 mysqli_close($link);
	 exit;
}

if(date("y-m-d H:i:s", $diff2) < date("y-m-d H:i:s"))
{
	echo("Exam is not active!");
	 mysqli_close($link);
	 exit;
}

$newanswer = "\"answer$questionnumber\":\"$answer\",";
$cevaparama = "\"answer$questionnumber\"";
$bosanswer;

$pattern = "/\"answer$questionnumber\":\"([^\"]*)\",/m";

$sql = "SELECT `answer` FROM `answers` WHERE `answerby` = '$Username' AND `answerto` = '$examnumber'";
$row = $link->query($sql)->fetch_array(MYSQLI_ASSOC);
$col = preg_replace($pattern, $newanswer, $row['answer']);
$boscol = preg_replace($pattern, "", $row['answer']);

$sql = "UPDATE `answers` SET `answer` = '$col' WHERE `answerby` = '$Username' AND `answerto` = '$examnumber'";

$sql2 = "UPDATE `answers` SET `answer` = '$boscol' WHERE `answerby` = '$Username' AND `answerto` = '$examnumber'";
	
	$query3 = "UPDATE `answers` SET `answer` = CONCAT(answer, '$newanswer') WHERE `answerby` = '$Username' AND `answerto` = '$examnumber'";
	
	if($answer == "BOS")
	{
		$link->query($sql2);
		mysqli_close($link);
	exit;
	}
	
	if(strpos($col, $cevaparama) !== false){
	$link->query($sql);
} else{
    $link->query($query3);
}
	
	mysqli_close($link);
	exit;

?>