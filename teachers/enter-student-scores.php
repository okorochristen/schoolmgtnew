<?php
  session_start();
  error_reporting(E_ALL);
  ini_set('display_errors', 'on');
?>

<?php if (isset($_SESSION['login'])): ?>
  <!DOCTYPE html>
  <html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Dashboard">
        <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

        <title>Enter Scores</title>

        <!-- Bootstrap core CSS -->
        <link href="assets/css/bootstrap.css" rel="stylesheet">
        <!--external css-->
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link rel="shortcut icon" href="school.png" type="image/png">
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
        <style>
          .input-sm{
            border-radius: 0;
          }
          .form-control{
            font-weight: bold;
            font-size: 18px;
          }
        </style>
      </head>
<?php if ( (isset($_GET['regno'])) && (isset($_GET['term'])) && (isset($_GET['subject'])) ) :


  include 'includes/db.php';
  include 'includes/header.php';

  $subject = $_GET['subject'];
  $term = $_GET['term'];
  $regno = $_GET['regno'];

  $q0 = $db->prepare('SELECT fname, current_session, current_class from accepted_students where regno = ?');
  $q0->bind_param('s', $regno);
  $q0->execute();
  $q0->store_result();
  $n = $q0->num_rows;
?>
<body class="bglight">

  <section id="slider" class="fullheight" style="background-image:url('images/bg1b.jpg'); height:100px">
          <div class="overlay dark-6">
            
            <!-- dark overlay [0 to 9 opacity] --></div>
          
  </section>

  <section class="bglight  borderbottom relative">
    <h1 class="text-center">Enter Student Scores</h1>
    <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="row">
    <div class="container cus-pos-abs">
      <div class="cover-center-text col-sm-12 col-md-12">
<?php if ($n > 0):
  $q0->bind_result($name, $session, $class);
  $q0->fetch();
  $q0->free_result();
  $q0->close();

  $q4 = $db->prepare('select subject from subjects where id = ?');
  $q4->bind_param('s', $subject);
  $q4->execute();
  $q4->bind_result($sb);
  $q4->fetch();
  $q4->free_result();
  $q4->close();
?>
      <script type="text/javascript" src="assets/js/calc.js"></script>
        <form method="post" action="scores-script.php">
          <input type="hidden" name="term" value="<?php echo $term; ?>">
          <input type="hidden" name="class" value="<?php echo $class; ?>">
          <input type="hidden" name="session" value="<?php echo $session; ?>">
          <input type="hidden" name="regno" value="<?php echo $regno; ?>">
          <input type="hidden" name="subject" value="<?php echo $subject; ?>">

          <div class="container">
              <div class="col-sm-12 form-group">
                  <label for="reg_number" class="size20 cblue">Enter <?php echo $name; ?> Score in <?php echo $sb; ?></label>
              </div>

              <div class="form-group col-sm-4">
                  <input type="number" class="form-control input-sm" value="" name="as1" placeholder="Assignment 1" id="as1" onchange="calcTotal()" onkeyup="calcTotal()" required>
              </div>
              <div class="form-group col-sm-4">
                  <input type="number" class="form-control input-sm" value="" name="as2" placeholder="Assignment 2" id="as2"  onchange="calcTotal()" onkeyup="calcTotal()" required>
              </div>
              <div class="form-group col-sm-4">
                  <input type="number" class="form-control input-sm" value="" name="ts1" placeholder="Test 1" id="ts1"  onchange="calcTotal()" onkeyup="calcTotal()" required>
              </div>
              <div class="form-group col-sm-4">
                  <input type="number" class="form-control input-sm" value="" name="ts2" placeholder="Test 2" id="ts2" onchange="calcTotal()" onkeyup="calcTotal()" required>
              </div>
              <div class="form-group col-sm-4">
                  <input type="number" class="form-control input-sm" value="" name="exam" placeholder="Exams Score" id="exam" onchange="calcTotal()" onkeyup="calcTotal()" required>
              </div>
              <div class="form-group col-sm-4">
                  <input type="number" class="form-control input-sm" value="" name="total" placeholder="Total Score" readonly id="total">
              </div>

              <div class="form-group col-sm-4">
                  <button type="submit" class="btn btn-success input-sm" id="btn" name="ss_btn">Submit Scores</button>
                  <a href="enter-scores.php" class="btn btn-info input-sm">Select Student</a>
              </div>
              <div >
                <strong id="msg"></strong>
             </div>
          </div>
      </form>

  <?php else: ?>
    <h2>This students record was not found</h2>
  <?php endif; ?>
  </div>
  </div>
  </div>
  </div>
</section>

  </body>
  </html>
<?php else:
  header('Location:enter-scores.php');
  exit;
  ?>

<?php endif; ?>

<?php else:
  header('Location:logout.php');
  exit;
?>

<?php endif; ?>
