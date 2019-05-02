<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'on');
error_reporting(1);

function genReg($n){
	++$n;
	while(strlen($n) < 3){
		$n = "0".$n;
	}
	$regn = "RHI-SEC/".date('y')."/".$n;
	return $regn;
}

if(strlen($_SESSION['login'])==0)
	{
header('Location:index.php');
}
else{
if(isset($_POST['submit']))

{
		include('config.php');
		$year = date('Y');
		$q0 = $dbh->prepare("select id from years where year = '$year'");
		$q0->execute();
		$results=$q0->fetchAll(PDO::FETCH_OBJ);
		if ($q0->rowCount() > 0) {
			$sq = "select stud_id from students";
			$q = $dbh->prepare($sq);
			$q->execute();
			$results=$q->fetchAll(PDO::FETCH_OBJ);
			$n=$q->rowCount();
		}
		else {
			$n = 0;
			$q = $dbh->prepare("INSERT into years (year) values ('$year')");
			$q->execute();
		}
		$school = "primary";
		$regno = $_POST['regno'];
		// var_dump($regno);
// 		$regno = genReg($n);
		$fname=$_POST['fname'];
		$gender=$_POST['gender'];
		$dob=$_POST['dob'];
		$religion=$_POST['religion'];
		$state=$_POST['state'];
		$lga=$_POST['lga'];
		$nationality=$_POST['nationality'];
		$class=$_POST['class_app'];
		$class2 = $_POST['cl'];
		$address=$_POST['address'];
		$parent=$_POST['parent'];
		$parent_num=$_POST['parent_num'];
		$session = $_POST['session'];
		$status = "accepted";

		if ($_FILES['passport']['error'] > 0) {
			$_SESSION['passport'] = 1;
		      header('Location:index.php?n=1');
		      exit;
		    }
		    elseif ( ($_FILES['passport']['type'] != 'image/png') && ($_FILES['passport']['type'] != 'image/jpg') && ($_FILES['passport']['type'] != 'image/jpeg') ) {
		    	$msg = "there's something wrong with the passport uploaded.";
		       header('Location:index.php?n=2');
		      exit;
		    }
		    else{
		    	$imageType = $_FILES['passport']['type'];
		      $image = $_FILES['passport']['tmp_name'];
					// var_dump($imageType);
		      if ($imageType == 'image/jpg' || $imageType == 'image/jpeg') {
		        $imageType = 'jpg';
		      }
		      elseif ($imageType == 'image/png') {
		        $imageType = 'png';
		      }

		      $passport = $fname."".date('Ymdhis').".".$imageType;
					$loc = "../studs/secondary applicants/".$passport;
					
		      if (move_uploaded_file($image, $loc)) {

				$query="INSERT INTO students(regno, fname, start_session, gender, dob, religion, state, lga, nationality, class_app, address, parent, parent_num, passport, status) VALUES (:regno, :fname, :session, :gender, :dob, :religion, :state, :lga,
        :nationality, :class, :address, :parent, :parent_num, :passport, :status)";

          $q = $dbh->prepare($query);
          $q->bindParam(':regno',$regno,PDO::PARAM_STR);
          $q->bindParam(':fname',$fname,PDO::PARAM_STR);
          $q->bindParam(':session',$session,PDO::PARAM_STR);
          $q->bindParam(':gender',$gender,PDO::PARAM_STR);
          $q->bindParam(':dob',$dob,PDO::PARAM_STR);
          $q->bindParam(':religion',$religion,PDO::PARAM_STR);
          $q->bindParam(':state',$state,PDO::PARAM_STR);
          $q->bindParam(':lga',$lga,PDO::PARAM_STR);
          $q->bindParam(':nationality',$nationality,PDO::PARAM_STR);
          $q->bindParam(':class',$class,PDO::PARAM_STR);
          $q->bindParam(':address',$address,PDO::PARAM_STR);
          $q->bindParam(':parent',$parent,PDO::PARAM_STR);
          $q->bindParam(':parent_num',$parent_num,PDO::PARAM_STR);
          $q->bindParam(':passport',$passport,PDO::PARAM_STR);
          $q->bindParam(':status',$status,PDO::PARAM_STR);

          if ($q->execute()) {
            $sql="INSERT INTO accepted_students(regno,fname,start_class,current_class, class, start_session, current_session, gender,dob,religion,state,lga,nationality,address,parent,parent_num,passport,school) VALUES(:regno,:fname,:sclass,:class, :class2,:ssession,:session,:gender,:dob,:religion,:state,:lga,:nationality,:address,:parent,:parent_num,:passport,:school)";

            $query = $dbh->prepare($sql);
            $query->bindParam(':regno',$regno,PDO::PARAM_STR);
            $query->bindParam(':fname',$fname,PDO::PARAM_STR);
            $query->bindParam(':sclass',$class,PDO::PARAM_STR);
            $query->bindParam(':class',$class,PDO::PARAM_STR);
            $query->bindParam(':class2',$class2,PDO::PARAM_STR);
            $query->bindParam(':ssession',$session,PDO::PARAM_STR);
            $query->bindParam(':session',$session,PDO::PARAM_STR);
            $query->bindParam(':gender',$gender,PDO::PARAM_STR);
            $query->bindParam(':dob',$dob,PDO::PARAM_STR);
            $query->bindParam(':religion',$religion,PDO::PARAM_STR);
            $query->bindParam(':state',$state,PDO::PARAM_STR);
            $query->bindParam(':lga',$lga,PDO::PARAM_STR);
            $query->bindParam(':nationality',$nationality,PDO::PARAM_STR);
            $query->bindParam(':address',$address,PDO::PARAM_STR);
            $query->bindParam(':parent',$parent,PDO::PARAM_STR);
            $query->bindParam(':parent_num',$parent_num,PDO::PARAM_STR);
            $query->bindParam(':passport',$passport,PDO::PARAM_STR);
            $query->bindParam(':school',$school,PDO::PARAM_STR);

            if(!$query->execute()){
                print_r(error_get_last());
                exit;
            }
            $lastInsertId = $dbh->lastInsertId();
            if($lastInsertId){
							$destination = '../studs/secondary passports/'.$passport;

              if(!copy($loc, $destination)){
                echo "couldnt transfer images.";
                exit;
              }
              $msg="Student added Successfully";
            }
            else{
              $error=" Something went wrong. Please try again";
              unlink($loc);
            }
          }
          else {
            $error=" Something went wrong. Please try again";
            unlink($loc);
          }
			}
			else {
				$error="Could not upload image! Check image type and size.";
			}
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

    <title>Teacher's Dashboard</title>

    <!-- Bootstrap core CSS -->
    <!--<link href="assets/css/bootstrap.css" rel="stylesheet">-->
    
    <!-- Font Awesome -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Bootstrap core CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
<!-- Material Design Bootstrap -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.4/css/mdb.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
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
	input,select{
padding:10px;
	}
  </style>
  <body>

  <section id="container" >
<?php include("includes/header.php");?>
<?php include("includes/sidebar.php");?>
      <section id="main-content">
          <section class="wrapper">
   <div class="page-container">
            <!-- <div class="clearfix" style="margin-top:5px;"></div> -->

<ol class="breadcrumb">
                <li class="breadcrumb-item" style="font-size:20px; color:#e74c3c;"><a href="dashboard.php" style="font-size:20px;">Home &nbsp</a><i class="fa fa-angle-right" style="font-size:20px; color:black;"></i>&nbsp Add Student </li>
            </ol>
		<!--grid-->
 	<div class="grid-form">

<!---->
<div class="grid-form1">
  	       <h3 style="color:#008de7">Add New Student</h3>
        						<!-- <div class="card card-primary" > -->
													<div class="card-body bg-white" height="700px">
																			<?php if($error){?><div class="errorWrap"><strong>ERROR</strong>: <span style="color:red">OOPS! </span><?php echo htmlentities($error); ?> </div><?php }
															else if($msg){?><div class="succWrap bg-sucess"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
															<?php
																include 'includes/db.php';
																$q = $db->prepare('SELECT class, id from classes');
																$q->execute();
																$q->bind_result($class, $classid);
															?>
  	        									<div class="tab-content">
																		<div class="tab-pane active" id="horizontal-form">

																			<!-- jdjkd -->
																			<form class="form-horizontal" name="" method="post" enctype="multipart/form-data">
																						<div class="form-group">
																							<label for="focusedinput" class="col-sm-2 control-label">Full Name</label>
																							<div class="col-sm-8">
																							<input type="text" class="form-control1 col-sm-12" name="fname" placeholder="Full Name" required>
																							</div>
																						</div>
																						<div class="form-group">
																							<label for="focusedinput" class="col-sm-2 control-label">Reg Number</label>
																							<div class="col-sm-8">
																							<input type="text" class="form-control1 col-sm-12" name="regno" placeholder="Reg Number" required>
																							</div>
																						</div>	
																						<div class="form-group">
																							<label for="focusedinput" class="col-sm-2 control-label">Gender</label>
																							<div class="col-sm-8">
																								<select class="form-control1 col-sm-12" name="gender" required>
																									<option>Select Gender</option>
																									<option value="Male">Male</option>
																									<option value="Female">Female</option>
																								</select>
																							</div>
																						</div>
																						<div class="form-group">
																										<label class="col-sm-2 control-label">Date of Birth</label>
			<div class="col-sm-8">																										<input type="date" name="dob" class="form-control1 col-sm-12" placeholder="Date of Birth" required>
				</div>
					</div>
			<div class="form-group">
										<label for="focusedinput" class="col-sm-2 control-label">State of Origin</label>
			<div class="col-sm-8">
							<select name="state" id="state" class="col-sm-12">
							  <option value="" selected="selected" >- Select -</option> 
							   <option value='Abia'>Abia</option>
							  <option value='Adamawa'>Adamawa</option>
							  <option value='AkwaIbom'>AkwaIbom</option>
							  <option value='Anambra'>Anambra</option>
							  <option value='Bauchi'>Bauchi</option>
							  <option value='Bayelsa'>Bayelsa</option>
							  <option value='Benue'>Benue</option>
							  <option value='Borno'>Borno</option>
							  <option value='Cross River'>Cross River</option>
							  <option value='Delta'>Delta</option>
							  <option value='Ebonyi'>Ebonyi</option>
							  <option value='Edo'>Edo</option>
							  <option value='Ekiti'>Ekiti</option>
							  <option value='Enugu'>Enugu</option>
							  <option value='FCT'>FCT</option>
							  <option value='Gombe'>Gombe</option>
							  <option value='Imo'>Imo</option>
							  <option value='Jigawa'>Jigawa</option>
							  <option value='Kaduna'>Kaduna</option>
							  <option value='Kano'>Kano</option>
							  <option value='Katsina'>Katsina</option>
							  <option value='Kebbi'>Kebbi</option>
							  <option value='Kogi'>Kogi</option>
							  <option value='Kwara'>Kwara</option>
							  <option value='Lagos'>Lagos</option>
							  <option value='Nasarawa'>Nasarawa</option>
							  <option value='Niger'>Niger</option>
							  <option value='Ogun'>Ogun</option>
							  <option value='Ondo'>Ondo</option>
							  <option value='Osun'>Osun</option>
							  <option value='Oyo'>Oyo</option>
							  <option value='Plateau'>Plateau</option>
							  <option value='Rivers'>Rivers</option>
							  <option value='Sokoto'>Sokoto</option>
							  <option value='Taraba'>Taraba</option>
							  <option value='Yobe'>Yobe</option>
							  <option value='Zamfara'>Zamafara</option>
							</select>
					</div>
					</div>
				<div class="form-group">
				<label for="focusedinput" class="col-sm-2 control-label">Local Government</label>
			<div class="col-sm-8">
			<select name="lga" id="lga" class="col-sm-12" required>
							</select>
				</div>
								</div>
					<div class="form-group">
					<label for="focusedinput" class="col-sm-2 control-label">Nationality</label>
									<div class="col-sm-8">
									<select name="religion" id="religion" class="col-sm-12">
						<option value="">- Select -</option> 
						<option value='Christianity'>Nigerian</option>
						<option value='Others'>Others</option>
						</select>																					</div>
					</div>
																						<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">Religion</label>
						<div class="col-sm-8">
						<select name="religion" id="religion" class="col-sm-12">
						<option value="" selected="selected" >- Select -</option> 
						<option value='Zamfara'>Christianity</option>
						<option value='Zamfara'>Islam</option>
						<option value='Zamfara'>Others</option>
						</select>
							</div>
						</div>
								<div class="form-group">
							<label for="focusedinput" class="col-sm-2 control-label">Class</label>
							<div class="col-sm-8">																		<select class="form-control1 col-sm-12" name="class_app" required id="sl" onchange="master()">
																									<option value="">Select Class</option>
									<?php while($q->fetch()): ?>																	<option value="<?php echo $classid; ?>"><?php echo $class; ?></option>
											<?php endwhile; $q->close(); $db->close(); ?>													</select>
														</div>
														</div>
												<div class="form-group" id="myd">
													<div class="col-md-8">
											<label class="radio-inline" id="l1"><input id="rd1" type="radio" name="cl" required value="A"> A </label>&nbsp&nbsp&nbsp&nbsp&nbsp
				<label class="radio-inline" id="l2"><input id="rd2" type="radio" name="cl"  required value="B"> B </label>&nbsp&nbsp&nbsp&nbsp&nbsp
																						
																								<!--<label class="radio-inline" id="l2"><input id="rd2" type="radio" name="cl"  required value="D"> D </label>&nbsp&nbsp&nbsp&nbsp&nbsp-->
																			<!--          <label class="radio-inline" id="l3"><input id="rd3" type="radio" name="cl"  required value="E"> E </label>-->
																							</div>
																						</div>
																						<div class="form-group">
																							<label for="focusedinput" class="col-sm-3 control-label">Academic Session</label>
																							<div class="col-sm-8">
																								<select class="form-control1 col-sm-12" name="session" required>
																									<option>Select Session</option>
										<option value="<?php $m = date('Y'); $sy = $m + 1; echo $m.'/'.$sy; ?>">
										<?php echo $m.'/'.$sy; ?></option>
										<?php //if( date('m') == 1 ): ?>
									<option value="<?php $py = $m - 1; echo $py.'/'.$m; ?>"><?php echo $py.'/'.$m;?></option>
																								<?php //endif; ?>
												</select>
												</div>																						</div>
										<div class="form-group">
									<label for="focusedinput" class="col-sm-4 control-label">Home Address</label>
										<div class="col-sm-6">
										<textarea class="form-control1 col-sm-12" style="height:120px;" name="address" placeholder="Home Address" required></textarea>
								</div>
										</div>
																						<div class="form-group">
																							<label for="focusedinput" class="col-sm-4 control-label">Name of Parent/Guardian</label>
																							<div class="col-sm-8">
																								<input type="text" class="form-control1 col-sm-12" name="parent" placeholder="Name of Parent/Guardian" required>
																							</div>
																						</div>
												<div class="form-group">
																				<label for="focusedinput" class="col-sm-6 control-label">Mobile Number of Parent/Guardian</label>
																							<div class="col-sm-8">
																								<input type="number" class="form-control1 col-sm-12" name="parent_num" placeholder="Mobile Number" required>
																							</div>
																						</div>
																						<div class="form-group">
																							<label for="focusedinput" class="col-sm-4 control-label">Upload students passport</label>
																							<div class="col-sm-8">
																								<input type="file" class="form-control1 col-sm-12" name="passport" placeholder="passport" required>
																							</div>
																						</div>
																						<div class="row">
																						<div class="col-sm-8 col-sm-offset-3">
																							<button type="submit" name="submit" class="btn-primary btn">Add</button>
																							<button type="reset" class="btn-danger btn">Reset</button>
																							</div>
																							
																						</div>
																			</form>
																			<!-- jdjd -->

																
																		</div>
															</div>
																			

   
  
													</div>
            				</div>
      <!--      <div class="col-md-2 col-sm-2 box0">-->
      <!--  <div>-->
      <!--</div></div>-->
   
              </div><!-- /row mt -->
						</div>





          </section>
      </section>
<?php #include("includes/footer.php");?>
  </section>
<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.13.0/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.4/js/mdb.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/jquery-1.8.3.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/jquery.sparkline.js"></script>
	<script src="assets/js/lga.js"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

    <script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="assets/js/gritter-conf.js"></script>

    <!--script for this page-->
    <script src="assets/js/sparkline-chart.js"></script>
	<script src="assets/js/zabuto_calendar.js"></script>
  </body>
<?php } ?>
