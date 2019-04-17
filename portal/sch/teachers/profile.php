<?php
session_start();
$id = $_SESSION['login'];
error_reporting(0);
include('includes/db.php');
if(strlen($_SESSION['login'])==0)
  {
header('location:index.php');
}
else{
date_default_timezone_set('Asia/Kolkata');// change according timezone
$currentTime = date( 'd-m-Y h:i:s A', time () );


if(isset($_POST['submit']))
{
$name=$_POST['name'];
$gender=$_POST['gender'];
$phone=$_POST['phone'];
$email=$_POST['email'];
$address=$_POST['address'];

$q = $db->prepare('update teachers set name = ?, phone = ?, EmailId = ?, address = ? where EmailId = ?');
$q->bind_param('sssss', $name, $phone, $email, $address, $id);

if($q->execute()){
  $successmsg="Profile Successfully !!";
}
else{
  $errormsg="Profile not updated !!";
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

    <title>Teacher's Profile</title>
<link rel="shortcut icon" href="school.png" type="image/png">
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-daterangepicker/daterangepicker.css" />
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

  </head>

  <body>

  <section id="container" >
     <?php include("includes/header.php");?>
      <?php include("includes/sidebar.php");?>
      <section id="main-content">
          <section class="wrapper">
          	<h3><i class="fa fa-angle-right"></i> Profile info</h3>

          	<!-- BASIC FORM ELELEMNTS -->
          	<div class="row mt">
          		<div class="col-lg-12">
                  <div class="form-panel">


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
                      <?php
                        $q = $db->prepare("SELECT name, gender, phone, EmailId, address, register_date from teachers where EmailId = ?");
                        $q->bind_param('s',$id);
                        $q->execute();
                        $q->bind_result($name, $gender, $phone, $email, $address, $date);
                        $q->fetch();
                        $q->close();
                        $db->close();
                      ?>

  <h4 class="mb"><i class="fa fa-user"></i>&nbsp;&nbsp;<?php echo htmlentities($row['name']);?>'s Profile</h4>
    <!--<h5><b>Last Updated at :</b>&nbsp;&nbsp;<?php //echo htmlentities($row['updationDate']);?></h5>-->
      <form class="form-horizontal style-form" method="post" name="profile" >

        <div class="form-group">
        <label class="col-sm-2 control-label">Full Name</label>
        <div class="col-sm-4">
        <input type="text" name="name" required="required" value="<?php echo htmlentities($name);?>" class="form-control" >
         </div>
        <label class="col-sm-2 control-label">Gender </label>
         <div class="col-sm-4">
        <input type="text" name="gender" required="required" value="<?php echo htmlentities($gender);?>" class="form-control" readonly>
        </div>
         </div>


        <div class="form-group">
        <label class="col-sm-2 control-label">Mobile Number</label>
         <div class="col-sm-4">
        <input type="number" name="phone" required="required" value="<?php echo htmlentities($phone);?>" class="form-control">
        </div>
        <label class="col-sm-2 control-label">Email Address</label>
         <div class="col-sm-4">
        <input type="email" name="email" required="required" value="<?php echo htmlentities($email);?>" class="form-control">
        </div>
        </div>

        <div class="form-group">
        <label class="col-sm-2 control-label">Contact Address </label>
        <div class="col-sm-4">
       <input type="text" name="address" required="required" value="<?php echo htmlentities($address);?>" class="form-control" >
         </div>
         <label class="col-sm-2 control-label">Reg Date </label>
        <div class="col-sm-4">
        <input type="text" name="regdate" required="required" value="<?php echo htmlentities($date);?>" class="form-control" readonly>
        </div>


         </div>
              <div class="form-group">
              <div class="col-sm-6 col-md-offset-2">
              <button type="submit" name="submit" class="btn btn-primary">Submit</button>
              </div>
              </div>
        </div>
  </form>
  </div>
  </div>
  </div>
		</section>
      </section>
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
