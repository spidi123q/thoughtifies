


<body>


	<nav class="navbar navbar-ddefault navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
			<div class="dropdown">
							<button class="dropdown-button btn btn-default dropdown-toggle btn-floating btn-large waves-effect waves-light red" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" data-activates='mainmenu'>
              <i class="material-icons">receipt</i>
              </button>

							<ul id="mainmenu" class="dropdown-content" aria-labelledby="dropdownMenu1">
							<li><a data-page="0">Home</a></li>
							<li><a data-page="1">Search</a></li>
							<li><a data-page="2">Messages</a></li>
							<li role="separator" class="divider"></li>
							<li><a data-page="3">Interest</a></li>
							<li><a data-page="4">Settings</a></li>
							</ul>
		 </div>

			</div>
		</div>
	</nav>

<br><br><br><br>

<div id="chatSidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a><br/>
	<div id="mySidenav-users">

			<table class="table">
				<td>

					<div class="table-responsive">

					</div>
				</td>


			</table>


	</div>
</div>


<!-- Chat Modal -->
<div id="chatModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div id="chatModal_data" class="modal-body">
        <p>Some text in the modal.</p>
      </div>
    </div>

  </div>
</div>

<!-- Use any element to open the sidenav -->
<span>
			<button  id="chat_button" class="btn-floating btn-large waves-effect waves-light purple tooltipped" data-position="left" data-delay="50" data-tooltip="chat">
		  <i class="material-icons mdl-badge mdl-badge--overlap">perm_contact_calendar</i>
		</button>
</span>




<div class="row">
  <div class="col-xs-12">
		<div id="toper">
			<div id='loadingmessage' style='display:none'>
  <img src='loadinggraphic.gif'/>loading

</div>

		</div>
  </div>
</div>

	<script>
	  $('#myButton').on('click', function () {
	    var $btn = $(this).button('loading')
	    // business logic...
	    $btn.button('reset')
	  })
	</script>
</body>

<script>

				var msgUser,interval = 50000000;

				function closeNav(){
					$("#chatSidenav").toggle('fast');
				}``




				$(document).ready(function(){
					//startup
					loadPage("0");
					$("#chatSidenav").toggle();

					/*----------------------*/
					setInterval(function() {
					//call $.ajax here
					//SELECT * FROM `member` WHERE (NOW() - last_logout) BETWEEN 0 and 5
				//	updateOnlineUsers();
				//	listOnlineUsers();

					}, interval);

						$("#mainmenu li a").click(function(){
						// remove previously added selectedLi
						$('.selectedLi').removeClass('selectedLi');
						// add class `selectedLi`
						$(this).addClass('selectedLi');
						 $('#loadingmessage').show();
						var selText = $(this).data('page');///User selected value...****
						//alert(selText);
						loadPage(selText);
						$(this).parents('.btn-group').find('.dropdown-toggle').html(selText+
						' <span class="caret"></span>');
						});


				});


				$(document).ready(function() {
					var win = $(window);
					//alert(win.scrollWidth);

					// Each time the user scrolls
					win.scroll(function() {
							// End of the document reached?
							if ($(document).height() - win.height() == win.scrollTop()) {
									$('#loading').show();

									// Uncomment this AJAX call to test it
									/*
									$.ajax({
											url: 'get-post.php',
											dataType: 'html',
											success: function(html) {
													$('#posts').append(html);
													$('#loading').hide();
											}
									});
									*/

									$('#posts').append('jjjjjjjjjjjjjj');
									$('#loading').hide();
							}
					});

				/*	$('body').on('click', '#bodyPart', function () {
							 alert("yeahhhh!!! but this doesn't work for me :(");
					});*/

					/*--------------------------------------------------------------
							ajax message update post
					------------------------------------------------------------------*/
					$( "body" ).on( "submit",' #message_sent_form', function( event ) {
					event.preventDefault();
							console.log( $( this ).serialize() );
							var formData = new FormData($(this)[0]);
							//alert(formData);
							console.log(formData);
							$.ajax({
									url: 'src/msgview.php',
									type: 'POST',
									data: formData,
									async: false,
									cache: false,
									contentType: false,
									processData: false,
									success: function (returndata) {
											//$("#productFormOutput").html(returndata);
											//alert(returndata);
											listMsgUser();
											loadUserMsg(msgUser);
									},
									error: function () {
											alert("error in ajax form submission");
									}
							});

				});

					/*----------------------------------------------------------------*/

					/*--------------------------------------------------------------
							ajax settings DOB update post
					------------------------------------------------------------------*/
					$( "body" ).on( "submit",'#DOB', function( event ) {
					event.preventDefault();
							console.log( $( this ).serialize() );
							var formData = new FormData($(this)[0]);
							//alert(formData);
							//console.log(formData);

							$.ajax({
									url: 'src/settings.php',
									type: 'POST',
									data: formData,
									async: false,
									cache: false,
									contentType: false,
									processData: false,
									success: function (returndata) {
											//$("#productFormOutput").html(returndata);
											//alert(returndata);

									},
									error: function () {
											alert("error in ajax form submission");
									}
							});

				});

					/*----------------------------------------------------------------*/

					/*---------------------chat button----------------*/
					$("#chat_button").click(function(){
							$("#chatSidenav").toggle("fast");
					});
					 $(".button-collapse").sideNav();
				/*------------------------------------------------------------*/

				/*------------------------open chat box----------------*/
				$( "#mySidenav-users" ).on( "click",".user_chip", function() {
					var username = $(this).data("username");

					loadUserMsg(username);
					setInterval(function() {

						loadUserMsg(username);
					}, interval);

				});
				/*------------------------------------------------------------*/






			});



				function loadPage(selText){
					 var url ="p/"+selText;
					$.post(url,
					{
							//name: "Donald Duck",
							sel: selText
					},
					function(data, status){
							//alert("Data: " + data + "\nStatus: " + status);
								 $('#loadingmessage').hide();
							$("#toper" ).html( data );

					});
				}

				/*----------------------------------------------------------*/
				function updateOnlineUsers(){

					//initilize online users
					/*----------------------------------------------------------*/
					$.post("src/class/class.online.php",
					{
							//name: "Donald Duck",

					},
					function(data, status){
							//alert("Data: " + data + "\nStatus: " + status);
								 //$('#loadingmessage').hide();

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
			/*----------------------------------------------------------*/
			function listOnlineUsers(){

				//get online users
				/*----------------------------------------------------------*/
				$.post("src/class/class.online.php",
				{
						//name: "Donald Duck",
						chat_list : "1",
						mem_id: '',
				},
				function(data, status){
						//alert("Data: " + data + "\nStatus: " + status);
							 $('#mySidenav-users').html(data);


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

			/*----------------------------------------------------------
					 load user chat messages
			----------------------------------------------------------*/
			function loadUserMsg(username){

				$.post("src/sel_select.php",
				{
						//name: "Donald Duck",
						userid: username,
				},
				function(data, status){
						//alert("Data: " + data + "\nStatus: " + status);
							 //$('#loadingmessage').hide();
						$("#chatModal_data" ).html( data );

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

</html>
