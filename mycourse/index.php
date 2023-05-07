<?php
include $_SERVER['DOCUMENT_ROOT'] . '/dbmid/model/chklogin/index.php';
if ($admin_id != 0) {
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


// Build SQL query based on filters
$sql = "
		SELECT `student`.*, `class`.*
		FROM `account`
			, `student`
			, `class`
		WHERE `account`.`account_id` = `student`.`account_id` AND `class`.`class_id` = `student`.`class_id` AND `account`.`account_id`='$account_id';
	";
// Execute query and get results
$result = mysqli_query($conn, $sql);


while ($row = mysqli_fetch_array($result)) {

	$student_id = $row['student_id'];
	$name = $row['name'];
	$class_id = $row['class_id'];
	$account_id = $row['account_id'];
	$credit_min = $row['credit_min'];
	$credit_max = $row['credit_max'];

	$class_id = $row['class_id'];
	$department_id = $row['department_id'];
	$class_name = $row['class_name'];

}


// continue
$sql = "
		SELECT 
			`course`.`course_name`, 
			`course`.`isRequired`, 
			`section_detail`.`section_id`, 
			`teacher`.`name`, `course`.`credit`, 
			`section`.`quota`, `section`.`quota_max`, 
			`section_detail`.`week`, 
			`section_detail`.`time_start`, 
			`section_detail`.`time_end`, 
			`section_detail`.`location`, 
			`section`.`note`
		FROM 
			`student`, 
			`section`, 
			`section_detail`, 
			`section_student`, 
			`course`, `teacher`, 
			`account`
		WHERE 
			`section_student`.`student_id` = `student`.`student_id` 
			AND `section`.`section_id` = `section_student`.`section_id` 
			AND `section`.`section_id` = `section_detail`.`section_id` 
			AND `course`.`course_id` = `section`.`course_id` 
			AND `teacher`.`teacher_id` = `section_detail`.`teacher_id` 
			AND `student`.`account_id` = `account`.`account_id` 
			AND `account`.`account` = '$account';
";

$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($result)) {
	echo $row[0];
	echo $row[2];

}

mysqli_close($conn);
?>


<html>

<head>

	<title>逢甲選課系統- 我的課表</title>

	<meta charset="utf-8">
	<meta name="viewport"
		content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<!--jQuery~-->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"
		integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"
		integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
	<!--~jQuery-->

	<!--bootstrap~-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
	<!--~bootstrap-->

	<!--fontawesome-->
	<script src="https://kit.fontawesome.com/d53abecaf1.js">
	</script>
	<link href="https://kit-free.fontawesome.com/releases/latest/css/free-v4-shims.min.css" media="all"
		rel="stylesheet">
	<link href="https://kit-free.fontawesome.com/releases/latest/css/free-v4-font-face.min.css" media="all"
		rel="stylesheet">
	<link href="https://kit-free.fontawesome.com/releases/latest/css/free.min.css" media="all" rel="stylesheet">
	<!--fontawesome-->

	<link href="/dbmid/main.css" rel="stylesheet" type="text/css" />
	<script src="/dbmid/main.js">	</script>

	<link href="main.css" rel="stylesheet" type="text/css" />
	<script src="main.js">
	</script>

	<link rel="stylesheet/scss" type="text/css" href="/bubble.scss" />
	<link href="/dbmid/bubble.css" rel="stylesheet" type="text/css" />
	<script src="/dbmid/course.js"></script>



</head>

