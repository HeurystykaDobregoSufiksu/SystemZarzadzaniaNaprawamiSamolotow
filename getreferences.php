<?php
$reference = $_GET['ref'];
session_start();
$id=$_SESSION['id'];
try{
  $pdo = new PDO('mysql:host=localhost;dbname=lotnictwo;charset=utf8', 'root', '');
  $pdo->query("SET NAMES utf8");
}	catch(PDOException $e)
  {
    echo "Blad: Przy polaczeniu z baza danych. $e->getMessage()";
    exit();
}
try{
    $prep = $pdo->prepare("SELECT * FROM manual WHERE `ref` LIKE ? ORDER BY using_count DESC");
    $prep->execute(array("$reference%"));

}catch(PDOException $e){
  echo "Blad: Przy zapytaniu do bazy danych . $e->getMessage()";
  exit();
}

$data=$prep->fetchAll();
foreach($data as $row) {
  $tdetails=$row['task_details'];?>
  <button type="button" onmouseover="xd(1,<?="'".$tdetails."'"?>,<?="'".$row['ref']."'"?>,<?="'".$row['ata']."'"?>)" onclick="xd(0,<?="'".$tdetails."'"?>,<?="'".$row['ref']."'"?>,<?="'".$row['ata']."'"?>)"
     style="<?php if($id==$row['id_user']){echo"border-left: 5px solid green;";}?>width:100%;height: 5vh; box-shadow: none;border-radius: 0px;"
     class="btn btn-default"><?=$row['ref']?></button>
<?php }?>
