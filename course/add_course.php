<?php
    include $_SERVER['DOCUMENT_ROOT'].'/dbmid/model/chklogin/index.php';
	if($admin_id!=0){
        header("Location: /dbmid/admin");
        exit();
    }
?>

<?php

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

$student_id=$_GET["student_id"];
$section_id=$_GET["section_id"];
echo $student_id."<br>";
echo $section_id."<br>";


$sql = "
        SELECT DISTINCT(section_student.section_id) FROM `section_student` 
        left join `section_detail` on `section_student`.`section_id`=`section_detail`.`section_id`
        inner join (SELECT week,time_start,time_end FROM `section_detail` where section_id=".$section_id.") as add_course
        on add_course.week=section_detail.week
        where `student_id`=".$student_id." AND
        (
        (add_course.time_start>=`section_detail`.`time_start` AND add_course.time_start<=`section_detail`.`time_end`)
        OR
        (add_course.time_end>=`section_detail`.`time_start`AND add_course.time_end<=`section_detail`.`time_end`)
        OR
        (add_course.time_start<`section_detail`.`time_start`AND add_course.time_end>`section_detail`.`time_end`)
        )
	";
    //WHERE `account` = '".$account."' and `is_valid`=1
//     SELECT * FROM `section_student` 
//     left join `section_detail` on `section_student`.`section_id`=`section_detail`.`section_id`
//     inner join (SELECT week,time_start,time_end FROM `section_detail` where section_id=1211) as add_course
//     on add_course.week=section_detail.week
//     where `student_id`=1 AND
//     (
//     (add_course.time_start>=`section_detail`.`time_start` AND add_course.time_start<=`section_detail`.`time_end`)
//     OR
//     (add_course.time_end>=`section_detail`.`time_start`AND add_course.time_end<=`section_detail`.`time_end`)
//     OR
//     (add_course.time_start<`section_detail`.`time_start`AND add_course.time_end>`section_detail`.`time_end`)
//     )

//     SELECT * FROM `section_student`
// left JOIN`section_detail` on `section_detail`.`section_id`=`section_student`.`section_id`
// where student_id=1  
// ORDER BY `section_detail`.`week` ASC
$result = mysqli_query($conn, $sql);
	
$section_id_arr=[];


while($row = mysqli_fetch_array($result)){
    array_push($section_id_arr, $row['section_id']);       
}
if (count($section_id_arr)==0)
{
    // $sql = "
        
// 	";

// $result = mysqli_query($conn, $sql);
    echo "<script language='javascript'>alert('加選成功!');</script>";
    echo "<script language='javascript'>window.location.href = './index.php'</script>";
    // echo "可以加選";
}

else
    echo "<script language='javascript'>alert('衝堂無法加選');</script>"; //跳出無法加選通知

    for($i=0;$i<count($section_id_arr);$i++)
    {
        echo $section_id_arr[$i];
    }
    echo "<script language='javascript'>window.location.href = './index.php'</script>";//
    exit;


?>