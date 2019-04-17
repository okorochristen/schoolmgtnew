<?php
session_start();
error_reporting(0);
include('includes/db.php');
if(strlen($_SESSION['login'])==0)
  {
header('location:index.php');
}
else{
date_default_timezone_set('Asia/Kolkata');// change according timezone
$currentTime = date( 'd-m-Y h:i:s A', time () );


if(isset($_POST['submit'])){
  $oldpassword = md5($_POST['password']);
  $id = $_SESSION['login'];
  $q = $db->prepare("select password from teachers where EmailId = ?");
  $q->bind_param('s',$id);
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
        $q = $db->prepare("update teachers set password = ? where EmailId = ?");
        $q->bind_param('ss', $newpassword, $id);
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

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Teacher Change Password</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link rel="shortcut icon" href="school.png" type="image/png">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-daterangepicker/daterangepicker.css" />
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
  <script type="text/javascript">
function valid()
{
if(document.chngpwd.password.value=="")
{
alert("Current Password Filed is Empty !!");
document.chngpwd.password.focus();
return false;
}
else if(document.chngpwd.newpassword.value=="")
{
alert("New Password Filed is Empty !!");
document.chngpwd.newpassword.focus();
return false;
}
else if(document.chngpwd.confirmpassword.value=="")
{
alert("Confirm Password Filed is Empty !!");
document.chngpwd.confirmpassword.focus();
return false;
}
else if(document.chngpwd.newpassword.value!= document.chngpwd.confirmpassword.value)
{
alert("Password and Confirm Password Field do not match  !!");
document.chngpwd.confirmpassword.focus();
return false;
}
return true;
}
</script>
<style>
  .input-sm{
    border-radius: 0
  }
</style>
  </head>

  <body>

  <section id="container" >
     <?php include("includes/header.php");?>
      <?php include("includes/sidebar.php");?>
      <section id="main-content">
          <section class="wrapper">
          	<h3><i class="fa fa-angle-right"></i> Change Password</h3>

          	<!-- BASIC FORM ELELEMNTS -->
          	<div class="row mt">
          		<div class="col-lg-12">
                  <div class="form-panel">
                  	  <h4 class="mb"><i class="fa fa-angle-right"></i> User Change Password</h4>

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
                              <label class="col-sm-2 col-sm-2 control-label">Current Password</label>
                              <div class="col-sm-8">
                                  <input type="password" name="password" required="required" class="form-control input-sm">
                              </div>
                          </div>

<div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">New Password</label>
                              <div class="col-sm-8">
                                  <input type="password" name="newpassword" required="required" class="form-control input-sm">
                              </div>
                          </div>

<div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Confirm Password</label>
                              <div class="col-sm-8">
                                  <input type="password" name="confirmpassword" required="required" class="form-control input-sm">
                              </div>
                          </div>
                          <div class="form-group">
                           <div class="col-sm-10" style="padding-left:18% ">
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
