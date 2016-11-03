
<div class="row">
  <div id="users_list" class="col-xs-3" >
    <div id="list_users" class="kk ui fluid vertical steps" style="overflow-y: scroll;height:100%">
        <?php echo $listMessengers; ?>
        <a class="jscoll" href="msg/f/0">
        loafd
        </a>
    </div>

  </div>
  <div id="msgtab" class="col-xs-9" >
    <p>
      <table style="height:100%;">
        <tr>
          <td class="col-xs-1">
            <div id="messages" style="height:100%;overflow-y: scroll;" >

            </div>
          </td>

        </tr>
        <tr style=" height: 20px;">
          <td>
            <table>
              <tr>
                <td>
                  <div class="row">
                  <form id="msg_input_form" action="" class="col s12">
                    <div class="row">
                      <div class="input-field col s12">
                        <textarea id="msg_input" class="materialize-textarea" name="msg"></textarea>
                        <label for="msg_input">Type message</label>
                      </div>
                    </div>
                  </form>
                  </div>


                </td>
                <td>
                  <button class="btn waves-effect waves-light" form="msg_input_form" type="submit" name="action">send
                    <i class="material-icons right">send</i>
                  </button>
                </td>
              </tr>
            </table>

          </td>
        </tr>
      </table>

    </p>
  </div>
</div>
<script>
var msgCurUser
$( function (){

  //listMsgUser();
  function a() {
    console.log("Loaded new images.");
  }



$(".kk").jscroll({
   debug : true,
   nextSelector: ".jscoll" ,
   padding : 0,
   callback : a,
 });


  $( ".completed" ).bind( "click", function() {

      var mem_id = $(this).data("id");
      loadUserMsg(mem_id);
      $('#list_users div').removeClass("active");
      $('#list_users div').addClass("completed");
      $(this).removeClass("completed");
      $(this).addClass("active");

    });


    $( ".myclass" ).bind( "click", function(event) {
            event.preventDefault();
            alert("ggggggggg")


      });

      $( "#msg_input_form" ).submit(function( event ) {

      // Stop form from submitting normally
      event.preventDefault();

      // Get some values from elements on the page:
      var $form = $( this ),
        msg = $form.find( "textarea[name='msg']" ).val(),
        url = 'msg/sent';
      // Send the data using post
      var posting = $.post( url, {
        'msg': msg,
        'receiver' : msgCurUser,
      } );

      // Put the results in a div
      posting.done(function( data ) {
        alert(data);
        var content = $( data ).find( "#content" );
        $( "#result" ).empty().append( content );
      });
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

  msgCurUser = mem_id;
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
              $('#msgtab').addClass('col-xs-12');
              $('#msgtab').show();
          }

          });
        if(viewport.is('<=xs')) {

            $('#msgtab').removeClass('col-xs-9');
            $('#msgtab').hide();
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
