<?php
session_start();

if(!isset($_GET['status'])){
	$status = "pending";
}
else{
	$status = $_GET['status'];
}

error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{
header('location:index.php');
}
else{
	?>
<!DOCTYPE HTML>
<html>
<head>
<title>Admin View Applicants</title>
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
<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.min.js"></script>
<!-- //jQuery -->
<!-- tables -->
<link rel="stylesheet" type="text/css" href="css/table-style.css" />
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
<!--heder end here-->
<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Home</a><i class="fa fa-angle-right"></i>Applicants</li>
            </ol>
<div class="agile-grids">
				<!-- tables -->

				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h2>Secondary Applicants List</h2>
					    <table id="table" class="">
					    <div class="btn-group  pull-right">
     <a href="applicants.php?status=pending" class="btn btn-default <?php if($status == "pending"){echo 'active';} ?>">Pending</a>
     <a href="applicants.php?status=accepted" class="btn btn-default <?php if($status == "accepted"){echo 'active';} ?>">Accepted</a>
     <a href="applicants.php?status=declined" class="btn btn-default <?php if($status == "declined"){echo 'active';} ?>">Declined</a>
    </div>
						<thead>
						  <tr>
						  <th>S/No</th>
							<th>Full Name</th>
							<th>Gender</th>
							<th>DOB</th>
							<th>State</th>
							<th>LGA</th>
							<th>Address</th>
							<th>Parent</th>
							<th>Parent N0</th>
							<th>Class</th>
							<?php if ($status == 'pending'): ?>
								<th style="text-align:center" colspan="2">Action</th>
							<?php endif; ?>
						  </tr>
						</thead>
						<tbody>
						<?php $sql = "SELECT * from students where status = '$status'";
						$query = $dbh -> prepare($sql);
						//$query -> bindParam(':city', $city, PDO::PARAM_STR);
						$query->execute();
						$results=$query->fetchAll(PDO::FETCH_OBJ);
						$cnt=1;
						if($query->rowCount() > 0)
						{
						foreach($results as $result){
						    $sql = "SELECT class from classes where id = '$result->class_app'";
                              $q = $dbh -> prepare($sql);
                              //$query -> bindParam(':city', $city, PDO::PARAM_STR);
                              $q->execute();
                              $r = $q->fetch();
						?>
						  <tr>
							<td><?php echo htmlentities($cnt);?></td>
							<td><?php echo htmlentities($result->fname);?></td>
							<td><?php echo htmlentities($result->gender);?></td>
							<td><?php echo htmlentities($result->dob);?></td>
							<td><?php echo htmlentities($result->state);?></td>
							<td><?php echo htmlentities($result->lga);?></td>
							<td><?php echo htmlentities($result->address);?></td>
							<td><?php echo htmlentities($result->parent);?></td>
							<td><?php echo htmlentities($result->parent_num);?></td>
							<td><?php echo htmlentities($r['class']);?></td>
							<?php if ($result->status == "pending"): ?>
								<td>
									<!-- Trigger the modal with a button -->
									<a href="abc.php?id=<?php echo htmlentities($result->regno);?>&school=sec&class=<?php echo $result->class_app; ?>
										&session=<?php echo $result->start_session; ?>"><button type="button" class="btn btn-primary btn-block">Accept</button></a>
								</td>
								<td><a href="decline-student.php?stud_id=<?php echo htmlentities($result->regno);?>"><button type="button" class="btn btn-danger btn-block">Decline</button></a></td>
							<?php endif; ?>
							</tr>
						 <?php $cnt=$cnt+1;} }?>
						</tbody>
					  </table>
					</div>
			</div>
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

   <!-- /Bootstrap Core JavaScript -->

</body>
</html>
<?php } ?>
