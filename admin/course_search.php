<?php
    include $_SERVER['DOCUMENT_ROOT'].'/dbmid/model/chklogin/index.php';
    if($admin_id==0){
        header("Location: /dbmid/login");
        exit();
    }
    $admin_account=$account;
?>

<?php


	$student_id=0;
	if(isset($_POST['student_account'])){
		
		$student_account=$_POST['student_account'];
	
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
	
		$week2cn["星期"]=0;
		$week2cn["Mon"]="一";
		$week2cn["Tue"]="二";
		$week2cn["Wed"]="三";
		$week2cn["Thu"]="四";
		$week2cn["Fri"]="五";

		$week=$week2cn[$_POST['week']];


		$time2num["節"]=0;
		$time2num["1th"]=1;
		$time2num["2th"]=2;
		$time2num["3th"]=3;
		$time2num["4th"]=4;
		$time2num["5th"]=5;
		$time2num["6th"]=6;
		$time2num["7th"]=7;
		$time2num["8th"]=8;
		$time2num["9th"]=9;
		$time2num["10th"]=10;
		$time2num["11th"]=11;
		$time2num["12th"]=12;
		$time2num["13th"]=13;

		$time=$time2num[$_POST['time']];

		// echo $week."<br>";
		// echo $time."<br>";


		$student_id=0;
		$sql = "
			SELECT `student` .* ,`account`.`account`
			FROM `student` 
			LEFT JOIN `account` ON `student`.`account_id`=`account`.`account_id`
			WHERE `account`.`account`='".$student_account."';
		";
		$result = mysqli_query($conn, $sql);
		while($row = mysqli_fetch_array($result)){

			$student_id=$row['student_id'];
						
		}


		
		// Build SQL query based on filters
		$sql = "
			SELECT * 
			FROM `section_detail` 
			LEFT JOIN (
			
				SELECT * 
				FROM `section`
				WHERE `section`.`section_id` NOT IN(
			
					SELECT DISTINCT sd.section_id 
					FROM section_detail sd 
					WHERE EXISTS ( 
						SELECT 1 FROM section_detail sd1 
						JOIN section_student ss ON sd1.section_id = ss.section_id 
						WHERE ss.student_id = ".$student_id." AND ss.is_valid = 1 AND ( 
							(sd1.week = sd.week AND 
							sd1.time_start <= sd.time_start AND 
							sd.time_start <= sd1.time_end) OR (
							sd1.week = sd.week AND 
							sd1.time_start <= sd.time_end AND 
							sd.time_end <= sd1.time_end) 
						) 
					)
			
				) 
				
			) AS valid ON `section_detail`.`section_id`=valid.`section_id`
			LEFT JOIN `course` ON valid.course_id=`course`.`course_id`
			LEFT JOIN `class` ON valid.class_id=`class`.`class_id`
			LEFT JOIN `department` ON `class`.`department_id`=`department`.`department_id`
			WHERE valid.`section_id` IS NOT NULL 
			AND `course`.`course_id` IS NOT NULL
			AND `department`.`department_id`=57
			
		";
		
		
		
		
		
		// if($week=="一" || $week=="二" || $week=="三" || $week=="四" || $week=="五" ){
		// 	$sql.=" AND `section_detail`.`week`='".$week."'";
		// 	echo "test<br>";
		// }



		// if($time>=1 && $time<=13){
		// 	$sql.="  AND (`section_detail`.`time_start`<=$time) OR (`section_detail`.`time_end`>=$time)";
		// 	echo "test2<br>";
		// }


		// Execute query and get results
		$result = mysqli_query($conn, $sql);


		$section_id=[];
		$quota=[];
		$quota_max=[];
		$course_name=[];
		$credit=[];
		$isRequired=[];
		$class_id=[];
		$class_name=[];
		$department_name=[];

		while($row = mysqli_fetch_array($result)){

			array_push($section_id, $row['section_id']);
			array_push($quota, $row['quota']);
			array_push($quota_max, $row['quota_max']);
			array_push($course_name, $row['course_name']);
			array_push($credit, $row['credit']);
			array_push($isRequired, $row['isRequired']);
			array_push($class_id, $row['class_id']);
			array_push($class_name, $row['class_name']);
			array_push($department_name, $row['department_name']);
						
			
		}

	}

	// continue

	



	
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
                    <a class="nav-link postloader" aria-current="page" href="/dbmid/admin">學生檢索</a>
		        </li>
				<li class="nav-item">
                    <a class="nav-link postloader" aria-current="page" href="/dbmid/admin/course_index.php">課程檢索</a>
		        </li>
				<li class="nav-item">
                    <a class="nav-link postloader active" aria-current="page" href="/dbmid/admin/course_search.php">學生選課</a>
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

		<div class="bg-primary py-3 py-md-4 py-md-5 mb-3">
			<div class="container">
				<div class="d-flex justify-content-center w-100  ">
					<form method="post" class="col-12 col-md-10 col-lg-8 bingShadow bg-white rounded-30 px-3" for="searchBox" action="/dbmid/admin/course_search.php">

						<div class="col">
							<div class="row">
								<input class="img-fluid col-auto" type="image" src="/dbmid/asset/search.svg" alt="Submit">
								<!-- <img src="/dbmid/asset/search.svg" class="img-fluid col-auto"> -->
								<div class="col px-0">
									<input name="student_account" type="text" class="col-12 h-100 border-0 py-3" id="searchBox" placeholder="學生帳號"
										<?php
											if(isset($_POST['student_account'])){
												echo "value='".$student_account."'";
											}
										?>
									>
								</div>
								
								<div class="col-auto px-0 rounded-30 py-1">
									<a class="btn btn-primary h-100 w-100 d-flex align-items-center rounded-30 px-3" data-bs-toggle="collapse" href="#filter" role="button" aria-expanded="false" aria-controls="filter">
										<i class="fa-solid fa-filter"></i>
									</a>
								</div>
								
								
							</div>
						</div>


						<div class="collapse pb-2 rounded-30" id="filter">
							<div class="col rounded-30">
								<div class="row rounded-30">
									
									<div class="col-12 mb-2">
										<div class="col">
											<div class="row">
												<div class="col-6">
													<select name="week" class="col-auto form-control py-1 px-2">
														<option>星期</option>
														<option>Mon</option>
														<option>Tue</option>
														<option>Wed</option>
														<option>Thu</option>
														<option>Fri</option>
													</select>
												</div>
												<div class="col-6">
													<select name="time" class="col-auto form-control py-1 px-2">
														<option>節</option>
														<option>1th</option>
														<option>2th</option>
														<option>3th</option>
														<option>4th</option>
														<option>5th</option>
														<option>6th</option>
														<option>7th</option>
														<option>8th</option>
														<option>9th</option>
														<option>10th</option>
														<option>11th</option>
														<option>12th</option>
														<option>13th</option>
													</select>
												</div>
											</div>
										</div>
										
									</div>
									
								</div>

								

								

							</div>
						</div>
					</form>
				</div>
		
			</div>
			
		</div>
		
		<div class="container">



			<div class="col">

				<?php
					if(!isset($_POST['student_account'])){
						
					}else if($student_id==0){
						echo "<script language='javascript'>alert('查無學生');</script>";
					}else{

					
						for($i=0;$i<count($section_id);$i++){
				?>
							<div class="row">

								<div class="col-auto">
									<?php echo "課程代碼:".$section_id[$i]." ";?>
								</div>

								<div class="col">
									<?php echo "課程名稱:".$course_name[$i]." ";?>
								</div>

								<div class="col-auto">
									<?php echo "學分:".$credit[$i]." ";?>
								</div>

								<div class="col-auto">
									<?php 
										if($isRequired[$i]==1){
											echo "必修 ";
										}else{
											echo "選修 ";
										}
									?>
								</div>

								<div class="col">
									<?php echo $class_name[$i]." ";?>
								</div>

								

								<div class="col">
									<?php echo "人數:".$quota[$i]."/".$quota_max[$i];?>
								</div>

								<div class="col">
									

										<?php

											// Build SQL query based on filters
											$sql = "
												SELECT * FROM `section_detail` WHERE `section_id` = ".$section_id[$i].";
											";
											

											// Execute query and get results
											$result = mysqli_query($conn, $sql);

											$week=[];	
											$time_start=[];	
											$time_end=[];	
											$location=[];	


											while($row = mysqli_fetch_array($result)){

												// array_push($week, $row['week']);
												// array_push($time_start, $row['time_start']);
												// array_push($time_end, $row['time_end']);
												// array_push($location, $row['location']);
												
												echo "(".$row['week'].")";
												echo $row['time_start']."~";
												echo $row['time_end'].",";
												echo $row['location']."<br>";

											}

											// for($i=0;$i<count($week);$i++){
											// 	echo $week[$i]."";
											// 	echo $time_start[$i]."";
											// 	echo $time_end[$i]."";
											// 	echo $location[$i]."<br>";
											// }

										?>


								</div>




								<div class="col-auto">
									<a 
										<?php
											echo "href='/dbmid/admin/course_add_student.php?section_id=".$section_id[$i]."&student_id=".$student_id."&isRequired=".$isRequired[$i]."'";
										?>
									>加選</a>
								</div>

								

							
							
							
							</div>
							<hr>

				<?php
						}
					}
				?>



				

					

				

			</div>




			
			
		</div>
		
		
		
		<script src="/dbmid/preLoaderClose.js" ></script>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.1/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
		<!--~bootstrap-->
		
  </body>
</html>


<?php
	if($student_id!=0){
		mysqli_close($conn);
	}
	
?>