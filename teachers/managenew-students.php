<?php
session_start();
error_reporting(0);
include('config.php');
if(strlen($_SESSION['login'])==0)
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
								<a href="managenew-students.php?cl=<?php echo $cl; ?>&cl2=A" class="btn btn-default <?php if(isset($_GET['cl2']) && $_GET['cl2'] == "A"){echo 'active';} ?>">A</a>
					      <a href="managenew-students.php?cl=<?php echo $cl; ?>&cl2=B" class="btn btn-default <?php if(isset($_GET['cl2']) && $_GET['cl2'] == "B"){echo 'active';} ?>">B</a>
					   <!--   <a href="manage-students.php?cl=<?php echo $cl; ?>&cl2=C" class="btn btn-default <?php if(isset($_GET['cl2']) && $_GET['cl2'] == "C"){echo 'active';} ?>">C</a>-->
								<!--<a href="manage-students.php?cl=<?php echo $cl; ?>&cl2=D" class="btn btn-default <?php if(isset($_GET['cl2']) && $_GET['cl2'] == "D"){echo 'active';} ?>">D</a>-->
					   <!--   <a href="manage-students.php?cl=<?php echo $cl; ?>&cl2=E" class="btn btn-default <?php if(isset($_GET['cl2']) && $_GET['cl2'] == "E"){echo 'active';} ?>">E</a>				-->
							</span>
						</h2>
					    <table id="table">
					        <div class="btn-group  pull-right">
                                 <a href="managenew-students.php?cl=1" class="btn btn-default <?php if($cl == 1){echo 'active';} ?>">Pre-School</a>
                                 <a href="managenew-students.php?cl=2" class="btn btn-default <?php if($cl == 2){echo 'active';} ?>">Pre-K1</a>
                                 <a href="managenew-students.php?cl=3" class="btn btn-default <?php if($cl == 3){echo 'active';} ?>">Pre-K2</a>
                                 <a href="managenew-students.php?cl=4" class="btn btn-default <?php if($cl == 4){echo 'active';} ?>">Kindergaten</a>
                                 <a href="managenew-students.php?cl=5" class="btn btn-default <?php if($cl == 5){echo 'active';} ?>">Grade 1</a>
                                 <a href="managenew-students.php?cl=6" class="btn btn-default <?php if($cl == 6){echo 'active';} ?>">Grade 2</a>
                                 <a href="managenew-students.php?cl=7" class="btn btn-default <?php if($cl == 7){echo 'active';} ?>">Grade 3</a>
                                 <a href="managenew-students.php?cl=8" class="btn btn-default <?php if($cl == 8){echo 'active';} ?>">Grade 4</a>
                                 <a href="managenew-students.php?cl=9" class="btn btn-default <?php if($cl == 9){echo 'active';} ?>">Grade 5</a>
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
