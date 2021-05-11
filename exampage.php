<?PHP
date_default_timezone_set('Europe/Istanbul');

require_once "config.php";
if (!isset($_SESSION)) {
    session_start();
}

if($_SESSION["loggedin"] == false){
    header("location: login.php");
    exit;
}



$examid = null;
if(isset($_SESSION["examid"])){
    $examid = $_SESSION["examid"];
}
else
{
	$_SESSION["uyari"] = "1";
    header('Location: exams.php');
	exit;
}

if(isset($_SESSION['lastquestion']))
{
	$questionnumber = $_SESSION['lastquestion'];
}
else
{
		$questionnumber = 1;
}

if(isset($_GET['q'])){
    $questionnumber = $_GET['q'];
	$_SESSION["lastquestion"] = $questionnumber;
}


$_SESSION['lastquestion'] = $questionnumber;

$Username = null;
if(isset($_SESSION['Username'])){
    $Username = $_SESSION['Username'];
}

$getquestioncount = mysqli_fetch_assoc(mysqli_query($link, "SELECT questioncount FROM exams WHERE examid = '$examid'"));
$sorusayisi = $getquestioncount['questioncount'];

if(!is_numeric($questionnumber))
{
	header("Location: exampage.php?q=1");
	exit;
}

if($questionnumber > $sorusayisi)
{
	header("Location: exampage.php?q=$sorusayisi");
}

	   
	  
$sql = "SELECT * FROM `exams` WHERE `examid` = '$examid' AND `active` = '0'";

$isexamactive = mysqli_query($link, $sql);

 $deadline = null;
$getdeadline = mysqli_fetch_assoc(mysqli_query($link, "SELECT deadline FROM exams WHERE examid = '$examid'"));
$deadline = $getdeadline['deadline'];
$diff = abs(strtotime($deadline) - strtotime(date("Y-m-d H:i:s"))); 


$years   = floor($diff / (365*60*60*24)); 
$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

$hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 

$minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 

$seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60)); 
$kalanzaman = "$days : $hours : $minuts : $seconds";

$basilantus = null;
$oncekibasilan = null;

if(mysqli_num_rows($isexamactive) > 0){
	echo("Exam is not active!");
	$_SESSION["uyari"] = "1";
	$_SESSION["examid"] = null;
	unset($_SESSION["examid"]);
	header('Location: exams.php');
	exit;
}

$startline = null;
$startdate = mysqli_fetch_assoc(mysqli_query($link, "SELECT startdate FROM exams WHERE examid = '$examnumber'"));
$startline = $startdate['startdate'];

$diffy = abs(strtotime($startline)); 
$diffz = abs(strtotime($deadline)); 

if(date("y-m-d H:i:s", $diffy) > date("y-m-d H:i:s"))
{
	echo("Exam is not active!");
	$_SESSION["uyari"] = "1";
	unset($_SESSION["examid"]);
	header('Location: exams.php');
	exit;
}

if(date("y-m-d H:i:s", $diffz) < date("y-m-d H:i:s"))
{
	echo("Exam is not active!");
	$_SESSION["uyari"] = "1";
	unset($_SESSION["examid"]);
	header('Location: exams.php');
	exit;
}



$sqlnaim = "SELECT `answer` FROM `answers` WHERE `answerby` = '$Username' AND `answerto` = '$examid'";
$rownaim = $link->query($sqlnaim)->fetch_array(MYSQLI_ASSOC);
$cevaparama = "\"answer$questionnumber\":";
$pattern = "/\"answer$questionnumber\":\"([^\"]*)\"/m";

function myFilter($var){
    return ($var !== NULL && $var !== FALSE && $var !== "" && $var !== " ");
}

$sonuc = null;
if(strpos($rownaim['answer'], $cevaparama) !== false){
	
	if (preg_match($pattern, $rownaim['answer'], $match)) 
	{
		$sonuc = $match[1];
	}

}
else
{
	$sonuc = "BOS";
}	
mysqli_close($link);
	
?>

