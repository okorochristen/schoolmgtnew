<?php
  ob_start();
  session_start();
?>
<?php if ( isset($_REQUEST['class']) && isset($_REQUEST['class2']) && isset($_REQUEST['session']) && isset($_REQUEST['regno']) && isset($_REQUEST['school']) ):
  include 'includes/db.php';
  $n = 0;

  $class = $_REQUEST['class'];
  $class2 = $_REQUEST['class2'];
  $regno = $_REQUEST['regno'];
  $school = $_REQUEST['school'];
  $session = $_REQUEST['session'];
  
  if($school == "primary"){
    $q = $db->prepare('select position, total, average, class_average, status from promotional_result2 where regno = ? and session = ?  and class = ? and class2 = ?');
    $q0 = $db->prepare('select subject, total, grade, class_average, position from promotional_scores2 where regno = ? and session = ?  and class = ? and class2 = ?');
    $q1 = $db->prepare('select class from pri_class where id = ?');
  }
  else {
    $q = $db->prepare('select position, total, average, class_average, status from promotional_result1 where regno = ? and session = ? and class = ? and class2 = ?');
    $q0 = $db->prepare('select subject, total, grade, class_average, position from promotional_scores1 where regno = ? and session = ? and class = ? and class2 = ?');
    $q1 = $db->prepare('select class from classes where id = ?');
  }

  $q->bind_param('ssss', $regno, $session, $class, $class2);
  $q->execute();
  $q->bind_result($position, $total, $average, $caverage, $status);
  $q->fetch();
  $q->close();

  if($status == 1){
    $promoted = 'PROMOTED';
  }
  else {
    $promoted = 'NOT PROMOTED';
  }

  $q1->bind_param('s', $class);
  $q1->execute();
  $q1->store_result();
  $q1->bind_result($cl);
  $q1->fetch();
  $q1->close();

  $q2 = $db->prepare('select fname, gender, state, lga, passport from accepted_students where regno = ?');
  $q2->bind_param('s', $regno);
  $q2->execute();
  $q2->bind_result($name, $gender, $state, $lga, $passport);
  $q2->fetch();
  $q2->close();

