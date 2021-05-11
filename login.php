<?php
// Check if the user is already logged in, if yes then redirect him to welcome page
session_start();

if(isset($_SESSION["admin"]) && $_SESSION["admin"] === true){
	header("location: controlpanel.php");
    exit;
}
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    
	header("location: exams.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$Username = $Password = "";
$Username_err = $Password_err = "";

if(isset($_POST['Username'])){
    $Username = $_POST['Username'];
}

if(isset($_POST['Password'])){
    $Password = $_POST['Password'];
}

if($Username != "")
  {
if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($Username_err) && empty($Password_err)){
        // Prepare a select statement
        $sql = "SELECT id, Username, Password FROM users WHERE Username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_Username);
            
            // Set parameters
            $param_Username = $Username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if Username exists, if yes then verify Password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $Username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if($Password == $hashed_password){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["Username"] = $Username;                            
                            
							
							$adminsql = "SELECT * FROM `users` WHERE `username` = '$Username' AND `isadmin` = '1'";
							$isadmin = mysqli_query($link, $adminsql);
							if(mysqli_num_rows($isadmin) > 0){
								$_SESSION["admin"] = true;
								header("location: controlpanel.php");
								exit;
							}
								
                            // Redirect user to welcome page
                            header("location: exams.php");
                        } else{
                            // Display an error message if Password is not valid
                            $Password_err = "The Password you entered was not valid.";
							echo "<script type='text/javascript'>alert('$Password_err');</script>";
                        }
                    }
                } else{
                    // Display an error message if Username doesn't exist
                    $Username_err = "No account found with that Username.";
					echo "<script type='text/javascript'>alert('$Username_err');</script>";
                }
            } else{
				echo "<script type='text/javascript'>alert('Something went wrong contact with administrator.');</script>";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
}
    // Close connection
    mysqli_close($link);
}
  }
?>

<!DOCTYPE html>
<html style="font-size: 16px;">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="Exam">
    <meta name="description" content="">
    <meta name="page_type" content="np-template-header-footer-from-plugin">
    <title>Login</title>
    <link rel="stylesheet" href="css/ugurokullari.css" media="screen">
<link rel="stylesheet" href="css/Login.css" media="screen">
    <script class="u-script" type="text/javascript" src="jquery/jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="jquery/ugurokullari.js" defer=""></script>
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i">
    
    
    <script type="application/ld+json">{
		"@context": "http://schema.org",
		"@type": "Organization",
		"name": "",
		"url": "index.html"
}</script>
    <meta property="og:title" content="Login">
    <meta property="og:type" content="website">
    <meta name="theme-color" content="#478ac9">
    <link rel="canonical" href="index.html">
    <meta property="og:url" content="index.html">
  </head>
  <body class="u-body"><header class="u-clearfix u-custom-color-1 u-header u-header" id="sec-fd9b"><div class="u-clearfix u-sheet u-sheet-1">
        <a href="#" class="u-btn u-btn-round u-button-style u-hover-palette-1-light-1 u-palette-1-base u-radius-6 u-btn-1">Button</a>
        <h2 class="u-heading-font u-subtitle u-text u-text-default u-text-1">Ugur Online Exam</h2>
      </div></header>
    <section class="u-clearfix u-section-1" id="sec-07d9">
      <div class="u-clearfix u-sheet u-valign-middle u-sheet-1">
        <div class="u-form u-form-1">
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="u-form-group u-form-name">
              <label for="name" class="u-form-control-hidden u-label"></label>
              <input type="text" placeholder="Username" id="Username" value="<?php echo $Username; ?>" name="Username" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="">
            </div>
            <div class="u-form-group">
              <label for="password" class="u-form-control-hidden u-label"></label>
              <input placeholder="Password" id="Password" value="<?php echo $Password; ?>" name="Password" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="required" type="Password">
            </div>
            <div class="u-align-center u-form-group u-form-submit">
              <a class="u-btn u-btn-submit u-button-style u-custom-color-2 u-btn-2">Login<br>
              </a>
              <input type="submit" value="submit" class="u-form-control-hidden">
            </div>
            <input type="hidden" value="" name="recaptchaResponse">
          </form>
        </div>
      </div>
    </section>
    
    
    <footer class="u-align-center u-clearfix u-footer u-grey-80 u-footer" id="sec-f266"><div class="u-clearfix u-sheet u-valign-middle u-sheet-1">
        <p class="u-small-text u-text u-text-variant u-text-1">Uğur Okulları Online Sınav Sistemi<br>
        </p>
      </div></footer>
  </body>
</html>