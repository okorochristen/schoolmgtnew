<?php session_start(); ?>

<?php if ( (isset($_SESSION['login']) ) && ( strlen($_SESSION['login']) > 0) ):
  include 'includes/db.php';
  $q = $db->prepare('SELECT subject from subjects');
?>
<link rel="shortcut icon" href="school.png" type="image/png">
<body class="bglight">
<div id="preloader">
    <div id="status">&nbsp;</div>
</div>
  <section id="slider" class="fullheight" style="background-image:url('images/bg1b.jpg'); height:100px">
          <div class="overlay dark-6"><!-- dark overlay [0 to 9 opacity] --></div>
          <div class="display-table">
            <div class="display-table-cell vertical-align-middle">
              <div class="container-fluid">
                <div class="row">
                  <div class="text-center col-md-12 col-xs-12">
                    <h1 class="bold font-raleway cwhite mt20"></h1>
                    <h2 class="bold font-raleway wow fadeInUp" data-wow-delay="0.90s"><p style="color:pink;margin: 0px;">ST PHILIPS ACCADEMY</p></h2>
                  </div>
                </div>
              </div>
            </div>
          </div>
  </section>
        <!-- /SLIDER -
<!-- SECTION IMAGE -->
<section class="bglight  borderbottom relative">
  <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="row">
  <div class="container cus-pos-abs">
    <div class="cover-center-text col-sm-12 col-md-12">
                <form method="get" action="#">
                <div class="container">
                    <div class="col-md-12 mt30 text-center">
                        <label for="reg_number" class="size40 cblue">Select Subject and Enter Score </label>
                    </div>
                    <div class="col-md-12">
                        <input type="text" class="form-control formlarge mt10" placeholder="Enter Student Name" name="student">
                    </div>
                    <div class="col-md-12 form-group mt20">
                        <select class="form-control formlarge" name="add_result">
                            <option>Select Subject</option>
                            <option value="">English Language</option>              <option value="">Mathematics</option>
                            <option value="">Physics</option>                       <option value="">Chemistry</option>
                            <option value="">Biology</option>                       <option value="">Literature in English</option>
                            <option value="">History</option>                       <option value="">Geography</option>
                            <option value="">Agricultural Science</option>          <option value="">Further Mathematics</option>
                            <option value="">Commerce</option>                      <option value="">Economics</option>
                            <option value="">Christian Religious Knowledge</option> <option value="">Government</option>
                            <option value="">Visual Art</option>                    <option value="">Computer Science</option>
                            <option value="">French</option>                        <option value="">Tie and Die</option>
                            <option value="">Civic Education</option>               <option value="">Animal Husbandary</option>
                            <option value="">Technical Drawing</option>             <option value="">Hausa</option>
                            <option value="">Creative Art</option>                  <option value="">Practical Agric</option>
                            <option value="">Physical Education</option>            <option value="">Basic Science</option>
                            <option value="">Introductory Technology</option>       <option value="">Business Studies</option>
                            <option value="">Social Studies</option>
                        </select>
                    </div>
                    <div class="col-md-3 mt20">
                        <input type="number" class="form-control formlarge" name="" placeholder="Assignment 1">
                    </div>
                    <div class="col-md-3 mt20">
                        <input type="number" class="form-control formlarge" name="" placeholder="Assignment 2">
                    </div>
                    <div class="col-md-3 mt20">
                        <input type="number" class="form-control formlarge" name="" placeholder="Test 1">
                    </div>
                    <div class="col-md-3 mt20">
                        <input type="number" class="form-control formlarge" name="" placeholder="Test 2">
                    </div>
                    <div class="col-md-4 mt20">
                        <input type="number" class="form-control formlarge" name="" placeholder="Exams Score">
                    </div>
                    <div class="col-md-4 mt20">
                        <input type="number" class="form-control formlarge" name="" placeholder="Total Score">
                    </div>
                    <div class="col-md-4 mt20">
                        <input type="number" class="form-control formlarge" name="" placeholder="Class Average">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary size20 form-control formlarge mt20 col-md-4">Add Scores</button>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success size20 form-control formlarge mt20 col-md-4">Submit Result</button>
                    </div>
                    </div>
            </form>
            </div>
    </div>
  </div>
    </div>
</section>
<?php include 'footer.php';?>

</body>
</html>

<?php else:
  header('Location:logout.php');
  exit;
?>

<?php endif; ?>
