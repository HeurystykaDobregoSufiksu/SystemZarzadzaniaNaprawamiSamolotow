function xd(flag,details,re,ata){
  if(flag==0){
    var ata = document.getElementById('ata').value=ata;
    var refvalue = document.getElementById('reference').value=re;
    var taskdetails = document.getElementById('taskdetails').value=details;
    document.getElementById("tips").style="display:none";


  }else{
      var taskdetails = document.getElementById('taskdetails').placeholder=details;
    var ata = document.getElementById('ata').placeholder=ata;
    var refvalue = document.getElementById('reference').placeholder=re;

  }

}

function showref() {
            var ref = document.getElementById('reference').value

            document.getElementById("tips").style="display:inline";
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
           ajaxRequest.onreadystatechange = function() {

              if(ajaxRequest.readyState == 4) {
                 var ref = document.getElementById('tips');
                 ref.innerHTML = ajaxRequest.responseText;
              }
           }
           // Now get the value from user and pass it to
           // server script.

           ajaxRequest.open("GET", "getreferences.php?ref=" + ref, true);
           ajaxRequest.send(null);

        }
        //-->
