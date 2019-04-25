<?php
  session_start();
  error_reporting(E_ALL);
  ini_set('display_errors', 'on');
?>
<?php if ( (isset($_SESSION['login'])) && (strlen($_SESSION['login']) >  0) ):
  include 'includes/db.php';
  //$id = $_SESSION['id'];

  $q = $db->prepare("select id, class from classes");
  $q->execute();
  $q->bind_result($classid, $class);
?>
<?php include 'includes/header.php'; ?>
<!DOCTYPE html>
<html>
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="">
      <meta name="author" content="Dashboard">
      <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

      <title>Select Class</title>

      <!-- Bootstrap core CSS -->
      <!--<link href="assets/css/bootstrap.css" rel="stylesheet">-->
      <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Bootstrap core CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
        <!-- Material Design Bootstrap -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.4/css/mdb.min.css" rel="stylesheet">
      <!--external css-->
      <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link rel="shortcut icon" href="school.png" type="image/png">
      <!-- Custom styles for this template -->
      <!--<link href="assets/css/style.css" rel="stylesheet">-->
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
          border-radius: 0
        }
        @media only screen and (max-width: 500px) {
          body {
           
          }
          .offset-2{
            margin: 0px;
          }
          .col-8{
            max-width: 100%;
          }
        }
      </style>
    </head>

<body>

<div class="container" style="margin-top: 100px">
    <div class="col-8 offset-2">
        <h2 class="text-center text-primary"> Scores Entry</h2>
    <div class="card">
        <div class="card-heading bg-primary text-white">
            <h3 class="text-center">Select Class, Subject &amp; Term</h3>          
        </div>
        <div class="card-body">
            <form role="form" action="enter-scores.php" method="post" class="col-sm-offset-3">
      <div class="form-group col-sm-12">
         <select class="form-control input-sm" name="class" required>
           <option value="">Select class</option>
           <?php while ($q->fetch()): ?>
             <option value="<?php echo $classid; ?>"><?php echo $class; ?></option>
           <?php endwhile; $q->free_result(); $q->close();?>
         </select>
      </div>
      <div class="form-group col-sm-12">
         <select class="form-control input-sm" name="class2" required>
            <option>Select Sub-class</option>
           <option value="a">A</option>
           <option value="b">B</option>
           <!--<option value="c">C</option>-->
           <!--<option value="d">D</option>-->
           <!--<option value="e">E</option>-->
         </select>
      </div>
      <div class="form-group col-sm-12">
        <select class="form-control input-sm" name="subject" required>
          <option value="">Select subject</option>
          <?php
            $q1 = $db->prepare("select id, subject from subjects order by subject");
            $q1->execute();
            $q1->bind_result($subjectid, $subject);
          ?>
          <?php while ($q1->fetch()): ?>
            <option value="<?php echo $subjectid; ?>"><?php echo $subject; ?></option>
          <?php endwhile; $q1->free_result(); $q1->close();?>
        </select>
      </div>
      <div class="form-group col-sm-12">
        <select class="form-control input-sm" name="term" required>
          <option value="">Select term</option>
          <option value="1">1st</option>
          <option value="2">2nd</option>
          <option value="3">3rd</option>
        </select>
      </div>
      <div class="form-group col-sm-12">
        <a href="dashboard.php" class="btn btn-outline-info input-sm">Back</a>
        <button type="submit" class="btn btn-outline-primary input-sm" name="scores_btn">Continue</button>
      </div>
    </form>
        </div>
    </div>
  
    
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
