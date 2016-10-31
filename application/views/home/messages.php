<!--<div class="">
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
              </div>
        </td>
      </div>

  </tr>
  </table>
</div>
-->

<div class="row">
  <div id="users_list" class="col-xs-3" style="overflow-y: scroll;height:100%">
    <div id="list_users" class="ui fluid vertical steps" >
      <div class="completed step">
        <i class="truck icon"></i>
        <div class="content">
          <div class="title">Shipping</div>
          <div class="description">Choose your shipping options</div>
        </div>
      </div>
      <div class="completed step">
        <i class="truck icon"></i>
        <div class="content">
          <div class="title">Shipping</div>
          <div class="description">Choose your shipping options</div>
        </div>
      </div>
      <div class="completed step">
        <i class="truck icon"></i>
        <div class="content">
          <div class="title">Shipping</div>
          <div class="description">Choose your shipping options</div>
        </div>
      </div>
      <div class="completed step">
        <i class="truck icon"></i>
        <div class="content">
          <div class="title">Shipping</div>
          <div class="description">Choose your shipping options</div>
        </div>
      </div>
      <div class="completed step">
        <i class="truck icon"></i>
        <div class="content">
          <div class="title">Shipping</div>
          <div class="description">Choose your shipping options</div>
        </div>
      </div>
      <div class="completed step">
        <i class="truck icon"></i>
        <div class="content">
          <div class="title">Shipping</div>
          <div class="description">Choose your shipping options</div>
        </div>
      </div>
      <div class="completed step">
        <i class="truck icon"></i>
        <div class="content">
          <div class="title">Shipping</div>
          <div class="description">Choose your shipping options</div>
        </div>
      </div>
      <div class="completed step">
        <i class="truck icon"></i>
        <div class="content">
          <div class="title">Shipping</div>
          <div class="description">Choose your shipping options</div>
        </div>
      </div>
      <div class="completed step">
        <i class="truck icon"></i>
        <div class="content">
          <div class="title">Shipping</div>
          <div class="description">Choose your shipping options</div>
        </div>
      </div>
      <div class="completed step">
        <i class="truck icon"></i>
        <div class="content">
          <div class="title">Shipping</div>
          <div class="description">Choose your shipping options</div>
        </div>
      </div>
      <div class="completed step">
        <i class="truck icon"></i>
        <div class="content">
          <div class="title">Shipping</div>
          <div class="description">Choose your shipping options</div>
        </div>
      </div>
      <div class="completed step">
        <i class="truck icon"></i>
        <div class="content">
          <div class="title">Shipping</div>
          <div class="description">Choose your shipping options</div>
        </div>
      </div>
      <div class="completed step">
        <i class="truck icon"></i>
        <div class="content">
          <div class="title">Shipping</div>
          <div class="description">Choose your shipping options</div>
        </div>
      </div>
      <div class="completed step">
        <i class="truck icon"></i>
        <div class="content">
          <div class="title">Shipping</div>
          <div class="description">Choose your shipping options</div>
        </div>
      </div>
      <div class="completed step">
        <i class="truck icon"></i>
        <div class="content">
          <div class="title">Shipping</div>
          <div class="description">Choose your shipping options</div>
        </div>
      </div>
      <div class="completed step">
        <i class="truck icon"></i>
        <div class="content">
          <div class="title">Shipping</div>
          <div class="description">Choose your shipping options</div>
        </div>
      </div>
      <div class="completed step">
        <i class="truck icon"></i>
        <div class="content">
          <div class="title">Shipping</div>
          <div class="description">Choose your shipping options</div>
        </div>
      </div>
      <div class="completed step">
        <i class="truck icon"></i>
        <div class="content">
          <div class="title">Shipping</div>
          <div class="description">Choose your shipping options</div>
        </div>
      </div>
      <div class="completed step">
        <i class="truck icon"></i>
        <div class="content">
          <div class="title">Shipping</div>
          <div class="description">Choose your shipping options</div>
        </div>
      </div>
      <div class="completed step">
        <i class="truck icon"></i>
        <div class="content">
          <div class="title">Shipping</div>
          <div class="description">Choose your shipping options</div>
        </div>
      </div>

        <?php echo $listMessengers; ?>
    </div>
  </div>
  <div class="col-xs-9" id="messages" >
    <p>
      <table>
        <tr>
          <td class="col-xs-1">
            jjjjjjjjjjjj
          </td>
          <td class="col-xs-11">
            <div class="inline field">
              <div class="ui left pointing label">
                That name is taken     h      !
              </div>
            </div>
          </td>
        </tr>
      </table>

    </p>
  </div>
</div>
<script>
$( function (){

  //listMsgUser();
  $( ".completed" ).bind( "click", function() {

      var mem_id = $(this).data("id");
      loadUserMsg(mem_id);
      $('#list_users div').removeClass("active");
      $('#list_users div').addClass("completed");
      $(this).removeClass("completed");
      $(this).addClass("active");

    });


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
function loadUserMsg(mem_id){

  msgUser = mem_id;
  $( "#message_tab div" ).first().addClass( "hidden-xs" );

  $.post("msg/load",
  {
      //name: "Donald Duck",
      id: mem_id,
  },
  function(data, status){
      //alert("Data: " + data + "\nStatus: " + status);
         //$('#loadingmessage').hide();
      $("#messages" ).html( data );

  })
      .done(function() {
       //alert( "second success" );
     })
     .fail(function() {
       //alert( "error" );
     })
     .always(function() {
      // alert( "finished" );
   });

}

 /*----------------------------------------------------------*/
 // Wrap IIFE around your code
(function($, viewport){
    $(document).ready(function() {

        // Executes only in XS breakpoint
        $( ".completed" ).bind( "click", function() {

          if(viewport.is('<=xs')) {


              $('#users_list').removeClass('col-xs-12');
              $('#users_list').hide();
              $('#messages').addClass('col-xs-12');
              $('#messages').show();
          }

          });
        if(viewport.is('<=xs')) {

            $('#messages').removeClass('col-xs-9');
            $('#messages').hide();
            $('#users_list').removeClass('col-xs-3');
            $('#users_list').addClass('col-xs-12');
        }

        // Executes in SM, MD and LG breakpoints
        if(viewport.is('>=sm')) {
            // ...
        }

        // Executes in XS and SM breakpoints
        if(viewport.is('<md')) {
            // ...
        }

        // Execute code each time window size changes
        $(window).resize(
            viewport.changed(function() {
                if(viewport.is('<=xs')) {

                }
            })
        );
    });
})(jQuery, ResponsiveBootstrapToolkit);

</script>
