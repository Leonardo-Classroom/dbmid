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

    
    $section_id=$_GET["section_id"];
    $student_id=$_GET["student_id"];


    // Build SQL query based on filters
    $sql = "
        UPDATE `section_student` 
        SET `is_valid`=0
        WHERE `section_id` = ".$section_id." AND `student_id` = ".$student_id.";
    ";

    // Execute query and get results
    $result = mysqli_query($conn, $sql);

    mysqli_close($conn);

    echo "<script language='javascript'>alert('退選成功');</script>";
    echo "<script language='javascript'>window.location.href = './course.php?student_id=".$student_id."'</script>";	

    
    exit;
?>