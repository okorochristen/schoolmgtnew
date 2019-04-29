<?php
  ob_start();
  session_start();
?>
<?php if ( isset($_POST['pin']) ):
  include 'includes/db.php';
  $n = 0;

  $pin = $_POST['pin'];
  $q = $db->prepare('select class, class2, session, term, regno from result_checker2 where pin = ?');
  $q->bind_param('s', $pin);
  $q->execute();
  $q->store_result();
  $n = $q->num_rows;
  
  if($n < 1){
    $q->close();
    
    $q = $db->prepare('select class, class2, session, term, regno from result_checker where pin = ?');
    $q->bind_param('s', $pin);
    $q->execute();
    $q->store_result();
    $n = $q->num_rows;
  }
?>
  <?php if ($n > 0):
    $q->bind_result($class, $class2, $session, $term, $regno);
    $q->fetch();
    $q->close();
    
    $q = $db->prepare('select school from accepted_students where regno = ?');
    $q->bind_param('s',$regno);
    $q->execute();
    $q->bind_result($school);
    $q->fetch();
    $q->close();
    
    if($school == "primary"){
        $q = $db->prepare('select position, total, average, class_average from result2 where regno = ? and session = ? and term = ? and class = ?');
        $q0 = $db->prepare('select subject, as1, as2, ts1, ts2, exam, total, grade, class_average, staffid from scores2 where regno = ? and session = ? and term = ? and class = ?');    
        $q1 = $db->prepare('select class from pri_class where id = ?');
    }
    else{
        $q = $db->prepare('select position, total, average, class_average from result where regno = ? and session = ? and term = ? and class = ?');
        $q0 = $db->prepare('select subject, as1, as2, ts1, ts2, exam, total, grade, class_average, staffid from scores where regno = ? and session = ? and term = ? and class = ?');
        $q1 = $db->prepare('select class from classes where id = ?');
    }
    
    $q->bind_param('ssss', $regno, $session, $term, $class);
    $q->execute();
    $q->store_result();
    $computed = $q->num_rows;
    
    if($computed > 0){
        if($term == 1){
            $ad = "st";
        }
        elseif($term == 2){
            $ad = "nd";
        }
        else{
            $ad = "rd";
        }
        
        $q->bind_result($position, $total, $average, $caverage);
        $q->fetch();
        
        $q1->bind_param('s', $class);
        $q1->execute();
        $q1->store_result();
        $q1->bind_result($cl);
        $q1->fetch();
        $q1->close();
    
        $q2 = $db->prepare('select fname, gender, state, lga, passport from accepted_students where regno = ?');
        $q2->bind_param('s', $regno);
        $q2->execute();
        $q->store_result();
        $q2->bind_result($name, $gender, $state, $lga, $passport);
        $q2->fetch();
        $q2->close();
    }
    
    $q->close();
    
  ?>
  <!DOCTYPE HTML>
  <html>
  <head>
  <title>.:: Result Checker</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="shortcut icon" href="images/school.png" type="image/png">
  <script type="applijewelleryion/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
  <!--<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />-->
  <!--<link href="css/style.css" rel='stylesheet' type='text/css' />-->
  
  <!-- Font Awesome -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Bootstrap core CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
