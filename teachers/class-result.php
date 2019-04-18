<?php
  session_start();
  error_reporting(E_ALL);
  ini_set('display_errors', 'on');
?>
<?php if ( (isset($_SESSION['login'])) && (strlen($_SESSION['login']) >  0) ): ?>

    <?php if ( (isset($_REQUEST['class'])) && (isset($_REQUEST['session'])) && (isset($_REQUEST['term'])) && (isset($_REQUEST['class2'])) ):
      include 'includes/db.php';
      $class = $_REQUEST['class'];
      $sclass = $_REQUEST['class2'];
      $session = $_REQUEST['session'];
      $term = $_REQUEST['term'];
      $q = $db->prepare('select regno, average, position from result where class = ? and sclass = ? and session = ? and term = ?');
      $q->bind_param('ssss', $class, $sclass, $session, $term);
      $q->execute();
      $q->store_result();
      $n = $q->num_rows;

      if($term == 1){
        $ad = "st";
      }
      elseif($term == 2){
        $ad = "nd";
      }
      else{
        $ad = "rd";
      }
    ?>
    <!DOCTYPE html>
    <html>
      <head>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <meta name="description" content="">
          <title>Results</title>

          <!-- Bootstrap core CSS -->
          <!--<link href="assets/css/bootstrap.css" rel="stylesheet">-->
          <!-- Font Awesome -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
            <!-- Bootstrap core CSS -->
            <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
            <!-- Material Design Bootstrap -->
            <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.8/css/mdb.min.css" rel="stylesheet">
          <!--external css-->
          <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />

          <!-- Custom styles for this template -->
          <!--<link href="assets/css/style.css" rel="stylesheet">-->
          <link href="assets/css/style-responsive.css" rel="stylesheet">
          <link rel="shortcut icon" href="school.png" type="image/png">
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
        <div class="container" style="margin-top: 50px">
            <?php if(isset($_SESSION['rac'])): ?>
              <div class="alert alert-info text-center">The result for this class has already been compiled!</div>
            <?php endif; unset($_SESSION['rac']); ?>
          <h1 class="text-center"><?php echo $term.$ad; ?> Term Result</h1>
          <div class="col-md-12">
            <?php if ($n > 0): $q->bind_result($regno, $average, $position); ?>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>REG NO</th>
                    <th>NAME</th>
                    <th>AVERAGE</th>
                    <th>POSITION</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($q->fetch()):
                    $q1 = $db->prepare('select fname, current_class, current_session from accepted_students where regno = ?');
                    $q1->bind_param('s', $regno);
                    $q1->execute();
                    $q1->bind_result($name, $cl, $ss);
                    $q1->fetch();
                    $q1->free_result();
                    $q1->close();
                 ?>
                  <tr>
                    <td><?php echo $regno; ?></td>
                    <td><?php echo $name; ?></td>
                    <td> &nbsp&nbsp&nbsp <?php echo $average; ?></td>
                    <td> &nbsp&nbsp&nbsp<?php echo $position; ?></td>
                    <td><a href="myresult.php?regno=<?php echo $regno; ?>&session=<?php echo $session; ?>&term=<?php echo $term; ?>&class=<?php echo $class; ?>&class2=<?php echo $sclass; ?>" target="_blank">View</a></td>
                  </tr>
                <?php endwhile; ?>
              </tbody>

            </table>
            <a href="dashboard.php" class="btn btn-outline-info input-sm">Go Back</a>
            <?php else:
              $q->free_result();
              $q->close();
              $q0 = $db->prepare('select class from classes where id = ?');
              $q0->bind_param('s', $class);
              $q0->execute();
              $q0->bind_result($cl);
              $q0->fetch();
              $q0->close();
            ?>

              <div class="sspacing">
                <div class="row">
                  <h3><?php echo $cl." ".$sclass; ?> result hasn't been computed.</h3>
                </div>

                <div class="row">
                  <div class="col-sm-4">
                    <!--<a href="compute-result.php?term=<?php echo $term; ?>&session=<?php echo $session; ?>&class=<?php echo $class; ?>&class2=<?php echo $sclass; ?>" class="btn btn-sm btn-success">Compute</a>-->
                    <a href="select-class2.php" class="btn btn-outline-success">Back</a>
                  </div>
                </div>
              </div>
              <div class="form-group">

              </div>
            <?php endif; ?>

          </div>
        </div>
      <?php include 'includes/footer.php'; $db->close(); ?>
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
