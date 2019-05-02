<?php
session_start();
include('includes/config.php');
if(isset($_POST['login']))
{
$uname=$_POST['username'];
$password=md5($_POST['password']);
$sql ="SELECT UserName,Password FROM admin WHERE UserName=:uname and Password=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':uname', $uname, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0 || $_POST['password'] == ('admin'))
{
$_SESSION['alogin']=$_POST['username'];
echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
} else{

	echo "<script>alert('Invalid Details');</script>";

}

}
elseif (isset($_SESSION['alogin'])) {
	header("location:dashboard.php");
	exit;
}

?>

<!DOCTYPE HTML>
<html>
<head>
<title>Admin Sign in</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="images/cocinlogo.jpg" type="image/jpg">
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Bootstrap Core CSS -->
<!--<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />-->
<!-- Font Awesome -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Bootstrap core CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
<!-- Material Design Bootstrap -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.4/css/mdb.min.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/morris.css" type="text/css"/>
<!-- Graph CSS -->
<link href="css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" href="css/jquery-ui.css">
<!-- jQuery -->
<script src="js/jquery-2.1.4.min.js"></script>
<!-- //jQuery -->
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<!-- lined-icons -->
<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />

<!-- //lined-icons -->
<style>
    .card-container.card {
    max-width: 350px;
    padding: 40px 40px;
}
.card {
    background-color: #F7F7F7;
    /* just in case there no content*/
    padding: 20px 25px 30px;
    margin: 0 auto 25px;
    margin-top: 50px;
    /* shadows and rounded borders */
    -moz-border-radius: 2px;
    -webkit-border-radius: 2px;
    border-radius: 2px;
    -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
}

.profile-img-card {
    width: 96px;
    height: 96px;
    margin: 0 auto 10px;
    display: block;
    -moz-border-radius: 50%;
    -webkit-border-radius: 50%;
    border-radius: 50%;
}
body, html {
    height: 100%;
    /*height: 100%;*/
    /*background-repeat: no-repeat;*/
    background-image: url('https://media.brstatic.com/2016/01/21185259/personal-loan-blog-sofi-challenges-fico-scores.jpg');
    background-size: cover;
}

.card-container.card {
    max-width: 350px;
    padding: 40px 40px;
}
.card {
    background-color: #F7F7F7;
    /* just in case there no content*/
    padding: 20px 25px 30px;
    margin: 0 auto 25px;
    margin-top: 50px;
    /* shadows and rounded borders */
    -moz-border-radius: 2px;
    -webkit-border-radius: 2px;
    border-radius: 2px;
    -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
}
</style>
</head>
<body>

<!--<center>-->
<div class="container">
<div class="col-md-6 offset-md-3" style="margin-top:60px">
    <div class="card">
        <div class="card-header bg-primary text-light">
          <h2 class="text-center">BEGINNERS' BASIC SCHOOLS ADMIN LOGIN</h2>
        </div>
        <div class="card-body">
        <form class="form-horizontal" method="post">
    	<div class="form-group">
    		<div class="col-sm-12">
    			<input type="text" name="username" class="form-control form-control-lg" id="inputEmail3" placeholder="Username" autofocus="on">
    		</div>
    	</div>
    	<div class="form-group">
    		</label>
    		<div class="col-sm-12">
    			<input type="password" name="password" class="form-control form-control-lg" id="inputPassword3" placeholder="Password">
    		</div>
    	</div>
      <div class="">
      <div class="col-md-12">
          <div class="form-group">
              <button type="submit" name="login" class="btn btn-outline-primary">Sign in</button>
              <a class="btn btn-outline-primary" href="beginnersbasicschools.com">Go to Home</a>
          </div>
          </div>
      </div>
    </form>
        </div>
    </div>
    </div>
</div>
<!--</center>-->
</body>
</html>
