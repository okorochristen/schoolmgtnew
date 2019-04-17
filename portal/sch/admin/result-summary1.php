<?php
  ob_start();
  session_start();
  error_reporting(E_ALL);
  ini_set('display_errors', 'on');?>
<?php if ( (isset($_SESSION['alogin'])) && (strlen($_SESSION['alogin']) >  0) ): ?>

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
  <!DOCTYPE HTML>
  <html>
  <head>
  <title>Admin Result Checker</title>
  <link rel="shortcut icon" href="images/cocinlogo.jpg" type="image/jpg">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
  <!-- Bootstrap Core CSS -->
  <link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
  <!-- Custom CSS -->
  <link href="css/style.css" rel='stylesheet' type='text/css' />
  <link rel="stylesheet" href="css/morris.css" type="text/css"/>
  <!-- Graph CSS -->
  <link href="css/font-awesome.css" rel="stylesheet">
  <!-- jQuery -->
  <script src="js/jquery-2.1.4.min.js"></script>
  <!-- //jQuery -->
  <!-- tables -->
  <link rel="stylesheet" type="text/css" href="css/table-style.css" />
  <link rel="stylesheet" type="text/css" href="css/basictable.css" />
  <script type="text/javascript" src="js/jquery.basictable.min.js"></script>
  <!-- //tables -->
  <link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
  <link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
  <!-- lined-icons -->
  <link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
  <!-- //lined-icons -->
  </head>
  <body>
    <body class="bglight bgwhite">
      <div class="container" style="margin-top: 50px">
        <h1 class="text-center" style="text-transform:uppercase">Result summary of <?php echo $cl." ".$class2; ?></h1>
        <div class="col-md-12">
          <?php if ($n > 0): $q->bind_result($regno, $average, $position, $status); ?>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>REG NO</th>
                  <th>NAME</th>
                  <th>AVERAGE</th>
                  <th>POSITION</th>
                  <th>STATUS</th>
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
                  <td>
                  <?php if ($status == "0"): ?>
                    <button type="button" name="button" class="btn btn-danger">Not promoted</button>
                  <?php elseif ($status == "1"): ?>
                    <button type="button" name="button" class="btn btn-primary">promoted</button>
                  <?php endif; ?>
                  </td>
                  <td><a href="student-result-summary1.php?regno=<?php echo $regno; ?>&session=<?php echo $session; ?>&class=<?php echo $class; ?>&class2=<?php echo $class2; ?>" target="_blank">View</a></td>
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
