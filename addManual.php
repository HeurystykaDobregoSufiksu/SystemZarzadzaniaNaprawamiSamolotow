<?php
  session_start();
  $_SESSION['error']='';
  if(isset($_POST['man']))
  {
    $ifAll=true;
    for($i=0;$i<=$_POST['hiddenValue'];$i++)
    {
      $flag=true;
      $ref=$_POST['ref'.$i];
      $ata=$_POST['ata'.$i];
      $id=$_SESSION['id'];
      $details=$_POST['details'.$i];

      if(strlen($ref)>80 || strlen($ref)<10)
      {
        $flag=false;
        $ifAll=false;
      }
      if(strlen($ata)>6 || strlen($ref)<4)
      {
        $flag=false;
        $ifAll=false;
      }
      if(strlen($details)<10)
      {
        $flag=false;
        $ifAll=false;
      }

      try{
        include_once('config.php');
          $pdo = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset='.$charset.'', $user, $password);
        $pdo->query("SET NAMES utf8");
        $prep = $pdo->prepare("SELECT count(*) FROM manual WHERE ref=:ref AND id_user=:id");
        $prep->execute([':ref'=>$ref,':id'=>$id]);
        $isReference=(int)$prep->fetchColumn();
        var_dump($isReference);
        if($isReference!=0){
          $flag=false;
          $ifAll=false;
        }
        if($flag){
          $prep = $pdo->prepare("INSERT INTO manual VALUES ('null',:ref,:task_details,:ata,:uid,'0')");
          $prep->execute([':ref'=>$ref,':task_details'=>$details,':ata'=>$ata,':uid'=>$id]);
          $pdo=null;
        }else{
          $_SESSION['error']=$_SESSION['error'].'\n'.$ref;
        }

      }catch(PDOException $e){
        $_SESSION['error']='Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
        header("location: index.php");
        exit();
      }
    }
    if($ifAll)
    {
      $_SESSION['info']='Poprawinie dodano wszystkie rekordy w manualu';
      unset($_SESSION['error']);
    }else{
      $_SESSION['error']='Oto rekordy które nie zostały dodane:'.$_SESSION['error'];
    }
    header("location: manual.php");
    exit();
  }
