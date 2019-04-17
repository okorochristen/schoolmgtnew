<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
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
<!DOCTYPE HTML>
<html>
<head>
<title>SMS | Admin Update Student's Information</title>
<link rel="shortcut icon" href="images/cocinlogo.jpg" type="image/jpg">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Pooled Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/morris.css" type="text/css"/>
<link href="css/font-awesome.css" rel="stylesheet">
<script src="js/jquery-2.1.4.min.js"></script>
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
  <style>
		.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
		</style>

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
										$q = $dbh->prepare("select id, class from pri_class");
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
