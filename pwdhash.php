<?php

//500密码
// for($i=1;$i<=500;$i++){
//     $password="D1176";
//     $temp=strval($i);
//     for($j=0;$j<3-strlen($temp);$j++){
//         $password.="0";
//     }
//     $password.=strval($i);

//     $hashed_password = password_hash($password, PASSWORD_DEFAULT);
//     echo $hashed_password."<br>";

//     // echo $password."<br>";
// }

    $password="admin";
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    echo $hashed_password."<br>";


?>