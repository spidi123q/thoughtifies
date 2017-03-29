<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#26A69A" />
	<link rel="manifest" href="manifest.json">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/index.css">
	<!--
	<script type="text/javascript">
						if ('serviceWorker' in navigator) {
					window.addEventListener('load', function() {
						navigator.serviceWorker.register('sw.js').then(function(registration) {
							// Registration was successful
							console.log('ServiceWorker registration successful with scope: ', registration.scope);
						}).catch(function(err) {
							// registration failed :(
							console.log('ServiceWorker registration failed: ', err);
						});
					});
					}
	</script>
-->
</head>
	<body class="login_body" >
		<div  class="title flex-container" style="">
							<form class="" name="loginform" action="data/1" method="post" >
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
						<div  class="phone simple-flex-container mobile_flex">
							<div class="myVideo">
								<video id="video" autoplay loop muted playsinline>
								  <source src="<?php echo base_url(); ?>images/sad.mp4" type="video/mp4">
								Your browser does not support the video tag.
								</video>
							</div>
							<div class="quotes flex-container column">
									<div>Advertising your thoughts</div>
									<div>Connecting people</div>
									<div>Privacy first! Thoughtifies don't track you</div>
							</div>
						</div>





		<div class="simple-flex-container footer">
			<div class="">
				Credits
			</div>
			<div class="">
				Privacy Policy
			</div>
			<div class="">
				Contact
			</div>
		</div>
<script type="text/javascript">
				var video = document.getElementById('video');
				document.addEventListener('click',function(){
						video.play();
				},false);
				window.onscroll = function (e) {
						// called when the window is scrolled.
						console.log("scroll");

				}
</script>
	</body>
</html>
