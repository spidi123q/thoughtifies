<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="google-signin-scope" content="profile email">
	<meta name="google-signin-client_id" content="577576396661-lbk5c1jku4va21c8qlqe66s7q8svm68f.apps.googleusercontent.com">
	<script src="https://apis.google.com/js/platform.js" async defer></script>
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
							<div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark"></div>
<br>
<fb:login-button
scope="public_profile,email"
onlogin="checkLoginState();">
</fb:login-button>
		</div>

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
		     var url = '/me?fields=name,email';
		                    FB.api(url, function (response) {
		                        console.log(response);
		                    });

		  });

		  FB.login(function(response) {
		   console.log(response);
		}, {scope: 'email'});

		}
		</script>
		<script>
			function onSignIn(googleUser) {
				// Useful data for your client-side scripts:
				var profile = googleUser.getBasicProfile();
				console.log("ID: " + profile.getId()); // Don't send this directly to your server!
				console.log('Full Name: ' + profile.getName());
				console.log('Given Name: ' + profile.getGivenName());
				console.log('Family Name: ' + profile.getFamilyName());
				console.log("Image URL: " + profile.getImageUrl());
				console.log("Email: " + profile.getEmail());

				// The ID token you need to pass to your backend:
				var id_token = googleUser.getAuthResponse().id_token;
				var xhr = new XMLHttpRequest();
				xhr.open('POST', 'data/3');
				xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				xhr.onload = function() {
				  console.log('Signed in as: ' + xhr.responseText);
				};
				xhr.send('idtoken=' + id_token);

				//console.log("ID Token: " + id_token);
			};
			angular.element(document).ready(function() {

			  var appElement = document.querySelector('[ng-app=IndexApp]');
			  var appScope = angular.element(appElement).scope();

			  console.log('Traversing from appScope to controllerScope:', appScope.$$childHead);


			  var controllerElement = document.querySelector('body');
			   controllerScope = angular.element(controllerElement).scope();

			  console.log('Directly from controllerScope:', controllerScope);

			  controllerScope.$apply(function() {
			  });
			});
		</script>
	</body>
</html>
