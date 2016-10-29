function showDate() {
  var value = parseInt(document.getElementById("show_more_button").value) ;
  console.log(value);
    alert (value);
    document.getElementById("show_more_button").value = value + 5;
    document.getElementById("search2").innerHTML = "haiiihhhhhhhhhhhhhhhhhii";
}
var temp = "";
function searchPages(str) {
    var value = parseInt(document.getElementById("show_more_button").value) ;

    if (str.length === 0) {
        document.getElementById("search2").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                        if(xmlhttp.responseText == "0 results"){
                          document.getElementById("search2").innerHTML = temp;
                          document.getElementById("show_more_button").disabled = true;
                          document.getElementById("show_more_button").innerText = 'no more result';
                        }
                        else {
                          document.getElementById("show_more_button").value = value + 5;
                          //document.getElementById("loading").innerHTML = '';
                          document.getElementById("search2").innerHTML = xmlhttp.responseText;
                          temp =  xmlhttp.responseText;
                        }







            }
        };

        //document.getElementById("loading").innerHTML = '<img src="images/web/loading.gif" />'; // Set here the image before sending request
        xmlhttp.open("GET", "src/display_search.php?slimit=" + value, true);

        xmlhttp.send();
    }
}
