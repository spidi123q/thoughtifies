function showDate() {
    alert ("this works");
}
var temp = "";
function displayProfile(str,id) {

  if(id == 'alas_block'){
    alert("blocked");
  }
  else {
    if (str.length === 0) {
        document.getElementById("bodyPart").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
              if(temp ==  xmlhttp.responseText){
                //document.getElementById("show_more").style.visibility = "hidden";


              }

              else{

                document.getElementById("bodyPart").innerHTML = xmlhttp.responseText;
                temp = xmlhttp.responseText;
              }

            }
        };
         // Set here the image before sending request
        xmlhttp.open("GET", "profile.php?id=" + id, true);
        xmlhttp.send();
    }
  }


}
