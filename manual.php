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
     <div class="col-sm-8 offset-sm-2" id="contentarea">
       <form class="row" action="addManual.php" id="manual" method="POST">
         <table style="text-align:center" class="table table-striped" id="formTable">
           <thead>
             <tr>
               <th style="width: 35%" scope="col">Reference</th>
               <th style="width: 15%" scope="col">ATA</th>
               <th style="width: 50%" scope="col">Task details</th>
               <th style="width: 1%" scope="col"></th>
               <th style="width: 1%" scope="col"></th>
             </tr>
           </thead>
           <tbody>
            <tr>
              <td>
                <input onchange="ataFiller(0)" required type="text" style="border-radius: 0px" required minlength="10" required maxlength="80" class="form-control" name="ref0">
              </td>
              <td>
                <input required type="text" style="border-radius: 0px" required minlength="4" required maxlength="6" class="form-control" name="ata0">
              </td>
              <td>
                <input required type="text" style="border-radius: 0px" required minlength="10" required maxlength="200" class="form-control" name="details0">
              </td>
            </tr>
          </tbody>
         </table>
         <input type="hidden" id="globalValue" name="hiddenValue" value="0">
         <button type="submit" style="width:100%; margin-top:1vh" class="btn btn-info" name="man">Zapisz referencje <i class="fa fa-unlock-alt"></i></button>
       </form>
       <table style="text-align:center" class="table table-striped" id="formTable">
         <thead>
           <tr>
             <th style="width: 35%" scope="col">Reference</th>
             <th style="width: 15%" scope="col">ATA</th>
             <th style="width: 50%" scope="col">Task details</th>
           </tr>
         </thead>
         <tbody>
           <?php
           $i=0;
           $id=$_SESSION['id'];
           try{
             $pdo = new PDO('mysql:host=localhost;dbname=lotnictwo;charset=utf8', 'root', '');
             $pdo->query("SET NAMES utf8");
             $prep = $pdo->prepare("SELECT ref,ata,task_details FROM manual WHERE id_user=:id");
             $prep->execute([':id'=>$id]);
             $data=$prep->fetchAll();
             foreach($data as $col)
             {

               echo'<tr data-toggle="tooltip" data-placement="bottom" title="Kliknij dwukrotnie, aby edytować.">
               <td><p ondblclick="showAndHideArea(tref'.$i.',this)" id="pref'.$i.'">'.$col['ref'].'</p><textarea rows="2" cols="20" onkeypress="if(event.keyCode==13){this.blur();}" onfocusout="showAndHideArea(pref'.$i.',this)" onchange="change(tref'.$i.',tata'.$i.',ttd'.$i.',pref'.$i.',pata'.$i.',ptd'.$i.')" style="display:none" id="tref'.$i.'">'.$col['ref'].'</textarea></td>

               <td><p ondblclick="showAndHideArea(tata'.$i.',this)" id="pata'.$i.'">'.$col['ata'].'</p><textarea rows="2" cols="10" onkeypress="if(event.keyCode==13){this.blur();}" onfocusout="showAndHideArea(pata'.$i.',this)" onchange="change(tref'.$i.',tata'.$i.',ttd'.$i.',pref'.$i.',pata'.$i.',ptd'.$i.')" style="display:none" id="tata'.$i.'">'.$col['ata'].'</textarea></td>
               <td><p ondblclick="showAndHideArea(ttd'.$i.',this)" id="ptd'.$i.'">'.$col['task_details'].'</p><textarea rows="3" cols="50" onkeypress="if(event.keyCode==13){this.blur();}" onfocusout="showAndHideArea(ptd'.$i.',this)" onchange="change(tref'.$i.',tata'.$i.',ttd'.$i.',pref'.$i.',pata'.$i.',ptd'.$i.')" style="display:none" id="ttd'.$i.'">'.$col['task_details'].'</textarea></td>
               </tr>
               ';
               $i++;
             }
             $pdo=null;
           }catch(PDOException $e){
             $_SESSION['error']='Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
             header("location: index.php");
             exit();
           }
          ?>
        </tbody>
       </table>
     </div>
   </div>
   <script>
   function addRowInTable()
   {
     if ( typeof addRowInTable.counter == 'undefined' ) {
       addRowInTable.counter = 1;
     }
     var table = document.getElementById("formTable");
     var row = table.insertRow(addRowInTable.counter+1);
     var cell1 = row.insertCell(0);
     var cell2 = row.insertCell(1);
     var cell3 = row.insertCell(2);
     cell1.innerHTML='<input onchange="ataFiller('+addRowInTable.counter+')" required type="text" style="border-radius: 0px" required minlength="10" required maxlength="80" class="form-control" name="ref'+addRowInTable.counter+'">';
     cell2.innerHTML='<input required type="text" style="border-radius: 0px" required minlength="4" required maxlength="6" class="form-control" name="ata'+addRowInTable.counter+'">'
     cell3.innerHTML='<input required type="text" style="border-radius: 0px" required minlength="10" required maxlength="200" class="form-control" name="details'+addRowInTable.counter+'">'
     var val= document.getElementById("globalValue");
     val.value=addRowInTable.counter;
     addRowInTable.counter++;
       moveButtons();
   }
   function deleteRowInTable()
   {
     if (addRowInTable.counter > 1) {
       var table = document.getElementById("formTable");
       var row = table.deleteRow(addRowInTable.counter);
       addRowInTable.counter--;
         moveButtons();
     }
   }

    function moveButtons(){
        if(document.getElementById('addBtn')){
            var element = document.getElementById("addBtn");
            element.parentNode.removeChild(element);
            element = document.getElementById("delBtn");
            element.parentNode.removeChild(element);
        }

        let table = document.getElementById("formTable");
        let tbody = table.lastElementChild;
        let tr  = tbody.lastElementChild;
        let tdAdd = document.createElement('td');
        tdAdd.id = 'addBtn';
        tdAdd.innerHTML = '<button type="button" onclick=\'addRowInTable()\' style="width:100%; margin-right:2.5%; margin-left:2.5%" class="btn btn-success" name="man" data-toggle="tooltip" data-placement="bottom" title="Dodaj kolejny"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>';
        let tdDel = document.createElement('td');
        tdDel.id = 'delBtn';
        tdDel.innerHTML = '<button type="button" onclick=\'deleteRowInTable()\' style="width:100%; margin-right:2.5%; margin-left:2.5%" class="btn btn-danger" name="man" data-toggle="tooltip" data-placement="bottom" title="Usuń ostatni"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>';
        tr.appendChild(tdAdd);
        tr.appendChild(tdDel);
    }

   function getAtaCode(refValue)
   {
     var i = refValue.search(/[0-9]/g);
     return refValue.slice(i,i+5);
   }
   function ataFiller(i)
   {
     var ref = document.getElementsByName("ref"+i)[0];
     var ata = document.getElementsByName("ata"+i)[0];
     if(ref.value.length>3+5)
     {
       ata.value=getAtaCode(ref.value);
     }
   }
   moveButtons();
   function showAndHideArea(idToShow,idToHide)
   {
     idToShow.style.display='inline';
     if(idToShow.tagName=="TEXTAREA")
     {
       idToShow.focus();
       idToShow.selectionStart = idToShow.selectionEnd = idToShow.value.length;
     }
     idToHide.style.display='none';
   }
   function change(tref,tata,ttd,pref,pata,ptd)
   {
     tref.value=tref.value.replace(/\n/g, '');
     tata.value=tata.value.replace(/\n/g, '');
     ttd.value =ttd.value.replace(/\n/g, '');

     if(tref.value!=pref.innerHTML)
     {
       var temp = getAtaCode(tref.value)
       tata.value=(temp==''?tata.value:temp)
     }

     const newValue={ref:tref.value,
                     ata:tata.value,
                     old_ref:pref.innerHTML,
                     task_details:ttd.value};
     var xhtml=new XMLHttpRequest();
     xhtml.onreadystatechange= function(){
       if(this.readyState==4 && this.status==200)
       {
         console.log(this.responseText);
         if(this.responseText=='good')
         {
           pref.innerHTML=tref.value;
           pata.innerHTML=tata.value;
           ptd .innerHTML=ttd.value;
         }else if(this.responseText=='error'){
           alert('błąd podczas zmiany');
           tref.value=pref.innerHTML;
           tata.value=pata.innerHTML;
           ttd .value=ptd .innerHTML;
         }
      }
     };
     xhtml.open("POST","manualUpdate.php",true);
     xhtml.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
     xhtml.send("manualChange="+JSON.stringify(newValue));
   }
   </script>
 </body>
</html>
<?php include_once('alerts.php'); ?>
