function m(){
  alert("df");
}


function usernameCheck(){
  var value = document.getElementById('username_val').value;
  if (0) {
  } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {


              document.getElementById("username_check").innerHTML = '';
              if(xmlhttp.responseText === '0'){
                document.getElementById("username_check").innerHTML = 'username not available';
              }
              else{
                document.getElementById("username_check").innerHTML = "available";
              }


          }
      };
      //document.getElementById("loading").innerHTML = '<img src="images/web/loading.gif" />'; // Set here the image before sending request
      xmlhttp.open("GET", "src/methods/username_check.php?check="+value, true);
      xmlhttp.send();
  }
}
