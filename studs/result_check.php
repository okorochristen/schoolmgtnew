<?php
	session_start();
    include('includes/config.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<title>.:: Result Checker</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--<link rel="shortcut icon" href="images/school.png" type="image/png">-->
<script type="applijewelleryion/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!--<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />-->
<!-- Font Awesome -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
<link rel="stylesheet" href="css/font-awesome.css">
<!-- Bootstrap core CSS -->
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet"> -->
<!-- Material Design Bootstrap -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.4/css/mdb.min.css" rel="stylesheet">
<link href="css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="css/table-style.css" />
  <link rel="stylesheet" type="text/css" href="css/basictable.css" />
  <script type="text/javascript" src="dataTables/dataTables/css/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="sum().js"></script>
<scr$(document).ready(function() {
    $('#example').DataTable();
} );
</script>
<!--animate-->
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->
<style>
	.input-lg{
		border-radius: 0
	}
		.input-lg, .input-sm{
		border-radius: 0
	}
</style>

</head>
<body>
<?php include('includes/header3.php');?>

    
    <div class="col-md-8 col-xs-12 ml-auto mr-auto">
        <div class="card" style="margin-top: 60px">
            <div class="card-heading bg-success text-white"><h2 class="text-center" style="padding-top: 20px">Result Checker</h2></div>
            <div class="card-body">
                <section>
			<div class="container">
				<?php if (isset($_SESSION['irp'])): ?>
					<div class="alert alert-danger text-center">
						The pin you entered is invalid.
					</div>
				<?php endif; unset($_SESSION['irp'])?>
				<form name="signup" method="post" action="result-script.php">
					<div class="form-group col-sm-12">
						<h2>Enter Your Pin</h2>
						<input type="text" placeholder="Enter your Pin Here..." name="pin" class="form-control form-control-lg" required="required">
					</div>
					<div class="form-group col-sm-12 col-md-offset-2">
						<button class="btn btn-outline-success input-lg btn-md" type="submit" name="submit">CHECK RESULT</button>
						<a class="btn btn-outline-primary btn-md" href="students-home.php">Back</a>
					</div>
				</form>
			</div>
		</section>
            </div>
        </div>
    </div>

	 <script>
            $(document).ready(function() {
            $('#example').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'print'
                ]
                } );
            } );
            
            
        </script>
		
<?php include('includes/footer.php'); ?>

</body>
</html>