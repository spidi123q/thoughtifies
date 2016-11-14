
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

            <div id="messages" class="pp" style="height:100%;overflow-y: scroll;">


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
var msgCurUser,s,countM;


var MScroll = function (container) {
    this.container = container;
    console.log('old instance deleting');
    this.end();
    this.prevHeight = $(this.container)[0].scrollHeight;
    console.log("pre"+this.prevHeight);
    $(this.container).data("requestRunning",false);

    $(this.container).bind('scroll');
     console.log('instance created');
     var cur = this;
     $( this.container ).on( "click", ".msgpage", function() {
       event.preventDefault();
       console.log("binde");
        cur.start();
        $(this).hide();
        cur.setScrollBar(cur);



     });
     //this.start();
     //this.end();
};

MScroll.prototype.start = function () {
  console.log('instance started');
  cur = this;
  $(this.container ).scroll(function() {

    var pos = $(this).scrollTop();
    console.log(pos);
     cur.status = $(cur.container).data("requestRunning");
    if(pos == 0){
      //alert("end");

        console.log("scroll pos :  "+pos);
        cur.get();


      //$(this).unbind('scroll');
    //  $( cur.container ).scrollTop( 200 );

  }else {

  }

  });
};

MScroll.prototype.end = function () {
  $(this.container).unbind('scroll');
  console.log('instance deletd');
};

MScroll.prototype.setScrollBar = function (obj) {
           obj.curHeight = $(obj.container)[0].scrollHeight;
           console.log("scrollHeight get : "+obj.curHeight);
           var newPos = obj.curHeight -obj.prevHeight;
           console.log("pre"+obj.prevHeight);
           console.log("cur"+obj.curHeight);
           $( obj.container ).scrollTop( 500 );
           obj.prevHeight = obj.curHeight;
};

MScroll.prototype.get = function () {
  $(this.container).data("requestRunning",true);
  console.log('calling get');
  var url = $( this.container+" .msgpage" ).first().attr( "href" );
  console.log(this.container);
  var container = this.container;
  var cur = this;
  var count = $('#messages').data('countmsg');
  if (url != "") {
    if (!this.status) {
      console.log("get busy : "+this.status);
      console.log("url not empty");
            var jqxhr = $.post( url,{
              id : msgCurUser,
              count: count,
            }, function(data) {
                console.log('get successllll'+data);
                data += $(container).html();
                $(container).html(data);
                //console.log('get success'+data);


            })
              .done(function() {

                cur.setScrollBar(cur);

              })
              .fail(function() {
                console.log('get error');
              })
              .always(function() {
                $(container).data("requestRunning",false);
              });


    }else {
      console.log("get busy : "+this.status);
    }


  }else {
    console.log("url empty");
    this.end();
  }

};


  $( "#messages" ).on( "click", ".mscoll", function() {
    event.preventDefault();

  });



$( function (){

  //listMsgUser();











  function a() {
    console.log("Loaded new images.");
  }





  $( ".completed" ).bind( "click", function() {

      var mem_id = $(this).data("id");
      countMsg(mem_id);
      $('#list_users div').removeClass("active");
      $('#list_users div').addClass("completed");
      $(this).removeClass("completed");
      $(this).addClass("active");

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

    $("#list_users").jscroll({
       debug : true,
       nextSelector: ".jscoll" ,
       padding : 0,
       callback : a,
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

}

 /*----------------------------------------------------------*/
 function countMsg(mem_id){
   /*----------------------------------------------------------*/
   //initilize list_users
   /*----------------------------------------------------------*/
         var jqxhr = $.get( "msg/count/"+mem_id, function(data) {

           console.log($('#messages').data('countmsg'));
           $('#messages').attr('data-countmsg', data);
           console.log($('#messages').data('countmsg'));

      })
        .done(function() {
          //alert( "second success" );
          loadUserMsg(mem_id);
        })
        .fail(function() {
          //alert( "error  kkk" );
        })
        .always(function() {
          //alert( "finished" );
        });

 }

  /*----------------------------------------------------------*/

/*----------------------------------------------------------
     load messages
----------------------------------------------------------*/
function loadUserMsg(mem_id){

  msgCurUser = mem_id;

  var count = $('#messages').data('countmsg');
  console.log("msg count : "+count);

  $.post("msg/load/0",
  {
      //name: "Donald Duck",
      id: mem_id,
      count: count,

  },
  function(data, status){
      //alert("Data: " + data + "\nStatus: " + status);
         //$('#loadingmessage').hide();
      $("#messages" ).html( data );

  })
      .done(function() {
       //alert( "second success" );
       s =  new MScroll("#messages");
       var d = $('#messages');
        d.scrollTop(d.prop("scrollHeight"));
        var k = $("#messages").scrollTop();
        //alert(k);
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
