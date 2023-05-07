<?php
    include $_SERVER['DOCUMENT_ROOT'].'/dbmid/model/chklogin/index.php';
	if($admin_id!=0){
        header("Location: /dbmid/admin");
        exit();
    }
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

						// Define variables for filters
						$search_query = $department = $week = $time = $scode = $namecourse = "";
						
						$sql = "
								SELECT `student`.*, `class`.*,`account`.*
								FROM `account`
									, `student`
									, `class`
								WHERE `account`.`account_id` = `student`.`account_id` AND `class`.`class_id` = `student`.`class_id` AND `account`.`account_id`='$account_id';
							";


							
							 
							 $result2 = mysqli_query($conn, $sql);
							 while ($row2 = mysqli_fetch_array($result2)) {


									$name = $row2['name'];
									$account = $row2['account'];
									$class_name = $row2['class_name'];

								}
						
						
						
						// Handle form submission
						if ($_SERVER["REQUEST_METHOD"] == "POST") {
							// Get filter values from form
							$search_query=($_POST["search_query"]);
							
							
							$department =($_POST["department"]);
							$week =($_POST["week"]);
							$time =($_POST["time"]);
							if(isset($_POST['is_exclude'])){
								$is_exclude=($_POST["is_exclude"]);
							}
							
							if($department=="科系"){
								$department="";
							}
							if($week=="星期"){
								$week="";
							}
							else if($week=="Mon")
							{
								$week="一";
							}
							else if($week=="Tue")
							{
								$week="二" ;
							}
							else if($week=="Wed")
							{
								$week="三" ;
							}
							else if($week=="Thu")
							{
								$week="四" ;
							}
							else if($week=="Fri")
							{
								$week="五" ;
							}
							if($time=="節"){
								$time="";
							}
							
							// Build SQL query based on filters
							if (!empty($search_query)) {
								$query = "SELECT week, time_start, time_end, course_id, course_name, quota, quota_max, year, semester, note, isRequired, credit, name, class_name, class_id, department_name, GROUP_CONCAT(DISTINCT times ORDER BY times SEPARATOR 'o\n') AS times, GROUP_CONCAT(DISTINCT locations ORDER BY locations SEPARATOR 'o\n') AS locations
											FROM 
											( SELECT c.course_id, c.course_name, s.quota, s.quota_max, s.year, s.semester, s.note, c.isRequired, c.credit, t.name, cl.class_name,cl.class_id,sd.location,sd.week,sd.time_start,sd.time_end,d.department_name, CONCAT('周',sd.week, ' ', sd.time_start, '-', sd.time_end, '節') AS times,CONCAT(sd.location) AS locations
											 FROM course c 
											 JOIN section s ON c.course_id = s.course_id 
											 JOIN section_detail sd ON s.section_id = sd.section_id 
											 JOIN teacher t ON sd.teacher_id = t.teacher_id 
											 JOIN class cl ON s.class_id=cl.class_id 
											 JOIN department d on cl.department_id=d.department_id
											 WHERE (s.course_id = '$search_query'  OR c.course_name like '%$search_query%' OR t.name like '%$search_query%')) AS subquery 
											 GROUP BY course_id, course_name
											 ";
								
							} 
							else {
								$query = "SELECT week, time_start, time_end, course_id, course_name, quota, quota_max, year, semester, note, isRequired, credit, name, class_name, class_id, department_name, GROUP_CONCAT(DISTINCT times ORDER BY times SEPARATOR 'o\n') AS times, GROUP_CONCAT(DISTINCT locations ORDER BY locations SEPARATOR 'o\n') AS locations
											FROM 
											( SELECT c.course_id, c.course_name, s.quota, s.quota_max, s.year, s.semester, s.note, c.isRequired, c.credit, t.name, cl.class_name,cl.class_id,sd.location,sd.week,sd.time_start,sd.time_end,d.department_name, CONCAT('周',sd.week, ' ', sd.time_start, '-', sd.time_end, '節') AS times,CONCAT(sd.location) AS locations
											 FROM course c 
											 JOIN section s ON c.course_id = s.course_id 
											 JOIN section_detail sd ON s.section_id = sd.section_id 
											 JOIN teacher t ON sd.teacher_id = t.teacher_id 
											 JOIN class cl ON s.class_id=cl.class_id 
											 JOIN department d on cl.department_id=d.department_id) AS subquery 
											 GROUP BY course_id, course_name
											";
							}
							if (!empty($is_exclude)) {
							// Check for no time collisions
									$query .= "intersect SELECT subquery.week, subquery.time_start, subquery.time_end, subquery.course_id, subquery.course_name, subquery.quota, subquery.quota_max, subquery.year, subquery.semester, subquery.note, subquery.isRequired, subquery.credit, subquery.name, subquery.class_name, subquery.class_id, subquery.department_name, subquery.times, subquery.locations
											FROM 
											( SELECT c.course_id, c.course_name, s.quota, s.quota_max, s.year, s.semester, s.note, c.isRequired, c.credit, t.name, cl.class_name,cl.class_id,sd.location,sd.week,sd.time_start,sd.time_end,d.department_name, CONCAT('周',sd.week, ' ', sd.time_start, '-', sd.time_end, '節') AS times,CONCAT(sd.location) AS locations
											  FROM course c 
											  JOIN section s ON c.course_id = s.course_id 
											  JOIN section_detail sd ON s.section_id = sd.section_id 
											  JOIN teacher t ON sd.teacher_id = t.teacher_id 
											  JOIN class cl ON s.class_id=cl.class_id 
											  JOIN department d on cl.department_id=d.department_id
											) AS subquery
											WHERE NOT EXISTS (
											  SELECT 1
											  FROM section_student ss
											  INNER JOIN section_detail sd ON ss.section_id = sd.section_id
											  INNER JOIN section se ON sd.section_id = se.section_id
											  INNER JOIN course c ON se.course_id = c.course_id
											  INNER JOIN student s ON ss.student_id = s.student_id
											  INNER JOIN account ac ON ac.account_id=s.account_id
											  WHERE ac.account= '$account'
											  AND ((subquery.week = sd.week AND subquery.time_start <= sd.time_start AND subquery.time_start <= sd.time_end)
											  OR (subquery.week = sd.week AND subquery.time_start <= sd.time_end AND subquery.time_end <= sd.time_end)))
												GROUP BY subquery.course_id, subquery.course_name
											";
											}
																		
												

							// Filter by department
							if (!empty($department)) {
								$query .= " INTERSECT SELECT week, time_start, time_end, course_id, course_name, quota, quota_max, year, semester, note, isRequired, credit, name, class_name, class_id, department_name, GROUP_CONCAT(DISTINCT times ORDER BY times SEPARATOR 'o\n') AS times, GROUP_CONCAT(DISTINCT locations ORDER BY locations SEPARATOR 'o\n') AS locations
											FROM 
											( SELECT c.course_id, c.course_name, s.quota, s.quota_max, s.year, s.semester, s.note, c.isRequired, c.credit, t.name, cl.class_name,cl.class_id,sd.location,sd.week,sd.time_start,sd.time_end,d.department_name, CONCAT('周',sd.week, ' ', sd.time_start, '-', sd.time_end, '節') AS times,CONCAT(sd.location) AS locations
											 FROM course c 
											 JOIN section s ON c.course_id = s.course_id 
											 JOIN section_detail sd ON s.section_id = sd.section_id 
											 JOIN teacher t ON sd.teacher_id = t.teacher_id 
											 JOIN class cl ON s.class_id=cl.class_id 
											 JOIN department d on cl.department_id=d.department_id
											 WHERE s.class_id IN (SELECT class_id FROM class WHERE department_name = '$department')) AS subquery 
											 GROUP BY course_id, course_name
											";
							}
							

							// Filter by week
							if (!empty($week)) {
							$query .= "INTERSECT SELECT week, time_start, time_end, course_id, course_name, quota, quota_max, year, semester, note, isRequired, credit, name, class_name, class_id, department_name, GROUP_CONCAT(DISTINCT times ORDER BY times SEPARATOR 'o\n') AS times, GROUP_CONCAT(DISTINCT locations ORDER BY locations SEPARATOR 'o\n') AS locations
											FROM 
											( SELECT c.course_id, c.course_name, s.quota, s.quota_max, s.year, s.semester, s.note, c.isRequired, c.credit, t.name, cl.class_name,cl.class_id,sd.location,sd.week,sd.time_start,sd.time_end,d.department_name, CONCAT('周',sd.week, ' ', sd.time_start, '-', sd.time_end, '節') AS times,CONCAT(sd.location) AS locations
											 FROM course c 
											 JOIN section s ON c.course_id = s.course_id 
											 JOIN section_detail sd ON s.section_id = sd.section_id 
											 JOIN teacher t ON sd.teacher_id = t.teacher_id 
											 JOIN class cl ON s.class_id=cl.class_id 
											 JOIN department d on cl.department_id=d.department_id
											 WHERE sd.week = '$week') AS subquery 
											 GROUP BY course_id, course_name
											";
							}

							// Filter by time
							if (!empty($time)) {
								$query .= "INTERSECT SELECT week, time_start, time_end, course_id, course_name, quota, quota_max, year, semester, note, isRequired, credit, name, class_name, class_id, department_name, GROUP_CONCAT(DISTINCT times ORDER BY times SEPARATOR 'o\n') AS times, GROUP_CONCAT(DISTINCT locations ORDER BY locations SEPARATOR 'o\n') AS locations
											FROM 
											( SELECT c.course_id, c.course_name, s.quota, s.quota_max, s.year, s.semester, s.note, c.isRequired, c.credit, t.name, cl.class_name,cl.class_id,sd.location,sd.week,sd.time_start,sd.time_end,d.department_name, CONCAT('周',sd.week, ' ', sd.time_start, '-', sd.time_end, '節') AS times,CONCAT(sd.location) AS locations
											 FROM course c 
											 JOIN section s ON c.course_id = s.course_id 
											 JOIN section_detail sd ON s.section_id = sd.section_id 
											 JOIN teacher t ON sd.teacher_id = t.teacher_id 
											 JOIN class cl ON s.class_id=cl.class_id 
											 JOIN department d on cl.department_id=d.department_id
											 WHERE sd.time_start = '$time') AS subquery 
											 GROUP BY course_id, course_name
											";
							}
							
							}
							
													
							// Execute query and get results
							 $result = mysqli_query($conn, $query);
							 if (!$result) {
    trigger_error(mysqli_error($conn), E_USER_ERROR);
}
							 
							 
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

					<?php
						// include $_SERVER['DOCUMENT_ROOT'].'/model/fculogo/index.php';
					?>
				</a>
				
		    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		    </button>
				
		    <div class="collapse navbar-collapse" id="navbarToggler">
		      <ul class="navbar-nav me-auto mb-0 mb-lg-0">
		        <li class="nav-item">
		          <a class="nav-link postloader" aria-current="page" href="/">首頁</a>
		        </li>
		        <!-- <li class="nav-item">
		          <a class="nav-link postloader" href="/dbmid/login">登入</a>
		        </li> -->
		        <!-- <li class="nav-item">
		          <a class="nav-link postloader" href="/dbmid/register">註冊</a>
		        </li> -->
				<li class="nav-item">
		          <a class="nav-link postloader active" href="/dbmid/course">選課</a>
		        </li>
                <li class="nav-item">
		          <a class="nav-link postloader" href="/dbmid/mycourse">我的課表</a>
		        </li>
		      </ul>
			  <ul class="d-flex justify-content-end m-0">
			  	<li class="nav-item d-flex align-items-center">
				  <p class="m-0 font-white pe-3"><?php echo $class_name . " " . $account . " " . $name; ?></p>
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
					<form method="post" class="col-12 col-md-10 col-lg-8 bingShadow bg-white rounded-30 px-3" for="searchBox" action="search.php">

						<div class="col">
							<div class="row">
								<input class="img-fluid col-auto" type="image" src="/dbmid/asset/search.svg" alt="Submit">
								<!-- <img src="/dbmid/asset/search.svg" class="img-fluid col-auto"> -->
								<div class="col px-0">
									<input name="search_query" type="text" class="col-12 h-100 border-0 py-3" id="searchBox" placeholder="選課代號、科目名稱、教師姓名">
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
									<div class="col-12 col-md-6 mb-2">
										<select name="department" class="col-auto form-control py-1 px-2">
											<option>科系</option>
											<option>資電學院</option>
											<option>資訊</option>
											<option>電子</option>
											<option>電機</option>
										</select>
									</div>
									<div class="col-12 col-md-6 mb-2">
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
									<div class="col-12 col-md-6 mb-2 d-flex align-items-center" for="is_exclude">


										<input class="py-0" type="checkbox" id="is_exclude" name="is_exclude" value="is_exclude">										

										<label class="py-0 ps-1 pe-5" for="is_exclude">過濾衝堂</label>
										<!-- <input type="text" class="col-12 py-1" id="" placeholder="科目名稱"> -->
									</div>
								</div>

								

								

							</div>
						</div>
					</form>
				</div>
		
			</div>
			
		</div>
		
		<div class="container">

