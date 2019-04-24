<?php session_start(); error_reporting(E_ALL); ini_set("display_errors","on");?>
<?php if (isset($_SESSION['login'])): ?>
  <?php if ( (isset($_GET['regno'])) && (isset($_GET['term'])) && (isset($_GET['subject'])) && (isset($_GET['session'])) && (isset($_GET['class'])) && (isset($_GET['class2'])) ) :
    include 'includes/db.php';
    include 'includes/header.php';

    $subjectid = $_GET['subject'];
    $term = $_GET['term'];
    $regno = $_GET['regno'];
    $session = $_GET['session'];
    $class = $_GET['class'];
    $class2 = $_GET['class2'];

    $q = $db->prepare('select as1, as2, exam, total from scores where session = ? and term = ? and class = ? and subject = ? and regno = ? and class2 = ?');
    $q->bind_param('ssssss', $session, $term, $class, $subjectid, $regno, $class2);
    $q->execute();
    $q->store_result();
    $no = $q->num_rows;
  ?>
  <?php if ($no > 0):
    $q->bind_result($as1, $as2, $exam, $total);
    $q->fetch();
    $q->close();

    $q = $db->prepare("select fname from accepted_students where regno = ?");
    $q->bind_param('s', $regno);
    $q->execute();
    $q->bind_result($name);
    $q->fetch();
    $q->free_result();
    $q->close();

    $q = $db->prepare("select subject from subjects where id = ?");
    $q->bind_param('s', $subjectid);
    $q->execute();
    $q->bind_result($subject);
    $q->fetch();
    $q->free_result();
    $q->close();
    $db->close();
    $_SESSION['allow'] = 1;
  ?>
  <!DOCTYPE html>
  <html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="keyword" content="">

        <title>Edit Scores</title>

        <!-- Bootstrap core CSS -->
        <!--<link href="assets/css/bootstrap.css" rel="stylesheet">-->
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Bootstrap core CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
        <!-- Material Design Bootstrap -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.4/css/mdb.min.css" rel="stylesheet">
        <!--external css-->
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link rel="shortcut icon" href="school.png" type="image/png">
        <!-- Custom styles for this template -->
        <!--<link href="assets/css/style.css" rel="stylesheet">-->
        <link href="assets/css/style-responsive.css" rel="stylesheet">
        <style>
          .input-sm{
            border-radius: 0;
          }
          .form-control{
            font-weight: bold;
            font-size: 18px;
          }
        </style>
      </head>
      <body class="bglight">

        <section class="bglight  borderbottom" style="margin-top: 40px">
          <div class="col-8 offset-2">
              <div class="card">
                  <div class="card-heading bg-primary text-white text-center">
                      <div class="col-sm-12 form-group">
                              <h3 for="reg_number" class="size20 cblue">Edit <?php echo $name; ?> Score in <?php echo $subject; ?></h3>
                         </div>
                  </div>
                  <div class="card-body">
                      <div class="row">
              <div class="container cus-pos-abs">
                <div class="cover-center-text col-sm-12 col-md-12">

                  <script type="text/javascript" src="assets/js/calc.js"></script>
                    <form method="post" action="edit-script.php">
                      <input type="hidden" name="term" value="<?php echo $term; ?>">
                      <input type="hidden" name="class" value="<?php echo $class; ?>">
                      <input type="hidden" name="class2" value="<?php echo $class2; ?>">
                      <input type="hidden" name="session" value="<?php echo $session; ?>">
                      <input type="hidden" name="regno" value="<?php echo $regno; ?>">
                      <input type="hidden" name="subject" value="<?php echo $subjectid; ?>">

                      <div class="container">
                          <div class="row">
                               <div class="form-group col-sm-6">
                                   <label>CA</label>
                              <input type="number" class="form-control input-sm" value="<?php echo $as1; ?>" name="as1" placeholder="CA" id="as1" onchange="calcTotal('as1','as2','exam','total')" onkeyup="calcTotal('as1','as2','exam','total')" required>
                          </div>
                          <div class="form-group col-sm-6">
                              <label>Assignment</label>
                              <input type="number" class="form-control input-sm" value="<?php echo $as2; ?>" name="as2" placeholder="Assignment" id="as2"  onchange="calcTotal('as1','as2','exam','total')" onkeyup="calcTotal('as1','as2','exam','total')" required>
                          </div>
                          </div>
                         
                          <div class="row">
                              <div class="form-group col-sm-6">
                                  <label>Exams</label>
                              <input type="number" class="form-control input-sm" value="<?php echo $exam; ?>" name="exam" placeholder="Exams Score" id="exam" onchange="calcTotal('as1','as2','exam','total')" onkeyup="calcTotal('as1','as2','exam','total')" required>
                          </div>
                          <div class="form-group col-sm-6">
                              <label>Total</label>
                              <input type="number" class="form-control input-sm" value="<?php echo $total; ?>" name="total" placeholder="Total Score" readonly id="total">
                          </div>
                          </div>
                          <div class="form-group col-sm-10">
                              <button type="submit" class="btn btn-outline-success" id="btn" name="ss_btn">Update Scores</button>
                              <a href="enter-scores.php?subject=<?php echo $subjectid; ?>&class=<?php echo $class; ?>&class2=<?php echo $class2; ?>&term=<?php echo $term; ?>" class="btn btn-outline-info">Back</a>
                          </div>
                          <div>
                            <strong id="msg"></strong>
                         </div>
                      </div>
                  </form>
                </div>
              </div>
            </div>
                  </div>
              </div>
            
          </div>
        </section>
      </body>
    </html>
  <?php else:
    header("Location:enter-scores.php?subject=$subjectid&class=$class&class2=$class2&term=$term");
    exit;
  ?>
  <?php endif; ?>
<?php else:
  if (!(empty($_SERVER['HTTP_REFERER']))) {
    $url = $_SERVER['HTTP_REFERER'];
  } else {
    $url = "dashboard.php";
  }
  header("Location:$url");
  exit;
?>
<?php endif; ?>
<?php else:
  header('Location:logout.php');
  exit;
?>
<?php endif; ?>
