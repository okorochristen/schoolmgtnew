<?php
  session_start();
  error_reporting(E_ALL);
  ini_set('display_errors', 'on');
?>
<?php if ( (isset($_SESSION['alogin'])) && (strlen($_SESSION['alogin']) >  0) ): ?>
  <?php if ( (isset($_REQUEST['regno'])) && (isset($_REQUEST['session'])) && (isset($_REQUEST['class'])) && (isset($_REQUEST['class2']))):
    $regno = $_REQUEST['regno'];
    $class = $_REQUEST['class'];
    $session = $_REQUEST['session'];
    $class2 = $_REQUEST['class2'];

    include 'includes/db.php';

    $q = $db->prepare('select position, total, average, class_average, status from promotional_result2 where regno = ? and session = ? and class = ? and class2 = ?');
    $q->bind_param('ssss', $regno, $session, $class, $class2);
    $q->execute();
    $q->bind_result($position, $total, $average, $caverage, $status);
    $q->fetch();
    $q->close();

    if($status == 1){
      $status = "Promoted";
    }
    elseif ($status == 0) {
      $status = "Not promoted";
    }
    else {
      $status = "";
    }

    $q1 = $db->prepare('select class from pri_class where id = ?');
    $q1->bind_param('s', $class);
    $q1->execute();
    $q1->bind_result($cl);
    $q1->fetch();
    $q1->close();

    $q2 = $db->prepare('select fname from accepted_students where regno = ?');
    $q2->bind_param('s', $regno);
    $q2->execute();
    $q2->bind_result($name);
    $q2->fetch();
    $q2->close();
  ?>
  <!DOCTYPE html>
  <html>
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
  <body>

        <section class="bglight  borderbottom sspacing">
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="row">
              <div class="container cus-pos-abs">
                <div class="cover-center-text col-sm-12 col-md-12">
                  <h3>Result summary for <?php echo $session; ?> academic session.</h3>
                  <p><b>Name: </b> <?php echo $name; ?>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>Registration number: </b> <?php echo $regno; ?></p><br>
                  <p style="text-transform: uppercase; margin-right:50px"><b>Class: </b> <?php echo $cl." ".$class2; ?> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <b>status</b> <?php echo $status; ?> </p><br>
                  <p><b>Class average: </b> <?php echo $caverage; ?>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>Average: </b> <?php echo $average; ?>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>Position: </b> <?php echo $position; ?></p><br>
                  <table class="table table-hover table-bordered">
                    <thead>
                      <tr>
                        <th>Subject</th>
                        <th>Total</th>
                        <th>Grade</th>
                        <th>Class average</th>
                      </tr>
                    </thead>
                    <tbody>

                        <?php
                          $q0 = $db->prepare('select subject, total, grade, class_average from promotional_scores2 where regno = ? and session = ? and class = ? and class2 = ?');
                          $q0->bind_param('ssss', $regno, $session, $class, $class2);
                          $q0->execute();
                          $q0->store_result();
                          $q0->bind_result($subjectid, $total, $grade, $class_average);
                        ?>
                        <?php while ($q0->fetch()):
                          $q5 = $db->prepare('select subject from subjects where id = ?');
                          $q5->bind_param('s', $subjectid);
                          $q5->execute();
                          $q5->store_result();
                          $q5->bind_result($subject);
                          $q5->fetch();
                          $q5->free_result();
                          $q5->close();
                        ?>
                          <tr>
                            <td><?php echo $subject; ?></td>
                            <td><?php echo $total; ?></td>
                            <td><?php echo $grade; ?></td>
                            <td><?php echo $class_average; ?></td>
                          </tr>
                        <?php endwhile; ?>
                        <?php $q0->free_result(); $q0->close(); ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </section>
      </body>
      </html>
  <?php else:
    $url = $_SERVER['HTTP_REFERER'];
    header("Location:$url");
    exit;
  ?>
  <?php endif; ?>
<?php else:
  header("Location:logout.php");
  exit;
?>
<?php endif; ?>
