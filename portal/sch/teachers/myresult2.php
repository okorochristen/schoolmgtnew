<?php
  session_start();
  error_reporting(E_ALL);
  ini_set('display_errors', 'on');
?>
<?php if ( (isset($_SESSION['login'])) && (!(empty($_SESSION['login']))) ): ?>
  <?php if ( (isset($_GET['regno'])) && (isset($_GET['session'])) && (isset($_GET['term'])) && (isset($_GET['class'])) && (isset($_GET['class2']))):
    $regno = $_GET['regno'];
    $class = $_GET['class'];
    $session = $_GET['session'];
    $term = $_GET['term'];
    $class2 = $_GET['class2'];

    include 'includes/db.php';

    $q = $db->prepare('select position, total, average, class_average from result2 where regno = ? and session = ? and term = ? and class = ? and sclass = ?');
    $q->bind_param('sssss', $regno, $session, $term, $class, $class2);
    $q->execute();
    $q->bind_result($position, $total, $average, $caverage);
    $q->fetch();
    $q->close();

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
                  <p><b>Class: </b> <?php echo $cl; ?> <span style="text-transform:uppercase"><?php echo $class2; ?></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>Term: </b> <?php echo $term; ?></p><br>
                  <p><b>Class average: </b> <?php echo $caverage; ?>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>Average: </b> <?php echo $average; ?>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>Position: </b> <?php echo $position; ?></p><br>
                  <table class="table table-hover table-bordered">
                    <thead>
                      <tr>
                        <th>Subject</th>
                        <th>1st Assignment</th>
                        <th>2nd Assignment</th>
                        <th>1st Test</th>
                        <th>2nd Test</th>
                        <th>Exam</th>
                        <th>Total</th>
                        <th>Grade</th>
                        <th>Class average</th>
                        <th>Teacher</th>
                      </tr>
                    </thead>
                    <tbody>

                        <?php
                          $q0 = $db->prepare('select subject, as1, as2, ts1, ts2, exam, total, grade, class_average, staffid from scores2 where regno = ? and session = ? and term = ? and class = ? and class2 = ?');
                          $q0->bind_param('sssss', $regno, $session, $term, $class, $class2);
                          $q0->execute();
                          $q0->store_result();
                          $q0->bind_result($subjectid, $as1, $as2, $as3, $as4, $exam, $total, $grade, $class_average, $staffid);
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

                          $q6 = $db->prepare('select name from teachers where emailid = ?');
                          $q6->bind_param('s', $staffid);
                          $q6->execute();
                          $q6->store_result();
                          $q6->bind_result($staff);
                          $q6->fetch();
                          $q6->free_result();
                          $q6->close();
                        ?>
                          <tr>
                            <td><?php echo $subject; ?></td>
                            <td><?php echo $as1; ?></td>
                            <td><?php echo $as2; ?></td>
                            <td><?php echo $as3; ?></td>
                            <td><?php echo $as4; ?></td>
                            <td><?php echo $exam; ?></td>
                            <td><?php echo $total; ?></td>
                            <td><?php echo $grade; ?></td>
                            <td><?php echo $class_average; ?></td>
                            <td><?php echo $staff; ?></td>
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