<!-- Material Design Bootstrap -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.4/css/mdb.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="css/table-style.css" />
  <link rel="stylesheet" type="text/css" href="css/basictable.css" />
  <script type="text/javascript" src="jquery.dataTables.js"></script>
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="sum().js"></script>
<scr$(document).ready(function() {
    $('#example').DataTable();
} );
</script>
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
    <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="row">
        <div class="container">
            <div class="row">
                <div class="col-sm-10 text-center" style="height:30px; width:100%;">
                    <h2 class="text-center" style="font-weight:bold; font-family:georgia; color:red">RHIMONI ACADEMY AKWANGA</h2>
                    <p><b></b></p>
                        <p>Keffi Road, Beside Shepherd International College, Akwanga, Nasarawa State. </p>
                        <p>08171454092, 07030925859, 08150462677</p>
                </div>
                <div class="col-md-2">
                    <?php if($computed > 0): ?>
                        <?php if($school == "primary"): ?>
                            <img src = "./primary passports/<?php echo htmlentities($passport); ?>" height="125" width="150" class="img-responsive img-thumbnail" />
                        <?php else: ?>
                            <img src = "./secondary passports/<?php echo htmlentities($passport); ?>" height="125" width="150" class="img-responsive img-thumbnail" />
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                
            
            </div>
        </div>
          <div class="cover-center-text col-sm-12 col-md-12" style="margin-top:10px">
            
              <div class="col-xs-12 col-sm-12 col-md-12">
                  <?php if($computed > 0): ?>
              <table class="display table-bordered" border="1" id="example" style="width:100%">
                  <thead>
                  <tr>
                      <th>STUDENT'S NAME</th>
                      <th>REGISTRATION NUMBER</th>
                      <th>GENDER</th>
                      <th>STATE OF ORIGIN</th>
                      <th>LGA</th>
                       <th>STUDENT'S CLASS</th>
                       <th>AVERAGE</th>
                      <th>TERM</th>
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
                      <td><?php echo $term.$ad; ?></td>
                      <td><?php echo $position; ?></td>
                      <td><?php echo $session; ?></td>
                      </tr>
                      
                <tr>
                      <th>SUBJECTS</th>
                      <th>1<sup>st</sup> Assignment</th>
                      <th>2<sup>nd</sup> Assignment</th>
                      <th>1<sup>st</sup> Test</th>
                      <th>2<sup>nd</sup> Test</th>
                      <th>Exams</th>
                      <th>TOTAL (100)</th>
                      <th>GRADE</th>
                      <th>CLASS AVERAGE</th>
                      <th>TEACHER</th>
                </tr>
                  </thead>
                
                  <tbody>
                      
                       <?php
                    
                    $q0->bind_param('ssss', $regno, $session, $term, $class);
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
                  
                      <?php //echo $position; ?></p><br>
                      
               
            </tbody>
            </table>
             <div class="row">
                 <?php
                    if($school == "primary"){
                        $q0 = $db->prepare('select punctuality, attendance, assignment, school_act, neatness, honesty, self_control, relationship, games, lab from primary_behaviour where session = ? and term = ? and class = ? and class2 = ? and regno = ?');   
                    }
                    else{
                        $q0 = $db->prepare('select punctuality, attendance, assignment, school_act, neatness, honesty, self_control, relationship, games, lab from secondary_behaviour where session = ? and term = ? and class = ? and class2 = ? and regno = ?');
                    }
                    $q0->bind_param('sssss', $session, $term, $class, $class2, $regno);
                    $q0->execute();
                    $q0->bind_result($punctuality, $attendance, $assignment, $school_act, $neatness, $honesty, $self_control, $relationship, $games, $lab);
                    $q0->fetch();
                    $q0->free_result();
                    $q0->close();
                ?>
                              <div class="col-md-6 col-sm-6 col-xs-6">
                                  <table class="display table-bordered" border="1" id="example" style="width:100%">
                                      <thead>
                                          <tr>
                                              <th colspan="2" class="text-center">CHARACTER/SKILL DEVELOPMENT</th>
                                          </tr>
                                          <tr>
                                              <th>Punctuality:</th><td><?php echo $punctuality; ?></td>
                                          </tr>
                                          <tr>
                                              <th>Attendance in class:</th><td><?php echo $attendance; ?></td>
                                          </tr>
                                          <tr>
                                              <th>Participation out of Assignment:</th><td><?php echo $assignment; ?></td>
                                          </tr>
                                          <tr>
                                              <th>Participation in school act:</th><td><?php echo $school_act; ?></td>
                                          </tr>
                                          <tr>
                                              <th>Neatness:</th><td><?php echo $neatness; ?></td>
                                          </tr>
                                          <tr>
                                              <th>Honesty:</th><td><?php echo $honesty; ?></td>
                                          </tr>
                                          <tr>
                                              <th>Self-Control:</th><td><?php echo $self_control; ?></td>
                                          </tr>
                                          <tr>
                                              <th>Relationship with others:</th><td><?php echo $relationship; ?></td>
                                          </tr>
                                          <tr>
                                              <th>Games/Sports:</th><td><?php echo $games; ?></td>
                                          </tr>
                                          <tr>
                                              <th>Handling of Lab_Tools:</th><td><?php echo $lab; ?></td>
                                          </tr>
                                      </thead>
                                      <tbody>
                                      	
                                      </tbody>
                                  </table>
                              </div>
                              <div class="col-md-6 col-sm-6 col-xs-6">
                                  <table class="display table-bordered" border="1" id="example" style="width:100%">
                                      <thead>
                                          <tr>
                                              <th colspan="2" class="text-center">SUMMARY OF ACADEMIC PERFORMANCE</th>
                                          </tr>
                                          <!--<tr>-->
                                          <!--	<th>GRAND TOTAL SCORE</th><td><?php //echo $total; ?></td>-->
                                          <!--</tr>-->
                                          <tr>
                                          	<th>CLASS AVERAGE</th><td><?php echo $caverage; ?></td>
                                          </tr>
                                          <tr>
                                          	<th>POSITION</th><td><?php echo $position; ?></td>
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
                                  <?php if($term == 3): $url = "summary.php?session=$session&class=$class&class2=$class2&regno=$regno&school=$school";?>
                                    <a href="<?php echo $url; ?>" class="btn btn-outline-primary btn-sm" target="_blank">View Summary</a>
                                <?php endif; ?>
                                <!--<button>PRINT</button>-->
                              </div>
                      </div>
                      <!-- here-->
                      <?php else: ?>
                        <h2 class="text-center">Your result for this term is not ready yet, please check again later, thank you.</h2>
                      <?php endif; $db->close(); ?>
            </div>
        </div>
      </div>
    </div>
  </section>
  
   
 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/jq-3.3.1/dt-1.10.18/b-1.5.2/b-html5-1.5.2/b-print-1.5.2/datatables.min.js"></script>

  
  <script src="js/jquery-1.12.0.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  
  
  <script>
      $(function() {
    var header_height = 0;
    $('table th span').each(function() {
        if ($(this).outerWidth() > header_height) header_height = $(this).outerWidth();
    });

    $('table th').height(header_height);
});
  </script>
  
  <script>
      $(document).ready(function() {
        $('#example').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        } );
    } );
  </script>
  <?php include 'includes/footer.php'; ?>
  </body>
  </html>

  <?php else:
    $q->close();
    $db->close();
    $_SESSION['irp'] = 1;
    header("Location:result_check.php");
    exit;
  ?>

  <?php endif; ?>

<?php else:
  $url = $_SERVER['HTTP_REFERER'];
  header("Location:$url");
  exit;
?>

<?php endif; ?>
