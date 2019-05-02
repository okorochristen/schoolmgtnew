<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'on');
error_reporting(0);

function genReg($n){
	++$n;
	while(strlen($n) < 3){
		$n = "0".$n;
	}
	$regn = "RHI-SEC/".date('y')."/".$n;
	return $regn;
}

if(strlen($_SESSION['alogin'])==0)
	{
header('Location:index.php');
}
else{
if(isset($_POST['submit']))

{
		include('includes/config.php');
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
<!DOCTYPE HTML>
<html>
<head>
<title>Admin Add Students</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="images/cocinlogo.jpg" type="image/jpg">
<meta name="keywords" content="Pooled Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/morris.css" type="text/css"/>
<link href="css/font-awesome.css" rel="stylesheet">
<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/sc.js"></script>
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
<body onload="master()">
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
                <li class="breadcrumb-item"><a href="index.html">Home</a><i class="fa fa-angle-right"></i>Add Student Details </li>
            </ol>
		<!--grid-->
 	<div class="grid-form">

<!---->
  <div class="grid-form1">
  	       <h3>Add Students</h3>
  	        	  <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>: <span style="color:red">OOPS! </span><?php echo htmlentities($error); ?> </div><?php }
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
				<?php
					include 'includes/db.php';
					$q = $db->prepare('SELECT class, id from classes');
					$q->execute();
					$q->bind_result($class, $classid);
				?>
  	         	<div class="tab-content">
						<div class="tab-pane active" id="horizontal-form">
							<form class="form-horizontal" name="" method="post" enctype="multipart/form-data">
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Full Name</label>
									<div class="col-sm-8">
									<input type="text" class="form-control1" name="fname" placeholder="Full Name" required>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Reg Number</label>
									<div class="col-sm-8">
									<input type="text" class="form-control1" name="regno" placeholder="Reg Number" required>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Gender</label>
									<div class="col-sm-8">
										<select class="form-control1" name="gender" required>
											<option>Select Gender</option>
											<option value="Male">Male</option>
											<option value="Female">Female</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Date of Birth</label>
									<div class="col-sm-8">
										<input type="date" name="dob" class="form-control1" placeholder="Date of Birth" required>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">State of Origin</label>
									<div class="col-sm-8">
									<select name="state" id="state" class="col-sm-12">
							  <option>- Select -</option> 
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
						<option value='Islam'>Others</option>
				
						</select>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Religion</label>
									<div class="col-sm-8">
										<select name="religion" id="religion" class="col-sm-12">
						<option value="">- Select -</option> 
						<option value='Christianity'>Christianity</option>
						<option value='Islam'>Islam</option>
						<option value='Others'>Others</option>
						</select>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Class</label>
									<div class="col-sm-8">
										<select class="form-control1" name="class_app" required id="sl" onchange="master()">
											<option value="">Select Class</option>
											<?php while($q->fetch()): ?>
												<option value="<?php echo $classid; ?>"><?php echo $class; ?></option>
											<?php endwhile; $q->close(); $db->close(); ?>
										</select>
									</div>
								</div>

								<div class="form-group" id="myd">
                  <div class="col-md-8">
                    <label class="radio-inline" id="l1"><input id="rd1" type="radio" name="cl" required value="A"> A </label>&nbsp&nbsp&nbsp&nbsp&nbsp
                    <label class="radio-inline" id="l2"><input id="rd2" type="radio" name="cl"  required value="B"> B </label>&nbsp&nbsp&nbsp&nbsp&nbsp
										<!--<label class="radio-inline" id="l2"><input id="rd2" type="radio" name="cl"  required value="C"> C </label>&nbsp&nbsp&nbsp&nbsp&nbsp-->
										<!--<label class="radio-inline" id="l2"><input id="rd2" type="radio" name="cl"  required value="D"> D </label>&nbsp&nbsp&nbsp&nbsp&nbsp-->
          <!--          <label class="radio-inline" id="l3"><input id="rd3" type="radio" name="cl"  required value="E"> E </label>-->
                  </div>
                </div>

								<div class="form-group">
									<labelfor="focusedinput" class="col-sm-2 control-label">Accadmic Session</label>
									<div class="col-sm-8">
										<select class="form-control1" name="session" required>
											<option>Select Session</option>
											<option value="<?php $m = date('Y'); $sy = $m + 1; echo $m.'/'.$sy; ?>"><?php echo $m.'/'.$sy; ?></option>
										<?php //if( date('m') == 1 ): ?>
											<option value="<?php $py = $m - 1; echo $py.'/'.$m; ?>"><?php echo $py.'/'.$m;?></option>
										<?php //endif; ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Home Address</label>
									<div class="col-sm-8">
										<textarea class="form-control1" rows="5" cols="50" name="address" placeholder="Home Address" required></textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Name of Parent/Guardian</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="parent" placeholder="Name of Parent/Guardian" required>
									</div>
								</div>

								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Mobile Number of Parent/Guardian</label>
									<div class="col-sm-8">
										<input type="number" class="form-control1" name="parent_num" placeholder="Mobile Number" required>
									</div>
								</div>

								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Upload students passport</label>
									<div class="col-sm-8">
										<input type="file" class="form-control1" name="passport" placeholder="passport" required>
									</div>
								</div>
			<div class="row">
			<div class="col-sm-8 col-sm-offset-3">
				<button type="submit" name="submit" class="btn-primary btn">Add</button>
				<button type="reset" class="btn-inverse btn">Reset</button>
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
<script src="js/lga.js"></script>
<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.min.js"></script>
   <!-- /Bootstrap Core JavaScript -->

</body>
</html>
<?php } ?>
