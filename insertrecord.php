<?php
session_start();
try{
  $id=$_SESSION['id'];
  $data=$_POST['date'];
  $acreg=$_POST['acreg'];
  $ata=$_POST['ata'];
  $kat=$_POST['kat'];
  $maint=$_POST['maint'];
  $taskd=$_POST['taskd'];
  $wo=$_POST['wo'];
  $reference=$_POST['reference'];
}
catch(PDOException $e){
  $_SESSION['error']="Brak zmiennej";
}
try{
  include_once('config.php');
  $pdo = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset='.$charset.'', $user, $password);
  $pdo->query("SET NAMES utf8");
    $prep = $pdo->prepare("SELECT count(*) FROM report WHERE id_user=:id");
    if($prep->execute([':id'=>$id])){
      $raportCount=(int)$prep->fetchColumn();
      if($raportCount == 0)
          {
          $prep = $pdo->prepare("INSERT INTO `report`(`id_user`,`date`) VALUES (:id,:data)");
          if(!$prep->execute([':id'=>$id,':data'=>$data])){
            $flaga="nie udalo sie utworzyc raportu";
            die($flaga);
          }

        }

          $prep = $pdo->prepare("SELECT id FROM report WHERE id_user=:id ORDER BY id DESC LIMIT 1");
          $prep->execute([':id'=>$id]);
          $raportnr=(int)$prep->fetchColumn();

if(isset($_POST['RepIdForNewRecord'])){
    $raportnr = $_POST['RepIdForNewRecord'];
}

          $prep = $pdo -> prepare('SELECT COUNT(id) as total FROM record WHERE id_report=:id_rep');
          if($prep->execute([':id_rep'=>$raportnr])){
            $records = $prep -> fetch();
            $records = $records['total'];
          }else{
            $flaga="Blad: nie mozna pobrac liczby rekordow";
            die($flaga);
          }

          if($records==10){
            $prep = $pdo->prepare("INSERT INTO `report`( `id_user`) VALUES (:id)");
            if($prep->execute([':id'=>$id])){
              $prep = $pdo->prepare("SELECT id FROM report WHERE id_user=:id ORDER BY id DESC LIMIT 1");
              $prep->execute([':id'=>$id]);
              $raportnr=(int)$prep->fetchColumn();
            }else{
              $flaga="Blad: nie mozna stworzyc nowego raportu";
              die($flaga);
            }
          }


          if(!isset($raportnr)){
            die("Blad brak report number");
            exit();
          }
    }else{
      $flaga="Blad: nie mozna pobrac id raportu";
      die($flaga);
    }

  $prep = $pdo->prepare("SELECT count(*) FROM manual WHERE ref=:reference AND id_user=:id");
  if($prep->execute([':reference'=>$reference, ':id'=>$id])){
    $manualCount=(int)$prep->fetchColumn();
    if($manualCount == 0)
        {
        $prep = $pdo->prepare("INSERT INTO `manual`(`ref`, `task_details`, `ata`, `id_user`) VALUES (:reference,:taskd,:ata,:id)");
        $prep->execute([':reference'=>$reference,':taskd'=>$taskd,':ata'=>$ata,':id'=>$id]);
        }
    $prep = $pdo->prepare("SELECT * FROM manual WHERE ref=:reference AND id_user=:id LIMIT 1");
    $prep->execute([':reference'=>$reference, ':id'=>$id]);
    $dane=$prep->fetchAll();
    $id_manual=$dane[0]['id'];
  }else{
    $flaga="Blad: nie mozna obrac manuala";
    die($flaga);
  }



  $prep = $pdo->prepare("INSERT INTO `record`(`id_manual`, `id_report`, `id_user`, `date`, `b`, `cat`, `ac_reg`, `wo_number`)
  VALUES (:idmanual,:idraport,:iduser,:data,:b,:cat,:acreg,:wonumber)");
  if($prep->execute([':idmanual'=>$id_manual,':idraport'=>  $raportnr,':iduser'=>$id,':data'=>$data,':b'=>$maint,':cat'=>$kat,':acreg'=>$acreg,':wonumber'=>$wo])){

  }else{
    $flaga="Blad: nie mozna dodac rekordu";
    die($flaga);
  }


  $prep = $pdo -> prepare('SELECT COUNT(id) as total FROM record WHERE id_report=:id_rep');
  if($prep->execute([':id_rep'=>$raportnr])){
    $records = $prep -> fetch();
    $records = $records['total'];
  }else{
    $flaga="Blad: nie mozna pobrac liczby rekordow";
    die($flaga);
  }


  if($records==10 & !isset($_POST['RepIdForNewRecord'])){
    $prep = $pdo->prepare("INSERT INTO `report`( `id_user`) VALUES (:id)");
    if($prep->execute([':id'=>$id])){

    }else{
      $flaga="Blad: nie mozna stworzyc nowego raportu";
      die($flaga);
    }
  }
  if(!isset($flaga)){
    $_SESSION['info']="Pomyslnie dodano rekord";
if(isset($_POST['RepIdForNewRecord'])){
    header("location:addRaport.php");
}
else
    header("location:index.php");
    exit();
  }
}catch(PDOException $e){
  echo "Blad przy dodawaniu manuala do bazy";
}
?>
