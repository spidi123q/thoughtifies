<script>

             // Shorthand for $( document ).ready()
            $(function() {
                //startup initilize
              $('ul.tabs').tabs();
              $('select').material_select();
              /*--------------------------------------------------------------
                  ajax tag post
            ------------------------------------------------------------------*/

                      $("#tag_submit_button").click(function(){
                         var tag = $( "#tag_input" ).val();
                        $.post("settings/1",
                        {
                            //name: "Donald Duck",
                            data: tag,
                        },
                        function(data, status){
                            //alert("Data: " + data + "\nStatus: " + status);
                               //$('#loadingmessage').hide();
                            //$("#toper" ).html( data );
                            loadPage(4);

                        })
                            .done(function() {
                             alert("done"  );
                           })
                           .fail(function() {
                             alert( "error" );
                           })
                           .always(function() {
                             alert( "finished" );
                         });
                    });
              /*----------------------------------------------------------------*/

              /*--------------------------------------------------------------
                  ajax about me post
            ------------------------------------------------------------------*/

                      $("#aboutMeSubmit_button").click(function(){
                         var val = $( "#aboutMeText_area" ).val();
                        $.post("settings/2",
                        {
                            //name: "Donald Duck",
                            data: val,
                        },
                        function(data, status){
                            //alert("Data: " + data + "\nStatus: " + status);
                               //$('#loadingmessage').hide();
                            loadPage(4);


                        })
                           .done(function() {
                            alert( "second success" );
                          })
                          .fail(function() {
                            alert( "error" );
                          })
                          .always(function() {
                            alert( "finished" );
                        });

                    });
              /*----------------------------------------------------------------*/

              /*--------------------------------------------------------------
                  ajax profile photo remove button post
            ------------------------------------------------------------------*/

                      $("#deleteDP_button").click(function(){
                         var val = $( "#aboutMeText_area" ).val();
                        $.post("src/settings.php",
                        {
                            //name: "Donald Duck",
                            deleteDP: "1",
                        },
                        function(data, status){
                            //alert("Data: " + data + "\nStatus: " + status);
                               //$('#loadingmessage').hide();
                               $("#profilePicture img").attr("src","tpl/photo.jpg");
                               var img = '<img src="tpl/photo.jpg">';
                            //$("#profilePicture img" ).html( img );


                        })
                           .done(function() {
                            alert( "second success" );
                          })
                          .fail(function() {
                            alert( "error" );
                          })
                          .always(function() {
                            alert( "finished" );
                        });

                    });
              /*----------------------------------------------------------------*/

              /*--------------------------------------------------------------
                  ajax profile photo update post
              ------------------------------------------------------------------*/
              $( "#dp_upload" ).on( "submit", function( event ) {
                  event.preventDefault();
                  console.log( $( this ).serialize() );
                  var formData = new FormData($(this)[0]);
                  console.log(formData);
                  $.ajax({
                      url: 'settings/upload',
                      type: 'POST',
                      data: formData,
                      async: false,
                      cache: false,
                      contentType: false,
                      processData: false,
                      success: function (returndata) {
                          //$("#productFormOutput").html(returndata);
                          alert(returndata);
                      },
                      error: function () {
                          alert("error in ajax form submission");
                      }
                  });

            });

              /*----------------------------------------------------------------*/

                /*--------------------------------------------------------------
                    ajax friend preference  post
                ------------------------------------------------------------------*/

                $("#aboutPSubmit_button").click(function(){
                   var val = $( "#aboutPText" ).val();
                   alert(val);
                  $.post("settings/3",
                  {
                      //name: "Donald Duck",
                      data: val,
                  },
                  function(data, status){
                      //alert("Data: " + data + "\nStatus: " + status);
                         //$('#loadingmessage').hide();
                      loadPage(4);


                  })
                     .done(function() {
                      alert( "second success" );
                    })
                    .fail(function() {
                      alert( "error" );
                    })
                    .always(function() {
                      alert( "finished" );
                  });

              });

            /*----------------------------------------------------------------*/





            });

            /*--------------------------------------------------------------
                ajax album image delete post
            ------------------------------------------------------------------*/

            function deleteAlbumImage(id,mem_id){

              $.post("src/settings.php",
              {
                  //name: "Donald Duck",
                  mem_id: mem_id,
                  image : id,
              },
              function(data, status){
                  //alert("Data: " + data + "\nStatus: " + status);
                     //$('#loadingmessage').hide();
                     var td = "#album_"+mem_id+id;
                     $(td ).html( "" );

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
            /*----------------------------------------------------------------*/

            /*--------------------------------------------------------------
                ajax friend age post
            ------------------------------------------------------------------*/

                    function friendAgePost(){
                         var lage = $( "#friend_age_form #l_age" ).val();
                         var hage = $( "#friend_age_form #h_age" ).val();

                        $.post("src/settings.php",
                        {
                            l_age : lage,
                            h_age : hage,
                            pAge  : 1,

                        },
                        function(data, status){
                            //alert("Data: " + data + "\nStatus: " + status);
                               //$('#loadingmessage').hide();
                            //$("#profilePicture img" ).html( img );


                        })
                           .done(function() {
                            alert( "second success" );
                          })
                          .fail(function() {
                            alert( "error" );
                          })
                          .always(function() {
                            alert( "finished" );
                        });


                    }
            /*----------------------------------------------------------------*/
</script>
 <div class="row">
   <div class="col-xs-2">

   </div>

   <div class="col-xs-8" id="settings_tabs">

     <div class="row">
   <div class="col s12">
     <ul class="tabs">
       <li class="tab col s3"><a class="active" href="#home">Profile</a></li>
       <li class="tab col s3"><a href="#menu1">Preference</a></li>
       <li class="tab col s3"><a href="#menu2">Settings</a></li>
     </ul>
   </div>
   <div id="home" class="col s12">
     <h3>Profile</h3>

     <p>
       <div class="row">
         <div class="col-sm-4">

         </div>
         <div class="col-sm-4">
           <div id="profilePicture">
             <img src="<?php echo $dp_thumb?>" alt="" />

                        <br/><button id="deleteDP_button">remove picture</button>
                        <br> <button type="button" class="waves-effect waves-light btn" data-toggle="modal" data-target="#myModal">Upload </button>
                           <button type="button" class="waves-effect waves-light btn" data-toggle="modal" data-target="#albumModal">Album </button>
                      </br>


            </div>
          </div>
            <div class="col-sm-4">

              <br>
               <br>
              <strong>Tag</strong>
               <br>
                <br>
              <form id="setting_tag_form" method="post" >
                <input id="tag_input" type="text" name="tag" value="<?php echo $tag?>">
              </form>
              <button id="tag_submit_button" class="waves-effect waves-light btn" name="button_tag">change</button>

            </div>
         </div>
         <div class="row">
           <div class="col-xs-12">
             <strong>About me </strong><br>
             <textarea id="settings_aboutMeText_area" class="form-control" rows="4" cols="50" readonly>
                <?php echo $about_me ?>
             </textarea><br>
             <button type="button" class="waves-effect waves-light btn" data-toggle="modal" data-target="#aboutModal">change </button>
             <br/>
           </div>
         </div>
       </div>
     </p>
   <div id="menu1" class="col s12" >
     <h3>Preference</h3>
     <p>
       <table class="table" id="aboutPartner">
         <tr>
           <td>
             <strong>Friend Preference </strong><br>

          <textarea class="form-control" rows="4" cols="50" readonly>
            <?php echo $about_partner?>
          </textarea><br>
          <button type="button" class="waves-effect waves-light btn" data-toggle="modal" data-target="#aboutPartnerModal">change </button>
      <br/>


           </td>
         </tr>
       </table>
     </p>
   </div>
   <div id="menu2" class="col s12">


           <p>
             <div class="row">
               <div class="col-xs-12">
                     <h3>Settings</h3>
               </div>
             </div>
             <div class="row">
               <div class="col-xs-12">
                   <strong>Date of birth</strong><br>
               </div>
             </div>
             <div class="row">
               <form id="DOB" action= "" method="post">
               <div class="col-xs-3">


                 Day:
                 <select name="DOBDay">
                   <?php

                     for($i = 31;$i > 0;$i--){
                       if($i == $dd ){
                         echo "<option selected value='$i'>$i</option>";
                       }
                       else {
                         echo "<option value='$i'>$i</option>";
                       }
                     }

                    ?>
                 </select>
               </div>
               <div class="col-xs-3">
                 Month:
                 <select name="DOBMonth">
                   <?php
                    for($i = 12;$i > 0;$i--){
                      if($i == $mm){
                        echo "<option selected value='$i'>$i</option>";
                      }
                      else {
                        echo "<option value='$i'>$i</option>";
                      }
                    }

                   ?>

                 </select>

               </div>
               <div class="col-xs-3">
                 Year:
                 <select name="DOBYear">
                   <?php

                    for($i = date(Y);$i > 1910;$i--){

                      if($i == $yy){
                        echo "<option selected value='$i'>$i</option>";
                      }
                      else {
                        echo "<option value='$i'>$i</option>";
                      }
                    }

                   ?>

                 </select>

               </div>
               <div class="col-xs-3">
                 <button class="waves-effect waves-light btn" type="submit" name="DOBchange" value="change">change</input>
                 <br>
               </div>
               </form>
             </div>

       <div class="row">
         <div class="col-xs-12">
           <strong>Country : </strong>

         </div>
       </div>
       <div class="row">
         <div class="col-xs-12">
           <button type="button" class="waves-effect waves-light btn" data-toggle="modal" data-target="#blockedModal">Blocked users </button>
         </div>
       </div>


           </p>

     </div>
 </div>

      <!--  DP Modal -->
      <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
              <p>  <div id="mainform" class="masterdiv">

                <?php
                $attributes = array('id' => 'dp_upload');
                 echo form_open_multipart('',$attributes);?>

                <input type="file" name="userfile" size="20" />

                <br /><br />

                <input type="submit" value="upload" />
                </form>
                 <strong>allowed types are *.png ,jpg<br></strong>
                </div></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>

      <!--  About me Modal -->
      <div class="modal fade" id="aboutModal" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
              <p>  <div id="mainform" class="masterdiv">
                 <textarea id="aboutMeText_area" name="aboutMeText" form="aboutMeSubmit">Enter text here...</textarea>
                </div></p>
            </div>
            <div class="modal-footer">
              <button id="aboutMeSubmit_button" name="aboutMeSubmit_button" class="btn btn-default" data-dismiss="modal">change</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

      <!--  About partner Modal -->
      <div class="modal fade" id="aboutPartnerModal" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
              <p>  <div id="mainform" class="masterdiv">


         <textarea id="aboutPText" form="aboutPSubmit">Enter text here...</textarea>
                </div></p>
            </div>
            <div class="modal-footer">
              <button id="aboutPSubmit_button"  class="btn btn-default" data-dismiss="modal">change</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <!--  Album Modal -->
      <div class="modal fade" id="albumModal" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
              <p>  <div id="mainform" class="masterdiv">
                 <div id="my_photos">
                   <h4>your pics</h4>
                 <div id="album_display"> </div>
                 </div>
                 <form action="picture.php?update=albumPicture"method="POST" enctype="multipart/form-data">
                   <input type="file" name="albumPicture"> <input type="submit" name="albumPictureSubmit" value="Upload">
                 </form>
                  <strong>allowed types are *.png ,jpg<br></strong>
                </div></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

     <!--  blocked users Modal -->
      <div class="modal fade" id="blockedModal" role="dialog">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Currently blocked users</h4>
                </div>
                <div class="modal-body">
                  <p>
                   </p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>



   <div class="col-xs-2">

   </div>
 </div>
 </div>
