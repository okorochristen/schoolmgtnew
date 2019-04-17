<?php
session_start();
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
<title>Admin Dashboard</title>
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
<!--four-grids here-->
		<div class="four-grids container">
			<div class="row">
			<div class="col-md-3 col-xs-3 four-grid"><center>
			<div class="dashboard-stat bg-success">
				<div class="icon">
				<i class="glyphicon glyphicon-education" aria-hidden="true"></i>
				</div>
			<div class="four-text">
					<h3>Active Students</h3>

				<?php $sql = "SELECT id from accepted_students";
					$query = $dbh -> prepare($sql);
					$query->execute();
					$results=$query->fetchAll(PDO::FETCH_OBJ);
					$cnt=$query->rowCount();
				?>
				<h4> <?php echo htmlentities($cnt);?> </h4>
			</div>

			</div></center>
			</div>
		<div class="col-md-3 col-xs-3 four-grid">
			<div class="dashboard-stat bg-info"><center>
			<div class="icon">
				<i class="glyphicon glyphicon-user" aria-hidden="true"></i>
			</div>
			<div class="four-text">
				<h3>Secondary Students</h3>
					<?php $sql1 = "SELECT * from accepted_students where school = 'secondary'";
					$query1 = $dbh -> prepare($sql1);
					$query1->execute();
					$results1=$query1->fetchAll(PDO::FETCH_OBJ);
					$cnt1=$query1->rowCount();
										?>
			<h4><?php echo htmlentities($cnt1);?></h4>
			</div></center>
			</div>
		</div>

		<div class="col-md-3 col-xs-3 four-grid">
			<div class="dashboard-stat bg-warning"><center>
				<div class="icon">
					<i class="glyphicon glyphicon-user" aria-hidden="true"></i>
				</div>
				<div class="four-text">
					<h3>Primary Students</h3>
					<?php $sql2 = "SELECT * from accepted_students where school = 'primary'";
					$query2= $dbh -> prepare($sql2);
					$query2->execute();
					$results2=$query2->fetchAll(PDO::FETCH_OBJ);
					$cnt2=$query2->rowCount();
					?>
				<h4><?php echo htmlentities($cnt2);?></h4>
				</div>

						</div></center>
					</div>
					<div class="col-md-3 col-xs-3 four-grid">
						<div class="dashboard-stat bg-danger"><center>
							<div class="icon">
								<i class="glyphicon glyphicon-edit" aria-hidden="true"></i>
							</div>
							<div class="four-text">
			<h3>Active Teachers</h3>
			<?php $sql3 = "SELECT teacher_id from teachers";
				$query3= $dbh -> prepare($sql3);
				$query3->execute();
				$results3=$query3->fetchAll(PDO::FETCH_OBJ);
				$cnt3=$query3->rowCount();
									?>
				<h4><?php echo htmlentities($cnt3);?></h4>
				</div>
				</div></center>
					</div>
						<div class="clearfix"></div>
				</div>
			</div>
		<div class="four-grids container">
			<div class="row">
					<div class="col-md-3 col-xs-3 four-grid">
						<div class="dashboard-stat bg-primary"><center>
							<div class="icon">
								<i class="glyphicon glyphicon-user" aria-hidden="true"></i>
							</div>
							<div class="four-text">
								<h3>Male Staff</h3>
						<?php $sql4 = "SELECT * from teachers where gender='Male'";
						$query4= $dbh -> prepare($sql4);
						$query4->execute();
						$results4=$query4->fetchAll(PDO::FETCH_OBJ);
						$cnt4=$query4->rowCount();
											?>
								<h4><?php echo htmlentities($cnt4);?></h4>

							</div>
							</center>
						</div>
					</div>

			<div class="col-md-3 col-xs-3 four-grid">
			<div class="dashboard-stat bg-danger"><center>
				<div class="icon">
					<i class="glyphicon glyphicon-new-window" aria-hidden="true"></i>
				</div>
			<div class="four-text">
			<h3>Female Staff</h3>
		<?php $sql5 = "SELECT * from teachers where gender='Female'";
			$query5= $dbh -> prepare($sql5);
			$query5->execute();
			$results5=$query5->fetchAll(PDO::FETCH_OBJ);
			$cnt5=$query5->rowCount();
		?>
		<h4><?php echo htmlentities($cnt5);?></h4>
			</div>
			</center>
			</div>
		</div>
		<div class="col-md-3 col-xs-3 four-grid">
			<div class="dashboard-stat bg-warning"><center>
				<div class="icon">
					<i class="glyphicon glyphicon-text-color" aria-hidden="true"></i>
				</div>
			<div class="four-text">
				<h3>Pending Secondary</h3>
		<?php $sql6 = "SELECT id from students where status ='pending'";
			$query6= $dbh -> prepare($sql6);
			$query6->execute();
			$results6=$query6->fetchAll(PDO::FETCH_OBJ);
			$cnt6=$query6->rowCount();
		?>
		<h4><?php echo htmlentities($cnt6);?></h4>
			</div>
		</center>
			</div>
		</div>
		<div class="col-md-3 col-xs-3 four-grid">
			<div class="dashboard-stat bg-primary"><center>
				<div class="icon">
					<i class="glyphicon glyphicon-duplicate" aria-hidden="true"></i>
				</div>
			<div class="four-text">
				<h3>Accepted Students</h3>
		<?php
			$sql11 = "SELECT id from students where status ='accepted'";
			$query11= $dbh -> prepare($sql11);
			$query11->execute();
			$results11=$query11->fetchAll(PDO::FETCH_OBJ);
			$cnt11=$query11->rowCount();
		?>
		<h4><?php echo htmlentities($cnt11);?></h4>
			</div>
		</center>
			</div>
		</div>

		<div class="four-grids container">
			<div class="row">
				<div class="col-md-3 col-xs-3 four-grid">
			<div class="dashboard-stat bg-primary"><center>
				<div class="icon">
					<i class="glyphicon glyphicon-duplicate" aria-hidden="true"></i>
				</div>
			<div class="four-text">
				<h3>Pending Primary</h3>
		<?php
			$sql12 = "SELECT id from primary_applicants where status ='pending'";
			$query12= $dbh -> prepare($sql12);
			$query12->execute();
			$results12=$query12->fetchAll(PDO::FETCH_OBJ);
			$cnt12=$query12->rowCount();
		?>
		<h4><?php echo htmlentities($cnt12);?></h4>
			</div>
		</center>
			</div>
		</div>
		<div class="col-md-3 col-xs-3 four-grid">
			<div class="dashboard-stat bg-primary"><center>
				<div class="icon">
					<i class="glyphicon glyphicon-duplicate" aria-hidden="true"></i>
				</div>
			<div class="four-text">
				<h3>Accepted Primary</h3>
		<?php
			$sql11 = "SELECT id from primary_applicants where status ='accepted'";
			$query11= $dbh -> prepare($sql11);
			$query11->execute();
			$results11=$query11->fetchAll(PDO::FETCH_OBJ);
			$cnt11=$query11->rowCount();
		?>
		<h4><?php echo htmlentities($cnt11);?></h4>
			</div>
		</center>
			</div>
		</div>
		</div>
	</div>
					<div class="clearfix"></div>
				</div>
