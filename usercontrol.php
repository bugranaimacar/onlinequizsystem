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
 
 
 $query ="SELECT * FROM users ORDER BY id DESC";  
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
			<link rel="stylesheet" href="css/edituser.css" media="screen">
			
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
				<h4 class="modal-title">Edit User Details</h4>
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                </div>  
                <div class="modal-body">  
                     <form method="post" id="insert_form">  
                          <label>Enter User Name</label>  
                          <input type="text" name="newusername" id="newusername" class="form-control" />  
                          <br />  
                          <label>Enter Password</label>  
                          <input type="text" name="newpassword" id="newpassword" class="form-control" />  
                          <br />   
                          <label>Admin (1-Admin 0-User)</label>  
                          <input type="text" name="newisadmin" id="newisadmin" class="form-control" />  
                          <br />  
                          <input type="hidden" name="userid" id="userid"/>  
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
 
                <h3 align="center">User List</h3>
					<div align="center">  
                          <button type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-warning">Add User</button>  
                     </div>				
                <br />  
                <div class="table-responsive"> 
									
                     <table id="sinavdata" class="table table-striped table-bordered">  
                          <thead>  
                               <tr>  
                                    <td>Username</td>  
                                    <td>Password</td>  
                                    <td>Admin</td>  
									<td width="13%">Edit User</td>
                               </tr>  
                          </thead>  
                          <?php  
                          while($row = mysqli_fetch_array($result))  
                          {
							$adminmi = "No";
						if($row["isadmin"] == "1")
						{
							$adminmi = "Yes";
						}
                               echo '  
                               <tr>  
                                    <td>'.$row["username"].'</td>  
                                    <td>'.$row["password"].'</td>  
                                    <td>'.$adminmi.'</td>  
									<td>
									<input type="button" style="padding: 5px" value="Edit User" id="'.$row["id"].'" class="btn naim2 u-button-style u-custom-color-2 u-btn-2"">
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
           var userid = $(this).attr("id");  
		   $(".btn-danger").show();
			$('#userid').val(userid);
			if(userid != '')  
           {  
                $.ajax({  
                url:"/api/getuser.php",  
                method:"POST",  
                data:{'userid':userid},  
                dataType:"json",  
                success:function(data){  
                     $('#newusername').val(data.username);  
                     $('#newpassword').val(data.password);  
                     $('#newisadmin').val(data.isadmin);
					 $('#insert').val("Update");  
					 $('#add_data_Modal').modal('show'); 					 
                }  
           });  
           }
			
	});
		  
 
 </script>
 
	<script>
	
	function Sil() {
		
		var userid = $("input[name='userid']").val();
        $.ajax(
	{
	type: "POST",
	url: "api/deleteuser.php",
	data: {'userid': userid},
	
	success: function (response) {
			 window.location.href = "usercontrol.php"; 
        },
	
});
    }
	
	$('#insert_form').on("submit", function(event){  
           event.preventDefault();  
           if($('#newusername').val() == "")  
           {  
                alert("Username is required");  
           }  
           else if($('#newpassword').val() == "")  
           {  
                alert("Password is required");  
           }
           else  
           {  
                $.ajax({  
                     url:"api/insertuser.php",  
                     method:"POST",  
                     data:$('#insert_form').serialize(),  
                     beforeSend:function(){  
                          $('#insert').val("Inserting");  
                     },  
                     success: function (response) {
                          $('#insert_form')[0].reset();  
                          $('#add_data_Modal').modal('hide'); 
						window.location.href = "usercontrol.php"; 

					 
                     }  	 
                });  
           }  
      });  
	
	
	</script>
	
	<script>
	
	$(document).ready(function(){  
      $('#add').click(function(){
		  
			$(".btn-danger").hide();
		   $("input[name='userid']").val("");
           $('#insert').val("Insert");  
           $('#insert_form')[0].reset();  
      });  
	});
	</script>
 