<?php
	if(!isset($_SESSION["roleid"])){
		$_SESSION["roleid"] = $this->CURRENT_USER->RoleId;
		$_SESSION["userid"] = $this->eprint($this->CURRENT_USER->Id);
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-Frame-Options" content="deny">
		<base href="<?php $this->eprint($this->ROOT_URL); ?>" />
		<title><?php $this->eprint($this->title); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="description" content="FRANCHISE" />
		<meta name="author" content="phreeze builder | phreeze.com" />

		<!-- Le styles -->
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
		<link href="styles/style.css" rel="stylesheet" />
		<link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
		<link href="bootstrap/css/font-awesome.min.css" rel="stylesheet" />
		<!--[if IE 7]>
		<link rel="stylesheet" href="bootstrap/css/font-awesome-ie7.min.css">
		<![endif]-->
		<link href="bootstrap/css/datepicker.css" rel="stylesheet" />
		<link href="bootstrap/css/timepicker.css" rel="stylesheet" />
		<link href="bootstrap/css/bootstrap-combobox.css" rel="stylesheet" />
		
		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
			<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<!-- Le fav and touch icons -->
		<link rel="shortcut icon" href="images/favicon.ico" />
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/apple-touch-icon-114-precomposed.png" />
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/apple-touch-icon-72-precomposed.png" />
		<link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon-57-precomposed.png" />

		<script type="text/javascript" src="scripts/libs/LAB.min.js"></script>
		<script type="text/javascript">
			$LAB.script("bootstrap/jquery-1.9.1.min.js").wait()
				
				.script("bootstrap/js/bootstrap.min.js")
				.script("bootstrap/js/bootstrap-datepicker.js")
				.script("bootstrap/js/bootstrap-timepicker.js")
				.script("bootstrap/js/bootstrap-combobox.js")
				.script("scripts/libs/underscore-min.js").wait()
				.script("scripts/libs/underscore.date.min.js")
				.script("scripts/libs/backbone-min.js")
				.script("scripts/app.js")
				.script("scripts/model.js").wait()
				.script("scripts/view.js").wait()
		</script>

		 <link rel="icon" type="image/ico" href="favicon.ico"/>
    
    <link href="css/stylesheets.css" rel="stylesheet" type="text/css" />
    <link rel='stylesheet' type='text/css' href='css/fullcalendar.print.css' media='print' />
    
 	<!-- general css -->
   <link href="css/general.css" rel="stylesheet" />
    
	</head>

	<body>
			<div class="navbar navbar-inverse navbar-fixed-top">
				<div class="navbar-inner">
					<div class="container">
						<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</a>
						<a class="brand" href="./">FRANCHISE</a>
						<div class="nav-collapse collapse in">
							<?php if($this->CURRENT_USER->RoleId == 4 && $this->CURRENT_USER->RoleId != ""){?>
							<ul class="nav">
								<li <?php if ($this->nav=='accounts') { echo 'class="active"'; } ?>><a href="./accounts">Accounts</a></li>
								<li <?php if ($this->nav=='accountmonths') { echo 'class="active"'; } ?>><a href="./accountmonths">AccountMonths</a></li>
								<li <?php if ($this->nav=='accounttypes') { echo 'class="active"'; } ?>><a href="./accounttypes">AccountTypes</a></li>
								<li <?php if ($this->nav=='basefees') { echo 'class="active"'; } ?>><a href="./basefees">BaseFees</a></li>
							</ul>
							<ul class="nav">
								<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">More <b class="caret"></b></a>
								<ul class="dropdown-menu">
								<li <?php if ($this->nav=='companies') { echo 'class="active"'; } ?>><a href="./companies">Companies</a></li>
								<li <?php if ($this->nav=='customers') { echo 'class="active"'; } ?>><a href="./customers">Customers</a></li>
								<li <?php if ($this->nav=='leads') { echo 'class="active"'; } ?>><a href="./leads">Leads</a></li>
								<li <?php if ($this->nav=='posts') { echo 'class="active"'; } ?>><a href="./posts">Posts</a></li>
								<li <?php if ($this->nav=='receives') { echo 'class="active"'; } ?>><a href="./receives">Receives</a></li>
								<li <?php if ($this->nav=='schedules') { echo 'class="active"'; } ?>><a href="./schedules">Schedules</a></li>
								<li <?php if ($this->nav=='services') { echo 'class="active"'; } ?>><a href="./services">Services</a></li>
								<li <?php if ($this->nav=='states') { echo 'class="active"'; } ?>><a href="./states">States</a></li>
								<li <?php if ($this->nav=='supports') { echo 'class="active"'; } ?>><a href="./supports">Supports</a></li>
								<li <?php if ($this->nav=='users') { echo 'class="active"'; } ?>><a href="./users">Users</a></li>
								<li <?php if ($this->nav=='works') { echo 'class="active"'; } ?>><a href="./works">Works</a></li>
								</ul>
								</li>
							</ul>
							<?php }?>
							<?php  if ($this->CURRENT_USER) { ?>
							<ul class="nav pull-right">
								<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-lock"></i> Hello <?php $this->eprint($this->CURRENT_USER->FirstName); ?> <i class="caret"></i></a>
								<ul class="dropdown-menu">
									<li><a href="./logout">Logout</a></li>
									<li class="divider"></li>
									<li><a href="./secureuser">Example User Page <i class="icon-lock"></i></a></li>
									<li><a href="./secureadmin">Example Admin Page <i class="icon-lock"></i></a></li>
								</ul>
								</li>
							</ul>
							<?php } else { ?>
							<ul class="nav pull-right">
								<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-lock"></i> Login <i class="caret"></i></a>
								<ul class="dropdown-menu">
									<li><a href="./loginform">Login</a></li>
									<li class="divider"></li>
									<li><a href="./secureuser">Example User Page <i class="icon-lock"></i></a></li>
									<li><a href="./secureadmin">Example Admin Page <i class="icon-lock"></i></a></li>
								</ul>
								</li>
							</ul>
							<?php } ?>
						</div><!--/.nav-collapse -->
					</div>
				</div>
			</div>

			<div class="header">
    <h4 class="pull-right" style="color:white;margin-top: 9px;margin-right: 10px;"><?php echo $this->title;?></h4>
    <ul class="header_menu">
        <li class="list_icon">
            <a href="#">&nbsp;</a>
        </li>
    </ul>
</div><div class="menu">
    
    <div class="admin">
        <div class="image">
            <img src="img/users/aqvatarius.jpg" class="img-polaroid"/>
        </div>
        <ul class="control">
            <li>
                <span class="icon-cog"></span><a href="forms.php">Settings</a>
            </li>
            <li>
                <span class="icon-share-alt"></span><a href="login.php">Logout</a>
            </li>
        </ul>
        <div class="info">
            <span>Welcom back! Your last visit: 24.10.2012 in 19:55</span>
        </div>
    </div>

    <ul class="navigation">
        <li class="openable">
			<a href="#"> <span class="isw-grid"></span><span class="text">Information</span></a>
            <ul>
                <li>
                    <a href="/franchise2/"> <span class="icon-th"></span><span class="text">View</span> </a>
                </li>
                <li>
                    <a href="editinformation.php"> <span class="icon-th-large"></span><span class="text">Edit</span> </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="workneed.php"> <span class="isw-grid"></span><span class="text">Work needs</span></a>
        </li>
        <li class="openable">
            <a href="#"> <span class="isw-list"></span><span class="text">Lead</span> </a>
            <ul>
				<li>
                    <a href="receive.php"> <span class="icon-th"></span><span class="text">Receive</span> </a>
                </li>
                <li>
                    <a href="/franchise2/addleads"> <span class="icon-th"></span><span class="text">Add</span> </a>
                </li>
                <li>
                    <a href="/franchise2/leads"> <span class="icon-th-large"></span><span class="text">List</span> </a>
                </li>
            </ul>
        </li>
		<li>
            <a href="workmanager.php"> <span class="isw-grid"></span><span class="text">Work manager</span></a>
        </li>
        <li>
            <a href="statisticmonth.php"> <span class="isw-graph"></span><span class="text">Statistics</span> </a>
        </li>
        <li>
            <a href="report.php"> <span class="isw-text_document"></span><span class="text">Report</span> </a>
        </li>
        <li class="openable">
            <a href="#"> <span class="isw-list"></span><span class="text">Customer</span> </a>
            <ul>
                <li>
                    <a href="addcustomer.php"> <span class="icon-th"></span><span class="text">Add</span> </a>
                </li>
                <li>
                    <a href="editcustomer.php"> <span class="icon-th-large"></span><span class="text">List</span> </a>
                </li>
            </ul>
        </li>		
    </ul>
    <div class="dr">
        <span></span>
    </div>
    <div class="widget-fluid">
        <div id="menuDatepicker"></div>
    </div>
    <div class="dr">
        <span></span>
    </div>
</div>
<div class="content">