<!DOCTYPE html>
<html style="font-size: 16px;">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="Time:">
    <meta name="description" content="">
    <meta name="page_type" content="np-template-header-footer-from-plugin">
    <title>Exam Page</title>
    <link rel="stylesheet" href="css/ugurokullari.css" media="screen">
    <link rel="stylesheet" href="css/Exam-Page.css" media="screen">
    <script src="jquery/jquery.js" type="text/javascript"></script>
    <script class="u-script" type="text/javascript" src="jquery/ugurokullari.js" defer=""></script>
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i">
    
    <script type="application/ld+json">{
		
		"@context": "http://schema.org",
		"@type": "Organization",
		"name": "",
		"url": "index.html"
}</script>


<script type="text/javascript">
  var gun = <?php echo $days; ?>;
  var saat = <?php echo $hours; ?>;
  var dakika = <?php echo $minuts; ?>;
  var saniye = <?php echo $seconds; ?>;
   function bak()
  {
	  if(gun == 0 && saniye == 0 && dakika == 0 && saat == 0) { 
	  	window.location.href = "finishexam.php";
	  return;
	  }
    if(saniye > 0) saniye = saniye - 1;
    else
    {
      saniye = 59; 
      if(dakika > 0) dakika = dakika - 1;
      else{dakika = 59; saat = saat - 1;}
    }
	if(saat == 0)
	{
		if(gun > 0) gun - 1;
	}
    $("#kalansinavzaman").html("Remaining Time: " + gun + " : " + saat + " : " + dakika + " : " + saniye);
  }
 
 
  
  window.onload = function() {
    $("#kalansinavzaman").html("Remaining Time: " + gun + " : " + saat + " : " + dakika + " : " + saniye);
    setInterval(bak, 1000);
  };
  
  
</script>


<script>

var oncekibasilan;

$(document).ready(function(){
	
	oncekibasilan = "bos";
	var naimsonuc = "<?php echo $sonuc; ?>";
	
	if(naimsonuc == "A")
	{
		var thisRadio = $("input[id='cevap1']");
		oncekibasilan = "cevap1";
		thisRadio.prop('checked', true);
        thisRadio.addClass("imChecked");
	}
	if(naimsonuc == "B")
	{
		var thisRadio = $("input[id='cevap2']");
		oncekibasilan = "cevap2";
		thisRadio.prop('checked', true);
        thisRadio.addClass("imChecked");
	}
	if(naimsonuc == "C")
	{
		var thisRadio = $("input[id='cevap3']");
		oncekibasilan = "cevap3";
		thisRadio.prop('checked', true);
        thisRadio.addClass("imChecked");
	}
	if(naimsonuc == "D")
	{
		var thisRadio = $("input[id='cevap4']");
		oncekibasilan = "cevap4";
		thisRadio.prop('checked', true);
        thisRadio.addClass("imChecked");
	}
	if(naimsonuc == "E")
	{
		var thisRadio = $("input[id='cevap5']");
		oncekibasilan = "cevap5";
		thisRadio.prop('checked', true);
        thisRadio.addClass("imChecked");
	}
});

$(document).on("click", "input[id='cevap1']", function(){
	if(oncekibasilan == "bos")
	{
		oncekibasilan = "cevap1";
	}
	if(oncekibasilan != "cevap1")
	{
		var karro = $("input[id='" + oncekibasilan + "']");
		karro.removeClass("imChecked");
		oncekibasilan = "cevap1";
	}
    thisRadio = $(this);
    if (thisRadio.hasClass("imChecked")) {
        thisRadio.removeClass("imChecked");
        thisRadio.prop('checked', false);
		
		
		var examnumber = <?php echo $examid; ?>;
		var questionid = <?php echo $questionnumber; ?>;
		
		
		$.ajax(
	{
	type: "POST",
	url: "api/saveanswer.php",
	data: {'ExamID': examnumber, 'questionnumber': questionid, 'answer': "BOS"},

	success: function (response) {
		
		if(response == "Exam is not active!")
		{
			 window.location.href = "finishexam.php"; 
		}
			
        },

});


    } else { 
        thisRadio.prop('checked', true);
        thisRadio.addClass("imChecked");
    };
})

