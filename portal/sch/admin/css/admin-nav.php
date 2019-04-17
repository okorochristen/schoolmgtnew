<?php include'head.php'; ?>
<style>
    .navbar-default{
        height: 100px;
        padding: 20px;
        background-color: aquamarine
    }
</style>
<div class="navbar navbar-default" role="navigation">
	<div class="container-fluid relative">

		<button type="button" class="btn left hide-show-button none">
		    <span class="burgerbar"></span>
		    <span class="burgerbar"></span>
		    <span class="burgerbar"></span>
		</button>
		<a href="#" class="closemenu"></a>

		<!-- mobile version drop menu -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle hamburger" data-toggle="collapse" data-target=".navbar-collapse">
			  <span class="sr-only">Toggle navigation</span>
			  <span class="icon-bar"></span>
			  <span class="icon-bar"></span>
			  <span class="icon-bar"></span>
			</button>
		</div>

		<!-- menu -->
		<div class="mainmenu mobanim dark-menu navbar-collapse collapse offset-0 ">
			<ul class="nav navbar-nav mobpad size30" id="navigation">
				<li>
				  <a href="admin-home.php">HOME </a>
				</li>
				<li><a href="applicants-list.php">APPLICANTS</a></li>
                <li><a href="student-list.php">STUDENTS</a></li>
				<li><a href="staff-list.php">STAFF</a></li>
				<li><a href="pass.php">EDIT PROFILE</a></li>
				<li><a href="logout.php">LOGOUT</a></li>
			</ul>
		</div>

	</div>
</div>
