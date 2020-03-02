<?php
  session_start();
  if(!isset($_SESSION['id']) || $_SESSION['status']==0){
      $_SESSION['error']='Brak praw dostępu';
      header("location:index.php");
      exit();
  }
?>

 <html>
 <head>
<?php include_once('head.php'); ?>
 </head>
 <body>
<script type="text/javascript">
function changeNumpage(ele) {
    if(ele.value != ''){
    var numpage = ele.value;
    let reportId = ele.offsetParent.children[1].value;

           var ajaxRequest;  // The variable that makes Ajax possible!
 
           try {
              // Opera 8.0+, Firefox, Safari
              ajaxRequest = new XMLHttpRequest();
           } catch (e) {
 
              // Internet Explorer Browsers
              try {
                 ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
              } catch (e) {
 
                 try {
                    ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
                 } catch (e) {
                    // Something went wrong
                    alert("Your browser broke!");
                    return false;
                 }
              }
           }
           // Create a function that will receive data
           // sent from the server and will update
           // div section in the same page.
           // Now get the value from user and pass it to
           // server script.
 
           ajaxRequest.open("GET", "updateNumpage.php?numpage=" + numpage+"&reportId="+reportId, true);
           ajaxRequest.send(null);
    }
        }
</script>
     <?php
       if(isset($_SESSION['file'])){
           $filename = $_SESSION['file'];
if(file_exists($filename)){

    //Get file type and set it as Content Type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    header('Content-Type: ' . finfo_file($finfo, $filename));
    finfo_close($finfo);

    //Use Content-Disposition: attachment to specify the filename
    header('Content-Disposition: attachment; filename='.basename($filename));

    //No cache
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');

    //Define file size
    header('Content-Length: ' . filesize($filename));

    ob_clean();
    flush();
    readfile($filename);
    unlink($filename);
    exit;
}
  unset($_SESSION['file']); }
     ?>
     <div class="main container-fluid">
         <?php include_once('menu.php'); ?>
         <div class="col-sm-8 offset-sm-2">
        <table style="text-align:center" class="table table-striped">
           <thead>
             <tr>
                <th style="width: 15%" scope="col">Data utworzenia raportu:</th>
                <th style="width: 15%" scope="col">Ilość rekordów:</th>
                <th style="width: 10%" scope="col">Numer strony:</th>
                <th style="width: 15%" scope="col"></th>
                <th style="width: 15%" scope="col"></th>
                <th style="width: 15%" scope="col"></th>
             </tr>
           </thead>
            </table>
             <?php include_once('alerts.php'); ?>
            <?php
            try
			{
					include_once('config.php');
					$pdo = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset='.$charset.'', $user, $password);
					$pdo->query("SET NAMES utf8");
					$prep = $pdo->prepare("SELECT id,date,numpage FROM report WHERE id_user=:user ORDER BY date DESC");
					$prep->execute([':user'=>$_SESSION['id']]);
					$reports=$prep->fetchAll();

                foreach($reports as $row){
                    $date = $row[1];
                    $id_rep = $row[0];
                    $numpage = $row[2];
                    $prep = $pdo -> prepare('SELECT COUNT(id) as total FROM record WHERE id_report=:id_rep');
                    $prep->execute([':id_rep'=>$id_rep]);
                    $records = $prep -> fetch();
                    $records = $records['total'];
                    echo '
                    <table style="text-align:center" class="table table-striped">
           <thead>
             <tr>
                <th style="width: 15%" scope="col"></th>
                <th style="width: 15%" scope="col"></th>
                <th style="width: 10%" scope="col"></th>
                <th style="width: 15%" scope="col"></th>
                <th style="width: 15%" scope="col"></th>
                <th style="width: 15%" scope="col"></th>
             </tr>
           </thead>
            <form action="converter/generate.php" method="POST">
           <tbody>
            <tr>
              <td>'.$date.'</td>
              <td>'.$records.'/10</td>
              <td><input onkeyup="changeNumpage(this)" onChange="changeNumpage(this)" name="number" type="number" min="1" style="width:100%" value="'.$numpage.'"><input type="hidden" name="idReport" value="'.$id_rep.'"></td>
              <td><button type="submit" style="width:100%" name="gen" class="btn btn-dark">Generuj raport <i class="fa fa-download"></i></button></td>';
                if($records == 0)
            echo'<td><button type="submit" style="width:100%" name="del" class="btn btn-danger">Usuń pusty <i class="fa fa-trash"></i></button></td>';
            else
            echo'<td></td>';
            echo'
              <td><button type="submit" style="width:100%" name="show" class="btn btn-info">Podgląd ';
            if(isset($_SESSION['id_report'])){
                if($id_rep == $_SESSION['id_report'])
                    echo'<i class="fa fa-angle-double-up"></i><input type="hidden" name="pressBtn" value="1">';
                else
                    echo'<i class="fa fa-angle-double-down"></i>';
            }
            else
                    echo'<i class="fa fa-angle-double-down"></i>';
            echo'</button></td>
            </tr>
           </tbody>
            </form>
            </table>
                    ';
                if(isset($_SESSION['id_report']))
                    if($id_rep == $_SESSION['id_report']){
                        include_once('showRaportRecords.php');
                    }
                }
            exit();
			}
			catch(PDOException $e)
			{
        $_SESSION['error']='Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
        header("location: addRaport.php");
        exit();
			}
            ?>
         </div>
     </div>
 </body>
</html>
