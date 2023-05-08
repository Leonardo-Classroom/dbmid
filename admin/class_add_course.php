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
        SELECT `section`.`section_id`,`course`.`course_name`,`class`.`class_id`,`class`.`class_name` ,`student`.`student_id`,`student`.`name`
        FROM `section` 
        LEFT JOIN `course` ON `section`.`course_id`=`course`.`course_id`
        LEFT JOIN `class` ON `section`.`class_id`=`class`.`class_id`
        ,`student`
        WHERE `section`.`class_id`=".$_GET["class_id"]." AND `student`.`class_id`=".$_GET["class_id"].";
	";

	// Execute query and get results
	$result = mysqli_query($conn, $sql);

    
    $class_id=[];
    $department_id=[];
    $class_name=[];
    $department_name=[];

    $section_id=[];	
    $course_name=[];	
    $class_id=[];	
    $class_name=[];	
    $student_id=[];	
    $name=[];	

	while($row = mysqli_fetch_array($result)){

        array_push($section_id, $row['section_id']);
        array_push($course_name, $row['course_name']);
        array_push($class_id, $row['class_id']);
        array_push($class_name, $row['class_name']);
        array_push($student_id, $row['student_id']);
        array_push($name, $row['name']);
		
	}


	// continue

	

?>

<?php

    // echo $_GET["class_id"]."<br>";
    for($i=0;$i<count($section_id);$i++){
        $sql_add = "
            INSERT INTO `section_student`(
                `section_id`, 
                `student_id`, 
                `is_withdrawable`, 
                `is_valid`
            ) VALUES (
                ".$section_id[$i].",
                ".$student_id[$i].",
                0,
                1
            )
        ";

        // Execute query and get results
        $result_add = mysqli_query($conn, $sql_add);
        // echo $result_add."<br>";

        // echo $section_id[$i]." ";
        // echo $course_name[$i]." ";
        // echo $class_id[$i]." ";
        // echo $class_name[$i]." ";
        // echo $student_id[$i]." ";
        // echo $name[$i]."<br>";
    }


    mysqli_close($conn);




    echo "<script language='javascript'>alert('班級加選完成');</script>";
    echo "<script language='javascript'>window.location.href = './tools.php'</script>";
?>