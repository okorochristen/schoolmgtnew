<?php
    ob_start();
  session_start();
  
  error_reporting(E_ALL);
  ini_set('display_errors', 'on');
?>
<?php if ( (isset($_SESSION['login'])) && (!empty($_SESSION['login'])) ): ?>
  <?php if ( isset($_POST['scores_btn']) || (isset($_SESSION['allow'])) ) :
    unset($_SESSION['allow']);
    if ( (empty($_POST['subject'])) && (!isset($_GET['subject'])) ) {
      header('Location:select-class.php');
      exit;
    }
    elseif ( (empty($_POST['class'])) && (!isset($_GET['class'])) ) {
      header('Location:select-class.php');
      exit;
    }
    elseif ( (empty($_POST['class2'])) && (!isset($_GET['class2'])) ) {
      header('Location:select-class.php');
      exit;
    }
    elseif ( (empty($_POST['term'])) && (!isset($_GET['term'])) ) {
      header('Location:select-class.php');
      exit;
    }
    else {
      include 'includes/db.php';
      // include "aa.php";
      include 'aa.php';
      $class = $_REQUEST['class'];
      $class2 = $_REQUEST['class2'];
      $subject = $_REQUEST['subject'];
      $term = $_REQUEST['term'];

      $q = $db->prepare("select distinct current_session from accepted_students order by current_session desc");
      $q->execute();
      $q->bind_result($sn);
      $q->fetch();
      $q->close();

      $q = $db->prepare("select id from result where session = ? and term = ? and class = ? and sclass = ?");
      $q->bind_param('ssss', $sn, $term, $class, $class2);
      $q->execute();
      $q->store_result();
      $nu = $q->num_rows;
      $q->close();
    }
  ?>
    <?php if($nu < 1):
      $school = "secondary";
      $q2 = $db->prepare('select class from classes where id = ?');
      $q2->bind_param('s', $class);
      $q2->execute();
      $q2->bind_result($cl);
      $q2->fetch();
      $q2->free_result();
      $q2->close();
      $q0 = $db->prepare('select regno, fname, current_session from accepted_students where current_class = ? and class = ? and school = ?');
      $q0->bind_param('sss', $class, $class2, $school);
      $q0->execute();
      $q0->store_result();
      $n = $q0->num_rows;
      include 'includes/header.php';
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

      <!-- Custom styles for this template -->
      <!--<link href="assets/css/style.css" rel="stylesheet">-->
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
            margin-top:200px!important;
          }
        }
        .smally{
            margin-top:100px;
        }
      </style>
    </head>
<body class="bglight bgwhite">

