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
		$school = "secondary";
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
<!DOCTYPE HTML>
<html>
<head>
<title>Add Students</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Bootstrap core CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
<!-- Material Design Bootstrap -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.4/css/mdb.min.css" rel="stylesheet">
<!--<link href="assets/css/style.css" rel='stylesheet' type='text/css' />-->
<link rel="stylesheet" href="assets/css/morris.css" type="text/css"/>
<!-- Graph CSS -->
<link href="assets/css/font-awesome.css" rel="stylesheet">
<!-- jQuery -->
<script src="assets/js/jquery-2.1.4.min.js"></script>
<!-- //jQuery -->
<!-- tables -->
<!--<link rel="stylesheet" type="text/css" href="assets/css/table-style.css" />-->
<!--<link rel="stylesheet" type="text/css" href="assets/css/basictable.css" />-->
<!--<script type="text/javascript" src="assets/js/jquery.basictable.min.js"></script>-->
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
<body class="bglight bgwhite">
<div class="container"> 
    <div class="col-9 offset-2" style="margin-top: 40px">
        <div class="card card-primary">
            <div class="card-header bg-primary text-white">
               <h3 class="text-center">Add New Student</h3> 
            </div>
						<div class="card-body">
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
										<input type="text" class="form-control1" name="state" placeholder="State of Origin" required>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Local Government</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="lga" placeholder="Local Government" required>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Nationality</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="nationality" placeholder="Nationality" required>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Religion</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="religion" placeholder="Religion" required>
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
				<button type="reset" class="btn-danger btn">Reset</button>
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
		<!--<script>-->
		<!--$(document).ready(function() {-->
		<!--	 var navoffeset=$(".header-main").offset().top;-->
		<!--	 $(window).scroll(function(){-->
		<!--		var scrollpos=$(window).scrollTop();-->
		<!--		if(scrollpos >=navoffeset){-->
		<!--			$(".header-main").addClass("fixed");-->
		<!--		}else{-->
		<!--			$(".header-main").removeClass("fixed");-->
		<!--		}-->
		<!--	 });-->

		<!--});-->
		<!--</script>-->
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
					<?php #include("includes/sidebar.php");?>
							  <div class="clearfix"></div>
							</div>
							<!--<script>-->
							<!--var toggle = true;-->

							<!--$(".sidebar-icon").click(function() {-->
							<!--  if (toggle)-->
							<!--  {-->
							<!--	$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");-->
							<!--	$("#menu span").css({"position":"absolute"});-->
							<!--  }-->
							<!--  else-->
							<!--  {-->
							<!--	$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");-->
							<!--	setTimeout(function() {-->
							<!--	  $("#menu span").css({"position":"relative"});-->
							<!--	}, 400);-->
							<!--  }-->

							<!--				toggle = !toggle;-->
							<!--			});-->
							<!--</script>-->
<!--js -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.13.0/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.4/js/mdb.min.js"></script>
   <!-- /Bootstrap Core JavaScript -->

</body>
</html>
<?php } ?>