$(document).on("click", "input[id='cevap2']", function(){
	if(oncekibasilan == "bos")
	{
		oncekibasilan = "cevap2";
	}
	if(oncekibasilan != "cevap2")
	{
		var karro2 = $("input[id='" + oncekibasilan + "']");
		karro2.removeClass("imChecked");
		oncekibasilan = "cevap2";
	}
    thisRadio = $(this);
    if (thisRadio.hasClass("imChecked")) {
        thisRadio.removeClass("imChecked");
        thisRadio.prop('checked', false);
		
		
		var examnumber = <?php echo $examid; ?>;
		var questionid = <?php echo $questionnumber; ?>;
		
		
		$.ajax(
	{
	type: "POST",
	url: "api/saveanswer.php",
	data: {'ExamID': examnumber, 'questionnumber': questionid, 'answer': "BOS"},

	success: function (response) {
		
		if(response == "Exam is not active!")
		{
			 window.location.href = "finishexam.php"; 
			
			
		}
			
        },

});


    } else { 
        thisRadio.prop('checked', true);
        thisRadio.addClass("imChecked");
    };
})

$(document).on("click", "input[id='cevap3']", function(){
		if(oncekibasilan == "bos")
	{
		oncekibasilan = "cevap3";
	}
	if(oncekibasilan != "cevap3")
	{
		var karro2 = $("input[id='" + oncekibasilan + "']");
		karro2.removeClass("imChecked");
		oncekibasilan = "cevap3";
	}
    thisRadio = $(this);
    if (thisRadio.hasClass("imChecked")) {
        thisRadio.removeClass("imChecked");
        thisRadio.prop('checked', false);
		
	
		var examnumber = <?php echo $examid; ?>;
		var questionid = <?php echo $questionnumber; ?>;
		
		
		$.ajax(
	{
	type: "POST",
	url: "api/saveanswer.php",
	data: {'ExamID': examnumber, 'questionnumber': questionid, 'answer': "BOS"},
	
	success: function (response) {
		
		if(response == "Exam is not active!")
		{
			 window.location.href = "finishexam.php"; 
		}
			
        },
	
});

    } else { 
        thisRadio.prop('checked', true);
        thisRadio.addClass("imChecked");
    };
})

$(document).on("click", "input[id='cevap4']", function(){
		if(oncekibasilan == "bos")
	{
		oncekibasilan = "cevap4";
	}
	if(oncekibasilan != "cevap4")
	{
		var karro2 = $("input[id='" + oncekibasilan + "']");
		karro2.removeClass("imChecked");
		oncekibasilan = "cevap4";
	}
    thisRadio = $(this);
    if (thisRadio.hasClass("imChecked")) {
        thisRadio.removeClass("imChecked");
        thisRadio.prop('checked', false);
			
		var examnumber = <?php echo $examid; ?>;
		var questionid = <?php echo $questionnumber; ?>;
		
		
		$.ajax(
	{
	type: "POST",
	url: "api/saveanswer.php",
	data: {'ExamID': examnumber, 'questionnumber': questionid, 'answer': "BOS"},
	
	success: function (response) {
		
		if(response == "Exam is not active!")
		{
			 window.location.href = "finishexam.php"; 
		}
			
        },
	
});

    } else { 
        thisRadio.prop('checked', true);
        thisRadio.addClass("imChecked");
    };
})