<!--//four-grids here-->

<div class="inner-block">

</div>
<!--inner block end here-->
<!--copy rights start here-->
<?php include('includes/footer.php');?>
</div>
</div>

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
<!-- morris JavaScript -->
<script src="js/raphael-min.js"></script>
<script src="js/morris.js"></script>
<script>
	$(document).ready(function() {
		//BOX BUTTON SHOW AND CLOSE
	   jQuery('.small-graph-box').hover(function() {
		  jQuery(this).find('.box-button').fadeIn('fast');
	   }, function() {
		  jQuery(this).find('.box-button').fadeOut('fast');
	   });
	   jQuery('.small-graph-box .box-close').click(function() {
		  jQuery(this).closest('.small-graph-box').fadeOut(200);
		  return false;
	   });

	    //CHARTS
	    function gd(year, day, month) {
			return new Date(year, month - 1, day).getTime();
		}

		graphArea2 = Morris.Area({
			element: 'hero-area',
			padding: 10,
        behaveLikeLine: true,
        gridEnabled: false,
        gridLineColor: '#dddddd',
        axes: true,
        resize: true,
        smooth:true,
        pointSize: 0,
        lineWidth: 0,
        fillOpacity:0.85,
			data: [
				{period: '2014 Q1', iphone: 2668, ipad: null, itouch: 2649},
				{period: '2014 Q2', iphone: 15780, ipad: 13799, itouch: 12051},
				{period: '2014 Q3', iphone: 12920, ipad: 10975, itouch: 9910},
				{period: '2014 Q4', iphone: 8770, ipad: 6600, itouch: 6695},
				{period: '2015 Q1', iphone: 10820, ipad: 10924, itouch: 12300},
				{period: '2015 Q2', iphone: 9680, ipad: 9010, itouch: 7891},
				{period: '2015 Q3', iphone: 4830, ipad: 3805, itouch: 1598},
				{period: '2015 Q4', iphone: 15083, ipad: 8977, itouch: 5185},
				{period: '2016 Q1', iphone: 10697, ipad: 4470, itouch: 2038},
				{period: '2016 Q2', iphone: 8442, ipad: 5723, itouch: 1801}
			],
			lineColors:['#ff4a43','#a2d200','#22beef'],
			xkey: 'period',
            redraw: true,
            ykeys: ['iphone', 'ipad', 'itouch'],
            labels: ['All Visitors', 'Returning Visitors', 'Unique Visitors'],
			pointSize: 2,
			hideHover: 'auto',
			resize: true
		});


	});
	</script>
</body>
</html>
<?php } ?>
