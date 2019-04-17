<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{
header('location:index.php');
exit;
}
else{
    if(isset($_GET['cl'])){
        $cl = $_GET['cl'];
    }
    else{
        $cl = 1;
    }
	?>
<!DOCTYPE HTML>
<html>
<head>
<title>Admin Manage Students</title>
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
<!-- tables -->
<link rel="stylesheet" type="text/css" href="css/table-style.css" />
<link rel="stylesheet" type="text/css" href="css/basictable.css" />
<script type="text/javascript" src="js/jquery.basictable.min.js"></script>
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
<!--heder end here-->
<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>Manage Students</li>
            </ol>
<div class="agile-grids">
				<!-- tables -->

				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h2>
							Manage Students
							<span class="pull-right">
								<a href="manage-students.php?cl=<?php echo $cl; ?>&cl2=A" class="btn btn-default <?php if(isset($_GET['cl2']) && $_GET['cl2'] == "A"){echo 'active';} ?>">A</a>
					      <a href="manage-students.php?cl=<?php echo $cl; ?>&cl2=B" class="btn btn-default <?php if(isset($_GET['cl2']) && $_GET['cl2'] == "B"){echo 'active';} ?>">B</a>
					   <!--   <a href="manage-students.php?cl=<?php echo $cl; ?>&cl2=C" class="btn btn-default <?php if(isset($_GET['cl2']) && $_GET['cl2'] == "C"){echo 'active';} ?>">C</a>-->
								<!--<a href="manage-students.php?cl=<?php echo $cl; ?>&cl2=D" class="btn btn-default <?php if(isset($_GET['cl2']) && $_GET['cl2'] == "D"){echo 'active';} ?>">D</a>-->
					   <!--   <a href="manage-students.php?cl=<?php echo $cl; ?>&cl2=E" class="btn btn-default <?php if(isset($_GET['cl2']) && $_GET['cl2'] == "E"){echo 'active';} ?>">E</a>				-->
							</span>
						</h2>
					    <table id="table">
					        <div class="btn-group  pull-right">
                                 <a href="manage-students.php?cl=1" class="btn btn-default <?php if($cl == 1){echo 'active';} ?>">Pre-School</a>
                                 <a href="manage-students.php?cl=2" class="btn btn-default <?php if($cl == 2){echo 'active';} ?>">Pre-K1</a>
                                 <a href="manage-students.php?cl=3" class="btn btn-default <?php if($cl == 3){echo 'active';} ?>">Pre-K2</a>
                                 <a href="manage-students.php?cl=4" class="btn btn-default <?php if($cl == 4){echo 'active';} ?>">Kindergaten</a>
                                 <a href="manage-students.php?cl=5" class="btn btn-default <?php if($cl == 5){echo 'active';} ?>">Grade 1</a>
                                 <a href="manage-students.php?cl=6" class="btn btn-default <?php if($cl == 6){echo 'active';} ?>">Grade 2</a>
                                 <a href="manage-students.php?cl=7" class="btn btn-default <?php if($cl == 7){echo 'active';} ?>">Grade 3</a>
                                 <a href="manage-students.php?cl=8" class="btn btn-default <?php if($cl == 8){echo 'active';} ?>">Grade 4</a>
                                 <a href="manage-students.php?cl=9" class="btn btn-default <?php if($cl == 9){echo 'active';} ?>">Grade 5</a>
                            </div>
						<thead>
						  <tr>
						  <th>Passport</th>
						  <th>S/No</th>
							<th>Full Name</th>
							<th>Regno</th>
							<th>Class</th>
							<th colspan="2" align="center">Admin Action</th>

						  </tr>
						</thead>
						<tbody>
						<?php
						if (isset($_GET['cl2'])) {
							$cl2 = htmlentities($_GET['cl2']);
							$sql = "SELECT * from accepted_students where school = 'primary' and current_class = '$cl' and class = '$cl2'";
						}
						else {
							$sql = "SELECT * from accepted_students where school = 'primary' and current_class = '$cl'";
						}
						$query = $dbh -> prepare($sql);
						//$query -> bindParam(':city', $city, PDO::PARAM_STR);
						$query->execute();
						$results=$query->fetchAll(PDO::FETCH_OBJ);
						$cnt=1;
						if($query->rowCount() > 0)
						{
						foreach($results as $result){
						?>
						<?php
              $sql = "SELECT class from classes where id = '$result->current_class'";
              $q = $dbh -> prepare($sql);
              //$query -> bindParam(':city', $city, PDO::PARAM_STR);
              $q->execute();
              $r = $q->fetch();
            ?>
						  <tr>
						    <td><img src = "../studs/secondary passports/<?php echo htmlentities($result->passport); ?>" class="img-responsive" style="max-height:70px;" /></td>
							<td><?php echo htmlentities($cnt);?></td>
							<td><?php echo htmlentities($result->fname);?></td>
							<td><?php echo htmlentities($result->regno);?></td>
							<td><?php echo htmlentities($r['class']);?></td>
							<td><a href="view-student.php?stud_id=<?php echo htmlentities($result->regno);?>"><button type="button" class="btn btn-primary btn-block">View</button></a></td>
							<td><a href="update-student-info.php?stud_id=<?php echo htmlentities($result->regno);?>"><button type="button" class="btn btn-primary btn-block">Edit</button></a></td>
						  </tr>
						 <?php $cnt=$cnt+1;} }
						 else{ ?>
							<tr><td class="text-center" colspan="6"><h3>There are no students in this class.</h3></td></tr>
						 <?php }?>
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
<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.min.js"></script>
   <!-- /Bootstrap Core JavaScript -->

</body>
</html>
<?php } ?>
