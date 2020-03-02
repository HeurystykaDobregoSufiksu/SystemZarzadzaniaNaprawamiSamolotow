<?php
  session_start();
  //$_SESSION['id']=123;
  if(!isset($_SESSION['id']) || $_SESSION['status']==0){
      $_SESSION['error']='Brak praw dostępu';
      header("location:index.php");
      exit();
  }
  if(isset($_SESSION['info'])){
    $info=$_SESSION['info'];
    echo "
    <script>
      alert('$info');
    </script>";
    unset($_SESSION['info']);
  }
  if(isset($_SESSION['error'])){
    $error=$_SESSION['error'];
    echo "
    <script>
      alert('$error');
    </script>";
  unset($_SESSION['error']); }
?>

 <html>
 <head>
<?php include_once('head.php'); ?>
 </head>
 <body>
   <div class="main container-fluid">
<?php include_once('menu.php'); ?>
     <div class="row" id="contentarea">

     </div>
   </div>
 </body>
</html>
