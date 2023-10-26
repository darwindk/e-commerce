// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location:webpro.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
         body{
margin:0;
padding: 0;
font-size: sans-serif;
background-color:rgb(32, 26, 26);
}
#main{
   height:70px;
   width:100%;
   display:flex;
   color:rgb(207, 85, 85) ;
   align-items: center;
   justify-content: space-between;
   padding: 0 30px;
background-color:#411111;
position: fixed;
}
#main h5{
   font-size:20px;
   text-transform: uppercase;  
   color:#ad9d9d;
   
   
}
#main h6{
   font-size:20px;
   margin-left: 50px;
   font-weight: 500;
   text-transform: uppercase;
   color:#ad9d9d;
   
}
a{
   text-decoration: none;
 }
 .loginbox{
    width:320px;
    height:550px;
    background:#000;
    color:#fff;
    top:50%;
    left: 50%;
    position: absolute;
    transform :translate(-50%,-50%);
    box-sizing: border-box;
    padding:70px 30px;
 }
 .icon{
    width:70px;
    height:70px;
    position:absolute;
    top:40px;
    left:121px;
 }

h3{
   margin: 0;
   padding: 0,0,20px;
   text-align: center;
   font-size: 15px;
}
.loginbox p{
   margin: 0;
   padding: 0,0,20px;
   

}

.loginbox input{
   width: 100%;
   margin-bottom: 20px;
}
 .loginbox input[type="text"],input[type="password"]{

border:none;
border-bottom: 2px solid#fff;
background:transparent;
outline: none;
height:50px;
color: #fff;
font-size: 16px;





 }

    </style>
</head>
<body>
 <div id="main">
        <h1 class="logo">BOAT</h1>
        <input type="text" placeholder="search">
      <a href=""><h5>ABOUT</h5></a>
       <a href=""> <h5 class="services">services</h5></a>
       <a href=""> <h5>PRODUCTS</h5></a>
       <a href=""> <h6>warrenty</h6></a>
     <h4> <i class="fa fa-shopping-cart" style="font-size:26px;color:#e2d7d7"></i></h4>
    
    </div> 
   <div class="loginbox">
         <img src="https://cdn-icons-png.flaticon.com/512/10307/10307911.png" class="icon">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
           <BR><br>
    <p>USER NAME</p>
    <input type="text"name="username" placeholder="enter username">
    <p>PASSWORD</p>
    <input type="password" name="password" placeholder="enter password">
    <p>Confirm PASSWORD</p>
    <input type="password" name="confirm_password" placeholder="enter password">
    <input type="submit"name="submit" value="signin">
    <p>Already have an account? <a href="l2.php">Login</a>.</p>
    
         
        </div>
</body>
</html>
        
