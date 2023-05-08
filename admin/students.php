<?php
    include $_SERVER['DOCUMENT_ROOT'].'/dbmid/model/chklogin/index.php';
    if($admin_id==0){
        header("Location: /dbmid/login");
        exit();
    }
    $admin_account=$account;
?>


<?php
	// Database connection details
	$host = "localhost";
	$username = "hj";
	$password = "test1234";
	$dbname = "dbmid";

	// Connect to database
	$conn = mysqli_connect($host, $username, $password, $dbname);

	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	
	// Build SQL query based on filters
	$sql = "
		SELECT `student`.* ,`account`.`account` ,`department`.`department_id`,`department`.`department_name`,`class`.`class_name`
		FROM `student` 
		LEFT JOIN `account` ON `student`.`account_id`=`account`.`account_id` 
		LEFT JOIN `class` ON `student`.`class_id`=`class`.`class_id`
		LEFT JOIN `department` on `class`.`department_id`=`department`.`department_id`
		WHERE `student`.`class_id` = ".$_GET["class_id"].";
	";

	// Execute query and get results
	$result = mysqli_query($conn, $sql);

    $student_id=[];
    $name=[];
    $class_id=[];
    $account_id=[];
    $credit_min=[];
    $credit_max=[];
    
    $account=[];

	$department_id=[];
	$department_name=[];
	$class_name=[];

	while($row = mysqli_fetch_array($result)){

        array_push($student_id, $row['student_id']);
        array_push($name, $row['name']);
        array_push($class_id, $row['class_id']);
        array_push($account_id, $row['account_id']);
        array_push($credit_min, $row['credit_min']);
        array_push($credit_max, $row['credit_max']);   
                    
        array_push($account, $row['account']);   

		array_push($department_id, $row['department_id']);
		array_push($department_name, $row['department_name']);
		array_push($class_name, $row['class_name']);
		
	}


	// continue

	



	mysqli_close($conn);
?>


<html>
  <head>

		<title>逢甲選課系統</title>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	
		<!--jQuery~-->
		<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
		<!--~jQuery-->

		<!--bootstrap~-->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
		<!--~bootstrap-->

		<!--fontawesome-->
		<script src="https://kit.fontawesome.com/4f410a4634.js" crossorigin="anonymous"></script>
		<link href="https://kit-free.fontawesome.com/releases/latest/css/free-v4-shims.min.css" media="all" rel="stylesheet">
		<link href="https://kit-free.fontawesome.com/releases/latest/css/free-v4-font-face.min.css" media="all" rel="stylesheet">
		<link href="https://kit-free.fontawesome.com/releases/latest/css/free.min.css" media="all" rel="stylesheet">
		<!--fontawesome-->
	
		<link href="/dbmid/main.css" rel="stylesheet" type="text/css" />
		<script src="/dbmid/main.js">
		</script>
	
		<link href="main.css" rel="stylesheet" type="text/css" />
		<script src="main.js">
		</script>

		<link rel="stylesheet/scss" type="text/css" href="/bubble.scss" />
		<link href="/dbmid/bubble.css" rel="stylesheet" type="text/css" />
		<script src="/dbmid/course.js"></script>

		

  </head>
  <body class="">
        <?php
			include $_SERVER['DOCUMENT_ROOT'].'/dbmid/model/preloader/index.php';
		?>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		  <div class="container-fluid">

				<button class="navbar-toggler hidden">
		      <span class="navbar-toggler-icon"></span>
		    </button>

				<a class="navbar-brand py-0" href="#">
					<img src="/dbmid/asset/fculogo.svg" class="img-fluid navbar-logo py-1">
				</a>
				
		    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		    </button>
				
		    <div class="collapse navbar-collapse" id="navbarToggler">
		      <ul class="navbar-nav me-auto mb-0 mb-lg-0">
			  	<li class="nav-item">
                    <a class="nav-link postloader active" aria-current="page" href="/dbmid/admin">學生檢索</a>
		        </li>
				<li class="nav-item">
                    <a class="nav-link postloader" aria-current="page" href="/dbmid/admin/course_index.php">課程檢索</a>
		        </li>
				<li class="nav-item">
                    <a class="nav-link postloader" aria-current="page" href="/dbmid/admin/course_search.php">學生選課</a>
		        </li>	
				
		      </ul>
			  <ul class="d-flex justify-content-end m-0">
			  	<li class="nav-item d-flex align-items-center">
				  <p class="m-0 font-white pe-3"><?php echo "admin_".$admin_id." ".$admin_account;?></p>
		        </li>
				<li class="nav-item">
					<form class="d-flex m-0" action="/dbmid/login/logout.php">			
						<button class="btn btn-outline-danger" type="submit">logout</button>
					</form>
		        </li>
			  
			  </ul>
		    </div>

			

		  </div>
		</nav>


        <div class="container">

			<div class="my-3">
				<span>
					<a href="/dbmid/admin/">
						/所有科系
					</a>
					<a
						<?php
							echo "href='/dbmid/admin/classes.php?department_id=".$department_id[0]."'";
						?>
					>
						<?php
							echo "/".$department_name[0]."系";
						?>
					</a>
					<a
						<?php
							echo "href='/dbmid/admin/students.php?class_id=".$class_id[0]."'";
						?>
					>
						<?php
							echo "/".$class_name[0].">";
						?>
					</a>
				</span>
			</div>

            <?php
                for($i=0;$i<count($class_id);$i++){                    
            ?>
                    
                    <a
                        <?php
                            echo "href='/dbmid/admin/course.php?student_id=".$student_id[$i]."'";
                        ?>
                    >
                        <?php
                            echo $account[$i]." ".$name[$i];
                        ?>
                    </a>
                    <br>

            <?php
                }
            ?>
            

        </div>


		

		
		
		<script src="/dbmid/preLoaderClose.js" ></script>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.1/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
		<!--~bootstrap-->
		
  </body>
</html>