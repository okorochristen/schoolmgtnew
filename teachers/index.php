<?php
session_start();
error_reporting(E_ALL); ini_set('display_errors', 'on');

if(isset($_POST['submit']))
{
  include 'includes/db.php';
  $username = $_POST['username'];
  $password = md5($_POST['password']);
  $q = $db->prepare('SELECT password from teachers where emailid = ?');
  $q->bind_param('s', $username);
  $q->execute();
  $q->store_result();
  $n = $q->num_rows;
  if ($n > 0) {
    $q->bind_result($dbPassword);
    $q->fetch();
    $q->close();
    $db->close();

    if ($password == $dbPassword) {
      $_SESSION['login']= $username;
      header("Location:dashboard.php");
      exit();
    }
    else {
      $_SESSION['wp'] = 1;
      header("Location:index.php");
      exit;
    }
  }
  else {
    $_SESSION['wu'] = 1;
    $q->close();
    $db->close();
    header("Location:index.php");
    exit;
  }
}
elseif (isset($_SESSION['login'])) {
  header("Location:dashboard.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    
    <title>Teacher Login</title>

    <!-- Bootstrap core CSS -->
    <!--<link href="assets/css/bootstrap.css" rel="stylesheet">-->
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<!--<link rel="shortcut icon" href="school.png" type="image/png">-->
    <!-- Custom styles for this template -->
    <!--<link href="assets/css/style.css" rel="stylesheet">-->
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <!-- Font Awesome -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Bootstrap core CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
<!-- Material Design Bootstrap -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.4/css/mdb.min.css" rel="stylesheet">
<script type="text/javascript">
function valid()
{
 if(document.forgot.password.value!= document.forgot.confirmpassword.value)
{
alert("Password and Confirm Password Field do not match  !!");
document.forgot.confirmpassword.focus();
return false;
}
return true;
}
</script>
<style>
body{
    /*height: 100%;*/
    /*background-repeat: no-repeat;*/
    background-image: url('https://media.brstatic.com/2016/01/21185259/personal-loan-blog-sofi-challenges-fico-scores.jpg');
    background-size: cover;
}
/*#container-fluid{*/
/*    background-color: rgba(18, 111, 120, 0.2);*/
/*    height: 566px;*/
/*}*/
</style>
  </head>

  <body>
      
<div class="container-fluid" id="container-fluid">
    <div class="col-md-6 offset-md-3 col-sm-12" style="margin-top:60px">
    <div class="card">
        <div class="card-header bg-primary text-white">
          <h2 class="text-center">TEACHER LOGIN</h2>
        </div>
        <div class="card-body">
        <form method="post">
    	<div class="form-group">
    		<div class="col-sm-12 col-sm-12 col-md-12">
    			<input type="text" name="username" autofocus class="form-control form-control-lg" id="inputEmail3" placeholder="Username" autofocus="on">
    		</div>
    	</div><br>
    	<div class="form-group">
    		<div class="col-sm-6 col-sm-12 col-md-12">
    			<input type="password" name="password" class="form-control form-control-lg" id="inputPassword3" placeholder="Password">
    		</div>
    	</div><br>
     
          <div class="form-group">
             <div class="col-sm-6 col-sm-12 col-md-12">
                <button type="submit" name="submit" class="btn btn-outline-primary">Sign in</button>
                <a class="btn btn-outline-primary" href="beginnersbasicschools.com">Go to Home</a>
             </div>
          </div>
    </form>
        </div>
    </div>
    </div>
    
  </div>   
  </body>
</html>
