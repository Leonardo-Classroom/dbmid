<?php
    include $_SERVER['DOCUMENT_ROOT'].'/dbmid/model/chklogin/index.php';
    if($admin_id==0){
        header("Location: /dbmid/login");
        exit();
    }
    $admin_account=$account;
?>

<?php

    $student_account = $_POST['student_account'];

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
        SELECT `account`.`account`,`student`.`student_id`
        FROM `account`
        LEFT JOIN `student` ON `account`.`account_id`=`student`.`account_id`
        WHERE `account`.`account`='".$student_account."';
	";

	// Execute query and get results
	$result = mysqli_query($conn, $sql);

    $student_id="";
    while($row = mysqli_fetch_array($result)){

        $student_id=$row['student_id'];
		
	}

    if($student_id==""){
        echo "<script language='javascript'>alert('查無學生');</script>";
        echo "<script language='javascript'>window.location.href = './'</script>";	
        exit;
    }

    echo "<script language='javascript'>window.location.href = './course.php?student_id=".$student_id."'</script>";	
    exit;		

?>