<div class="container-fluid smally" style="padding-top: 60px;">
  <div class="col-12">
      <div class="card">
          
            <?php if ($n > 0):
              $q4 = $db->prepare('select subject from subjects where id = ?');
              $q4->bind_param('s', $subject);
              $q4->execute();
              $q4->bind_result($sb);
              $q4->fetch();
              $q4->free_result();
              $q4->close();
             ?>
      
      <?php $q0->bind_result($regno, $fname, $session) ?>
    <div class="card-heading text-white bg-primary">
                <h3 style="text-transform: uppercase;" class="text-center"> Enter <?php echo $cl." ".$class2; ?> student scores in <?php echo $sb; ?></h3><br><br>        
          </div>
          <div class="card-body">
         
        <table class="table table-hover table-responsive table-striped" style="margin-bottom:70px">
          <thead>
            <tr>
              <th>REG NO</th>
              <th>NAME</th>
              <th>CA</th>
              <th>Homework</th>
              <!-- <th></th> -->
              <!--<th>Ts 2</th>-->
              <th>Exam</th>
              <th>TotaL</th>
              <th>Last term score</th>
              <th>Cum Score</th>
              <th>Grade</th>
              <th>Class highest mark</th>
              <th>Class Avg</th>
              <!-- <th>Position</th>
              <th>Remarks</th> -->
              <th colspan="2">Action</th>
            </tr>
          </thead>
          <tbody>
            <form class="" action="scores-script.php" method="post">
            <?php while ($q0->fetch()): ?>
            
              <?php
                $q = $db->prepare('select as1, as2,ts1, ts2, exam, total, grade, class_average from scores where session = ? and term = ? and class = ? and subject = ? and regno = ?;');
                // var_dump($q);
                $q->bind_param('sssss', $session, $term, $class, $subject, $regno);
                $q->execute();
                $q->store_result();
                $no = $q->num_rows;
              ?>
              <tr>
                <td><?php echo $regno; ?></td>
                <td><?php echo $fname; ?></td>
                <?php if ($no > 0):
                  $q->bind_result($as1, $as2, $ts1, $ts2, $exam, $total,$grades, $class_average);
                  $q->fetch();
                
                ?>
                  <?php 
                  
                ?>   
                  <td><?php echo $as1+$as2; ?></td>
                  <td><?php echo $ts1+$ts2; ?></td>
                  <td><?php echo $exam; ?></td>
                  <td><?php echo $total; ?></td>
                  <td><?php echo "last term"; ?></td>
                  <td><?php echo "cum score"; ?></td>
                  
                  

                  <td><?php echo $grades; ?></td>
                  <td>
                    <?php 
                    
                      echo $result;
                    ?>
                  </td>
                  <td><?php echo $class_average; ?></td>
               
                   
                  

                  <td><a href="edit-score.php?class2=<?php echo $class2; ?>&session=<?php echo $session; ?>&term=<?php echo $term; ?>&class=<?php echo $class; ?>&subject=<?php echo $subject; ?>&regno=<?php echo $regno; ?>" class="btn btn-outline-info">Edit</a></td>
                  <td><a href="delete-score.php?class2=<?php echo $class2; ?>&session=<?php echo $session; ?>&term=<?php echo $term; ?>&class=<?php echo $class; ?>&subject=<?php echo $subject; ?>&regno=<?php echo $regno; ?>" class="btn btn-outline-danger">Delete</a></td>
                <?php else: ?>
                  <td> <input type="number" id="<?php echo $regno; ?>as1" name="<?php echo $regno; ?>as1" placeholder="0" placeholder="" class="form-control"
                    onchange="calcTotal('<?php echo $regno."as1"; ?>','<?php echo $regno."as2"; ?>','<?php echo $regno."exam"; ?>','<?php echo $regno."total"; ?>')"
                    onkeyup="calcTotal('<?php echo $regno."as1"; ?>','<?php echo $regno."as2"; ?>','<?php echo $regno."exam"; ?>','<?php echo $regno."total"; ?>')"> </td>
                  <td> <input type="number" id="<?php echo $regno; ?>as2" name="<?php echo $regno; ?>as2" placeholder="0" placeholder="" class="form-control"
                    onchange="calcTotal('<?php echo $regno."as1"; ?>','<?php echo $regno."as2"; ?>','<?php echo $regno."exam"; ?>','<?php echo $regno."total"; ?>')"
                    onkeyup="calcTotal('<?php echo $regno."as1"; ?>','<?php echo $regno."as2"; ?>','<?php echo $regno."exam"; ?>','<?php echo $regno."total"; ?>')"> </td>
                  <td> <input type="number" id="<?php echo $regno; ?>exam" name="<?php echo $regno; ?>exam" placeholder="0" placeholder="" class="form-control"
                    onchange="calcTotal('<?php echo $regno."as1"; ?>','<?php echo $regno."as2"; ?>','<?php echo $regno."exam"; ?>','<?php echo $regno."total"; ?>')"
                    onkeyup="calcTotal('<?php echo $regno."as1"; ?>','<?php echo $regno."as2"; ?>','<?php echo $regno."exam"; ?>','<?php echo $regno."total"; ?>')"> </td>
                  <td> <input type="number" id="<?php echo $regno; ?>total" name="" value="0" placeholder="" class="form-control" readonly> </td>
                  <td colspan="2"></td>
                  <input type="hidden" name="term" value="<?php echo $term; ?>">
                  <input type="hidden" name="class" value="<?php echo $class; ?>">
                  <input type="hidden" name="class2" value="<?php echo $class2; ?>">
                  <input type="hidden" name="session" value="<?php echo $session; ?>">
                  <input type="hidden" name="subject" value="<?php echo $subject; ?>">
                <?php endif; ?>
                <?php $q->free_result(); $q->close(); ?>
              </tr>
            <?php endwhile; ?>
            <tr>
              <td colspan="12">
                  <div class="col-md-6 pull-left">
                      <a href="select-class.php" class="btn btn-outline-primary">Go Back</a>
                  </div>
                <div class="col-md-6 pull-right">
                    <button type="submit" class="btn btn-outline-success input-sm pull-right" id="btn" name="ss_btn">Submit Scores</button>
                </div>
              </td>
            </tr>
            <?php $q0->free_result(); $q0->close(); ?>
          </tbody>
        </table>
        </form>
    <?php else:
      $q0->free_result();
      $q0->close();
    ?>
      <h2>There are no students in <?php echo $cl." ".$class2; ?></h2>
    <?php endif; ?>
  </div>
  <a href="dashboard.php" class="btn btn-outline-info input-sm">Back to Dashboard</a>
        </div>
      </div>
  
</div>

<?php include 'includes/footer.php'; $db->close(); ?>
</body>
</html>
<?php else:
  $_SESSION['rac'] = 1;
  header("Location:class-result.php?session=$sn&class=$class&term=$term&class2=$class2");
  exit;
?>
<?php endif; ?>
<?php else:
  header('Location:select-class.php?');
  exit;
?>
<?php endif; ?>
<?php else:
  header('Location:logout.php');
  exit;
?>
<?php endif; ?>
