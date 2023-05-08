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

	$section_id = $_GET['section_id'];
	$student_id = $_GET['student_id'];
	$isRequired = $_GET['isRequired'];

	if($isRequired==1){
		$is_withdrawable=0;
	}else{
		$is_withdrawable=1;
	}
	// echo $section_id."<br>";
    // echo $student_id."<br>";
	// echo $isRequired."<br>";

	// Build SQL query based on filters
	$sql = "
		INSERT INTO `section_student`(
			`section_id`, 
			`student_id`, 
			`is_withdrawable`, 
			`is_valid`
		) VALUES (
			".$section_id.",
			".$student_id.",
			".$is_withdrawable.",
			1
		)
	";

	$result = mysqli_query($conn, $sql);
	mysqli_close($conn);

	echo "<script language='javascript'>alert('加選成功');</script>";
    echo "<script language='javascript'>window.location.href = './course.php?student_id=".$student_id."'</script>";

	// // Execute query and get results
	// $result = mysqli_query($conn, $sql);


	// $section_id=[];


	// while($row = mysqli_fetch_array($result)){

    //     array_push($section_id, $row['section_id']);

        	        
		
	// }


	// continue

	



	
?>

