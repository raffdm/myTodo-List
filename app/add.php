<?php

if(isset($_POST['submit'])){
    require '../db_conn.php';

    $title = $_POST['title'];
    $deadline = $_POST['deadline'];

    if(empty($title)){
        header("Location: ../index.php?mess=error");
    }else {
        $stmt = $conn->prepare("INSERT INTO todos(title, deadline) VALUE(?,?)");
        $res = $stmt->execute([$title, $deadline]);

        if($res){
            header("Location: ../index.php?mess=success"); 
        }else {
            header("Location: ../index.php");
        }
        $conn = null;
        exit();
    }
}else {
    header("Location: ../index.php?mess=error");
}
?>