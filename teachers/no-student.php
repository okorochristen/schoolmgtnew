<?php
  session_start();
  error_reporting(E_ALL);
  ini_set('display_errors', 'on');
?>
<?php if ( (isset($_SESSION['login'])) && (!(empty($_SESSION['login'])) ) ): ?>
  <?php if ( isset($_SESSION['ns']) ): unset($_SESSION['ns']); ?>
    <!DOCTYPE html>
    <html>
      <head>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <meta name="description" content="">
          <meta name="author" content="Dashboard">
          <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

          <title>No Student</title>
<link rel="shortcut icon" href="school.png" type="image/png">
          <!-- Bootstrap core CSS -->
          <link href="assets/css/bootstrap.css" rel="stylesheet">
          <!--external css-->
          <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />

          <!-- Custom styles for this template -->
          <link href="assets/css/style.css" rel="stylesheet">
          <link href="assets/css/style-responsive.css" rel="stylesheet">
          <script type="text/javascript">
            function valid()
            {
             if(document.forgot.password.value!= document.forgot.confirmpassword.value)
            {
            alert("Password and Confirm Password Field do not match  !!");
            document.forgot.confirmpassword.focus();
            return false;
            }
            return true;
            }
          </script>
        </head>
    <body class="bglight bgwhite">
      <div class="container sspacing">
        <div class="col-md-12">
          <div class="sspacing text-center">
            <h2>There is currently no student in this class</h2>
          </div>
          <a href="dashboard.php" class="btn btn-info input-sm">Go Back</a>
        </div>
      </div>
    <?php include 'includes/footer.php';  ?>
    </body>
  </html>
  <?php else:
    header('Location:select-class2.php');
    exit;
  ?>
  <?php endif; ?>

<?php else:
  header('Location:logout.php');
  exit;
?>

<?php endif; ?>
