<?php
error_reporting(0);
if(isset($_POST['submit']))
{
$fname=$_POST['fname'];
$lname=$_POST['lname'];
$gender=$_POST['gender'];
$dob=($_POST['dob']);
$state=($_POST['state']);
$lga=($_POST['lga']);
$class_app=($_POST['class_app']);
$address=($_POST['address']);
$parent=($_POST['parent']);
$parent_num=($_POST['parent_num']);

$sql="INSERT INTO  students(fname,lname,gender,dob,state,lga,class_app,address,parent,parent_num) VALUES(:fname,:lname:gender,:dob,:state,:lga,:class_app,:address,:parent,:parent_num)";
$query = $dbh->prepare($sql);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':lnme',$lname,PDO::PARAM_STR);
$query->bindParam(':gender',$gender,PDO::PARAM_STR);
$query->bindParam(':dob',$dob,PDO::PARAM_STR);
$query->bindParam(':state',$state,PDO::PARAM_STR);
$query->bindParam(':lga',$lga,PDO::PARAM_STR);
$query->bindParam(':class_app',$class_app,PDO::PARAM_STR);
$query->bindParam(':address',$address,PDO::PARAM_STR);
$query->bindParam('parent',$parent,PDO::PARAM_STR);
$query->bindParam(':parent_num',$parent_num,PDO::PARAM_STR);

$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$_SESSION['msg']="You are Scuccessfully registered.";
header('location:index.php');
}
else 
{
$_SESSION['msg']="Something went wrong. Please try again.";
header('location:index.php');
}
}
?>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<style>
	.input-sm{
		border-radius: 0
	}
</style>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h2 class="modal-title text-center" id="myModalLabel">Application Form</h2>
							<p class="text-center size18">Fill in your details</p>					
						</div>

							<section>
								<div class="modal-body">
									<div class="login-grids">
										<div class="login">
											
											
<form name="signup" method="post">
					
<div class="form-group">
	<input type="text" placeholder="First Name" name="fname" class="form-control input-sm" required="required">
</div>
<div class="form-group mt17">
	<input type="text" placeholder="Othernames" name="lname" required="required" class="form-control input-sm">
</div>
<div class="form-group mt17">
	<label></span><input type="radio" name="gender" value="Male" required="required"> Male</label>
	<label><input type="radio" name="gender" value="Female" required="required"> Female</label>
</div>
<div class="form-group mt17">
	<label>Date of Birth</label>
	<input type="date" name="dob" placeholder="Date of Birth" class="form-control input-sm" required="required">
</div>
<div class="form-group mt17">
	<select class="form-control input-sm" name="state">
		<option>Select State</option>
		<option value="Abia">Abia</option>
		<option value="Adamawa">Adamawa</option>
		<option value="Akwa Ibom">Akwa Ibom</option>
		<option value="Anambra">Anambra</option>
	</select>
</div>
<div class="form-group mt17">
	<input type="text" name="lga" placeholder="Local Government" class="form-control input-sm" required="required">
</div>
<div class="form-group mt17">
	<select class="form-control input-sm" name="class_app">
		<option>Select Class</option>
		<option value="Jss1">Jss1</option>
		<option value="Jss2">Jss2</option>
		<option value="Jss3">Jss3</option>
		<option value="SSS1">SSS1</option>
		<option value="SSS2">SSS2</option>
		<option value="SSS3">SSS3</option>
	</select>
</div>
<div class="form-group mt17">
	<textarea type="text" name="address" rows="4" placeholder="Address" class="form-control input-sm" required="required"></textarea>
</div>
<div class="form-group mt17">
	<input type="text" name="parent" placeholder="Name of Parent/Gaurdian" class="form-control input-sm mt17" required="required">
</div>
<div class="form-group mt17">
	<input type="text" name="parent_num" placeholder="Parent/Guardian Number" class="form-control input-sm" required="required">
</div>
<div class="form-group mt17">
	<button class="btn btn-primary input-sm" type="submit" name="submit">APPLY</button>
</div>



</form>
											
<div class="clearfix">
	
</div>								
</div>
<p>By logging in you agree to our <a href="">Terms and Conditions</a> and <a href="">Privacy Policy</a></p>
									</div>
								</div>
							</section>
					</div>
				</div>
			</div>