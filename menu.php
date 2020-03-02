     <div class="row" id="topbar">
        <div id="logo" class="col-sm-4 offset-sm-4">
          <i class="fas fa-plane"></i>
          <span>Lotnik</span>
        </div>
     </div>
     <div class="row" id="toolbar">
       <table style="table-layout: fixed; " class="table table-bordered table-dark">
         <thead>
           <tr>
            <th scope="col" data-toggle="tooltip" data-placement="bottom" title="Tworzenie nowych rekordów do raportów.">
                <?php if(isset($_SESSION['id']) && $_SESSION['status']>0){echo '<a href="index.php">Nowy raport';}else{echo 'Nowy raporty';}?></th>
               <th scope="col" data-toggle="tooltip" data-placement="bottom" title="Dodawanie referencji, informacji o referencji, edytowanie istniejących referencji.">
                   <?php if(isset($_SESSION['id']) && $_SESSION['status']>0){echo '<a href="manual.php">Nowy manual </a>';}else{echo 'Nowy manual';}?></th>
             <th scope="col" data-toggle="tooltip" data-placement="bottom" title="Podgląd, edycja i generowanie raportów.">
                 <?php if(isset($_SESSION['id']) && $_SESSION['status']>0){echo '<a href="addRaport.php">Moje raporty';}else{echo 'Moje raporty';}?></th>
             <th scope="col" data-toggle="tooltip" data-placement="bottom" title="Informacje o koncie, zmiana hasła.">
                 <?php if(isset($_SESSION['id']) && $_SESSION['status']>0){echo '<a href="myProfile.php">Mój profil</a>';}else{echo 'Mój profil</i>';}?></th>
             <th scope="col">
                 <?php if(isset($_SESSION['id'])){echo '<a href="logout.php">Wyloguj</a>';}else{echo '<a href="index.php">Zaloguj </a>';}?></th>
           </tr>
         </thead>
       </table>
     </div>
