<?php
  session_start();
  error_reporting(E_ALL);
  ini_set('display_errors', 'on');
?>
<?php if ( (isset($_SESSION['login'])) && (strlen($_SESSION['login']) >  0) ): ?>
  <?php if ( (isset($_GET['regno'])) && (isset($_GET['session'])) && (isset($_GET['class'])) ):
    $regno = $_GET['regno'];
    $class = $_GET['class'];
    $session = $_GET['session'];

    include 'includes/db.php';

    $q = $db->prepare('select position, total, average, class_average from promotional_result2 where regno = ? and session = ? and class = ?');
    $q->bind_param('sss', $regno, $session, $class);
    $q->execute();
    $q->bind_result($position, $total, $average, $caverage);
    $q->fetch();
    $q->close();

    $q1 = $db->prepare('select class from classes where id = ?');
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
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Dashboard">
        <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

        <title>Result</title>

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
      </head>
      <body class="bglight" style="background-size: cover;">

        <section class="bglight  borderbottom sspacing">
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="row">
              <div class="container cus-pos-abs">
                <div class="cover-center-text col-sm-12 col-md-12">
                  <p><b>Name: </b> <?php echo $name; ?>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>Registration number: </b> <?php echo $regno; ?></p><br>
                  <p><b>Class: </b> <?php echo $cl; ?></p><br>
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
                          $q0 = $db->prepare('select subject, total, grade, class_average from promotional_scores2 where regno = ? and session = ? and class = ?');
                          $q0->bind_param('sss', $regno, $session, $class);
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
