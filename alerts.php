<?php
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
