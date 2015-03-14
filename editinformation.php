﻿<!DOCTYPE html>
<html lang="en">
<head>        
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <title>Franchise</title>
    <link rel="icon" type="image/ico" href="favicon.ico"/>
    
    <link href="css/stylesheets.css" rel="stylesheet" type="text/css" />
    <link rel='stylesheet' type='text/css' href='css/fullcalendar.print.css' media='print' />
    
    <script type='text/javascript' src='js/jquery.min.js'></script>
    <script type='text/javascript' src='js/jquery-ui.min.js'></script>
    <script type='text/javascript' src='js/plugins/jquery/jquery.mousewheel.min.js'></script>
    <script type='text/javascript' src='js/plugins/cookie/jquery.cookies.2.2.0.min.js'></script>
    <script type='text/javascript' src='js/plugins/bootstrap.min.js'></script>
    <script type='text/javascript' src='js/plugins/charts/excanvas.min.js'></script>
    <script type='text/javascript' src='js/plugins/charts/jquery.flot.js'></script>    
    <script type='text/javascript' src='js/plugins/charts/jquery.flot.stack.js'></script>    
    <script type='text/javascript' src='js/plugins/charts/jquery.flot.pie.js'></script>
    <script type='text/javascript' src='js/plugins/charts/jquery.flot.resize.js'></script>
    <script type='text/javascript' src='js/plugins/sparklines/jquery.sparkline.min.js'></script>
    <script type='text/javascript' src='js/plugins/fullcalendar/fullcalendar.min.js'></script>
    <script type='text/javascript' src='js/plugins/select2/select2.min.js'></script>
    <script type='text/javascript' src='js/plugins/uniform/uniform.js'></script>
    <script type='text/javascript' src='js/plugins/maskedinput/jquery.maskedinput-1.3.min.js'></script>
    <script type='text/javascript' src='js/plugins/validation/languages/jquery.validationEngine-en.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/validation/jquery.validationEngine.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js'></script>
    <script type='text/javascript' src='js/plugins/animatedprogressbar/animated_progressbar.js'></script>
    <script type='text/javascript' src='js/plugins/qtip/jquery.qtip-1.0.0-rc3.min.js'></script>
    <script type='text/javascript' src='js/plugins/cleditor/jquery.cleditor.js'></script>
    <script type='text/javascript' src='js/plugins/dataTables/jquery.dataTables.min.js'></script>    
    <script type='text/javascript' src='js/plugins/fancybox/jquery.fancybox.pack.js'></script>
    <script type='text/javascript' src='js/cookies.js'></script>
    <script type='text/javascript' src='js/actions.js'></script>
    <script type='text/javascript' src='js/charts.js'></script>
    <script type='text/javascript' src='js/plugins.js'></script>
    
</head>
<body>
    <div class="header">
    <h4 style="color:white;margin-top: 9px;margin-left: 10px;">Franchise</h4>
    <ul class="header_menu">
        <li class="list_icon">
            <a href="#">&nbsp;</a>
        </li>
    </ul>
</div><div class="menu">
    <div class="breadLine">
        <div class="arrow"></div>
        <div class="adminControl active">
            Hi, Jim's Online
        </div>
    </div>
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
                    <a href="addinformation.php"> <span class="icon-th"></span><span class="text">View</span> </a>
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
                    <a href="addpick.php"> <span class="icon-th"></span><span class="text">Add</span> </a>
                </li>
                <li>
                    <a href="statistic.php"> <span class="icon-th-large"></span><span class="text">List</span> </a>
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
		<li class="openable">
            <a href="#"> <span class="isw-list"></span><span class="text">User</span> </a>
            <ul>
                <li>
                    <a href="adduser.php"> <span class="icon-th"></span><span class="text">Add</span> </a>
                </li>
                <li>
                    <a href="listuser.php"> <span class="icon-th-large"></span><span class="text">List</span> </a>
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
</div><div class="content">
    <div class="breadLine">
        <ul class="breadcrumb">
            <li>
                <a href="#">Simple Admin</a><span class="divider">></span>
            </li>
            <li class="active">
                Forms stuff
            </li>
        </ul>
    </div>
    <div class="workplace">
        <div class="row-fluid">
            <div class="span6">
                <div class="head">
                    <div class="isw-documents"></div>
                    <h1>Your Franchise</h1>
                    <div class="clear"></div>
                </div>
                <div class="block-fluid">
                    <div class="row-form">
                        <div class="span3">
                            Code
                        </div>
                        <div class="span9">
                            <input type="text" class="form-control">
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="row-form">
                        <div class="span3">
                            Territory
                        </div>
                        <div class="span9">
                            <input type="text" class="form-control">
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="row-form">
                        <div class="span3">
                            Region
                        </div>
                        <div class="span9">
                            <input type="text" class="form-control">
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="row-form">
                        <div class="span3">
                            Started
                        </div>
                        <div class="span9">
                            21-02-2015
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="row-form">
                        <div class="span3">
                            Status
                        </div>
                        <div class="span9">
                            OK
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="head">
                    <div class="isw-documents"></div>
                    <h1>Your Details</h1>
                    <div class="clear"></div>
                </div>
                <div class="block-fluid">
                    <div class="row-form">
                        <div class="span3">
                            Name
                        </div>
                        <div class="span9">
                            <input type="text" class="form-control">
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="row-form">
                        <div class="span3">
                            Mobile
                        </div>
                        <div class="span9">
                            <input type="text" class="form-control">
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="row-form">
                        <div class="span3">
                            Email
                        </div>
                        <div class="span9">
                            <input type="text" class="form-control">
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="row-form">
                        <div class="span3">
                            Address
                        </div>
                        <div class="span9">
                            <input type="text" class="form-control">
                        </div>
                        <div class="clear"></div>
                    </div>
					<div class="row-form">
                        <div class="span3"></div>
                        <div class="span9">
                            <a href="statistic.php"><button class="btn" type="button">Update</button></a>
                            <button class="btn btn-warning" type="button">Clear</button>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dr">
            <span></span>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="head">
                    <div class="isw-documents"></div>
                    <h1>Contacts at Jim</h1>
                    <div class="clear"></div>
                </div>
                <div class="block-fluid">
                    <div class="row-form">
                        <div class="span3">
                            Franchisor
                        </div>
                        <div class="span9">
                            Martin McAulife - 0418 552 535 <br>
                            marty@jimcleaning.net.au
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="row-form">
                        <div class="span3">
                            Divisonal
                        </div>
                        <div class="span9">
                            Haydar Hussein - 0418 370 364 <br>
                            haydar@jimcleaning.net.au
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="row-form">
                        <div class="span3">
                            Admin centre
                        </div>
                        <div class="span9">
                            Melbourne - (03) 9780 9876
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="row-form">
                        <div class="span3">
                            National
                        </div>
                        <div class="span9">
                            39 Fisher St 3012 VIC
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="row-form">
                        <div class="span3">
                            Jim
                        </div>
                        <div class="span9">
                            jim@jim.net
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dr">
            <span></span>
        </div>
    </div>
</div>
</body>
</html>