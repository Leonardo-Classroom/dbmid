<!DOCTYPE html>
<html lang="en" style="background-color: #7d212a;">
<head>

<title>逢甲選課系統 - Login</title>


</head>
<body>
    
</body>
</html>

<?php

    //  

	// 取得使用者輸入的帳號和密碼
	$username = $_POST['account'];
	$password = $_POST['password'];

	// 將密碼加密
	$hashed_password = password_hash($password, PASSWORD_DEFAULT);
	//echo $username."<br>";
	//echo $password."<br>";
	//echo $hashed_password."<br>";

	// 建立資料庫連線
	$servername = "localhost";
	$username_db = "hj";
	$password_db = "test1234";
	$dbname = "dbmid";

	$conn = mysqli_connect($servername, $username_db, $password_db, $dbname);

	// 檢查連線是否成功
	if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
	}

	// 從資料庫中取得使用者資訊
	$sql = "SELECT `account`.*,`admin`.`admin_id`,`admin`.`admin_name` 
			FROM `account` 
			LEFT JOIN `admin` ON `account`.`account_id`=`admin`.`account_id`
			WHERE `account`.`account`='$username';
			";
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0) {
		// 找到該使用者，比對密碼是否正確
		$user = mysqli_fetch_assoc($result);
		//echo $user['password']."<br>";	
		if (password_verify($password, $user['password'])) {
            // 登入成功，儲存使用者資訊到 session 中

			if($user['is_banned']==1){
				echo "<script language='javascript'>alert('YOU ARE BANNED!!');</script>";
        		echo "<script language='javascript'>window.location.href = '../'</script>";	
				exit;			
			}

			
			
            session_start();
            $_SESSION['account_id'] = $user['account_id'];
            $_SESSION['account'] = $user['account'];

			$_SESSION['admin_id']=0;
			if($user['admin_id']!=NULL){
				$_SESSION['admin_id'] = $user['admin_id'];
			}
			
			if($_SESSION['admin_id']!=0){
				header("Location: "."/dbmid/admin/");
				// echo "is admin";
			}else{
				header("Location: "."/dbmid/mycourse/");
				// echo "is student";
			}

            exit;
		} else {            
			//echo "Invalid password";
            echo "<script language='javascript'>alert('Invalid password');</script>";
            echo "<script language='javascript'>window.location.href = '../'</script>";
            //header("Location: ".'/dbmid/login/');
            exit;
	}
	} else {
	    //echo "Invalid username";
        echo "<script language='javascript'>alert('Invalid username');</script>";
        echo "<script language='javascript'>window.location.href = '../'</script>";
        //header("Location: ".'/dbmid/login/');
        exit;

	}

	mysqli_close($conn);

?>