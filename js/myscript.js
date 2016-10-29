function showDate() {
    alert ("this worksi");
}
var temp = "";
var index = 1;
function showHint(str) {

    if (str.length === 0) {
        document.getElementById("message_display").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
              if(temp ==  xmlhttp.responseText){
                //document.getElementById("show_more").style.visibility = "hidden";
                document.getElementById("show_more").disabled = true;
                //document.getElementById("show_more").value= "Hide Filter";
                document.getElementById("loading").innerHTML = '';
                document.getElementById("show_more").innerText = 'no more messages';

              }

              else{
                document.getElementById("loading").innerHTML = '';
                document.getElementById("message_display").innerHTML = xmlhttp.responseText;
                temp = xmlhttp.responseText;
              }

            }
        };
        document.getElementById("loading").innerHTML = '<img src="images/web/loading.gif" />'; // Set here the image before sending request
        xmlhttp.open("GET", "src/display_message.php?q=" + str, true);
        xmlhttp.send();
    }
}

function sentInterest(str) {
  var id = document.getElementById("username").innerText;

    if (str.length === 0) {
        document.getElementById("i_butt").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
              document.getElementById("interestButt").innerText='Interest sented';

            }
        };
         // Set here the image before sending request
        xmlhttp.open("GET", "profile.php?interest=" + id, true);
        xmlhttp.send();
    }
}

function sentInteresti(str,id) {

    if (str.length === 0) {
        document.getElementById("i_butt").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
              document.getElementById('butt_'+id).innerText='Interest sented';
              document.getElementById('butt_'+id).disabled = true;

            }
        };
         // Set here the image before sending request
        xmlhttp.open("GET", "src/display_search.php?interest=" + id, true);
        xmlhttp.send();
    }
}



function paging(){
  //document.getElementById ("show_mor").addEventListener ("click", alert(6), false);
      if (0) {
      } else {
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
              if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                  //document.getElementById("show_more").style.visibility = "hidden";
                  //document.getElementById("show_more").disabled = true;
                  //document.getElementById("show_more").value= "Hide Filter";
                  //document.getElementById("loading").innerHTML = '';
                  //document.getElementById("show_more").innerText = 'no more messages';

                    document.getElementById("search2").innerHTML = xmlhttp.responseText;

                  //document.getElementById("loading").innerHTML = '';

                  //temp = xmlhttp.responseText;
              }
          };
          //document.getElementById("loading").innerHTML = '<img src="images/web/loading.gif" />'; // Set here the image before sending request
          xmlhttp.open("GET", "src/display_search.php?q="+1, true);
          xmlhttp.send();
      }


}
