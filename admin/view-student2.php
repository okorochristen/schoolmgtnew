<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors','on');
include('includes/config.php');
include 'includes/db.php';
if(strlen($_SESSION['alogin'])==0)
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
<!DOCTYPE HTML>
<html>
<head>
<title>Admin Manage Primary Students</title>
<link rel="shortcut icon" href="images/cocinlogo.jpg" type="image/jpg">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="images/school.png" type="image/png">
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
<!-- tables -->
<link rel="stylesheet" type="text/css" href="css/table-style.css" />
<link rel="stylesheet" type="text/css" href="css/basictable.css" />
<script type="text/javascript" src="js/jquery.basictable.min.js"></script>
<script type="text/javascript" src="js/images.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
      $('#table').basictable();

      $('#table-breakpoint').basictable({
        breakpoint: 768
      });

      $('#table-swap-axis').basictable({
        swapAxis: true
      });

      $('#table-force-off').basictable({
        forceResponsive: false
      });

      $('#table-no-resize').basictable({
        noResize: true
      });

      $('#table-two-axis').basictable();

      $('#table-max-height').basictable({
        tableWrapper: true
      });
    });
</script>
<!-- //tables -->
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

	$q = $db->prepare("select class from pri_class where id = ?");
	$q->bind_param('i',$classid);
	$q->execute();
	$q->bind_result($class);
	$q->fetch();
	$q->free_result();
	$q->close();
	$db->close();
?>
<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>View Primary Students</li>
</ol>
<div class="agile-grids">
				<!-- tables -->
			<div class="row">

				<div class="agile-tables col-md-8">

					<div class="w3l-table-info">

						<h2>STUDENT INFORMATION</h2>
							<table>
									<a href="manage-students2.php" class="btn btn-warning" style="margin-right:25px">Back</a><a href="remove-student.php?id=<?php echo $id; ?>&school=primary" class="btn btn-warning" style="background-color:red; color:white;">Remove</a>
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
				<img id="psp" alt="passport" src = "../studs/primary passports/<?php echo htmlentities($passport); ?>" class="img-responsive img-thumbnail"/>
				<div class="col-md-6">
					<script type="text/javascript" src="js/passport.js"></script>
					<form class="" action="change-passport.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
						<input type="hidden" name="school" value="pri">
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
<div class="inner-block">

</div>
<!--inner block end here-->
<!--copy rights start here-->
<?php include('includes/footer.php');?>
<!--COPY rights end here-->
</div>
</div>
  <!--//content-inner-->
		<!--/sidebar-menu-->
						<?php include('includes/sidebarmenu.php');?>
							  <div class="clearfix"></div>
							</div>
							<script>
							var toggle = true;

							$(".sidebar-icon").click(function() {
							  if (toggle)
							  {
								$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
								$("#menu span").css({"position":"absolute"});
							  }
							  else
							  {
								$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
								setTimeout(function() {
								  $("#menu span").css({"position":"relative"});
								}, 400);
							  }

											toggle = !toggle;
										});
							</script>
<!--js -->
<script src="js/jquery.nicescroll.js"></script>
<script src="js/scripts.js"></script>
<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.min.js"></script>
   <!-- /Bootstrap Core JavaScript -->

</body>
</html>
<?php } ?>
