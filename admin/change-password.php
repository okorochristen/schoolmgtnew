<?php
session_start();
error_reporting(0);
include('includes/db.php');
if(strlen($_SESSION['alogin'])==0)
  {
header('location:index.php');
}
else{
/*date_default_timezone_set('Asia/Kolkata');// change according timezone
$currentTime = date( 'd-m-Y h:i:s A', time () );*/


if(isset($_POST['submit'])){
  $oldpassword = md5($_POST['password']);
  $q = $db->prepare("select password from admin");
  $q->execute();
  $q->bind_result($password);
  $q->fetch();
  $q->free_result();
  $q->close();
  if ($password == $oldpassword) {
    $newpassword = $_POST['newpassword'];
    $newpassword2 = $_POST['confirmpassword'];
    if ($newpassword == $newpassword2) {
        $newpassword = md5($newpassword);
        $q = $db->prepare("update admin set password = ?");
        $q->bind_param('s', $newpassword);
        if ($q->execute()) {
          $q->close();
          $db->close();
          $_SESSION['sc'] = 1;
          header("Location:change-password.php");
          exit;
        }
        else {
          $q->close();
          $db->close();
          $_SESSION['sw'] = 1;
          header("Location:change-password.php");
          exit;
        }
    }
    else {
      $db->close();
      $_SESSION['pm'] = 1;
      header("Location:change-password.php");
      exit;
    }
  }
  else {
    $db->close();
    $_SESSION['wp'] = 1;
    header("Location:change-password.php");
    exit;
  }
}
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Admin Change Password</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="images/cocinlogo.jpg" type="image/jpg">
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/morris.css" type="text/css"/>
<!-- Graph CSS -->
<link href="css/font-awesome.css" rel="stylesheet">
<!-- jQuery -->
<script src="js/jquery-2.1.4.min.js"></script>
<!-- //jQuery -->
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<!-- lined-icons -->
<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
<!-- //lined-icons -->
</head>

  <body>
   <div class="page-container">
   <!--/content-inner-->
<div class="left-content">
	   <div class="mother-grid-inner">
<!--header start here-->
<?php include('includes/header.php');?>
<!--header end here-->
		<ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Home</a> </li>
         </ol>
    
              	<!-- BASIC FORM ELELEMNTS -->
              	<div class="row mt">
              		<div class="col-sm-12">
                      <div class="form-panel">
                      	  <h4 class="mb"><i class="fa fa-angle-right"></i> Admin Change Password</h4>
    
                          <?php if($successmsg)
                          {?>
                          <div class="alert alert-success alert-dismissable">
                           <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <b>Well done!</b> <?php echo htmlentities($successmsg);?></div>
                          <?php }?>
    
                            <?php if($errormsg)
                          {?>
                          <div class="alert alert-danger alert-dismissable">
                         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <b>Oh snap!</b> </b> <?php echo htmlentities($errormsg);?></div>
                          <?php }?>
    
                          <?php if (isset($_SESSION['sc'])): ?>
                            <div class="alert alert-info text-center">
                              Your password was changed successfuly!
                            </div>
                          <?php endif; unset($_SESSION['sc']);?>
    
                          <?php if (isset($_SESSION['sw'])): ?>
                            <div class="alert alert-info text-center">
                              Oops, something went wrong, please try again!
                            </div>
                          <?php endif; unset($_SESSION['sw']);?>
    
                          <?php if (isset($_SESSION['pm'])): ?>
                            <div class="alert alert-info text-center">
                              The new password doesn't match!
                            </div>
                          <?php endif; unset($_SESSION['pm']);?>
    
                          <?php if (isset($_SESSION['wp'])): ?>
                            <div class="alert alert-info text-center">
                              The password you entered is incorrect!
                            </div>
                          <?php endif; unset($_SESSION['wp']);?>
    
    
                          <form class="form-horizontal style-form" method="post" name="chngpwd" onSubmit="return valid();">
                              <div class="form-group">
                                  <div class="col-sm-8">
                                      <input type="password" name="password" required="required" class="form-control2 input-sm" placeholder="Current Password">
                                  </div>
                              </div>
    
                                <div class="form-group">
                                  <div class="col-sm-8">
                                      <input type="password" name="newpassword" required="required" class="form-control2 input-sm" placeholder="New Password">
                                  </div>
                              </div>
    
                             <div class="form-group">
                                  <div class="col-sm-8">
                                      <input type="password" name="confirmpassword" required="required" class="form-control2 input-sm" placeholder="Confirm New Password">
                                  </div>
                              </div>
                              <div class="form-group">
                               <div class="col-sm-6">
    <button type="submit" name="submit" class="btn btn-primary col-sm-4 input-sm">Submit</button>
    </div>
    </div>
    
                              </form>
                              </div>
                              </div>
                              </div>
    
    
    
    		</section><! --/wrapper -->
          </section><!-- /MAIN CONTENT -->
    <?php include("includes/footer.php");?>
  </section>
<!--/sidebar-menu-->
				<?php include('includes/sidebarmenu.php');?>
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

    <!--script for this page-->
    <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>

	<!--custom switch-->
	<script src="assets/js/bootstrap-switch.js"></script>

	<!--custom tagsinput-->
	<script src="assets/js/jquery.tagsinput.js"></script>

	<!--custom checkbox & radio-->

	<script type="text/javascript" src="assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap-daterangepicker/date.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap-daterangepicker/daterangepicker.js"></script>

	<script type="text/javascript" src="assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>


	<script src="assets/js/form-component.js"></script>


  <script>
      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

  </script>

  </body>
</html>
<?php } ?>
