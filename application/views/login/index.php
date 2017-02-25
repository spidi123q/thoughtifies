<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/index.css">
</head>
	<body ng-app="IndexApp" ng-controller="AppCtrl">
		<div class="title flex-container">
							<form name="loginform" action="data/1" method="post" class="">
									<div class="container-fluid row-fluid">
										<div id="fdf" class="col-sm-7">L social network</div>
												<div class="col-sm-2">
														  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
													    	<input class="mdl-textfield__input" name="username" type="text"/>
													    	<label class="mdl-textfield__label" for="sample3">username</label>
															</div>
												  </div>
													<div class="col-sm-2">
															<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
																	<input class="mdl-textfield__input" name="password" type="password"/>
														    <label class="mdl-textfield__label" for="sample3">password</label>
															</div>
												  </div>
									  <div class="col-sm-1">
											<button class="" name="" type="submit">login</button>
										</div>
									</div>
							</form>
							<div>
								<img class="logo" src="<?php echo base_url(); ?>images/logo.png" alt=""/>
							</div>
							<?php echo $fb ?>
						</div>
						<div class="quotes">
								<span>Playground of thoughts around world</span>
								<span>Create & share thoughts</span>
								<span>Privacy first! Thoughtifies don't track you</span>
						</div>
<video poster="https://s3-us-west-2.amazonaws.com/s.cdpn.io/4273/polina.jpg" id="bgvid" playsinline autoplay muted loop>
  <!-- WCAG general accessibility recommendation is that media such as background video play through only once. Loop turned on for the purposes of illustration; if removed, the end of the video will fade in the same way created by pressing the "Pause" button  -->
	<source src="<?php echo base_url(); ?>images/untitled.webm" type="video/webm">

</video>




		<div id="footer">
		</div>
		<!-- Angular Material requires Angular.js Libraries -->

		<!-- Angular Material Library -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link href="https://fonts.googleapis.com/css?family=Roboto:300" rel="stylesheet">

		<!--<script>
							  window.fbAsyncInit = function() {
							    FB.init({
							      appId      : '1789323091320402',
							      cookie     : true,
							      xfbml      : true,
							      version    : 'v2.8'
							    });
							    FB.AppEvents.logPageView();
							  };

							  (function(d, s, id){
							     var js, fjs = d.getElementsByTagName(s)[0];
							     if (d.getElementById(id)) {return;}
							     js = d.createElement(s); js.id = id;
							     js.src = "//connect.facebook.net/en_US/sdk.js";
							     fjs.parentNode.insertBefore(js, fjs);
							   }(document, 'script', 'facebook-jssdk'));

							   function checkLoginState() {
							  FB.getLoginStatus(function(response) {
							     console.log(response);

									 sentToken(response.authResponse.accessToken,4)
							    /* var url = '/me?fields=name,email';
							                    FB.api(url, function (response) {
							                        console.log(response);
							                    });*/

							  });

								  FB.login(function(response) {
								   console.log(response);
								}, {scope: 'email'});

								}

							function sentToken(id_token,type) {
								var xhr = new XMLHttpRequest();
								xhr.open('POST', 'data/'+type);
								xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
								xhr.onload = function() {
									//console.log('Signed in as: ' + xhr.responseText);
									//location.reload();
									//window.location.assign = 'aaa';
									//window.location.reload();
									//document.write(xhr.responseText);
					        //document.close();
								};
								xhr.send('idtoken=' + id_token);
							}
		</script> -->
	</body>
</html>
