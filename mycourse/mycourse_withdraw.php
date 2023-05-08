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

echo $section_id . " _ ";
echo $student_id . "<br>";

$sql = "
    UPDATE `section_student` 
        SET is_valid = 0
    WHERE `student_id` = " . $student_id . "
        AND `section_id` = " . $section_id . "
    ;    
";
$result = mysqli_query($conn, $sql); //把SQL查詢的結果指向result

echo '<script language = "javascript">alert("Successes!");</script>';
echo '<script language = "javascript"> window.location.href = "./index.php?student_id=' . $student_id . '"</script>';

mysqli_close($conn);

?>