<body class="">
	<?php
	include $_SERVER['DOCUMENT_ROOT'] . '/dbmid/model/preloader/index.php';
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

			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
				aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
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
						<a class="nav-link postloader" href="/dbmid/course">選課</a>
					</li>
					<li class="nav-item">
						<a class="nav-link postloader active" href="/dbmid/mycourse">我的課表</a>
					</li>
				</ul>
				<ul class="d-flex justify-content-end m-0">
					<li class="nav-item d-flex align-items-center">
						<p class="m-0 font-white pe-3">
							<?php echo $class_name . " " . $account . " " . $name; ?>
						</p>
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


	<P>TEST STRING要記得刪掉</P>



	<div class="container py-2">



		<link href="/dbmid/table.css" rel="stylesheet" type="text/css" />
		<link href="/dbmid/mycourse/main.css" rel="stylesheet" type="text/css" />
		<div class="col-12 px-1" id="printArea">

			<div class="col px-2">

				<!-- 學分計算(not yet) -->
				<p class="m-0">當前學分：16/30</p>

				<!-- Day -->
				<div class="row bg-light-grey font-white roundRT roundLT">

					<div class="col-auto px-1 centerVertically bi-table border left-title px-0 roundLT">
						<a class="font-white" target="_blank"
							href="https://newleonardoclassroom.leonardoholmes.repl.co/en-us/about-me/"><i
								class="fas fa-user" aria-hidden="true"></i></a>
					</div>

					<div class="col border centerVertically px-1">
						Mon
					</div>

					<div class="col border centerVertically px-1">
						Tue
					</div>

					<div class="col border centerVertically px-1">
						Wed
					</div>

					<div class="col border centerVertically px-1">
						Thr
					</div>

					<div class="col border centerVertically px-1 roundRT">
						Fri
					</div>

				</div>

				<!-- php loop echo 表格課表 -->
				<?php
				for ($i = 0; $i < 13; $i++) {
					?>
					<div class="row">
						<?php
						for ($j = 0; $j < 5; $j++) {
							?>
							<div class="col-auto centerVertically px-1 bg-light-grey font-white border left-title px-0">
								<?php
								if ($j == 0) {
									echo $i + 1;
								} else {
									echo '"col border f-height centerVertically px-1 "';
								}
								?>
							</div>
							<?php
						}
						?>
						<?php
				}
				?>


					<div class="col border f-height centerVertically px-1 " id="d1-1">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d2-1">

						<p class="ㄊ-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d3-1">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 bi-table" id="d4-1">

						<p class="m-0 p-0 form-ellipsis " id="bi">資料庫管理系統</p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d5-1">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

				</div>

				<div class="row">

					<div class="col-auto centerVertically px-1 bg-light-grey font-white border left-title px-0">
						2
					</div>

					<div class="col border f-height centerVertically px-1 " id="d1-2">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 bi-table" id="d2-2" data-bs-toggle="modal"
						data-bs-target="#exampleModal">

						<p class="m-0 p-0 form-ellipsis " id="bi">行動裝置程式設計</p>
					</div>

					<div class="col border f-height centerVertically px-1 xuan-table" id="d3-2">

						<p class="m-0 p-0 form-ellipsis " id="bi">網際系統設計</p>
					</div>

					<div class="col border f-height centerVertically px-1 bi-table" id="d4-2">

						<p class="m-0 p-0 form-ellipsis " id="bi">資料庫管理系統</p>
					</div>

					<div class="col border f-height centerVertically px-1 bi-table" id="d5-2">

						<p class="m-0 p-0 form-ellipsis " id="bi">系統分析與設計</p>
					</div>

				</div>

				<div class="row">

					<div class="col-auto centerVertically px-1 bg-light-grey font-white border left-title px-0">
						3
					</div>

					<div class="col border f-height centerVertically px-1 " id="d1-3">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 bi-table" id="d2-3">

						<p class="m-0 p-0 form-ellipsis " id="bi">行動裝置程式設計</p>
					</div>

					<div class="col border f-height centerVertically px-1 xuan-table" id="d3-3">

						<p class="m-0 p-0 form-ellipsis " id="bi">網際系統設計</p>
					</div>

					<div class="col border f-height centerVertically px-1 bi-table" id="d4-3">

						<p class="m-0 p-0 form-ellipsis " id="bi">資料庫專題</p>
					</div>

					<div class="col border f-height centerVertically px-1 bi-table" id="d5-3">

						<p class="m-0 p-0 form-ellipsis " id="bi">系統分析與設計</p>
					</div>

				</div>

				<div class="row">

					<div class="col-auto centerVertically px-1 bg-light-grey font-white border left-title px-0">
						4
					</div>

					<div class="col border f-height centerVertically px-1 " id="d1-4">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 bi-table" id="d2-4">

						<p class="m-0 p-0 form-ellipsis " id="bi">行動裝置程式設計</p>
					</div>

					<div class="col border f-height centerVertically px-1 xuan-table" id="d3-4">

						<p class="m-0 p-0 form-ellipsis " id="bi">網際系統設計</p>
					</div>

					<div class="col border f-height centerVertically px-1 bi-table" id="d4-4">

						<p class="m-0 p-0 form-ellipsis " id="bi">資料庫專題</p>
					</div>

					<div class="col border f-height centerVertically px-1 bi-table" id="d5-4">

						<p class="m-0 p-0 form-ellipsis " id="bi">系統分析與設計</p>
					</div>

				</div>

				<div class="row">

					<div class="col-auto centerVertically px-1 bg-light-grey font-white border left-title px-0">
						5
					</div>

					<div class="col border f-height centerVertically px-1 " id="d1-5">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d2-5">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d3-5">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 bi-table" id="d4-5">

						<p class="m-0 p-0 form-ellipsis " id="bi">資訊網路</p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d5-5">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

				</div>

				<div class="row">

					<div class="col-auto centerVertically px-1 bg-light-grey font-white border left-title px-0">
						6
					</div>

					<div class="col border f-height centerVertically px-1 " id="d1-6">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d2-6">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d3-6">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 bi-table" id="d4-6">

						<p class="m-0 p-0 form-ellipsis " id="bi">資訊網路</p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d5-6">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

				</div>

				<div class="row">

					<div class="col-auto centerVertically px-1 bg-light-grey font-white border left-title px-0">
						7
					</div>

					<div class="col border f-height centerVertically px-1 " id="d1-7">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 bi-table" id="d2-7">

						<p class="m-0 p-0 form-ellipsis " id="bi">生涯運動</p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d3-7">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 bi-table" id="d4-7">

						<p class="m-0 p-0 form-ellipsis " id="bi">週會/班會</p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d5-7">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

				</div>

				<div class="row">

					<div class="col-auto centerVertically px-1 bg-light-grey font-white border left-title px-0">
						8
					</div>

					<div class="col border f-height centerVertically px-1 " id="d1-8">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 bi-table" id="d2-8">

						<p class="m-0 p-0 form-ellipsis " id="bi">生涯運動</p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d3-8">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 bi-table" id="d4-8">

						<p class="m-0 p-0 form-ellipsis " id="bi">週會/班會</p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d5-8">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

				</div>

				<div class="row">

					<div class="col-auto centerVertically px-1 bg-light-grey font-white border left-title px-0">
						9
					</div>

					<div class="col border f-height centerVertically px-1 " id="d1-9">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d2-9">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d3-9">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d4-9">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d5-9">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

				</div>

				<div class="row">

					<div class="col-auto centerVertically px-1 bg-light-grey font-white border left-title px-0">
						10
					</div>

					<div class="col border f-height centerVertically px-1 " id="d1-10">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d2-10">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d3-10">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d4-10">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d5-10">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

				</div>

				<div class="row">

					<div class="col-auto centerVertically px-1 bg-light-grey font-white border left-title px-0">
						11
					</div>

					<div class="col border f-height centerVertically px-1 " id="d1-11">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d2-11">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d3-11">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d4-11">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d5-11">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

				</div>

				<div class="row">

					<div class="col-auto centerVertically px-1 bg-light-grey font-white border left-title px-0">
						12
					</div>

					<div class="col border f-height centerVertically px-1 " id="d1-12">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d2-12">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d3-12">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d4-12">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d5-12">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

				</div>

				<div class="row">

					<div class="col-auto centerVertically px-1 bg-light-grey font-white border left-title px-0 roundLB">
						13
					</div>

					<div class="col border f-height centerVertically px-1 " id="d1-13">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d2-13">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d3-13">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 " id="d4-13">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

					<div class="col border f-height centerVertically px-1 roundRB" id="d5-13">

						<p class="m-0 p-0 form-ellipsis "></p>
					</div>

				</div>


			</div>


		</div>




	</div>






	<!-- Modal -->
	<div class="modal fade px-0" <?php
	echo "id='" . "exampleModal" . "'";
	?> tabindex="-1"
		aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
			<div class="modal-content rounded-30">
				<div class="modal-header">
					<h5 class="modal-title"></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">

					<div class="row pt-0 pb-0 px-2 mb-3 pt-1">
						<div class="col-auto text-right px-0 m-0">
							<div class="h-100 d-flex align-items-end flex-column">
								<h5 class="bi px-3 py-1 m-0">必修</h5>
							</div>
						</div>

						<div class="col text-left pe-0 ps-1 m-0  d-flex align-items-center">
							<h5 class="fw-bold ellipsis-1 m-0 ps-2">
								<span>程式設計III程式設計III程式設計III</span>
							</h5>
						</div>
					</div>



					<div class="pt-0 pb-0 px-2 mb-2 pt-1">


						<div class="col h-100 d-flex justify-content-between border-bottom pb-2 mb-2">
							<h5 class="fw-bold m-0 w-50">代碼</h5>
							<h5 class="m-0 w-50">1211</h5>
						</div>

						<div class="col h-100 d-flex justify-content-between border-bottom pb-2 mb-2">
							<h5 class="fw-bold m-0 w-50">授課教師</h5>
							<h5 class="m-0 w-50">何霆鋒</h5>
						</div>

						<div class="col h-100 d-flex justify-content-between border-bottom pb-2 mb-2">
							<h5 class="fw-bold m-0 w-50">學分</h5>
							<h5 class="m-0 w-50">2</h5>
						</div>

						<div class="col h-100 d-flex justify-content-between border-bottom pb-2 mb-2">
							<h5 class="fw-bold m-0 w-50">實收名額</h5>
							<h5 class="m-0 w-50">60</h5>
						</div>

						<div class="col h-100 d-flex justify-content-between border-bottom pb-2 mb-2">
							<h5 class="fw-bold m-0 w-50">開放名額</h5>
							<h5 class="m-0 w-50">70</h5>
						</div>


						<div class="col h-100 d-flex justify-content-between pb-2">
							<h5 class="fw-bold m-0 w-50">上課時間</h5>
							<h5 class="m-0 w-50">周四 3~4節</h5>
						</div>

						<div class="col h-100 d-flex justify-content-between border-bottom pb-2 mb-2">
							<h5 class="fw-bold m-0 w-50">上課地點</h5>
							<h5 class="m-0 w-50">科航204</h5>
						</div>

						<div class="col h-100 d-flex justify-content-between pb-2">
							<h5 class="fw-bold m-0 w-50">上課時間</h5>
							<h5 class="m-0 w-50">周五 1~4節</h5>
						</div>

						<div class="col h-100 d-flex justify-content-between border-bottom pb-2 mb-2">
							<h5 class="fw-bold m-0 w-50">上課地點</h5>
							<h5 class="m-0 w-50">資電234</h5>
						</div>

						<div class="col h-100">
							<h5 class="fw-bold m-0 pb-1">備註</h5>
							<h5 class="m-0 w-100">2023/02/13~2023/04/13[第01~09周上課]</h5>
						</div>

						<div class="col w-100 d-flex justify-content-center pt-3">
							<button class="btn btn-primary rounded-30 py-2 px-3" type="submit">退選</button>
						</div>

					</div>

				</div>

			</div>
		</div>
	</div>









	<script src="/dbmid/preLoaderClose.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
		crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.1/dist/umd/popper.min.js"
		integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN"
		crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.js"
		integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/"
		crossorigin="anonymous"></script>
	<!--~bootstrap-->

</body>

</html>