<?php
$flag = true;
if(isset($_POST['id_report'])){
    try{
        $id_rep = $_POST['id_report'];
        $id_user = $_SESSION['id'];
try{
    include_once('config.php');
    $pdo = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset='.$charset.'', $user, $password);
    $pdo->query("SET NAMES utf8");
    $prep = $pdo->prepare("SELECT id FROM report WHERE id=:id_rep AND id_user=:id_user limit 1");
    $prep->execute([':id_rep'=>$id_rep,':id_user'=>$id_user]);
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
    $pdo->query("SET NAMES utf8");
    $prep = $pdo->prepare("SELECT id FROM record WHERE id_report=:id_rep");
    $prep->execute([':id_rep'=>$id_rep]);
    $records=$prep->fetchAll();
    $how = sizeof($records);
    $pdo = null;
    if($how < 10){
        echo '<input type="hidden" name="RepIdForNewRecord" value="'.$id_rep.'">';
    }
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


?>