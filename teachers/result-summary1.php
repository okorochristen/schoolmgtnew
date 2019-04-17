<?php
  ob_start();
  session_start();
  error_reporting(E_ALL);
  ini_set('display_errors', 'on');?>
<?php if ( (isset($_SESSION['login'])) && (strlen($_SESSION['login']) >  0) ): ?>

  <?php if ( (isset($_REQUEST['class'])) && (isset($_REQUEST['session'])) && (isset($_REQUEST['class2'])) ):
    include 'includes/db.php';

    $class = $_REQUEST['class'];
    $session = $_REQUEST['session'];
    $class2 = $_REQUEST['class2'];

    $q = $db->prepare("select class from classes where id = ?");
    $q->bind_param('s',$class);
    $q->execute();
    $q->bind_result($cl);
    $q->fetch();
    $q->close();

    $q = $db->prepare('select distinct regno, average, position, status from promotional_result1 where class = ? and session = ? and class2 = ?');
    $q->bind_param('sss', $class, $session, $class2);
    $q->execute();
    $q->store_result();
    $n = $q->num_rows;
  ?>
  <!DOCTYPE html>
  <html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Dashboard">
        <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

        <title>Results</title>

        <!-- Bootstrap core CSS -->
        <link href="assets/css/bootstrap.css" rel="stylesheet">
        <!--external css-->
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />

        <!-- Custom styles for this template -->
        <link href="assets/css/style.css" rel="stylesheet">
        <link href="assets/css/style-responsive.css" rel="stylesheet">
        <script type="text/javascript" src="includes/prompt1.js"></script>
        <script type="text/javascript">
        <link rel="shortcut icon" href="school.png" type="image/png">
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
        <h1 class="text-center">Result summary of <?php echo $cl." ".$class2; ?></h1>
        <div class="col-md-12">
          <?php if ($n > 0): $q->bind_result($regno, $average, $position, $status); ?>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>REG NO</th>
                  <th>NAME</th>
                  <th>AVERAGE</th>
                  <th>POSITION</th>
                  <th></th>
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
                  <td> &nbsp&nbsp&nbsp<?php echo $average; ?></td>
                  <td> &nbsp&nbsp&nbsp<?php echo $position; ?></td>
                  <td><a href="student-result-summary1.php?regno=<?php echo $regno; ?>&session=<?php echo $session; ?>&class=<?php echo $class; ?>" target="_blank">View</a></td>
                  <td colspan="2">
                  <?php if ($status == "pending"): ?>
                    <a href="#" class="btn btn-success" onclick="promoteStudent(<?php echo "'$name','$regno','$class','$session'"; ?>)">Promote</a>
                    <a href="#" class="btn btn-warning" onclick="repeatStudent(<?php echo "'$name','$regno','$class','$session'"; ?>)">Repeat</a>
                  <?php else: ?>
                      <?php echo $status; ?>
                  <?php endif; ?>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
          <a href="dashboard.php" class="btn btn-info input-sm">Go Back</a>
          <?php else:
            $q->free_result();
            $q->close();
            header("Location:dashboard.php");
            exit;
          ?>
          <?php endif; ?>

        </div>
      </div>
    <?php include 'includes/footer.php'; $db->close(); ?>
    </body>
  </html>
  <?php else:
    header('Location:dashboard.php');
    exit;
  ?>
  <?php endif; ?>

<?php else:
  header('Location:logout.php');
  exit;
?>

<?php endif; ?>
