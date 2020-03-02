<?php
session_start();
$flag = true;
if(isset($_POST['record_id'])){
    try{
        $id_rec = $_POST['record_id'];
        $id_user = $_SESSION['id'];
try{
    include_once('config.php');
    $pdo = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset='.$charset.'', $user, $password);
    $pdo->query("SET NAMES utf8");
    $prep = $pdo->prepare("SELECT id FROM record WHERE id=:id_rec AND id_user=:id_user limit 1");
    $prep->execute([':id_rec'=>$id_rec,':id_user'=>$id_user]);
    $report=$prep->fetch();
    if($report[0] == 0)
    $flag = false;
}
catch(PDOException $e){
    $_SESSION['error']='Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
    header("location: addRaport.php");
    exit();
}


if($flag){
try{
    $prep = $pdo->prepare("DELETE FROM record WHERE id=:id_rec");
    $prep->execute([':id_rec'=>$id_rec]);
    $pdo = null;
    header("location: addRaport.php");
    exit();
    }
catch(PDOException $e){
    $_SESSION['error']='Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
    header("location: addRaport.php");
    exit();
}
}
    }
catch(PDOException $e){
  $_SESSION['error']="Brak zmiennej";
    header('location: addRaport.php');
}
}
else{
  $_SESSION['error']="Brak zmiennej";
    header('location: addRaport.php');
}


?>