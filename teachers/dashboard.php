<?php
  session_start();
  error_reporting(E_ALL); ini_set('display_errors', 'on');
  include('includes/db.php');
  if( !isset($_SESSION['login']) )
    {
      header('Location:index.php');
      exit;
  }
  else{ ?>

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

            <div class="row">
            <div class="clearfix"></div>
                     <div class="col-md-4 col-sm-2 box0">
    	<div class="box1">
			<span class="li_news"></span>
      <?php
        $q = $db->prepare("SELECT count(id) FROM accepted_students");
        $q->execute();
        $q->bind_result($num1);
        $q->fetch();
        $q->close();
    {?>
					  			<h3><?php echo htmlentities($num1);?> STUDENTS</h3>
                  			</div>
					  			<p><?php echo htmlentities($num1);?>   Students</p>
                  		</div>
                      <?php }?>


                     
                    
                    
                <div class="col-md-4 col-sm-2 box0">
                        <div class="box1">
                          <span class="li_news"></span>
                          <?php
                            $q = $db->prepare("SELECT count(id) FROM result");
                            $q->execute();
                            $q->bind_result($num3);
                            $q->fetch();
                            $q->close();
                        {?>

                          <h3><?php echo htmlentities($num3);?> RESULTS </h3>
                        </div>
                        <p><?php echo htmlentities($num3);?>  Results</p>
                      </div>
                    <?php }?>
                       <div class="col-md-4 col-sm-2 box0">
                        <div class="box1">
                          <span class="li_news"></span>
                          <?php
                            $q = $db->prepare("SELECT count(id) FROM subjects");
                            $q->execute();
                            $q->bind_result($num4);
                            $q->fetch();
                            $q->close();
                        {?>

                          <h3><?php echo htmlentities($num4);?> SUBJECTS </h3>
                        </div>
                        <p><?php echo htmlentities($num4);?>  Subjects</p>
                      </div>
                    <?php }?>

            </div>
            </div>
      <!--      <div class="col-md-2 col-sm-2 box0">-->
      <!--  <div>-->
      <!--</div></div>-->
   
                  	</div><!-- /row mt -->






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
