<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors','on');
include('config.php');
include 'includes/db.php';
if(strlen($_SESSION['login'])==0)
	{
header('location:index.php');
}
else{
    if(isset($_GET['stud_id'])){
        $id = $_GET['stud_id'];

				$q = $db->prepare("select regno, fname, current_class, class, gender, dob, religion, state, lga, nationality, address, parent, parent_num, passport from accepted_students where regno = ?");
				$q->bind_param('s',$id);
				$q->execute();
				$q->store_result();
				$n = $q->num_rows;
    }
    else{
        $url = $_SERVER['HTTP_REFERER'];
        header("Location:$url");
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
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Teacher's Dashboard</title>

    <!-- Bootstrap core CSS -->
    <!--<link href="assets/css/bootstrap.css" rel="stylesheet">-->
    
    <!-- Font Awesome -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Bootstrap core CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
<!-- Material Design Bootstrap -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.4/css/mdb.min.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="assets/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css">
<link rel="shortcut icon" href="school.png" type="image/png">
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

    <script src="assets/js/chart-master/Chart.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
<style>
.small-bread{
color:#000;
font-weight:1rem;
}
.w3l-table-info h2,.agile-tables h3 {
    font-size: 28px;
    color: #1b93e1;
}
li.breadcrumb-item i.fa.fa-angle-right {
    font-size: 25px;
    padding: 0 8px;
    color: #000;
	vertical-align: middle;
}
.breadcrumb > li {
    color: #e74c3c ! important;
    font-size: 16px ! important;
    vertical-align: middle ! important;
}
tr:nth-child(even) {
  background-color: #f3faff;
}

</style>
  <body>
  <section id="container" >
<?php include("includes/header.php");?>
<?php include("includes/sidebar.php");?>
      <section id="main-content">
          <section class="wrapper">

   <div class="page-container">
   <!--/content-inner-->
<div class="left-content">
	   <div class="mother-grid-inner">
            <!--header start here-->
				<?php #include('includes/header.php');?>
				     <div class="clearfix"> </div>
				</div>
				<?php if (isset($_SESSION['msg'])): ?>
					<div class="alert alert-info">
						<h3 class="text-center"><?php echo htmlentities($_SESSION['msg']); ?></h3>
					</div>
				<?php endif; unset($_SESSION['msg']); ?>
<!--heder end here-->
<?php if ($n > 0):
	$q->bind_result($regno, $name, $classid, $cl, $gender, $dob, $religion, $state, $lga, $nationality, $address, $parent, $pphone, $passport);
	$q->fetch();
	$q->free_result();
	$q->close();

	$q = $db->prepare("select class from classes where id = ?");
	$q->bind_param('i',$classid);
	$q->execute();
	$q->bind_result($class);
	$q->fetch();
	$q->free_result();
	$q->close();
	$db->close();
?>
<ol class="breadcrumb" style="margin-top:30px;">
		<li class="breadcrumb-item" style="font-size:1rem;"><a style="color:blue" href="dashboard.php">Home</a><i class="fa fa-angle-right" style="color:#000;"></i>View Secondary Students</li>
</ol>
<div class="agile-grids" style="background-color:#fff;margin-top:30px;">
				<!-- tables -->
			<div class="container row">

				<div class="agile-tables col-md-8" style="padding:1rem;">

					<div class="w3l-table-info">

						<h2>STUDENT INFORMATION</h2>
							<table class="table small-bread">
									<a href="managenew-students.php" class="btn" style="margin-right:25px;background-color:#e0a800;">Back</a><a href="remove-student.php?id=<?php echo $id; ?>&school=secondary" class="btn btn-danger" style="background-color:red; color:white;">Remove</a>
						<tbody>
							<tr>
								<td>NAME:</td>
								<td><?php echo $name;?></td>
							</tr>
							<tr>
								<td>REGISTRATION NUMBER:</td>
								<td><?php echo $id;?></td>
							</tr>
							<tr>
								<td>CLASS:</td>
								<td><?php echo $class." ".$cl; ?></td>
							</tr>
							<tr>
								<td>GENDER:</td>
								<td><?php echo $gender; ?></td>
							</tr>
							<tr>
								<td>DOB:</td>
								<td><?php echo $dob; ?></td>
							</tr>
							<tr>
								<td>STATE:</td>
								<td><?php echo $state; ?></td>
							</tr>
							<tr>
								<td>LGA:</td>
								<td><?php echo $lga; ?></td>
							</tr>
							<tr>
								<td>NATIONALITY:</td>
								<td><?php echo $nationality; ?></td>
							</tr>
							<tr>
								<td>PARENT:</td>
								<td><?php echo $parent; ?></td>
							</tr>
							<tr>
								<td>PARENT NUMBER:</td>
								<td><?php echo $pphone; ?></td>
							</tr>
						</tbody>
					</table>
			</div>
			</div>
			<div class="agile-tables col-md-4">
				<?php if (isset($_SESSION['passport'])): ?>
					<div class="alert alert-info text-center">
						<?php echo $_SESSION['passport']; ?>
					</div>
				<?php endif; unset($_SESSION['passport'])?>
				<img id="psp" alt="passport" src = "../studs/secondary passports/<?php echo htmlentities($passport); ?>" class="img-responsive img-thumbnail"/>
				<div class="col-md-6">
					<script type="text/javascript" src="js/passport.js"></script>
					<form class="form-group" action="change-passport.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
						<input type="hidden" name="school" value="sec">
						<input type="hidden" name="in" value="<?php echo $passport; ?>">
						<input type="hidden" name="name" value="<?php echo $name; ?>">
						<input type="file" id="fileInput" name="psp_btn" value="Change" class="btn btn-success col-md-12" style="margin-top:10px;" onchange="showSubmitButton()">
						<input type="hidden" name="psp_sb" value="" id="sb" class="btn btn-primary">
					</form>
				</div>
			</div>
			</div>
<?php else:
	$q->close();
	$db->close();
?>
	<h3 class="text-center">Student not found.</h3>
<?php endif; ?>
<!-- script-for sticky-nav -->
		<script>
		$(document).ready(function() {
			 var navoffeset=$(".header-main").offset().top;
			 $(window).scroll(function(){
				var scrollpos=$(window).scrollTop();
				if(scrollpos >=navoffeset){
					$(".header-main").addClass("fixed");
				}else{
					$(".header-main").removeClass("fixed");
				}
			 });

		});
		</script>
		<!-- /script-for sticky-nav -->
<!--inner block start here-->
</section>
      </section>
<?php //include("includes/footer.php");?>
  </section>
<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.13.0/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.4/js/mdb.min.js"></script>
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/jquery-1.8.3.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/jquery.sparkline.js"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

    <script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="assets/js/gritter-conf.js"></script>

    <!--script for this page-->
    <script src="assets/js/sparkline-chart.js"></script>
	<script src="assets/js/zabuto_calendar.js"></script>
</html>
<?php } ?>
