<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="manifest" href="manifest.json">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/index.css">
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
</head>
	<body  >
		<div  class="title flex-container" style="">
							<form name="loginform" action="data/1" method="post" style="">
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
						<div class="quotes flex-container">
								<div>Advertises your thoughts</div>
								<div>Privacy first! Thoughtifies don't track you</div>
						</div>


						<video poster="" id="bgvid" playsinline autoplay muted loop>
							<!-- WCAG general accessibility recommendation is that media such as background video play through only once. Loop turned on for the purposes of illustration; if removed, the end of the video will fade in the same way created by pressing the "Pause" button  -->
							<source src="<?php echo base_url(); ?>images/untitled.webm" type="video/webm">

						</video>



		<div id="footer">
		</div>
		<!-- Angular Material requires Angular.js Libraries -->

		<!-- Angular Material Library -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link href="https://fonts.googleapis.com/css?family=Roboto:300" rel="stylesheet">

	</body>
</html>
