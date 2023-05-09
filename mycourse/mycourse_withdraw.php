<?php
include $_SERVER['DOCUMENT_ROOT'] . '/dbmid/model/chklogin/index.php';
if ($admin_id != 0) {
    header("Location: /dbmid/admin");
    exit();
}
?>

<?php
$host = "localhost";
$username = "hj";
$password = "test1234";
$dbname = "dbmid";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$section_id = $_GET["section_id"];
$student_id = $_GET["student_id"];
$S_ID = $_GET["S_ID"];

echo "課程代碼：" . $section_id . " <br>";
echo "學號：" . $S_ID . " <br>";
// echo $student_id . " <br>";


//當前學分總和
$sql = "
        SELECT 
            student_id, sum(credit)
        FROM 
            section_student
            LEFT JOIN section on section.section_id = section_student.section_id
            LEFT JOIN course on course.course_id=section.course_id
        WHERE student_id =" . $student_id . "
";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_array($result)) {
    $credit_cnt = $row['sum(credit)'];
}
echo "<br>#當前學分--> " . $credit_cnt . " <br>";

//將退選課程之學分數
$sql = "
        SELECT 
            credit, isRequired
        FROM 
            section, course
        WHERE 
            course.course_id = section.course_id
            AND section_id =" . $section_id . "
";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_array($result)) {
    $credit_drop = $row['credit'];
    $isRequired_drop = $row['isRequired'];
}
echo "<br>#欲退學分--> " . $credit_drop . " <br>";
echo "<br>#該院系必(1)選(0)修--> " . $isRequired_drop . " <br>";

//必修課不可退選
$sql = "
        SELECT 
            section_student.is_withdrawable
        FROM
            section_student
        WHERE
            section_id = " . $section_id . "
            AND student_id = " . $student_id . "
";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_array($result)) {
    $is_withdrawable = $row['is_withdrawable'];
}

//系統判斷是否加選
if (!$is_withdrawable) {
    echo "<script language = 'javascript'>alert('課務公告： " . $S_ID . " 同學，此為<必修>課程，學生無法自行退選喔！');</script>";
} else if (($credit_cnt - $credit_drop) < 9) {
    echo "<script language = 'javascript'>alert('課務公告： " . $S_ID . " 同學，退選後您的學分總和將<低於最低學分限制>，故無法退選！');</script>";
} else {
    //進行退選
    // ---------------------------------------section_student 刪除資料列
    $sql = "
        UPDATE `section_student` 
            SET is_valid = 0
        WHERE `student_id` = " . $student_id . "
            AND `section_id` = " . $section_id . "
        ;    
    ";
    mysqli_query($conn, $sql); //把SQL查詢的結果指向result

    echo "<script language = 'javascript'>alert('課務公告： " . $S_ID . " 同學，課程退選成功！');</script>";
}
echo '<script language = "javascript"> window.location.href = "./index.php?student_id=' . $student_id . '"</script>';



mysqli_close($conn);

?>