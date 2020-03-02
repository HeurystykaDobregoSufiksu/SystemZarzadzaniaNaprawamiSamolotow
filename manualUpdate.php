<?php
  session_start();
  $flag=true;
  $data = json_decode($_POST['manualChange']);
  $data->ref= trim(preg_replace('/\s\s+/', ' ', $data->ref));
  $data->ata= trim(preg_replace('/\s\s+/', ' ', $data->ata));
  $data->task_details= trim(preg_replace('/\s\s+/', ' ', $data->task_details));
  if(strlen($data->ref)>80 || strlen($data->ref)<10)
  {
    $flag=false;
  }
  if(strlen($data->ata)>6 || strlen($data->ata)<4)
  {
    $flag=false;
  }
  if(strlen($data->task_details)<10)
  {
    $flag=false;
  }
  if($flag)
  {
    try{
      $pdo = new PDO('mysql:host=localhost;dbname=lotnictwo;charset=utf8', 'root', '');
      $pdo->query("SET NAMES utf8");
      $prep = $pdo->prepare("UPDATE manual SET ref=:ref,ata=:ata,task_details=:task_details WHERE ref=:old_ref AND id_user=:id");
      $prep ->execute([':ref'=>$data->ref,':ata'=>$data->ata,':task_details'=>$data->task_details,':old_ref'=>$data->old_ref,":id"=>$_SESSION["id"]]);
      echo "good";
    }catch(PDOException $e){
      $_SESSION['error']='Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
      exit();
    }

  }else{
    echo 'error';
  }
?>
