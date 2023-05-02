<?php
    // 檢查使用者是否已登入
    session_start();

    if (!isset($_SESSION['account_id'])) {
        //若使用者未登入，導向到登入頁面
        header("Location: /dbmid/login");
        exit();
    }

    // 取得使用者資訊
    $account_id = $_SESSION['account_id'];
    $account = $_SESSION['account'];
    $admin_id = $_SESSION['admin_id'];
    // echo $account_id."<br>";
    // echo $account."<br>";
    // echo $admin_id."<br>";
?>