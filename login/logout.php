<?php
    session_start();

    // 清除 session
    session_unset();
    session_destroy();

    // 導向到登出後的頁面
    header("Location: /dbmid/login/");
    exit();
?>