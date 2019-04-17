<?php
  session_start();
  error_reporting(E_ALL);
  ini_set('display_errors', 'on');
?>
<?php if ( (isset($_SESSION['login'])) && (strlen($_SESSION['login']) >  0) ):
  include 'includes/db.php';
  //$id = $_SESSION['id'];

  $q = $db->prepare("select distinct class from promotional_result2");
  $q->execute();
  $q->store_result();
  $q->bind_result($classid);
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
          border-radius: 0
        }
      </style>
    </head>

<body>

<div class="container" style="padding-top: 120px">
  <h3 class="text-center">Select Class &amp; Session</h3>
  <div class="col-md-12">

    <form role="form" action="result-summary2.php" method="GET" class="col-sm-offset-3">
      <div class="form-group col-sm-8">
         <select class="form-control input-sm" name="class" required>
           <option value="">Select class</option>
           <?php while ($q->fetch()):
             $q0 = $db->prepare("select class from pri_class where id = ?");
             $q0->bind_param('s',$classid);
             $q0->execute();
             $q0->bind_result($class);
             $q0->fetch();
             $q0->free_result();
             $q0->close();
           ?>
             <option value="<?php echo $classid; ?>"><?php echo $class; ?></option>
           <?php endwhile; $q->free_result(); $q->close();?>
         </select>
      </div>
      <div class="form-group col-sm-8">
        <select class="form-control input-sm" name="session" required>
          <option value="">Select Session</option>
          <?php
            $q1 = $db->prepare("select distinct session from promotional_result2 order by session desc");
            $q1->execute();
            $q1->bind_result($session);
          ?>
          <?php while ($q1->fetch()): ?>
            <option value="<?php echo $session; ?>"><?php echo $session; ?></option>
          <?php endwhile; $q1->free_result(); $q1->close();?>
        </select>
      </div>
      <div class="form-group col-sm-8">
        <a href="dashboard.php" class="btn btn-info input-sm">Back</a>
        <button type="submit" class="btn btn-primary input-sm" name="scores_btn">Submit</button>
      </div>
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
