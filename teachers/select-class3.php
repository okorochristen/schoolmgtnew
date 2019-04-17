<?php
  session_start();
  error_reporting(E_ALL);
  ini_set('display_errors', 'on');
?>
<?php if ( (isset($_SESSION['login'])) && (strlen($_SESSION['login']) >  0) ):
  include 'includes/db.php';
  $q = $db->prepare("select id, class from classes");
  $q->execute();
  $q->bind_result($classid, $class);
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Behaviourial Ratings</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Bootstrap Core CSS -->
<!--<link href="assets/css/bootstrap.min.css" rel='stylesheet' type='text/css' />-->
<!-- Custom CSS -->
<!-- Font Awesome -->
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
<body class="bglight bgwhite">
<div class="container"> 
    <div class="col-8 offset-2" style="margin-top: 40px">
        <div class="card card-primary">
            <div class="card-header bg-primary text-white">
               <h3 class="text-center">Select class to enter Behaviourial Ratings</h3> 
            </div>
            <div class="card-body">
                <form  role="form" action="enter-behaviourial-ratingsp.php" method="post">
                  <div class="form-group">
                     <select class="form-control form-control-lg" name="class" required>
                       <option value="">Select class</option>
                       <?php while ($q->fetch()): ?>
                         <option value="<?php echo $classid; ?>"><?php echo $class; ?></option>
                       <?php endwhile; $q->free_result(); $q->close(); ?>
                     </select>
                  </div>
            
                  <div class="form-group">
                    <select class="form-control form-control-lg" name="term" required>
                      <option value="">Select term</option>
                      <option value="1">1st</option>
                      <option value="2">2nd</option>
                      <option value="3">3rd</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <select class="form-control form-control-lg" name="class2" required>
                        <option>Select Sub-Class</option>
                      <option value="a">A</option>
                      <option value="b">B</option>
                      <!--<option value="c">C</option>-->
                      <!--<option value="d">D</option>-->
                      <!--<option value="e">E</option>-->
                    </select>
                  </div>
                  <div class="form-group">
        <?php
          $q1 = $db->prepare('select distinct session from scores order by session desc');
          $q1->execute();
          $q1->store_result();
          $n = $q1->num_rows;
       ?>
         <select class="form-control form-control-lg" name="session" required>
           <option value="">Select session</option>
           <?php if($n > 0):
               $q1->bind_result($session);
           ?>
               <?php while ($q1->fetch()): ?>
                 <option value="<?php echo $session; ?>"><?php echo $session; ?></option>
               <?php endwhile; $q1->free_result(); ?>
           <?php endif; $q1->close(); ?>
         </select>
      </div>
                  <button type="submit" class="btn btn-outline-primary" name="result_btn">Continue</button>
                  <a href="dashboard.php" class="btn btn-outline-primary">Back</a>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.13.0/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.4/js/mdb.min.js"></script>
</body>
</html>
<?php else:
  header('Location:logout.php');
  exit;
?>

<?php endif; ?>
