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
   <div class="main container-fluid">
<?php include_once('menu.php'); ?>
     <div class="row" id="contentarea">
         <div class="col-sm-6 offset-sm-3">
           <div class="row">
         <form class="col-sm-6" style="border-right:1px solid black" action="saveChanges.php" id="rejestracja" method="POST">
           <center><h3>Moje dane</h3></center>
             <?php
                    $name = $_SESSION['name'];
                    $surname = $_SESSION['surname'];
                    $email = $_SESSION['email'];
             ?>
            <div data-toggle="tooltip" data-placement="bottom" title="Imię i nazwisko wymagane do generowania raportów.">
           <div class="form-group" >
             <label for="subject">Imię:</label>
             <input required type="text" required minlength="1" required maxlength="30" class="form-control" name="name" value="<?php echo $name; ?>">
           </div>
           <div class="form-group">
             <label for="subject">Nazwisko:</label>
             <input required type="text" required minlength="1" required maxlength="30" class="form-control" name="surname" value="<?php echo $surname; ?>">
           </div>
             </div>
           <div class="form-group">
             <label for="subject">Email:</label>
             <input required type="email" minlength="1" class="form-control" name="email" value="<?php echo $email; ?>">
           </div>
           <button type="submit" style="width:100%" class="btn btn-dark">Zapisz dane <i class="fa fa-unlock-alt"></i></button>
         </form>
         <form class="col-sm-6" action="changePass.php" id="logowanie" method="POST">
           <center><h3>Zmiana hasła</h3></center>
           <div class="form-group">
             <label for="subject">Stare hasło:</label>
             <input required type="password" required minlength="8" required maxlength="50" class="form-control"  name="passOld">
           </div>
           <div class="form-group">
             <label for="subject">Nowe hasło:</label>
             <input required type="password" required minlength="8" required maxlength="50" class="form-control"  name="pass1">
           </div>
           <div class="form-group">
             <label for="subject">Powtórz nowe hasło:</label>
             <input required type="password" required minlength="8" required maxlength="50" class="form-control"  name="pass2">
           </div>
           <button type="submit" style="width:100%" class="btn btn-dark">Zmień hasło <i class="fa fa-unlock-alt"></i></button>
         </form>
       </div>
       </div>
     </div>
   </div>
 </body>
</html>
<?php include_once('alerts.php'); ?>
