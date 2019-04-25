<?php
  session_start();
  error_reporting(E_ALL);
  ini_set('display_errors', 'on');
?>
<?php if ( (isset($_SESSION['login'])) && (!empty($_SESSION['login'])) ): ?>
  <?php if ( isset($_REQUEST['session']) && (isset($_REQUEST['term'])) && (isset($_REQUEST['class'])) && (isset($_REQUEST['class2'])) ) :
      include 'includes/db.php';
      $class = $_REQUEST['class'];
      $class2 = $_REQUEST['class2'];
      $session = $_REQUEST['session'];
      $term = $_REQUEST['term'];
      $school = "secondary";

      $q2 = $db->prepare('select class from pri_class where id = ?');
      $q2->bind_param('s', $class);
      $q2->execute();
      $q2->bind_result($cl);
      $q2->fetch();
      $q2->free_result();
      $q2->close();

      $q0 = $db->prepare('select regno, fname from accepted_students where current_class = ? and class = ? and school = ?');
      $q0->bind_param('sss', $class, $class2,$school);
      $q0->execute();
      $q0->store_result();

     // include 'includes/header.php';
  ?>
<!DOCTYPE html>
<html>
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="">
      <meta name="author" content="">
      <meta name="keyword" content="">

      <title>Primary Students Behaviourial Ratings</title>
        <!--<link rel="icon" href="school.png" type="image/png">-->
      <!-- Bootstrap core CSS -->
      <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Bootstrap core CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
        <!-- Material Design Bootstrap -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.4/css/mdb.min.css" rel="stylesheet">
      <!--<link href="assets/css/bootstrap.css" rel="stylesheet">-->
      <!--external css-->
      <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />

      <!-- Custom styles for this template -->
      <!--<link href="assets/css/style.css" rel="stylesheet">-->
      <link href="assets/css/style-responsive.css" rel="stylesheet">
      <style>
        .input-sm{
          border-radius: 0
        }
      </style>
    </head>
<body class="bglight bgwhite">
<div class="container-fluid" style="margin-top: 30px">
<div class="col-12">
<div class="card" style="margin-bottom: 60px">
<div class="card-heading bg-primary text-center text-white">
    <?php if ($q0->num_rows > 0): ?>
      <h3 style="text-transform: uppercase;padding-top:20px;"> Enter <?php echo $cl." ".$class2; ?> students behaviourial ratings.</h3><br><br>
      <?php $q0->bind_result($regno, $fname) ?>
