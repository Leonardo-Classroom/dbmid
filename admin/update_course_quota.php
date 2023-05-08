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
        SELECT `section`.`section_id`, IF(valid.section_student_id IS NULL,0,COUNT(`section`.`section_id`)) AS 'quota'
        FROM `section` 
        LEFT JOIN (
            SELECT *
            FROM `section_student`
            WHERE `section_student`.`is_valid`=1
        )AS valid ON `section`.`section_id`=valid.`section_id`
        GROUP BY `section`.`section_id`
        ORDER BY `section`.`section_id` 
    ";

    // Execute query and get results
    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_array($result)){

        // echo $row['section_id']." ";
        // echo $row['quota']."<br>";

        $sql_update="
            UPDATE `section` 
            SET `quota`='".$row['quota']."'
            WHERE `section_id`=".$row['section_id'].";
        ";

        $result_update = mysqli_query($conn, $sql_update);
        
    }


    // continue





    mysqli_close($conn);






    echo "<script language='javascript'>alert('更新完成');</script>";
    echo "<script language='javascript'>window.location.href = './tools.php'</script>";
?>