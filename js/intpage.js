function m(){
  alert("hi");
}
  var temp;
function interestPaging( tab){
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
                  if (xmlhttp.responseText === temp) {
                    alert("end");
                  }
                  else {
                    //alert(xmlhttp.responseText);
                    document.getElementById("interestBody").innerHTML = '';
                    //document.getElementById("interestTabs").innerHTML = '';

                    document.getElementById("interestBody").innerHTML = xmlhttp.responseText;
                  }
                  //document.getElementById("loading").innerHTML = '';

                  //temp = xmlhttp.responseText;
                  temp = xmlhttp.responseText;
              }
          };
          //document.getElementById("loading").innerHTML = '<img src="images/web/loading.gif" />'; // Set here the image before sending request
          xmlhttp.open("GET", "src/methods/interest_disp.php?ilimit="+1+"&tab="+tab, true);
          xmlhttp.send();
      }


}
