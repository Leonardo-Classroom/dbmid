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
// echo $student_id."<br>";
// echo $section_id."<br>";

//找出課表上與欲加選之衝堂的課
$sql = "
        SELECT DISTINCT(section_student.section_id) FROM `section_student` 
        left join `section_detail` on `section_student`.`section_id`=`section_detail`.`section_id`
        inner join (SELECT week,time_start,time_end FROM `section_detail` where section_id=".$section_id.") as add_course
        on add_course.week=section_detail.week
        where `student_id`=".$student_id." AND `is_valid`=1 AND
        (
        (add_course.time_start>=`section_detail`.`time_start` AND add_course.time_start<=`section_detail`.`time_end`)
        OR
        (add_course.time_end>=`section_detail`.`time_start`AND add_course.time_end<=`section_detail`.`time_end`)
        OR
        (add_course.time_start<`section_detail`.`time_start`AND add_course.time_end>`section_detail`.`time_end`)
        )
	";
 
$result = mysqli_query($conn, $sql);
	
$section_id_overlap=[];//與欲加選衝堂的section_id

while($row = mysqli_fetch_array($result)){
    array_push($section_id_overlap, $row['section_id']);       
}

//判斷欲選課名已存在課表
$sql = "
    SELECT course_name
    FROM `section` 
    left join course on course.course_id=section.course_id
    where section_id=".$section_id." AND course_name in(
        SELECT course_name
        FROM `section_student`
        LEFT JOIN section on section.section_id= section_student.section_id
        LEFT JOIN course on course.course_id=section.course_id
        WHERE student_id=".$student_id."AND `is_valid`=1
    );
";
$result = mysqli_query($conn, $sql);
$course_name_overlap=[];
while($row = mysqli_fetch_array($result)){
    array_push($course_name_overlap, $row['course_name']);    
}
// echo count($section_id_overlap)."<br>";
// echo $course_name_overlap[0]."<br>";

//**************判斷加選後是否超過30學分*************
// 目前學分數
// $sql = "
//     SELECT student_id,sum(credit) as credit
//     FROM `section_student` 
//     LEFT JOIN section on section.section_id = section_student.section_id
//     LEFT JOIN course on course.course_id=section.course_id
//     WHERE student_id =".$student_id."
//     );
// ";
$sql = "
        SELECT student_id,sum(credit) as credit
        FROM `section_student` 
        LEFT JOIN section on section.section_id = section_student.section_id
        LEFT JOIN course on course.course_id=section.course_id
        WHERE student_id =".$student_id." AND is_valid=1
	";
$result = mysqli_query($conn, $sql);
$current_credit=[];
while($row = mysqli_fetch_array($result)){
    array_push($current_credit, $row['credit']);    
}
// echo $current_credit[0]."<br>";

//欲加選之學分
$sql = "
        SELECT credit
        FROM section
        LEFT JOIN course on section.course_id=course.course_id
        WHERE section_id=".$section_id."
	";
$result = mysqli_query($conn, $sql);
	
$Add_credit=[];
while($row = mysqli_fetch_array($result)){
    array_push($Add_credit, $row['credit']);       
}
// echo $Add_credit[0]."<br>";
$over_credit=0;
if($current_credit[0]+$Add_credit[0]>30)
    $over_credit++;

//人數已滿的課程不可加選
//確認人數是否已滿
$sql = "
        SELECT *
        FROM `section`
        WHERE section_id=".$section_id." AND quota>=quota_max
	";
$result = mysqli_query($conn, $sql);
	
$full=[];
while($row = mysqli_fetch_array($result)){
    array_push($full, $row['quota_max']); 
}




if (count($section_id_overlap)==0&&count($course_name_overlap)==0&&$over_credit==0&&count($full)==0) //準備加選課程 
{
    //找出欲選課之department_id、isRequired以判斷是否可自行退選
    $sql = "
    SELECT department_id,isRequired
    FROM `section` 
    left join course on course.course_id=section.course_id
    left join class on section.class_id=class.class_id
    where section_id=".$section_id."
	";

    $result = mysqli_query($conn, $sql);

    $Add_department_id=[];
    $isRequired=[];
    while($row = mysqli_fetch_array($result)){
        array_push($Add_department_id, $row['department_id']); 
        array_push($isRequired, $row['isRequired']);       
    }

    //找出自己之department_id，以判斷是否可自行退選
    $sql = "
    SELECT department_id
    FROM `student` 
    LEFT JOIN class ON class.class_id=student.class_id
    where student_id=".$student_id."
	";
    $result = mysqli_query($conn, $sql);

    $my_department_id=[];
    while($row = mysqli_fetch_array($result)){
        array_push($my_department_id, $row['department_id']);       
    }

    //只當與"必修"欲選課同學院時，才無法自行退選
    if(($Add_department_id[0]==$my_department_id[0])&&($isRequired[0]==1))
        $is_withdrawable=0;
    else if(($Add_department_id[0]!=$my_department_id[0])&&($isRequired[0]==1))//限制加選院外必修
    {
        echo "<script language='javascript'>alert('無權限加選院外必修...加選失敗!');</script>";
        echo "<script language='javascript'>window.location.href = './index.php'</script>";
        exit;
    }
    else
        $is_withdrawable=1;
    
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
    //加選進資料庫
    mysqli_query($conn, $sql);
// $result = mysqli_query($conn, $sql);
    echo "<script language='javascript'>alert('加選成功!');</script>";
    echo "<script language='javascript'>window.location.href = '../mycourse/index.php'</script>";
    // echo "可以加選";
}

else//無法加選課程
{
    //通知加選失敗並通知原因
    if(count($course_name_overlap)!=0)
        echo "<script language='javascript'>alert('重複選修: ".$course_name_overlap[0]."...加選失敗!');</script>";
    else if(count($section_id_overlap)!=0)
        echo "<script language='javascript'>alert('與選課代碼:「".$section_id_overlap[0]."」衝堂...加選失敗!');</script>"; 
    else if($over_credit!=0)
        echo "<script language='javascript'>alert('超過學分上限...加選失敗!');</script>";
    else if(count($full)!=0)
        echo "<script language='javascript'>alert('修課人數已滿".$full[0]."人...加選失敗!');</script>";
    else
        echo "<script language='javascript'>alert('無法加選!');</script>"; 
    // for($i=0;$i<count($section_id_overlap);$i++)
    // {
    //     echo $section_id_overlap[$i];
    // }
    echo "<script language='javascript'>window.location.href = './index.php'</script>";//
}
exit;
?>