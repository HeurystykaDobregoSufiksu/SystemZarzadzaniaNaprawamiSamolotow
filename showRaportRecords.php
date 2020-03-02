<?php
$values = $_SESSION['recordsFromReport'];
$id_rep = $_SESSION['id_report'];

$how = 0;
try{
    include_once('config.php');
    $pdoN = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset='.$charset.'', $user, $password);
    $pdoN->query("SET NAMES utf8");
    $prepp = $pdoN->prepare("SELECT id FROM record WHERE id_report=:id_rep ORDER BY date");
    $prepp->execute([':id_rep'=>$id_rep]);
    $recordss=$prepp->fetchAll();
    $how = sizeof($recordss);

    $pdoN = null;
}
catch(PDOException $e){
    $_SESSION['error']='Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
    header("location: ../addRaport.php");
    exit();
}



echo '
        <table style="text-align:center" class="table table-striped">
           <thead>
             <tr>
                <th style="width: 10%" scope="col">Date</th>
                <th style="width: 3%" scope="col">A\C Reg.</th>
                <th style="width: 5%" scope="col">ATA</th>
                <th style="width: 25%" scope="col">Task Detail/Task Number</th>
                <th style="width: 15%" scope="col">Reference AMM/CMM</th>
                <th style="width: 5%" scope="col">W/O Number</th>
                <th style="width: 1%" scope="col">Base Main</th>
                <th style="width: 1%" scope="col">Line Main</th>
                <th style="width: 1%" scope="col">B1</th>
                <th style="width: 1%" scope="col">B2</th>
                <th style="width: 1%" scope="col"></th>
                <th style="width: 1%" scope="col"></th>
             </tr>
           </thead>
';


for($i = 0; $i < 10; $i++){
echo'
           <tbody>
            <tr>';

for($j = 0; $j < 10; $j++){
    echo '<td>'.$values[$i][$j].'</td>';
}

if($i < $how){
$rowId = $recordss[$i][0];
echo '

<td data-toggle="tooltip" data-placement="bottom" title="Edytuj rekord">
<form action="editRecord.php" method="POST">
<input type="hidden" value="'.$rowId.'">
<button type="submit" style="width:100%" class="btn btn-dark"><i class="fa fa-wrench"></i></button></form></td>

<td data-toggle="tooltip" data-placement="bottom" title="Usuń rekord">
<form action="removeRecord.php" method="POST">
<input type="hidden" name="record_id" value="'.$rowId.'">
<button type="submit" style="width:100%" class="btn btn-info"><i class="fa fa-trash"></i></button></form></td>
';
}
else{
echo'
<td colspan="2" data-toggle="tooltip" data-placement="bottom" title="Dodaj rekord">
<form action="index.php" method="POST">
<input type="hidden" name="id_report" value="'.$id_rep.'">
<button type="submit"'; if($how == 0) echo 'style="width:100%"'; else echo 'style="width:40%"'; echo'class="btn btn-success"><i class="fa fa-plus-circle" aria-hidden="true"></i></button></form></td>
';
}
echo'
            </tr>
           </tbody>';
}
echo '</table>';

unset($_SESSION['id_report']);
unset($_SESSION['recordsFromReport']);
?>