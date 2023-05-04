

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
		SELECT * 
		FROM `section_student`
		WHERE `student_id` = 1
	";

	// Execute query and get results
	$result = mysqli_query($conn, $sql);
	
	$section_student_id=[];
	$section_id=[];
	$student_id=[];
	$is_withdrawable=[];
	$is_valid=[];

	while($row = mysqli_fetch_array($result)){

        array_push($section_student_id, $row['section_student_id']);
		array_push($section_id, $row['section_id']);
		array_push($student_id, $row['student_id']);
		array_push($is_withdrawable, $row['is_withdrawable']);
		array_push($is_valid, $row['is_valid']);
        	        
	}


	// Build SQL query based on filters
	$result =[];
	for($i=0;$i<count($section_id);$i++)
	{
		$arr[$section_id[$i]]["week"]=[];
		$arr[$section_id[$i]]["time_start"]=[];
		$arr[$section_id[$i]]["time_end"]=[];
		
		$sql = "
		Select section_id, week, time_start, time_end
		from `section_detail`
		where section_id=".$section_id[$i]."
		";

		$temp = mysqli_query($conn, $sql);
		// Execute query and get results

		while($row = mysqli_fetch_array($temp)){
			
			
			echo $row['week']." ";
			echo $row['time_start']." ";
			echo $row['time_end']." ";
			echo "<br>";
			//Store the data of same section_id in the same column(3D)
			array_push($arr[$section_id[$i]]["week"],$row['week']);
			array_push($arr[$section_id[$i]]["time_start"],$row['time_start']);
			array_push($arr[$section_id[$i]]["time_end"],$row['time_end']);
		}

		// array_push(,mysqli_fetch_array($temp));
	}
	// $week=[];
	// $time_start=[];
	// $time_end=[];

	// while($row = mysqli_fetch_array($result)){
	// 	array_push($week, $row['week']);
	// 	array_push($time_start, $row['time_start']);
	// 	array_push($time_end, $row['time_end']); 
	// }

	for($i=0;$i<count($section_id);$i++){
		for($j=0;$j<count($arr[$section_id[$i]]["week"]);$j++){
			// echo $arr[$section_id[$i]]["week"][$j]." ";
			// echo $arr[$section_id[$i]]["time_start"][$j]." ";
			// echo $arr[$section_id[$i]]["time_end"][$j]."<br><br>";
		}
	}
//Insert the section_id in the coresponding box




	// continue
	echo $account."<br>";
	for($i=0;$i<count($section_id);$i++){

		// echo $section_id[$i]."<br>";

	}
	
	for($i=0;$i<13;$i++){
		for($j=0;$j<5;$j++){
			$table[$i][$j]=0;
		}
	}

	for($i=0;$i<13;$i++){
		for($j=0;$j<5;$j++){
			echo $table[$i][$j]." ";
		}echo "<br>";
	}
	



	mysqli_close($conn);
?>








<link href="/dbmid/table.css" rel="stylesheet" type="text/css" />
<div class="col-12 px-1" id="printArea">


	
		



	<div class="col px-2">

		<div class="row bg-light-grey font-white roundRT roundLT">
			
			<div class="col-auto px-1 centerVertically bi-table border left-title px-0 roundLT">
				<a class="font-white" target="_blank" href="https://newleonardoclassroom.leonardoholmes.repl.co/en-us/about-me/"><i class="fas fa-user" aria-hidden="true"></i></a>
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

		<div class="row">

			<div class="col-auto centerVertically px-1 bg-light-grey font-white border left-title px-0">
				1
			</div>

			<div class="col border f-height centerVertically px-1 " id="d1-1">
				              
				<p class="m-0 p-0 form-ellipsis "></p>
			</div>

			<div class="col border f-height centerVertically px-1 " id="d2-1">
				
				<p class="m-0 p-0 form-ellipsis "></p>
			</div>

			<div class="col border f-height centerVertically px-1 " id="d3-1">
				
				<p class="m-0 p-0 form-ellipsis "></p>
			</div>

			<div  
			
				<?php

$isBi=0;

					if($isBi){
						echo 'class="col border f-height centerVertically px-1 bi-table"';
					}else{
						echo 'class="col border f-height centerVertically px-1 xuan-table"';
					}				
				?>
			
			>
				
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

			<div class="col border f-height centerVertically px-1 bi-table" id="d2-2">
				              
				<p class="m-0 p-0 form-ellipsis " id="bi"> 

					<?php
						echo "hi";
					?>
				</p>
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