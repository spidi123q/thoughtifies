
var temp = "";
function nextPage(str) {
var value = parseInt(document.getElementById("show_more_button").value) ;
    if (str.length === 0) {
        document.getElementById("show_more").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
              if(temp ==  xmlhttp.responseText){
                //document.getElementById("show_more").style.visibility = "hidden";
                document.getElementById("show_more_button").disabled = true;
                //document.getElementById("show_more").value= "Hide Filter";
                //document.getElementById("loading").innerHTML = '';
                document.getElementById("show_more_button").innerText = 'no more messages';

              }

              else{
                document.getElementById("show_more_button").value = value + 5;
                //document.getElementById("loading").innerHTML = '';
                document.getElementById("show_more").innerHTML = xmlhttp.responseText;
                temp = xmlhttp.responseText;
              }

            }
        };
        document.getElementById("loading").innerHTML = '<img src="images/web/loading.gif" />'; // Set here the image before sending request
        xmlhttp.open("GET", "src/msg_list.php?page=" + value, true);
        xmlhttp.send();
    }
}