<!-- 			<div class="v-slider">
        <div class="hold promote-layer"></div>
      </div> -->



			<div class="col px-1">
				<div class="row">

							 <?php
							while ($row = mysqli_fetch_assoc($result)){
							if (mysqli_num_rows($result) > 0) {
								// Print results in a table?>
								<div class="col-12 col-md-6 col-lg-4 col-xl-3 px-2">

									<div class="col card mb-3 pt-2 px-2 pb-1" data-bs-toggle="modal" 
										<?php
											echo "data-bs-target='#Modal".$row['course_id']."'";
										?>
									>
										
										<div class="row pt-0 pb-0 px-3 mb-2 pt-1">
										<?php if($row['isRequired']==1){
										?>
											<div class="col-auto text-right px-0 m-0">           
												<div class="h-100 d-flex align-items-end flex-column">
													<h5 class="bi px-3 py-1 m-0">必</h5>
												</div>
											</div>
										<?php }
										else{
										?>
											<div class="col-auto text-right px-0 m-0">           
												<div class="h-100 d-flex align-items-end flex-column">
													<h5 class="xuan px-3 py-1 m-0">選</h5>
												</div>
											</div>
										<?php } ?>
											
											<div class="col text-left pe-0 ps-1 m-0  d-flex align-items-center">
												<h5 class="fw-bold ellipsis-1 m-0 ">
													<span><?php echo $row['course_name']; ?></span>
												</h5>
											</div>          
										</div>

										<hr class="my-2">
										
										<div class="row pb-0 px-3 mb-2">
											<div class="col text-left px-0 m-0">
												<h5 class="fw-bold m-0"><?php echo $row['name']; ?></h5>  
											</div>
											<div class="col-auto text-right px-0 m-0">           
												<div class="h-100 d-flex align-items-center">
													<h5 class="fw-bold  m-0">代碼&nbsp;<span><?php echo $row['course_id']; ?></span></h5>
												</div>
											</div>
										</div>

										<div class="row pb-0 px-3 mb-2">
											<div class="col text-left px-0 m-0">
												<h5 class="m-0">人數&nbsp;<span><?php echo $row['quota']; ?></span>/<span><?php echo $row['quota_max']; ?></span></h5>
											</div>
											<div class="col-auto text-right px-0 m-0">           
												<div class="h-100 d-flex align-items-center">
													<h5 class="m-0">學分&nbsp;<span><?php echo $row['credit']; ?></span></h5>
												</div>
											</div>
										</div>

										<hr class="my-2">
										
										<div class="row pb-0 px-3 mb-2">
											<div class="col text-left px-0 m-0">
												<div class="h-100 d-flex align-items-center">
													<h5 class="m-0"><?php
																$n=0;
																$str=$row['times'];
																$delim='o';
																$words= explode($delim,$str);
																foreach($words as $word)
																{
																	if($n==0){
																		sscanf($word, "周%s %d-%d節", $day,$time_str, $time_end);
																		if($time_str==$time_end){
																			echo "周".$day." ".$time_str."節";
																			$n=$n+1;
																		}
																		else{
																			echo "周".$day." ".$time_str."-".$time_end."節";
																			$n=$n+1;
																		}
																	}
																	else{
																		sscanf($word, " 周%s %d-%d節", $day1, $time_str1, $time_end1);
																		if($time_str1==$time_end1){
																			echo "周".$day1." ".$time_str1."節";
																		}
																		else{
																			echo "周".$day1." ".$time_str1."-".$time_end1."節";
																		}
																	}
															?></h5>
												</div>
											</div>
											<div class="col-auto text-right px-0 m-0">           
												<div class="h-100 d-flex align-items-center">
													<h5 class="m-0"><?php
														}
													?></h5>
												</div>
											</div>
										</div>   
									</div>
									
								</div>
								<?php }
								if (mysqli_num_rows($result) > 0){
								?>
								<div class="modal fade px-0"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" 
									<?php
												echo "id='Modal".$row['course_id']."'";
									?>
								>
								  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
									<div class="modal-content rounded-30">
									  <div class="modal-header">
										<h5 class="modal-title"></h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									  </div>
									  <div class="modal-body">
												
										<div class="row pt-0 pb-0 px-2 mb-3 pt-1">
													<?php if($row['isRequired']==1){
													?>
													<div class="col-auto text-right px-0 m-0">           
														<div class="h-100 d-flex align-items-end flex-column">
															<h5 class="bi px-3 py-1 m-0">必修</h5>
														</div>
													</div>
													<?php }
													else{
													?>
													<div class="col-auto text-right px-0 m-0">           
														<div class="h-100 d-flex align-items-end flex-column">
															<h5 class="xuan px-3 py-1 m-0">選修</h5>
														</div>
													</div>
													<?php }?>
													
													<div class="col text-left pe-0 ps-1 m-0  d-flex align-items-center">
														<h5 class="fw-bold ellipsis-1 m-0 ps-2">
															<span ><?php echo $row['course_name']; ?></span>
														</h5>
													</div>			
												</div>

												
												
												<div class="pt-0 pb-0 px-2 mb-2 pt-1">
										
														   
														<div class="col h-100 d-flex justify-content-between border-bottom pb-2 mb-2">
															<h5 class="fw-bold m-0 w-50">代碼</h5>							
															<h5 class="m-0 w-50"><?php echo $row['course_id']; ?></h5>
														</div>

														<div class="col h-100 d-flex justify-content-between border-bottom pb-2 mb-2">
															<h5 class="fw-bold m-0 w-50">授課教師</h5>							
															<h5 class="m-0 w-50"><?php echo $row['name']; ?></h5>
														</div>
														<div class="col h-100 d-flex justify-content-between border-bottom pb-2 mb-2">
															<h5 class="fw-bold m-0 w-50">班級</h5>							
															<h5 class="m-0 w-50"><?php echo $row['class_name']; ?></h5>
														</div>

														<div class="col h-100 d-flex justify-content-between border-bottom pb-2 mb-2">
															<h5 class="fw-bold m-0 w-50">學分</h5>							
															<h5 class="m-0 w-50"><?php echo $row['credit']; ?></h5>
														</div>

														<div class="col h-100 d-flex justify-content-between border-bottom pb-2 mb-2">
															<h5 class="fw-bold m-0 w-50">實收名額</h5>							
															<h5 class="m-0 w-50"><?php echo $row['quota']; ?></h5>
														</div>

														<div class="col h-100 d-flex justify-content-between border-bottom pb-2 mb-2">
															<h5 class="fw-bold m-0 w-50">開放名額</h5>							
															<h5 class="m-0 w-50"><?php echo $row['quota_max']; ?></h5>
														</div>


														<div class="col h-100 d-flex justify-content-between pb-2">
															<h5 class="fw-bold m-0 w-50">上課時間</h5>
															<h5 class="m-0 w-50"><?php
																$n=0;
																$str=$row['times'];
																$delim='o';
																$words= explode($delim,$str);
																foreach($words as $word)
																{
																	if($n==0){
																		sscanf($word, "周%s %d-%d節", $day,$time_str, $time_end);
																		if($time_str==$time_end){
																			echo "周".$day." ".$time_str."節";
																			$n=$n+1;
																		}
																		else{
																			echo "周".$day." ".$time_str."-".$time_end."節";
																			$n=$n+1;
																		}
																		echo "<br>";
																	}
																	else{
																		sscanf($word, " 周%s %d-%d節", $day1, $time_str1, $time_end1);
																		if($time_str1==$time_end1){
																			echo "周".$day1." ".$time_str1."節";
																			$n=$n+1;
																		}
																		else{
																			echo "周".$day1." ".$time_str1."-".$time_end1."節";
																			$n=$n+1;
																		}
																	}
																}
															?></h5>
														</div>

														<div class="col h-100 d-flex justify-content-between border-bottom pb-2 mb-2">
															<h5 class="fw-bold m-0 w-50">上課地點</h5>
															<h5 class="m-0 w-50"><?php
																$str2=$row['locations'];
																$flag=0;
																for($l=0;$l<strlen($str2);$l++)
																{
																	if($str2[$l]=='o')
																	{
																		$flag=1;
																		break;
																	}
																}
																
																if($flag==1)
																{
																	$i=0;
																	$delim='o';
																	$words2= explode($delim,$str2);
																	foreach($words2 as $word2)
																	{
																	if($i==0){
																		echo $word2;
																		$i=$i+1;
																		}
																	else if($i==1){
																			echo $word2;
																	}
																	echo "<br>";
																	}
																}
																else if($flag==0&&$n==2)
																{
																	echo $str2;
																	echo "<br>";
																	echo $str2;
																}
																else
																{
																	echo $str2;
																}
															?></h5>
														</div>

														<!--<div class="col h-100 d-flex justify-content-between pb-2">
															<h5 class="fw-bold m-0 w-50"></h5>
															<h5 class="m-0 w-50"></h5>	
														</div>

														<div class="col h-100 d-flex justify-content-between border-bottom pb-2 mb-2">
															<h5 class="fw-bold m-0 w-50"></h5>
															<h5 class="m-0 w-50"></h5>
														</div>-->

														<div class="col h-100">
															<h5 class="fw-bold m-0 pb-1">備註</h5>
															<h5 class="m-0 w-100"><?php echo $row['note']; ?></h5>
														</div>
														<div class="col w-100 d-flex justify-content-center pt-3">
															<button class="btn btn-primary rounded-30 py-2 px-3" type="submit">加選</button>
														</div>
													
												</div>
												
									  </div>
									  
									</div>
								  </div>
								</div>

							<?php
							} else {
								echo "No results found.";
							}
							}
							
						

						// Close database connection
						mysqli_close($conn);
						?>

				</div>
			</div>



<!-- 			timetable -->
			<div>
				<div class="bubble"></div>
			</div>
			
			<div class="chat_container container ">
				
			  <div class="chat col-12 pe-2">
					<div class="chatIn col-12 p-0">

							<?php
								include $_SERVER['DOCUMENT_ROOT'].'/dbmid/model/timetable/index.php';
							?>

						
					</div>	
					
					
			    
			  </div>
			</div>

			<div class="timetableMask"></div>
			
			
		</div>
		
		
		
		<script src="/dbmid/preLoaderClose.js" ></script>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.1/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
		<!--~bootstrap-->
		
  </body>
</html>