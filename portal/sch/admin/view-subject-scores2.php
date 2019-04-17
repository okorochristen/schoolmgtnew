<?php
  session_start();
  error_reporting(E_ALL);
  ini_set('display_errors', 'on');
?>
<?php if ( (isset($_SESSION['alogin'])) && (!empty($_SESSION['alogin'])) ):
    $url = $_SERVER['HTTP_REFERER'];
    if ( (empty($_POST['subject'])) && (!isset($_GET['subject'])) ) {
      header('Location:$url.php');
      exit;
    }
    elseif ( (empty($_POST['class'])) && (!isset($_GET['class'])) ) {
      header('Location:$url.php');
      exit;
    }
    elseif ( (empty($_POST['class2'])) && (!isset($_GET['class2'])) ) {
      header('Location:$url.php');
      exit;
    }
    elseif ( (empty($_POST['term'])) && (!isset($_GET['term'])) ) {
      header('Location:$url.php');
      exit;
    }
    elseif ( (empty($_POST['session'])) && (!isset($_GET['session'])) ) {
      header('Location:$url.php');
      exit;
    }
    else {
      include 'includes/db.php';
      $class = $_REQUEST['class'];
      $class2 = $_REQUEST['class2'];
      $subject = $_REQUEST['subject'];
      $term = $_REQUEST['term'];
      $session = $_REQUEST['session'];

      if($term == 1){
        $ad = "st";
      }
      elseif($term == 2){
        $ad = "2nd";
      }
      else{
        $ad = "rd";
      }

      $school = "secondary";
      $q2 = $db->prepare('select class from pri_class where id = ?');
      $q2->bind_param('s', $class);
      $q2->execute();
      $q2->bind_result($cl);
      $q2->fetch();
      $q2->free_result();
      $q2->close();
      $q0 = $db->prepare('select regno from scores2 where class = ? && class2 = ? && session = ? and term = ?');
      $q0->bind_param('ssss', $class, $class2, $session, $term);
      $q0->execute();
      $q0->store_result();
      $n = $q0->num_rows;
      //include 'includes/header.php';
    }
  ?>
<!DOCTYPE html>
<html>
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Subject Class Scores</title>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

      <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
      <!-- Bootstrap Core CSS -->
      <!--<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />-->
      
      <!-- Font Awesome -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Bootstrap core CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
<!-- Material Design Bootstrap -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.9/css/mdb.min.css" rel="stylesheet">
      <!-- Custom CSS -->
      <!--<link href="css/style.css" rel='stylesheet' type='text/css' />-->
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
<body class="bglight bgwhite">

<div class="container" style="padding-top: 60px">
  <div class="col-md-12">
    <?php if ($n > 0):
      $q4 = $db->prepare('select subject from subjects where id = ?');
      $q4->bind_param('s', $subject);
      $q4->execute();
      $q4->bind_result($sb);
      $q4->fetch();
      $q4->free_result();
      $q4->close();
     ?>
      <h3 style="text-transform: uppercase;"> <?php echo $cl." ".$class2; ?> students scores in <?php echo $sb." $term $ad term"; ?></h3><br>
      <?php $q0->bind_result($regno); ?>

        <table class="table table-hover table-bordered">
          <thead>
            <tr>
              <th>REG NO</th>
              <th>NAME</th>
              <th>As 1</th>
              <th>As 2</th>
              <th>Ts 1</th>
              <th>Ts 2</th>
              <th>Exam</th>
              <th>TOTAL</th>
            </tr>
          </thead>
          <tbody>
            <form class="" action="scores-script.php" method="post">
            <?php while ($q0->fetch()): ?>
              <?php
                $q = $db->prepare("select fname from accepted_students where regno = ?");
                $q->bind_param('s',$regno);
                $q->execute();
                $q->bind_result($fname);
                $q->fetch();
                $q->free_result();
                $q->close();

                $q = $db->prepare('select as1, as2, ts1, ts2, exam, total from scores2 where session = ? and term = ? and class = ? and subject = ? and regno = ? and term = ?');
                $q->bind_param('ssssss', $session, $term, $class, $subject, $regno, $term);
                $q->execute();
                $q->store_result();
                $no = $q->num_rows;
              ?>
              <tr>
                <td><?php echo $regno; ?></td>
                <td><?php echo $fname; ?></td>
                <?php if ($no > 0):
                  $q->bind_result($as1, $as2, $ts1, $ts2, $exam, $total);
                  $q->fetch();
                ?>
                  <td><?php echo $as1; ?></td>
                  <td><?php echo $as2; ?></td>
                  <td><?php echo $ts1; ?></td>
                  <td><?php echo $ts2; ?></td>
                  <td><?php echo $exam; ?></td>
                  <td><?php echo $total; ?></td>

                <?php endif; ?>
                <?php $q->free_result(); $q->close(); ?>
              </tr>
            <?php endwhile; ?>
            <?php $q0->free_result(); $q0->close(); ?>
          </tbody>
        </table>
        </form>
    <?php else:
      $q0->free_result();
      $q0->close();
    ?>
      <h2>There are no students in <?php echo $cl.$class2; ?></h2>
    <?php endif; ?>
  </div>
  <div class="col-md-6 pull-left">
      <a href="primary-results.php?<?php echo 'class='.$class.'&class2='.$class2.'&term='.$term.'&session='.$session; ?>" class="btn btn-outline-info">Go Back</a>
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
