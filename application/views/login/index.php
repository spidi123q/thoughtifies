<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/index.css">
</head>
	<body ng-app="IndexApp" ng-controller="AppCtrl">
		<div id="top_panel" class="row-fluid ">
							<form name="loginform" action="data/1" method="post">
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
									  <div class="col-sm-1"><button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" name="" type="submit">login</button></div>
									</div>
							</form>

<br>
<fb:login-button
scope="public_profile,email,user_birthday,user_friends,user_hometown"
onlogin="checkLoginState();">
</fb:login-button>


		<div id="footer">
		</div>
		<!-- Angular Material requires Angular.js Libraries -->
		<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-animate.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-aria.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-messages.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-route.js" charset="utf-8"></script>
		<script src="<?php echo base_url(); ?>js/node_modules/angular-ui-scroll/dist/ui-scroll.js"></script>
		<script src="<?php echo base_url(); ?>js/node_modules/angular-ui-scroll/dist/ui-scroll-jqlite.js"></script>
		<script src="<?php echo base_url(); ?>js/index_app.js"></script>
		<script src="http://twemoji.maxcdn.com/2/twemoji.min.js?2.2.3"></script>
		<!-- Angular Material Library -->
		<script src="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.js"></script>
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">


		<script>
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
				console.log('Signed in as: ' + xhr.responseText);
			};
			xhr.send('idtoken=' + id_token);
		}
		</script>
	</body>
</html>
