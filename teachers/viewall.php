<?php session_start();
  ini_set("display_errors","on");
  error_reporting(E_ALL);
?>
<?php if ( (isset($_SESSION['login'])) && (!empty($_SESSION['login'])) ): ?>

  <?php if (!empty($_REQUEST['session']) && !empty($_REQUEST['class2']) && !empty($_REQUEST['term']) && !empty($_REQUEST['class'])):
    include 'includes/db.php';

    $class = $_REQUEST['class'];
    $class2 = $_REQUEST['class2'];
    $term = $_REQUEST['term'];
    $session = $_REQUEST['session'];

    $q = $db->prepare("select distinct subject from scores where class = ? && class2 = ? && term = ? && session = ?");
    $q->bind_param('ssss',$class,$class2,$term,$session);
    $q->execute();
    $q->store_result();
    $c = $q->num_rows;
  ?>
  <!DOCTYPE html>
<html>
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="">
      <meta name="author" content="Dashboard">
      <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

      <title>Enter Scores</title>
        <!--<link rel="icon" href="school.png" type="image/png">-->
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
    <link rel="stylesheet" type="text/css" href="assets/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="assets/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css">
<link rel="shortcut icon" href="school.png" type="image/png">
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
      <script type="text/javascript" src="assets/js/calc.js"></script>
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
        @media (max-width:600px){
          .smally{
            margin:10px;
            margin-top:80px;
            padding-left:0px
          }
        }
        .smally{
            /* margin:10px; */
            margin-top:70px;
            padding-left:250px
          }
      </style>
      </head>
      <body>
        <div>
          <?php include('includes/header.php');?>
        <?php include('includes/sidebar.php');?>
      </div>
      <div class="container smally">
        <?php if (isset($_SESSION['msg'])): ?>
          <div class="alert alert-info">
            <p class="text-center"> <?php echo $_SESSION['msg']; ?> </p>
          </div>
        <?php endif; unset($_SESSION['msg']); ?>
        <h3 class="text-center">Overall Performance of Students</h3>
        <div class="col-md-12">
          <?php if ($c > 0):
            $q->bind_result($subjectid);
            $a = 1;

            $q1 = $db->prepare("select count(id) from result where class = ? && sclass = ? && term = ? && session = ?");
            $q1->bind_param('ssss',$class,$class2,$term,$session);
            $q1->execute();
            $q1->bind_result($n);
            $q1->fetch();
            $q1->free_result();
            $q1->close();
          ?>
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Subject</th>
                  <th>Total Students</th>
                  <th>0 - 39</th>
                  <th>40 - 49</th>
                  <th>50 - 70</th>
                  <th>70 - 80</th>
                  <th>80 - 100</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>

                  <?php while ($q->fetch()):
                    $q0 = $db->prepare("select subject from subjects where id = ?");
                    $q0->bind_param('s',$subjectid);
                    $q0->execute();
                    $q0->bind_result($subject_name);
                    $q0->fetch();
                    $q0->close();

                    $q0 = $db->prepare("select count(id) from scores where class = ? && class2 = ? && term = ? && session = ? && subject = ?");
                    $q0->bind_param('sssss',$class,$class2,$term,$session,$subjectid);
                    $q0->execute();
                    $q0->bind_result($total);
                    $q0->fetch();
                    $q0->close();

                    $q0 = $db->prepare("select count(id) from scores where class = ? && class2 = ? && term = ? && session = ? && subject = ? && total >= ? && total < ?");
                    $start_score = 0;
                    $end_score = 40;
                    $q0->bind_param('sssssii',$class,$class2,$term,$session,$subjectid,$start_score,$end_score);
                    $q0->execute();
                    $q0->bind_result($poor);
                    $q0->fetch();
                    $q0->close();
                    $poor = $poor/$total*100;
                    $poor = round($poor);

                    $q0 = $db->prepare("select count(id) from scores where class = ? && class2 = ? && term = ? && session = ? && subject = ? && total >= ? && total < ?");
                    $start_score = 40;
                    $end_score = 50;
                    $q0->bind_param('sssssss',$class,$class2,$term,$session,$subjectid,$start_score,$end_score);
                    $q0->execute();
                    $q0->bind_result($fair);
                    $q0->fetch();
                    $q0->close();

                    $fair = $fair/$total*100;
                    $fair = round($fair);

                    $q0 = $db->prepare("select count(id) from scores where class = ? && class2 = ? && term = ? && session = ? && subject = ? && total >= ? && total < ?");
                    $start_score = 50;
                    $end_score = 70;
                    $q0->bind_param('sssssss',$class,$class2,$term,$session,$subjectid,$start_score,$end_score);
                    $q0->execute();
                    $q0->bind_result($good);
                    $q0->fetch();
                    $q0->close();

                    $good = $good/$total*100;
                    $good = round($good);

                    $q0 = $db->prepare("select count(id) from scores where class = ? && class2 = ? && term = ? && session = ? && subject = ? && total >= ? && total < ?");
                    $start_score = 70;
                    $end_score = 80;
                    $q0->bind_param('sssssss',$class,$class2,$term,$session,$subjectid,$start_score,$end_score);
                    $q0->execute();
                    $q0->bind_result($vgood);
                    $q0->fetch();
                    $q0->close();

                    $vgood = $vgood/$total*100;
                    $vgood = round($vgood);

                    $q0 = $db->prepare("select count(id) from scores where class = ? && class2 = ? && term = ? && session = ? && subject = ? && total >= ? && total <= ?");
                    $start_score = 80;
                    $end_score = 100;
                    $q0->bind_param('sssssss',$class,$class2,$term,$session,$subjectid,$start_score,$end_score);
                    $q0->execute();
                    $q0->bind_result($excelent);
                    $q0->fetch();
                    $q0->close();

                    $excelent = $excelent/$total*100;
                    $excelent = round($excelent);
                  ?>
                  <tr>
                    <td> <?php echo $a; $a++; ?> </td>
                    <td> <?php echo $subject_name; ?> </td>
                    <td> <?php echo $total; ?> </td>
                    <td> <?php echo $poor; ?>% </td>
                    <td> <?php echo $fair; ?>% </td>
                    <td> <?php echo $good; ?>% </td>
                    <td> <?php echo $vgood; ?>% </td>
                    <td> <?php echo $excelent; ?>% </td>
                    <td> <a href="view-subject-scores.php?<?php echo 'class='.$class.'&class2='.$class2.'&term='.$term.'&session='.$session.'&subject='.$subjectid; ?>">View</a> </td>
                  </tr>
                <?php endwhile; ?>
                <!-- <tr>
                  <?php #if ($n < 1): ?>
                    <td> <a href="compute-result.php?<?php# echo 'class='.$class.'&class2='.$class2.'&term='.$term.'&session='.$session; ?>" class="btn btn-primary pull-right">Compute</a> </td>
                  <?php #else: ?>
                    <td> <a href="reset-result.php? <?php# echo 'class='.$class.'&class2='.$class2.'&term='.$term.'&session='.$session; ?>" class="btn btn-primary pull-right">Reset Result</a> </td>
                  <?php #endif; ?>
                </tr> -->
              </tbody>
            </table>
          <?php else: ?>
            <h4>No scores  have been entered for this class this term. <a href="secondary-results.php?<?php echo 'class='.$class.'&class2='.$class2.'&term='.$term.'&session='.$session; ?>" class="btn btn-default">Back</a> </h4>
          <?php endif; ?>

        </div>

     </div>
    </div>
       
      </body>
    </html>
  <?php else:
    header("Location:viewall.php");
    exit;
  ?>
  <?php endif; ?>
<?php else:
  header("Location:logout.php");
  exit;
?>
<?php endif; ?>
