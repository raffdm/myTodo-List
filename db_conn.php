<?php 

$sName = "localhost";
$uName = "root";
$pass = "";
$db_name = "to_do_list";

// try {
//     $conn = new PDO("mysql:host=$sName;dbname=$db_name", $uName, $pass);
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// }catch(PDOException $e){
//   echo "Connection failed : ". $e->getMessage();
// }

$dsn = "mysql:host=$sName;dbname=$db_name;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
];

try {
    $conn = new PDO($dsn, $uName, $pass, $options);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}

?>