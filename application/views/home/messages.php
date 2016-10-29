<table class="">
  <tr>
    <div id="message_tab" class="row">
      <td>
        <div class="col-xs-4">
              <div id="list_users">
            </div>
        </div>
      </td>
      <td>
          <div id="messages" class="col-xs-8">
      </td>



      </div>
    </div>

</tr>
</table>
<script>
$( function (){

  listMsgUser();

});


function listMsgUser(){
  /*----------------------------------------------------------*/
  //initilize list_users
  /*----------------------------------------------------------*/
  $.post("src/sel_select.php",
  {
      //name: "Donald Duck",
      messagelist: "1",
  },
  function(data, status){
      //alert("Data: " + data + "\nStatus: " + status);
         //$('#loadingmessage').hide();
      $("#list_users" ).html( data );

  })
      .done(function() {
       //alert( "second success" );
     })
     .fail(function() {
       alert( "error" );
     })
     .always(function() {
       //alert( "finished" );
   });
   /*----------------------------------------------------------*/
}


/*----------------------------------------------------------
     load messages
----------------------------------------------------------*/
function loadUserMsg(username){

  msgUser = username;

  $( "#message_tab div" ).first().addClass( "hidden-xs" );

  $.post("src/sel_select.php",
  {
      //name: "Donald Duck",
      userid: username,
  },
  function(data, status){
      //alert("Data: " + data + "\nStatus: " + status);
         //$('#loadingmessage').hide();
      $("#message_tab #messages" ).html( data );

  })
      .done(function() {
       //alert( "second success" );
     })
     .fail(function() {
       alert( "error" );
     })
     .always(function() {
       //alert( "finished" );
   });

}

 /*----------------------------------------------------------*/

</script>
