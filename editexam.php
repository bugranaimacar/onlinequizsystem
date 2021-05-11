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
 
 $query ="SELECT * FROM exams ORDER BY examid DESC";  
 $result = mysqli_query($link, $query); 
 mysqli_close($link); 
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
			<link rel="stylesheet" href="css/editexam.css" media="screen">
			
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
			
			<div id="add_data_Modal" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                <div class="modal-header">  
				<h4 class="modal-title">Edit Exam Details</h4>
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                </div>  
                <div class="modal-body">  
                     <form method="post" id="insert_form">  
                          <label>Enter Question Count</label>  
                          <input type="text" name="newquestioncount" id="newquestioncount" class="form-control" />  
                          <br />  
                          <label>Enter Start Date (YEAR-MONTH-DAY HOUR:MINUTE)</label>  
                          <input type="text" name="newstartdate" id="newstartdate" class="form-control" />  
                          <br />   
                          <label>Enter Deadline (Example: 2020-12-06 15:00)</label>  
                          <input type="text" name="newdeadline" id="newdeadline" class="form-control" />  
                          <br />
						  <label>Enter Answer Key (Example: ABCDE)</label>  
                          <input type="textbox" name="newanswerkey" id="newanswerkey" class="form-control" />  
                          <br />
						  <label>Enter Status (1-Active 2-Passive)</label>  
                          <input type="text" name="newactive" id="newactive" class="form-control" />  
                          <br />						  
                          <input type="hidden" name="examid" id="examid"/>  
                          <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" />
						  <input type="button" onclick="Sil()" name="delete" id="delete" value="Delete" class="btn btn-danger" />
                     </form>  
                </div>  
                <div class="modal-footer">  
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                </div>  
           </div>  
      </div>  
 </div>  
 
                <h3 align="center">Exam List</h3>
					<div align="center">  
                          <button type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-warning">Add Exam</button>  
                     </div>				
                <br />  
                <div class="table-responsive"> 
									
                     <table id="sinavdata" class="table table-striped table-bordered">  
                          <thead>  
                               <tr>
									<td>Exam ID:</td>
                                    <td>Question Count</td>  
                                    <td width="15%">Start Date</td>  
                                    <td width="15%">Deadline</td>
									<td>Answer Key</td>
									<td>Active</td>
									<td width="14%">Exam Results</td>
									<td width="13%">Edit Exam</td>
									<td width="14%">Upload Questions</td>
                               </tr>  
                          </thead>  
                          <?php  
                          while($row = mysqli_fetch_array($result))  
                          {
							$aktifmi = "No";
						if($row["active"] == "1")
						{
							$aktifmi = "Yes";
						}
                               echo '  
                               <tr>  
                                    <td>'.$row["examid"].'</td>  
                                    <td>'.$row["questioncount"].'</td>
									<td>'.$row["startdate"].'</td>
									<td>'.$row["deadline"].'</td>
									<td>'.$row["answerkey"].'</td>
                                    <td>'.$aktifmi.'</td>  
									<td>
									<input type="button" style="padding: 5px" value="Exam Result" id="'.$row["examid"].'" class="btn naim4 u-button-style u-custom-color-2 u-btn-2"">
									</td>
									<td>
									<input type="button" style="padding: 5px" value="Edit Exam" id="'.$row["examid"].'" class="btn naim2 u-button-style u-custom-color-2 u-btn-2"">
									</td>
									<td>
									<input type="file" id="inpFile" class="u-form-control-hidden" multiple/>
									<input type="button" style="padding: 5px" name="uploadquestion" value="Upload Questions" id="'.$row["examid"].'" class="btn ahmet u-button-style u-custom-color-2 u-btn-2"">
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
  
	$(document).on('click', '.naim2', function(){  
           var examid = $(this).attr("id");  
		   $(".btn-danger").show();
			$('#examid').val(examid);
			if(examid != '')  
           {  
                $.ajax({  
                url:"api/getexam.php",  
                method:"POST",  
                data:{'examid':examid},  
                dataType:"json",  
                success:function(data){  
                     $('#newquestioncount').val(data.questioncount);  
                     $('#newstartdate').val(data.startdate);  
                     $('#newdeadline').val(data.deadline);
					 $('#newanswerkey').val(data.answerkey);
					 $('#newactive').val(data.active);
					 $('#insert').val("Update");  
					 $('#add_data_Modal').modal('show'); 					 
                }  
           });  
           }
			
	});
		  
 
 </script>
 
 
 <script>
 
 var naimid;
		$(document).on('click', '.ahmet', function(e){   
        $('#inpFile').click();
		naimid = $(this).attr("id");
		e.preventDefault();
    });
	
	$(document).on('change','#inpFile',function(){
		const inpFile = document.getElementById("inpFile");
		const formData = new FormData();
		
		for(const file of inpFile.files) {
			formData.append("photos[]", file);
		}
		
		
		const xhr = new XMLHttpRequest();
		
		xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      if(xhr.response == "nopng")
	  {
		  alert("Please upload your questions as png");
		  window.location.href = "editexam.php";
	  }
	  else if(xhr.response == "ok")
	  {
		  window.location.href = "editexam.php";
	  }
    }
  }
		
		xhr.open("post", "api/upload.php?examid=" + naimid);
		xhr.send(formData);
		
	
	});
	
 
 </script>
 
 <script>
	$(document).on('click', '.naim4', function(e){
	 var naimid = $(this).attr("id");
	 window.location.href = "examresult.php?examid=" + naimid;
 });
 
 </script>
 
	<script>
	
	function Sil() {
		
		var examid = $("input[name='examid']").val();
        $.ajax(
	{
	type: "POST",
	url: "api/deleteexam.php",
	data: {'examid': examid},
	
	success: function (response) {
			 window.location.href = "editexam.php"; 
        },
	
});
    }
	
	$('#insert_form').on("submit", function(event){  
           event.preventDefault();  
           if($('#newstartdate').val() == "")  
           {  
                alert("Start Date is required");  
           }  
           else if($('#newdeadline').val() == "")  
           {  
                alert("Deadline is required");  
           }
		   else if($('#newanswerkey').val() == "")  
           {  
                alert("Answer Key is required");  
           }
           else  
           {  
                $.ajax({  
                     url:"api/insertexam.php",  
                     method:"POST",  
                     data:$('#insert_form').serialize(),  
                     beforeSend:function(){  
                          $('#insert').val("Inserting");  
                     },  
                     success: function (response) {
                          $('#insert_form')[0].reset();  
                          $('#add_data_Modal').modal('hide'); 
						window.location.href = "editexam.php"; 

					 
                     }  	 
                });  
           }  
      });  
	
	
	</script>
	
	<script>
	
	$(document).ready(function(){  
      $('#add').click(function(){
		  
			$(".btn-danger").hide();
		   $("input[name='examid']").val("");
           $('#insert').val("Insert");  
           $('#insert_form')[0].reset();  
      });  
	});
	</script>
 