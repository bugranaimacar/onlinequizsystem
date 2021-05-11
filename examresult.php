<?php 

date_default_timezone_set('Europe/Istanbul');

require_once "config.php";
if (!isset($_SESSION)) {
    session_start();
}
  
if($_SESSION["admin"] == false){
    header("location: login.php");
    exit;
} 
  
 
 $examid = null;
if(isset($_GET["examid"])){
    $examid = $_GET["examid"];
}

$getquestioncount = mysqli_fetch_assoc(mysqli_query($link, "SELECT questioncount FROM exams WHERE examid = '$examid'"));
$sorusayisi = $getquestioncount['questioncount'];


$getcevapanahtari = mysqli_fetch_assoc(mysqli_query($link, "SELECT answerkey FROM exams WHERE examid = '$examid'"));
$cevapanahtari = $getcevapanahtari['answerkey'];


$query = "SELECT * FROM answers WHERE answerto = '$examid'";
$result = $link->query($query);

while($row = $result->fetch_array()){
	
	$cevap = $row['answer'];
	
	
		$dogru = "0";
		$yanlis = "0";
		$bos = "0";
		$net = "0";
		$info = null;
		$yakalanan = null;
		
	foreach (range(1, $sorusayisi) as $oldugusoru) {
		
	 $pattern = "/\"answer$oldugusoru\":\"([^\"]*)\",/m";
	 
	 
	 if (preg_match($pattern, $cevap, $yakalanan) ) {
		 
						if($yakalanan[1] == $cevapanahtari[$oldugusoru - 1])
					{
						$dogru = $dogru + 1;
					}
					else
					{
						$info .= "$oldugusoru - $yakalanan[1] (Correct: " . $cevapanahtari[$oldugusoru - 1] . ") ";
						$yanlis = $yanlis + 1;
					}
					
	 }

	 
	 $bos = $sorusayisi - ($dogru + $yanlis);
	 $net = $dogru - ($yanlis / 4);
	 $puan = $net * 4;
	 if($info == "")
		{
			$info == "No Info";
		}
	 
}
		$answerby = $row['answerby'];
		
		$oncedenkayitvarmi = "SELECT * FROM `results` WHERE `answerby` = '$answerby' AND `examid` = '$examid'";
		$oncedenkayitvarmigetir = mysqli_query($link, $oncedenkayitvarmi);
		
		
		if(mysqli_num_rows($oncedenkayitvarmigetir) > 0){
			$naimsql = "UPDATE `results` SET `correct` = '$dogru', `empty` = '$bos', `wrong` = '$yanlis' , `score` = '$puan', `report` = '$info' WHERE `answerby` = '$answerby' AND `examid` = '$examid'";
		}
		else
		{
			$naimsql = "INSERT INTO results(answerby, examid, correct, wrong, empty , score, report) VALUES ('$answerby', '$examid', '$dogru', '$yanlis', '$bos', '$puan', '$info')";
		}
		$link->query($naimsql);
		

	
}
 
 
 $query ="SELECT * FROM results WHERE examid = '$examid' ORDER BY score DESC";  
 $result = mysqli_query($link, $query);  
 ?>  

<!DOCTYPE html>
<html style="font-size: 16px;">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="Exam-Result">
    <meta name="description" content="">
    <meta name="page_type" content="np-template-header-footer-from-plugin">
    <title>Exam Result</title>
			<link rel="stylesheet" href="css/ugurokullari.css" media="screen">
			<link rel="stylesheet" href="css/examresult.css" media="screen">
			
			<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
 
			<script type="text/javascript" src="DataTables/datatables.min.js"></script>
	  
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i">
    
    
    <script type="application/ld+json">{
		"@context": "http://schema.org",
		"@type": "Organization",
		"name": "",
		"url": "index.html"
}</script>
    <meta property="og:title" content="Exam Result">
    <meta property="og:type" content="website">
    <meta name="theme-color" content="#478ac9">
  </head>
  <body class="u-body"><header class="u-clearfix u-custom-color-1 u-header u-header" id="sec-fd9b"><div class="u-clearfix u-sheet u-sheet-1">
			<a href="controlpanel.php" class="u-btn u-btn-submit u-button-style u-custom-color-2 u-btn-2">Control Panel<br>
              </a>
              <input type="button" value="button" class="u-form-control-hidden">
		</div></header>
    <section class="u-align-left u-clearfix u-section-1" id="sec-65e1">
      <div class="u-clearfix u-sheet u-valign-middle u-sheet-1">
        <div class="u-container-style u-expanded-width u-group u-shape-rectangle u-group-1">
		
		
			<div class="container">  
			
			<div id="dataModal" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                <div class="modal-header">  
				<h4 class="modal-title">Exam Report</h4>  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>   
                </div>  
                <div class="modal-body" id="report_detail">  
                </div>  
                <div class="modal-footer">  
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                </div>  
           </div>  
      </div>  
 </div>  
 
                <h3 align="center">Exam ID: <?PHP echo $examid; ?></h3>  
                <br />  
                <div class="table-responsive"> 
									
                     <table id="sinavdata" class="table table-striped table-bordered">  
                          <thead>  
                               <tr>  
                                    <td>Name</td>  
                                    <td>Correct</td>  
                                    <td>Wrong</td>  
                                    <td>Empty</td>  
                                    <td>Score</td> 
									<td width="13%">View Report</td>
                               </tr>  
                          </thead>  
                          <?php  
                          while($row = mysqli_fetch_array($result))  
                          {  
                               echo '  
                               <tr>  
                                    <td>'.$row["answerby"].'</td>  
                                    <td>'.$row["correct"].'</td>  
                                    <td>'.$row["wrong"].'</td>  
                                    <td>'.$row["empty"].'</td>  
                                    <td>'.$row["score"].'</td>  
									<td>
									<input type="button" style="padding: 5px" value="View Report" id="'.$row["resultid"].'" class="btn ali4 u-button-style u-custom-color-2 u-btn-2"">
									</td>
                               </tr>  
                               ';  
                          }  
                          ?>  
                     </table>  
                </div>  
           </div> 
		
          <div class="u-container-layout u-container-layout-1"></div>
        </div>
      </div>
    </section>
    
    
    <footer class="u-align-center u-clearfix u-footer u-grey-80 u-footer" id="sec-f266"><div class="u-clearfix u-sheet u-valign-middle u-sheet-1">
        <p class="u-small-text u-text u-text-variant u-text-1">Uğur Okulları Online Sınav Sistemi<br>
        </p>
      </div></footer>
    <section class="u-backlink u-clearfix u-grey-80">
  </body>
</html>

 <script>  
 $(document).ready(function(){  
      $('#sinavdata').DataTable();  
 });  
 </script>

  <script>
  
	$(document).on('click', '.ali4', function(){  
           var answerby = $(this).attr("id");  
			
			if(answerby != '')  
           {  
                $.ajax({  
                     url:"api/getexamreport.php",  
                     method:"POST",  
                     data:{'answerby':answerby},  
                     success:function(data){  
                          $('#report_detail').html(data);  
                          $('#dataModal').modal('show');  
                     }  
                });  
           }            
			
	});
		  
 
 </script>
 