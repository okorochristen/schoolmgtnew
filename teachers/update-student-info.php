<?php
session_start();
error_reporting(0);
include('config.php');
if(strlen($_SESSION['login'])==0)
	{
header('location:index.php');
}
else{
$pid= $_GET['stud_id'];
if(isset($_POST['submit']))
{
$fname=$_POST['fname'];
$gender=$_POST['gender'];
$dob=$_POST['dob'];
$state=$_POST['state'];
$lga=$_POST['lga'];
$class_app=$_POST['class_app'];
$address=$_POST['address'];
$parent=$_POST['parent'];
$parent_num=$_POST['parent_num'];

$sql="UPDATE accepted_students SET fname=:fname, gender=:gender, dob=:dob, state=:state, lga=:lga, current_class=:class_app, address=:address, parent=:parent, parent_num=:parent_num where regno = :pid ";
$query = $dbh->prepare($sql);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':gender',$gender,PDO::PARAM_STR);
$query->bindParam(':dob',$dob,PDO::PARAM_STR);
$query->bindParam(':state',$state,PDO::PARAM_STR);
$query->bindParam(':lga',$lga,PDO::PARAM_STR);
$query->bindParam(':class_app',$class_app,PDO::PARAM_STR);
$query->bindParam(':address',$address,PDO::PARAM_STR);
$query->bindParam(':parent',$parent,PDO::PARAM_STR);
$query->bindParam(':parent_num',$parent_num,PDO::PARAM_STR);
$query->bindParam(':pid',$pid,PDO::PARAM_STR);

if (!$query->execute()) {
	print_r (error_get_last());
	exit;
};
$msg="Student's Information Updated Successfully";
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
<?php# include('includes/header.php');?>

				     <div class="clearfix"> </div>
				</div>
<!--heder end here-->
	<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i> Update Student's Information </li>
            </ol>
		<!--grid-->
 	<div class="grid-form">

<!---->
  <div class="grid-form1">
  	       <h3>Update Student's Information</h3>
  	        	  <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php }
					else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
  	         		<div class="tab-content">
					<div class="tab-pane active" id="horizontal-form">

<?php
$stud_id= $_GET['stud_id'];
$sql = "SELECT * FROM accepted_students WHERE regno = :stud_id";
$query = $dbh -> prepare($sql);
$query -> bindParam(':stud_id', $stud_id, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{	?>

							<form class="form-horizontal" name="package" method="post" enctype="multipart/form-data">
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Full Name</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="fname"  placeholder="Full Name" value="<?php echo htmlentities($result->fname);?>" required>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Gender</label>
									<div class="col-sm-8">
										<input type="text"  name="gender" value="<?php echo htmlentities($result->gender);?>" class="form-control1 ">
									</div>
								</div>

								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Date of Birth</label>
									<div class="col-sm-8">
										<input type="date" class="form-control1" name="dob" value="<?php echo htmlentities($result->dob);?>" required>
									</div>
								</div>

								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">State of Origin</label>
									<div class="col-sm-8">
										<input type="text" name="state" placeholder="State of Origin" class="form-control1" value="<?php echo htmlentities($result->state); ?>">
									</div>
								</div>

								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Local Government</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="lga"  placeholder="Local Government" value="<?php echo htmlentities($result->lga);?>" required>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Nationality</label>
									<div class="col-sm-8">
										<input type="text" name="state" placeholder="State of Origin" class="form-control1" value="<?php echo htmlentities($result->nationality); ?>">
									</div>
								</div>
								<div class="form-group">
									<?php
										$q = $dbh->prepare("select id, class from classes");
										$q->execute();
								  ?>
									<label for="focusedinput" class="col-sm-2 control-label">Class</label>
									<div class="col-sm-8">
										<select class="form-control1" name="class_app" required>
											<?php while($r = $q->fetch()): ?>
												<option value="<?php echo $r['id']; ?>" <?php if($result->current_class == $r['id']){echo "selected";} ?>><?php echo $r['class']; ?></option>
											<?php endwhile; ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Contact Address</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="address" rows="5" value="<?php echo htmlentities($result->address);?>" required>

									</div>
								</div>

								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Parent/Guardian</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="parent"  placeholder="Parent/Guardian" value="<?php echo htmlentities($result->parent);?>" required>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Parent/Guardian's Number</label>
									<div class="col-sm-8">
										<input type="number" class="form-control1" name="parent_num"  placeholder="Parent/Guardian Number" value="<?php echo htmlentities($result->parent_num);?>" required>
									</div>
								</div>
							<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Last Updation Date</label>
									<div class="col-sm-8">
							<?php echo htmlentities($result->register_date);?>
									</div>
								</div>
								<?php }} ?>

								<div class="row">
							<div class="col-sm-8 col-sm-offset-2">
							<button type="submit" name="submit" class="btn-primary btn">Update</button>
						</div>
					</div>
					</div>

					</form>

      <div class="panel-footer">

	 </div>
    </form>
  </div>
 	</div>
 	<!--//grid-->

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
</body>
</html>
<?php } ?>
