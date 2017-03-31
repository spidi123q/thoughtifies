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
<title>Thoughtifies</title>
</head>
	<body class="login_body" >
		<div  class="title flex-container" style="">
							<form class="hide" name="loginform" action="data/1" method="post" >
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
								<a href="index">
								<img class="logo" src="<?php echo base_url(); ?>images/logo.png" alt=""/>
								</a>
							</div>

							<div class="">
								<div class="">
									{fb}
								</div>
								<div class="tpp">
									By signing up, you agree to our <a href="license">Terms</a> &
									<a href="privacy">Privacy</a> Policy.
								</div>
							</div>

						</div>
						<div >
							{content}
						</div>




		<div class="simple-flex-container footer">
			<div class="simple-flex-container">
				<div class="">
					Credits
				</div>
				<div class="">
					<a href="privacy">
						Privacy
					</a>
				</div>
				<div class="">
					<a href="license">
						Terms
					</a>
				</div>
			</div>
			<div class="contact">
				Contact
			</div>
		</div>

	</body>
</html>
