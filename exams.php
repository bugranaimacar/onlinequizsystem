<?PHP
if (!isset($_SESSION)) {
    session_start();
}

if($_SESSION["loggedin"] == false){
    header("location: login.php");
    exit;
}

$examid = "0";
$examnumber = null;

if(isset($_SESSION["examid"])){
    $examid = $_SESSION["examid"];
}
	  
if($examid !== "0"){
	echo $examid;
    header("location: exampage.php");
    exit;
}	

$name = "";
$name = $_SESSION["Username"]; 

?>


<!DOCTYPE html>
<html style="font-size: 16px;">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="Exams">
    <meta name="description" content="">
    <meta name="page_type" content="np-template-header-footer-from-plugin">
    <title>Exams</title>
    <link rel="stylesheet" href="css/ugurokullari.css" media="screen">
	<link rel="stylesheet" href="css/Exams.css" media="screen">

    <script class="u-script" type="text/javascript" src="jquery/jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="jquery/ugurokullari.js" defer=""></script>
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i">
    
    <script type="application/ld+json">{
		"@context": "http://schema.org",
		"@type": "Organization",
		"name": "",
		"url": "index.html"
}</script>
    <meta property="og:title" content="Exams">
    <meta property="og:type" content="website">
    <meta name="theme-color" content="#478ac9">
    <link rel="canonical" href="index.html">
  </head>
  <body class="u-body"><header class="u-clearfix u-custom-color-1 u-header u-header" id="sec-fd9b"><div class="u-clearfix u-sheet u-sheet-1">
  <?php if(isset($_SESSION["uyari"])){
    if($_SESSION["uyari"] == "1"){
	unset($_SESSION["uyari"]);
  } ?>
    <div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  Exam is not active or id is invalid!
</div>
  <?php } ?>
  
  <?php if(isset($_SESSION["basari"])){
    if($_SESSION["basari"] == "1"){
	unset($_SESSION["basari"]);
  } ?>
    <div class="alert success">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  <strong>Success!</strong> Your answers have been saved.
</div>
  <?php } ?>

        <a href="#" class="u-btn u-btn-round u-button-style u-hover-palette-1-light-1 u-palette-1-base u-radius-6 u-btn-1">Button</a>
        <h2 class="u-heading-font u-subtitle u-text u-text-default u-text-1">Username: <?php echo "$name" ; ?></h2>
      </div></header>
    <section class="u-align-center u-clearfix u-white u-section-1" id="carousel_159e">
      <div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-form u-form-1">
          <form action="api/examcontrol.php" style="padding: 10px" method="post" class="u-clearfix u-form-spacing-10 u-inner-form">
            <div class="u-form-group">
              <label for="name-82fa" class="u-form-control-hidden u-label">Name</label>
              <input placeholder="Exam ID" id="name-82fa" value="<?php echo $examnumber; ?>" name="ExamID" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" type="text" autofocus="autofocus">
            </div>
            <div class="u-align-left u-form-group u-form-submit">
              <a class="u-btn u-btn-submit u-button-style u-custom-color-2 u-btn-1">Submit</a>
              <input type="submit" value="submit" class="u-form-control-hidden">
            </div>
          </form>
        </div>
        <a href="logout.php" class="u-btn naimeklenti u-button-style u-custom-color-2 u-btn-2">Log Out</a>
		<input type="submit" value="logout" class="u-form-control-hidden">
      </div>
    </section>
    
    
    <footer class="u-align-center u-clearfix u-footer u-grey-80 u-footer" id="sec-f266"><div class="u-clearfix u-sheet u-valign-middle u-sheet-1">
        <p class="u-small-text u-text u-text-variant u-text-1">Uğur Okulları Online Sınav Sistemi<br>
        </p>
      </div></footer>
  </body>
</html>