$(document).on("click", "input[id='cevap5']", function(){
		if(oncekibasilan == "bos")
	{
		oncekibasilan = "cevap5";
	}
	if(oncekibasilan != "cevap5")
	{
		var karro2 = $("input[id='" + oncekibasilan + "']");
		karro2.removeClass("imChecked");
		oncekibasilan = "cevap5";
	}
    thisRadio = $(this);
    if (thisRadio.hasClass("imChecked")) {
        thisRadio.removeClass("imChecked");
        thisRadio.prop('checked', false);
		
		var examnumber = <?php echo $examid; ?>;
		var questionid = <?php echo $questionnumber; ?>;
		
		
		$.ajax(
	{
	type: "POST",
	url: "api/saveanswer.php",
	data: {'ExamID': examnumber, 'questionnumber': questionid, 'answer': "BOS"},
	
	success: function (response) {
		
		if(response == "Exam is not active!")
		{
			 window.location.href = "finishexam.php"; 
		}
			
        },
	
});


    } else { 
        thisRadio.prop('checked', true);
        thisRadio.addClass("imChecked");
    };
})

  
$(function () {
    $('input[name="cevap"]:radio').change(function () {
		var answer = $("input[name='cevap']:checked").val();
		var examnumber = <?php echo $examid; ?>;
		var questionid = <?php echo $questionnumber; ?>;
		
		$.ajax(
	{
	type: "POST",
	url: "api/saveanswer.php",
	data: {'ExamID': examnumber, 'questionnumber': questionid, 'answer': answer},
	
	success: function (response) {
		
		if(response == "Exam is not active!")
		{
			 window.location.href = "finishexam.php"; 
		}
			
        },
	
});

    });
});
</script>
    <meta property="og:title" content="Exam Page">
    <meta property="og:type" content="website">
    <meta name="theme-color" content="#478ac9">
    <link rel="canonical" href="index.html">
    <meta property="og:url" content="index.html">
  </head>
  <body class="u-body"><header class="u-clearfix u-custom-color-1 u-header u-header" id="sec-fd9b"><div class="u-clearfix u-sheet u-sheet-1">
        <a href="https://ugurokullari.com/" class="u-btn u-btn-round u-button-style u-hover-palette-1-light-1 u-palette-1-base u-radius-6 u-btn-1">Button</a>
        <h2 class="u-heading-font u-subtitle u-text u-text-default u-text-1"><div id="kalansinavzaman"> Remaining Time: <?PHP echo $kalanzaman; ?> </div></h2>
      </div></header>
    <section class="u-clearfix u-section-1" id="sec-56cc">
      <div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-clearfix u-expanded-width u-layout-wrap u-layout-wrap-1">
          <div class="u-layout">
            <div class="u-layout-row">
              <div class="u-container-style u-layout-cell u-size-30 u-layout-cell-1">
                <div class="u-container-layout u-valign-top u-container-layout-1">

    <img src="images/exams/<?php echo "$examid"; ?>/<?php echo "$questionnumber"; ?>.png" alt="" class="u-expanded-width u-image u-image-default" data-image-width="2000" data-image-height="1333">
                </div>
              </div>
              <div class="u-container-style u-layout-cell u-size-30 u-layout-cell-2">
                <div class="u-container-layout u-container-layout-2">
                  <div class="u-expanded-width u-form u-form-1">
                    <form action="exampage.php?q=<?PHP echo "$questionnumber" + 1; ?>" method="POST" class="u-clearfix u-form-spacing-15 u-inner-form" style="padding: 15px;" source="custom" name="cevapkismi">
                      <div class="u-form-group u-form-radiobutton u-form-group-1">
                        <div class="u-form-radio-button-wrapper">
                          <input id="cevap1" type="radio" name="cevap" value="A">
                          <label class="cevap" for="radiobutton">A</label>
                          <br>
                          <input id="cevap2" type="radio" name="cevap" value="B">
                          <label class="cevap" for="radiobutton">B</label>
                          <br>
                          <input id="cevap3" type="radio" name="cevap" value="C">
                          <label class="cevap" for="radiobutton">C</label>
                          <br>
                          <input id="cevap4" type="radio" name="cevap" value="D">
                          <label class="cevap" for="radiobutton">D</label>
                          <br>
                          <input id="cevap5" type="radio" name="cevap" value="E">
                          <label class="cevap" for="radiobutton">E</label>
                          <br>
                        </div>
                      </div>
                      <div class="u-align-right u-form-group u-form-submit">
                        <a class="u-btn u-btn-submit u-button-style u-custom-color-2 u-btn-1">Next Question<br>
                        </a>
                        <input type="submit" value="okey" class="u-form-control-hidden">
                      </div>
                    </form>
                  </div>
                  <a href="exampage.php?q=<?PHP if($questionnumber != 1) { echo "$questionnumber" + -1; } else { echo "$questionnumber"; } ?>" class="u-align-left naimeklenti u-btn u-button-style u-custom-color-2 u-btn-2">Previous Question</a>
                  <p class="u-text u-text-default u-text-1">Question: <?PHP echo "$questionnumber" ;?></p>
				  <a href="finishexam.php" class="u-align-left u-btn u-button-style u-custom-color-2 u-btn-3">Finish Exam</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    
    <footer class="u-align-center u-clearfix u-footer u-grey-80 u-footer" id="sec-f266"><div class="u-clearfix u-sheet u-valign-middle u-sheet-1">
        <p class="u-small-text u-text u-text-variant u-text-1">Uğur Okulları Online Sınav Sistemi<br>
        </p>
      </div></footer>
  </body>
</html>