<?php 

date_default_timezone_set('Europe/Istanbul');

if (!isset($_SESSION)) {
    session_start();
}
  
if($_SESSION["admin"] == false){
    header("location: login.php");
    exit;
} 
 ?>

<!DOCTYPE html>
<html style="font-size: 16px;">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="page_type" content="np-template-header-footer-from-plugin">
    <title>Control Panel</title>
    <link rel="stylesheet" href="css/ugurokullari.css" media="screen">
<link rel="stylesheet" href="css/controlpanel.css" media="screen">
    <script class="u-script" type="text/javascript" src="jquery/jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="jquery/ugurokullari.js" defer=""></script>
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i">
    
    
    <script type="application/ld+json">{
		"@context": "http://schema.org",
		"@type": "Organization",
		"name": "",
		"url": "index.html"
}</script>
    <meta property="og:title" content="Control Panel">
    <meta property="og:type" content="website">
    <meta name="theme-color" content="#478ac9">
    <link rel="canonical" href="index.html">
  </head>
  <body class="u-body"><header class="u-clearfix u-custom-color-1 u-header u-header" id="sec-fd9b"><div class="u-clearfix u-sheet u-sheet-1">
        <a class="u-btn u-btn-round u-button-style u-hover-palette-1-light-1 u-palette-1-base u-radius-6 u-btn-1">Button</a>
      </div></header>
    <section class="u-align-left u-clearfix u-section-1" id="sec-f1df">
      <div class="u-clearfix u-sheet u-sheet-1">
        <a href="usercontrol.php" class="u-btn u-button-style u-custom-color-2 u-hover-custom-color-2 u-btn-1">User List</a>
        <a href="editexam.php" class="u-btn u-button-style u-custom-color-2 u-hover-custom-color-2 u-btn-2">Exam List</a>
        <a href="logout.php" class="u-btn u-button-style u-custom-color-2 u-hover-custom-color-2 u-btn-3">Log Out</a>
      </div>
    </section>
    
    
    <footer class="u-align-center u-clearfix u-footer u-grey-80 u-footer" id="sec-f266"><div class="u-clearfix u-sheet u-valign-middle u-sheet-1">
        <p class="u-small-text u-text u-text-variant u-text-1">Uğur Okulları Online Sınav Sistemi<br>
        </p>
      </div></footer>
  </body>
</html>