</div>
<div class="card-body">
        <table class="table table-striped table-bordered table-responsive">
          <thead>
            <tr>
              <th>REG NO</th>
              <th>NAME</th>
              <th>Punctuality</th>
              <th>Attendance</th>
              <th>Assignment participation</th>
              <th>School act participation</th>
              <th>Neatness</th>
              <th>Truthfulness</th>
              <th>SelfControl</th>
              <th>Relationship with others</th>
              <th>Games/sports</th>
              <th>Laboratory</th>
            </tr>
          </thead>
          <tbody>
            <form class="" action="pbehaviourial-script.php" method="post">
            <?php while ($q0->fetch()): ?>
              <?php
                $q = $db->prepare('select punctuality, attendance, assignment, school_act, neatness, honesty, self_control, relationship, games, lab from primary_behaviour where session = ? and term = ? and class = ? and class2 = ? and regno = ?');
                $q->bind_param('sssss', $session, $term, $class, $class2, $regno);
                $q->execute();
                $q->store_result();
              ?>
              <tr>
                <td><?php echo $regno; ?></td>
                <td><?php echo $fname; ?></td>
                <?php if ($q->num_rows):
                  $q->bind_result($punctuality, $attendance, $assignment, $school_act, $neatness, $honesty, $self_control, $relationship, $games, $lab);
                  $q->fetch();
                ?>
                  <td><?php echo $punctuality; ?></td>
                  <td><?php echo $attendance; ?></td>
                  <td><?php echo $assignment; ?></td>
                  <td><?php echo $school_act; ?></td>
                  <td><?php echo $neatness; ?></td>
                  <td><?php echo $honesty; ?></td>
                  <td> <?php echo $self_control; ?> </td>
                  <td> <?php echo $relationship; ?> </td>
                  <td> <?php echo $games; ?> </td>
                  <td> <?php echo $lab; ?> </td>
                <?php else: ?>
                  <td>
                    <select class="form-control" name="<?php echo $regno; ?>punctuality" required>
                      <option value="">-</option>
                      <option value="0">0</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <!--<option value="6">6</option>-->
                      <!--<option value="7">7</option>-->
                      <!--<option value="8">8</option>-->
                      <!--<option value="9">9</option>-->
                      <!--<option value="10">10</option>-->
                    </select>
                  </td>
                  <td>
                    <select class="form-control" name="<?php echo $regno; ?>attendance" required>
                      <option value="">-</option>
                      <option value="0">0</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <!--<option value="6">6</option>-->
                      <!--<option value="7">7</option>-->
                      <!--<option value="8">8</option>-->
                      <!--<option value="9">9</option>-->
                      <!--<option value="10">10</option>-->
                    </select>
                  </td>
                  <td>
                    <select class="form-control" name="<?php echo $regno; ?>assignment" required>
                      <option value="">-</option>
                      <option value="0">0</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <!--<option value="6">6</option>-->
                      <!--<option value="7">7</option>-->
                      <!--<option value="8">8</option>-->
                      <!--<option value="9">9</option>-->
                      <!--<option value="10">10</option>-->
                    </select>
                  </td>
                  <td>
                    <select class="form-control" name="<?php echo $regno; ?>school_act" required>
                      <option value="">-</option>
                      <option value="0">0</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <!--<option value="6">6</option>-->
                      <!--<option value="7">7</option>-->
                      <!--<option value="8">8</option>-->
                      <!--<option value="9">9</option>-->
                      <!--<option value="10">10</option>-->
                    </select>
                  </td>
                  <td>
                    <select class="form-control" name="<?php echo $regno; ?>neatness" required>
                      <option value="">-</option>
                      <option value="0">0</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <!--<option value="6">6</option>-->
                      <!--<option value="7">7</option>-->
                      <!--<option value="8">8</option>-->
                      <!--<option value="9">9</option>-->
                      <!--<option value="10">10</option>-->
                    </select>
                  </td>
                  <td>
                    <select class="form-control" name="<?php echo $regno; ?>honesty" required>
                      <option value="">-</option>
                      <option value="0">0</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <!--<option value="6">6</option>-->
                      <!--<option value="7">7</option>-->
                      <!--<option value="8">8</option>-->
                      <!--<option value="9">9</option>-->
                      <!--<option value="10">10</option>-->
                    </select>
                  </td>
                  <td>
                    <select class="form-control" name="<?php echo $regno; ?>self_control" required>
                      <option value="">-</option>
                      <option value="0">0</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <!--<option value="6">6</option>-->
                      <!--<option value="7">7</option>-->
                      <!--<option value="8">8</option>-->
                      <!--<option value="9">9</option>-->
                      <!--<option value="10">10</option>-->
                    </select>
                  </td>
                  <td>
                    <select class="form-control" name="<?php echo $regno; ?>relationship" required>
                      <option value="">-</option>
                      <option value="0">0</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <!--<option value="6">6</option>-->
                      <!--<option value="7">7</option>-->
                      <!--<option value="8">8</option>-->
                      <!--<option value="9">9</option>-->
                      <!--<option value="10">10</option>-->
                    </select>
                  </td>
                  <td>
                    <select class="form-control" name="<?php echo $regno; ?>games" required>
                      <option value="">-</option>
                      <option value="0">0</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <!--<option value="6">6</option>-->
                      <!--<option value="7">7</option>-->
                      <!--<option value="8">8</option>-->
                      <!--<option value="9">9</option>-->
                      <!--<option value="10">10</option>-->
                    </select>
                  </td>
                  <td>
                    <select class="form-control" name="<?php echo $regno; ?>lab" required>
                      <option value="">-</option>
                      <option value="0">0</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <!--<option value="6">6</option>-->
                      <!--<option value="7">7</option>-->
                      <!--<option value="8">8</option>-->
                      <!--<option value="9">9</option>-->
                      <!--<option value="10">10</option>-->
                    </select>
                  </td>
                <?php endif; ?>
                <?php $q->free_result(); $q->close(); ?>
              </tr>
            <?php endwhile; ?>
            <tr>
              <input type="hidden" name="term" value="<?php echo $term; ?>">
              <input type="hidden" name="class" value="<?php echo $class; ?>">
              <input type="hidden" name="class2" value="<?php echo $class2; ?>">
              <input type="hidden" name="session" value="<?php echo $session; ?>">
              <td colspan="12">
                <div class="col-md-6 pull-right">
                    <button type="submit" class="btn btn-outline-success pull-right" id="btn" name="bhv_btn">Submit</button>
                </div>
                 <div class="col-md-6 pull-left">
                      <a href="select-primary-class3.php" class="btn btn-outline-info input-sm">Go Back</a>
                  </div>
              </td>
            </tr>
            <?php $q0->free_result(); $q0->close(); ?>
          </tbody>
        </form>
        </table>
    <?php else:
      $q0->free_result();
      $q0->close();
    ?>
      <h2>There are no students in <?php echo $cl.$class2; ?></h2>
    <?php endif; ?>
  </div>
</div>
</div>
<?php //include 'includes/footer.php'; $db->close(); ?>

<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.13.0/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.4/js/mdb.min.js"></script>
</body>
</html>
<?php else:
  header('Location:select-primary-class3.php');
  exit;
?>
<?php endif; ?>
<?php else:
  header('Location:logout.php');
  exit;
?>
<?php endif; ?>
