<?php
//db connection
    $conn = mysqli_connect('localhost', 'root', '', 'pluralogin');

    if($conn){
        //die("Connection Failed: ". mysqli_connect_error());
        echo "connection success";
    }

?>