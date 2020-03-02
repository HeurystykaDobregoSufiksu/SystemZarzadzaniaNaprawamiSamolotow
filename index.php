<?php session_start();
  date_default_timezone_set('Europe/Warsaw');
  $date = date('Y-m-d', time());
?>

 <html>
 <head>
<?php include_once('head.php'); ?>
 </head>
 <body>
   <script src="ajaxshowref.js"></script>
   <div class="main container-fluid">
<?php include_once('menu.php'); ?>
     <div class="row" id="contentarea">
       <?php if(isset($_SESSION['id'])){?>
        <table style="text-align:center" class="table table-striped">
           <thead>
             <tr>
               <th style="width: 10%" scope="col">Date</th>
               <th style="width: 10%" scope="col">A/C Reg</th>
               <th style="width: 7.5%"scope="col">ATA</th>
               <th style="width: 30%" scope="col">Task details</th>
               <th style="width: 30%"scope="col">Reference</th>
               <th style="width: 7.5%"scope="col">W/O number</th>
               <th style="width: 5%"scope="col">Kat</th>
             </tr>
           </thead>
           <tbody>
            <tr>
              <form action="insertrecord.php" method="POST">
              <td><input required type="date" style="width:100%" name="date" value="<?=$date?>"></td>
              <td><input required minlength="1" required type="text" id="acreg" name="acreg" style="width:100%" value="El-"></td>
              <td>
                <input required minlength="1" required type="text" id="ata" name="ata" style="width:100%" value=""></td>
              </td>
              <td><textarea id="taskdetails"style="width:100%; max-height:20vh;" required type="text" rows="3" required minlength="1" required maxlength="500" class="form-control" name="taskd"></textarea></td>
              <td id="refe"><input onkeyup="showref()" id="reference" required minlength="1" required type="text" style="width:100%" name="reference">
                <div id="tips" style="width:100%; height:10vh;">
                  Manuale dodane przez ciebie są oznaczone kolorem zielonym.
                </div>
            </td>
              <td><input required minlength="1" required type="text" style="width:100%" name="wo"><br></td>
              <td><div class="form-group">
                <select class="form-control" value="1" placeholder="B2" name="kat">
                  <option value="0">B1</option>
                  <option value="1">B2</option>
                </select>
              </div>
              <h5>Maintenence</h5>
              <div class="form-group">
                <select class="form-control" value="0" placeholder="Base" name="maint">
                  <option value="0">Base</option>
                  <option value="1">Line</option>
                </select>
              </div>
            <?php include_once('addNextRecord.php');?>
            <button type="submit" style="width:100%; margin-top:2vh" class="btn btn-dark">Dodaj rekord</button></td>
            </tr>
          </form>
           </tbody>
         </table>
         <div id="refarea" class="col-sm-12"></div>

       <?php }else{?>
         <div class="col-sm-6 offset-sm-3">
           <div class="row">
         <form class="col-sm-6" style="border-right:1px solid black" action="register.php" id="rejestracja" method="POST">
           <center><h3>Rejestracja</h3></center>
           <div class="form-group">
             <label for="subject">Imię:</label>
             <input required type="text" required minlength="1" required maxlength="30" class="form-control" name="name">
           </div>
           <div class="form-group">
             <label for="subject">Nazwisko:</label>
             <input required type="text" required minlength="1" required maxlength="30" class="form-control" name="surname">
           </div>
           <div class="form-group">
             <label for="subject">Email:</label>
             <input required type="email" minlength="1" class="form-control" name="email">
           </div>
           <div class="form-group">
             <label for="subject">Haslo:</label>
             <input required type="password" required minlength="8" required maxlength="50" class="form-control"  name="pass1">
           </div>
           <div class="form-group">
             <label for="subject">Powtorz haslo:</label>
             <input required type="password" required minlength="8" required maxlength="50" class="form-control"  name="pass2">
           </div>
           <button type="submit" style="width:100%" class="btn btn-default">Zarejestruj się</button>
         </form>
         <form class="col-sm-6" action="login.php" id="logowanie" method="POST">
           <center><h3>Logowanie</h3></center>
           <div class="form-group">
             <label for="subject">Email:</label>
             <input required type="email" minlength="1" class="form-control" name="email">
           </div>
           <div class="form-group">
             <label for="subject">Haslo:</label>
             <input required type="password" minlength="1" class="form-control" name="pass1">
           </div>
           <button type="submit" style="width:100%" class="btn btn-default">Zaloguj się</button>
         </form>
       </div>
       </div>
       <?php }?>
     </div>
   </div>
   <script>

    function addref() {
        alert("XDD");
        var xdd=document.getElementById("addreference");
        var x = document.createElement("INPUT");
        x.style="margin-top:2vh; width:100%";
        var xd=document.getElementById("refe").insertBefore(x,xdd);
    }
    </script>
 </body>
</html>
<?php include_once('alerts.php'); ?>
