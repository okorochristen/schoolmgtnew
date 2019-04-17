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
	$regn = "SPAPRI/".date('y')."/".$n;
	return $regn;
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Primary School Registration</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="images/school.png" type="image/png">
<script type="applijewelleryion/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<link href="css/font-awesome.css" rel="stylesheet">
<!-- Custom Theme files -->
<script src="js/jquery-1.12.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!--animate-->
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->
</head>
<body style="background-color: #DCDCDC">

</body>
</html>

<?php if(isset($_POST['submit'])):

	include 'includes/config.php';
	$year = date('Y');
	$q0 = $dbh->prepare("select id from years where year = '$year'");
	$q0->execute();
	$results=$q0->fetchAll(PDO::FETCH_OBJ);
	if ($q0->rowCount() > 0) {
		$sq = "select id from primary_applicants";
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
	$regno = genReg($n);
$fname=$_POST['fname'];
$gender=$_POST['gender'];
$dob=($_POST['dob']);
$religion=($_POST['religion']);
$state=($_POST['state']);
$lga=($_POST['lga']);
$nationality=($_POST['nationality']);
$class_app=($_POST['class_app']);
$address=($_POST['address']);
$parent=($_POST['parent']);
$parent_num=($_POST['parent_num']);
$start_session = $_POST['start_session'];

if ($_FILES['passport']['error'] > 0) {
	$_SESSION['msg'] = "There's something wrong with the uploaded image";
      header('Location:primary.php?n=1');
      exit;
    }
    elseif($_FILES['passport']['size'] > 512000){
        $_SESSION['msg'] = "Only images not greater than 500kb allowed";
        header('Location:primary.php?n=1');
        exit;
    }
    elseif ( ($_FILES['passport']['type'] != 'image/png') && ($_FILES['passport']['type'] != 'image/jpg') && ($_FILES['passport']['type'] != 'image/jpeg') ) {
    	$_SESSION['msg'] = "there's something wrong with the passport uploaded.";
       header('Location:primary.php?n=2');
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
      $loc = "primary applicants/".$passport;

      if (move_uploaded_file($image, $loc)) {

      	$sql="INSERT INTO  primary_applicants (regno, fname, start_session, gender, dob, religion, state, lga, nationality, class_app, address, parent, parent_num, passport) VALUES(:regno,:fname,:start_session,:gender,:dob,:religion,:state,:lga,:nationality,:class_app,:address,:parent,:parent_num,:passport)";
				$query = $dbh->prepare($sql);
				$query->bindParam(':regno',$regno,PDO::PARAM_STR);
				$query->bindParam(':fname',$fname,PDO::PARAM_STR);
				$query->bindParam(':start_session',$start_session,PDO::PARAM_STR);
				$query->bindParam(':gender',$gender,PDO::PARAM_STR);
				$query->bindParam(':dob',$dob,PDO::PARAM_STR);
				$query->bindParam(':religion',$religion,PDO::PARAM_STR);
				$query->bindParam(':state',$state,PDO::PARAM_STR);
				$query->bindParam(':lga',$lga,PDO::PARAM_STR);
				$query->bindParam(':nationality',$nationality,PDO::PARAM_STR);
				$query->bindParam(':class_app',$class_app,PDO::PARAM_STR);
				$query->bindParam(':address',$address,PDO::PARAM_STR);
				$query->bindParam('parent',$parent,PDO::PARAM_STR);
				$query->bindParam(':parent_num',$parent_num,PDO::PARAM_STR);
				$query->bindParam(':passport',$passport,PDO::PARAM_STR);

				if($query->execute()){
					$_SESSION['msg']="You are Scuccessfully registered.";
					echo '<script>alert("You have succesfully registered.");
							window.history.back();
							</script>';
					header('Location:primary.php');

				}
				else{
					$_SESSION['msg']="Something went wrong. Please try again.";
					unlink($loc);
					header('Location:primary.php');


				}
      }
      else{
				$_SESSION['msg']="Something went wrong. Please try again.";
				header('Location:primary.php');

      }
    }


?>
<?php else:
	include('../teachers/includes/home.php');
	include 'includes/db.php';

	$q = $db->prepare('SELECT id, class from pri_class');
	$q->execute();
	$q->bind_result($classid, $class);
	$q->store_result();
?>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<style>
	.input-lg{
		border-radius: 0
	}
	body{
	    background-color:#F0FFF0;
	}
</style>


<h2 class="text-center">Primary Application Form</h2>
<p class="text-center size18">Fill in your details</p>
</div>

<section>
	<div class="container">
		<?php if (isset($_SESSION['msg'])): ?>
			<div class="alert alert-info text-center">
				<?php echo $_SESSION['msg']; ?>
			</div>
		<?php endif; unset($_SESSION['msg']); ?>

	<form name="signup" method="post" enctype="multipart/form-data">
	<div class="row">
<div class="form-group col-sm-6">
	<label>Full Name</label>
	<input type="text" placeholder="First Name" name="fname" class="form-control input-lg" required="required">
</div>
<div class="form-group col-sm-6">
	<label>Gender</label>
	<select name="gender" class="form-control input-lg" required>
		<option>Select Gender</option>
		<option value="Male">Male</option>
		<option value="Female">Female</option>
	</select>
</div>

<div class="form-group col-sm-6">
	<label>Date of Birth</label>
	<input type="date" name="dob" placeholder="Date of Birth" class="form-control input-lg" required="required">
</div>
<div class="form-group col-sm-6">
	<label>Religion</label>
	<input type="text" name="religion" placeholder="Religion" class="form-control input-lg" required="required">
</div>
</div>
<div class="row">
<div class="form-group mt17 col-sm-4">
    <label>State of Origin</label>
	<?php
			$q0= $db->prepare('select state from states_in_nigeria order by state');
			$q0->execute();
			$q0->bind_result($states);
	 ?>
	<select class="form-control input-lg" name="state" required>
		<option value="">State of Origin</option>
		<?php while($q0->fetch()): ?>
			<option value="<?php echo $states; ?>"><?php echo $states; ?></option>
		<?php endwhile; ?>
		<?php $q0->close(); ?>
	</select>
</div>
<div class="form-group mt17 col-sm-4">
	<label>Local Government</label>
	<input type="text" name="lga" placeholder="Local Government" class="form-control input-lg" required="required">
</div>

<div class="form-group mt17 col-sm-4">
	<label>Nationality</label>
	<input type="text" name="nationality" placeholder="Nationality" class="form-control input-lg" required="required">
</div>
</div>
<div class="row">
<div class="form-group mt17 col-sm-6">
	<label>Class Applying for</label>
	<select class="form-control input-lg" name="class_app" required>
		<option>Select Class</option>
		<?php while($q->fetch()): ?>
			<option value="<?php echo $classid; ?>"><?php echo $class; ?></option>
		<?php endwhile; $q->close(); $db->close(); ?>
	</select>
</div>
<div class="form-group mt17 col-sm-6">
	<label>Accadmic Session</label>
	<select class="form-control input-lg" name="start_session" required>
		<option>Select Session</option>
		<option value="<?php $m = date('Y'); $sy = $m + 1; echo $m.'/'.$sy; ?>"><?php echo $m.'/'.$sy; ?></option>
	<?php if( date('m') == 1  ): ?>
		<option value="<?php $py = $m - 1; echo $py.'/'.$m; ?>"><?php echo $py.'/'.$m;?></option>
	<?php endif; ?>
	</select>
</div>
</div>
<div class="row">
<div class="form-group mt17 col-sm-6">
	<label>Contact Address</label>
	<textarea type="text" name="address" rows="6" placeholder="Address" class="form-control input-lg" required="required"></textarea>
</div>
<div class="form-group mt17 col-sm-6">
	<label>Parent/Guardian</label>
	<input type="text" name="parent" placeholder="Name of Parent/Gaurdian" class="form-control input-lg mt17" required="required">


	<label>Parent/Guardin Mobile Number</label>
	<input type="text" name="parent_num" placeholder="Parent/Guardian Number" class="form-control input-lg mt17" required="required">
</div>
</div>
<div class="row">
<div class="col-sm-12">
	<label for="">Upload Passport</label>
 <input type="file" name="passport" required>
</div>

<div class="form-group mt17 col-sm-12" style="padding-top:10px">
	<button class="btn btn-primary input-lg col-sm-4" type="submit" name="submit">APPLY</button>
</div>
</form>

<div class="clearfix">
<div class="form-group col-sm-12">
	<p>By clicking apply, you agree to our <a href="">Terms and Conditions</a> and <a href="">Privacy Policy</a></p>
</div>
</div>

									</div>
								</div>
							</section>
					</div>
				</div>
			</div>
		<?php endif; ?>
