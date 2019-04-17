<?php
  session_start();
  error_reporting(E_ALL);
  ini_set('display_errors', 'on');
?>
<?php if ( (isset($_SESSION['login'])) && (empty(!$_SESSION['login']) ) ):
  include 'includes/db.php';

  $q = $db->prepare("select id, class from pri_class");
  $q->execute();
  $q->bind_result($classid, $class);
?>
<!DOCTYPE HTML>
<html>
<head>
<title>View Results</title>
<link rel="shortcut icon" href="images/cocinlogo.jpg" type="image/jpg">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Bootstrap Core CSS -->
<link href="assets/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="assets/css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="assets/css/morris.css" type="text/css"/>
<!-- Graph CSS -->
<link href="assets/css/font-awesome.css" rel="stylesheet">
<!-- jQuery -->
<script src="assets/js/jquery-2.1.4.min.js"></script>
<!-- //jQuery -->
<!-- tables -->
<link rel="stylesheet" type="text/css" href="assets/css/table-style.css" />
<link rel="stylesheet" type="text/css" href="assets/css/basictable.css" />
<script type="text/javascript" src="assets/js/jquery.basictable.min.js"></script>
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
<body class="bglight bgwhite">

<div class="container" style="padding-top:30px">
  <div class="col-md-6 col-md-offset-3">
      <h3 class="text-center">Select from the dropdown below to enter Scores</h3>
    <form class="form-inline" role="form" action="class-result2.php" method="post">
      <div class="form-group">
         <select class="form-control input-lg" name="class">
           <option value="">Select class</option>
           <?php while ($q->fetch()): ?>
             <option value="<?php echo $classid; ?>"><?php echo $class; ?></option>
           <?php endwhile; $q->free_result(); $q->close();?>
         </select>
      </div>

      <div class="form-group">
        <select class="form-control input-lg" name="term">
          <option value="">Select term</option>
          <option value="1">1st</option>
          <option value="2">2nd</option>
          <option value="2">3rd</option>
        </select>
      </div>

      <div class="form-group">
        <?php
          $q1 = $db->prepare('select distinct session from scores2 order by session asc');
          $q1->execute();
          $q1->bind_result($session);
       ?>
         <select class="form-control input-lg" name="session">
           <option value="">Select session</option>
           <?php while ($q1->fetch()): ?>
             <option value="<?php echo $session; ?>"><?php echo $session; ?></option>
           <?php endwhile; $q1->free_result(); $q1->close();?>
         </select>
      </div>
      <button type="submit" class="btn btn-primary" name="result_btn">Submit</button>
    </form>
  </div>
</div>
<?php include 'includes/footer.php'; $db->close(); ?>
</body>
</html>
<?php else:
  header('Location:logout.php');
  exit;
?>

<?php endif; ?>
