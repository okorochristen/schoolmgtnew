<?php session_start(); ?>

<?php if ( (isset($_SESSION['admin'])) && ($_SESSION['admin'] == 'wahdoyouknow') ):
  include 'includes/header.php';
  
  include 'includes/config.php';

  if ( (!(isset($_GET['status']))) || (empty($_GET['status'])) ) {
    $status = 'pending';
  }
  else {
    $status = $_GET['status'];
  }

  $q = $db->prepare("SELECT regno, fname, gender, dob, religion, state, lga, nationality, class_app, address, parent, parent_num, passport  from students where status = ? ");
  $q->bind_param('s', $status);
  $q->execute();
  $q->store_result();
  $n = $q->num_rows;
?>
<body class="bglight bgwhite">

<div class="container sspacing">
  <div class="col-md-12">
    <div class="btn-group  pull-right">
     <a href="applicants-list.php?status=pending" class="btn btn-default <?php if($status == "pending"){echo 'active';} ?>">Pending</a>
     <a href="applicants-list.php?status=accepted" class="btn btn-default <?php if($status == "accepted"){echo 'active';} ?>">Accepted</a>
     <a href="applicants-list.php?status=declined" class="btn btn-default <?php if($status == "declined"){echo 'active';} ?>">Declined</a>
    </div>
    <?php if ($n > 0):
      $q->bind_result($regno, $fname, $gender, $dob, $religion, $state, $lga, $nationality, $class_app, $address, $parent, $parent_num, $passport);
    ?>
    <?php if ($status == 'pending'): ?>
      <script type="text/javascript" src="js/accdec.js"></script>
    <?php endif; ?>
      <h3>List of <?php echo $status; ?> Applicants</h3>
      <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th></th>
          <th>REG NO.</th>
          <th>NAME</th>
          <th></th>
          <?php if ($status == 'pending'): ?>
            <th></th>
            <th></th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php while($q->fetch()): ?>
          <tr>
            <td><img src="applicants/<?php echo $passport; ?>" alt="<?php echo $sur_name; ?>" class="img-responsive" style="max-height:50px;"></td>
            <td><?php echo $regno; ?></td>
            <td><?php echo $fname." ".$gender." ".$class_app; ?></td>
            <td><a href="#<?php echo $reg_no; ?>" class="btn btn-link" data-toggle="collapse">view</a></td>
            <?php if ($status == 'pending'): ?>
              <td><a href="#" class="btn btn-primary" onclick="acstudent(<?php echo "'".$fname." ".$gender." ".$class_app."','".$regno."'"; ?>)">Accept</a></td>
              <td><a href="#" class="btn btn-danger" onclick="dcstudent(<?php echo "'".$fname." ".$gender." ".$class_app."','".$regno."'"; ?>)">Decline</a></td>
            <?php endif; ?>
          </tr>
          <tr id="<?php echo $reg_no; ?>" class="collapse">
            <td colspan="6">
              <p><b>Date of birth: </b><u><?php echo $dob; ?></u> </p>
              <p><b>Present school: </b><?php echo $present_school; ?> </p>
              <p><b>Address of school: </b> <u><?php echo $present_school_address; ?></u> </p>
              <p><b>How long have ou been at this: </b> <u><?php echo $duration; ?></u></p>
              <p><b>Other schools attended: </b> <u><?php echo $other_school; ?></u></p>
              <p><b>Present class: </b> <u><?php echo $present_class; ?></u></p>
              <p><b>Religion: </b> <u><?php echo $religion; ?></u></p>
              <p><b>Name of parent/guardian: </b> <u><?php echo $guardian; ?></u></p>
              <p><b>Occupation of parent/guardian: </b> <u><?php echo $occupation; ?></u></p>
              <p><b>Fathers tribe: </b> <u><?php echo $fathers_tribe; ?></u> &nbsp&nbsp&nbsp&nbsp&nbsp<b>Mothers tribe: </b> <u><?php echo $mothers_tribe; ?></u></p>
              <p><b>Fathers State of origin: </b> <u><?php echo $state_of_origin; ?></u> &nbsp&nbsp&nbsp&nbsp&nbsp<b>L.G.C of father: </b> <u><?php echo $lga; ?></u></p>
              <p><b>Who will pay College fees: </b> <u><?php echo $who_will_pay_fees; ?></u></p>
              <p><b>Address: </b> <u><?php echo $address; ?></u></p>
              <p><b>Phone: </b> <u><?php echo $phone; ?></u></p>
            </td>
          </tr>

        <?php endwhile ?>

        <?php $q->free_result(); ?>
      </tbody>
    </table>

    <?php else: ?>

      <h2>There are no <?php echo $status; ?> applicants at this time</h2>
      <div class=""></div>

    <?php endif; $q->close(); $db->close();?>

  </div>
</div>
<?php include 'futa.php'; ?>
</body>
</html>
<?php else:
  session_destroy();
  header('Location:login.php');
  exit;
?>

<?php endif; ?>