?>
  <!DOCTYPE HTML>
  <html>
  <head>
  <title>.:: Result summary</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="shortcut icon" href="images/school.png" type="image/png">
  <script type="applijewelleryion/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
  <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
  <link href="css/style.css" rel='stylesheet' type='text/css' />
  <link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
  <link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
  <link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
  <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css" type="text/css" rel="stylesheet">
  <link href="css/font-awesome.css" rel="stylesheet">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="DataTables/Responsive/css/responsive.bootstrap.min.css">
	<link rel="stylesheet" href="DataTables/Responsive/css/responsive.jqueryui.min.css">
	<link rel="stylesheet" href="DataTables/pdfmake/pdfmake.min.css">
	<link rel="stylesheet" href="DataTables/DataTables/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="DataTables/DataTables/dataTables.jqueryui.min.css">
	<link rel="stylesheet" href="DataTables/Buttons/buttons.dataTables.min.css">
	<link rel="stylesheet" href="DataTables/DataTables/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs-3.3.7/jqc-1.12.3/jszip-2.5.0/dt-1.10.16/b-1.5.0/b-html5-1.5.0/b-print-1.5.0/datatables.min.css"/>
	 <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.0/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.0/css/buttons.dataTables.min.css">
  <!-- Custom Theme files -->
  <script src="js/jquery-1.12.0.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <!--animate-->
  <link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <style>
    .input-sm{
      border-radius: 0
    }
    table, tr, td, th {
          border: 1px solid #000;
          position: relative;
          /*padding: 1px;*/
        }

        th span {
          transform-origin: 0 50%;
          transform: rotate(-90deg);
          white-space: nowrap;
          display: block;
          position: absolute;
          bottom: 0;
          left: 50%;
        }
  </style>
  <script src="js/wow.min.js"></script>
    <script>
       new WOW().init();
    </script>
  </head>
  <body>
  <?php include('../teachers/includes/header3.php');?>
  <section class="bglight  borderbottom sspacing">
    <div class="col-xs-12 col-sm-12 col-md-12 panel-body">
      <div class="row">
        <div class="container cus-pos-abs">
            <div class="row">
                <div class="col-sm-12">
                   
            <!--        <div class="col-sm-4" style="height:30px; width:10%; padding:8px; margin-bottom:35px">-->
                <!--<img src="images/logo.png" class="img-thumbnail img-responsive">-->
            <!--</div>-->
            <div class="col-sm-10 text-center" style="height:30px; width:100%;">
            <h2 class="text-center" style="font-weight:bold; font-family:georgia; color:red">WHITE DIAMONDS ACADEMY</h2>
            <p><b>(Kindergarten, Elementary & High School)</b></p>
                <p>Beside Grace and Power Church, Diye-Tei, off Zaramagada Rayfield Road (by Railway crossing), Jos. Phone:
                08164158713, 08036167308</p>
              <h4>RESULT SUMMARY FOR <?php echo $session; ?> ACADEMIC SESSION.</h4>
              
            </div>
             <div class="col-md-2">
                      <?php if($school == "primary"): ?>
                          <img src = "./primary passports/<?php echo htmlentities($passport); ?>" height="120" width="150" class="img-responsive img-thumbnail" />
                      <?php else: ?>
                          <img src = "./secondary passports/<?php echo htmlentities($passport); ?>" height="120" width="150" class="img-responsive img-thumbnail" />
                      <?php endif; ?>
                    </div>
            </div>
            </div>
          <div class="cover-center-text col-sm-12 col-md-12" style="margin-top:10px">

              <div class="col-xs-12 col-sm-12 col-md-12">
              <table class="table table-bordered table-condensed" id="example" cellpadding="0" align="center">
                  <thead>
                  <tr>
                      <th>STUDENT'S NAME</th>
                      <th>REGISTRATION NUMBER</th>
                      <th>GENDER</th>
                      <th>STATE OF ORIGIN</th>
                      <th>LGA</th>
                      <th>STUDENT'S CLASS</th>
                      <th>AVERAGE</th>
                      <th></th>
                      <th>POSITION</th>
                      <th>SESSION</th>
                  </tr>
                  <tr>
                      <td><?php echo $name; ?></td>
                      <td><?php echo $regno; ?></td>
                      <td><?php echo $gender; ?></td>
                      <td><?php echo $state; ?></td>
                      <td><?php echo $lga; ?></td>
                       <td><?php echo $cl; ?></td>
                       <td><?php echo $average; ?></td>
                      <td></td>
                      <td><?php echo $position; ?></td>
                      <td><?php echo $session; ?></td>
                      </tr>

                    <tr>
                      <th colspan="2">SUBJECTS</th>
                      <th colspan="2">TOTAL (100)</th>
                      <th colspan="2">GRADE</th>
                      <th colspan="2">POSITION</th>
                      <th colspan="2">CLASS AVERAGE</th>
                    </tr>
                  </thead>

                  <tbody>
                   <?php
                    $q0->bind_param('ssss', $regno, $session, $class, $class2);
                    $q0->execute();
                    $q0->store_result();
                    $q0->bind_result($subjectid, $total, $grade, $class_average, $position);
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
                      <td colspan="2"><?php echo $subject; ?></td>
                      <td colspan="2"><?php echo $total; ?></td>
                      <td colspan="2"><?php echo $grade; ?></td>
                      <td colspan="2"><?php echo $position; ?></td>
                      <td colspan="2"><?php echo $class_average; ?></td>
                    </tr>
                  <?php endwhile; ?>
                  <?php $q0->free_result(); $q0->close(); ?>

            </tbody>
            </table>
             <div class="row">
                              <div class="col-md-6 col-sm-6 col-xs-6">
                                  <table class="table table-bordered table-condensed">
                                      <thead>
                                          <tr>
                                              <th colspan="2" class="text-center">CHARACTER/SKILL DEVELOPMENT</th>
                                          </tr>
                                          <tr>
                                              <th>Punctuality:</th><td>5</td>
                                          </tr>
                                          <tr>
                                              <th>Attendance in class:</th><td>5</td>
                                          </tr>
                                          <tr>
                                              <th>Participation out of Assignment:</th><td>5</td>
                                          </tr>
                                          <tr>
                                              <th>Participation in school act:</th><td>5</td>
                                          </tr>
                                          <tr>
                                              <th>Neatness:</th><td>5</td>
                                          </tr>
                                          <tr>
                                              <th>Honesty:</th><td>5</td>
                                          </tr>
                                          <tr>
                                              <th>Self-Control:</th><td>5</td>
                                          </tr>
                                          <tr>
                                              <th>Relationship with others:</th><td>5</td>
                                          </tr>
                                          <tr>
                                              <th>Games/Sports:</th><td>5</td>
                                          </tr>
                                          <tr>
                                              <th>Handling of Lab_Tools:</th><td>5</td>
                                          </tr>
                                      </thead>
                                      <tbody>

                                      </tbody>
                                  </table>
                              </div>
                              <div class="col-md-6 col-sm-6 col-xs-6">
                                  <table class="table table-bordered table-condensed">
                                      <thead>
                                          <tr>
                                              <th colspan="2" class="text-center">SUMMARY OF ACADEMIC PERFORMANCE</th>
                                          </tr>
                                          <!--<tr>-->
                                          <!--	<th>GRAND TOTAL SCORE</th><td><?php //echo $total; ?></td>-->
                                          <!--</tr>-->
                                          <tr>
                                          	<th>CLASS AVERAGE</th><td><?php echo $class_average; ?></td>
                                          </tr>
                                          <tr>
                                          	<th>STATUS</th><td><?php echo $promoted; ?></td>
                                          </tr>
                                      </thead>
                                      <tbody>
                                      	<tr>
                                      		<th colspan="2" class="text-center">KEY TO RATING</th>
                                      	</tr>
                                      	<tr>
                                      		<td>75-100 = A1: - Excellent</td>
                                      		<td>70-74 = B2: - Very Good</td>
                                      	</tr>
										<tr>
                                      		<td>65-69 = B3: - Good</td>
                                      		<td>60-64 = C4: - Credit</td>
                                      	</tr>
                                      	<tr>
                                      		<td>55-59 = C5: - Credit</td>
                                      		<td>50-54 = C6: - Credit</td>
                                      	</tr>
                                      	<tr>
                                      		<td>45-49 = D7: - Fair</td>
                                      		<td>40-44 = E8: - Fair</td>
                                      	</tr>
                                      	<tr>
                                      		<td colspan="2">0-39 = F9: - Fail</td>
                                      	</tr>
                                      </tbody>
                                  </table>
                              </div>
                      </div>
                      <!-- here-->

                      <?php $db->close(); ?>
            </div>
        </div>
      </div>
    </div>
  </section>
  <script>
      $(function() {
    var header_height = 0;
    $('table th span').each(function() {
        if ($(this).outerWidth() > header_height) header_height = $(this).outerWidth();
    });

    $('table th').height(header_height);
});
  </script>
  <?php include 'includes/footer.php'; ?>
  </body>
  </html>

<?php else:
  $url = $_SERVER['HTTP_REFERER'];
  header("Location:$url");
  exit;
?>

<?php endif; ?>
