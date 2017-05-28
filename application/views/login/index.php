<html>
<head>
	<meta charset="utf-8">
    <meta name="description" content="A place where you can share and explore thoughts of people around the world,friends and connecting with them.We respect your privacy so we don't collect private data or track you">
    <meta name="keywords" content="thoughts,facebook,social network,privacy">
    <meta name="author" content="Suraj Kiran">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="msvalidate.01" content="AC7559ADA74AA6F34319B5A26EBF3C41" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#26A69A" />
    <meta property="fb:app_id" content="<?php echo $_SERVER['FB_APP_ID'] ?>">
    <meta property="og:image" content="https://static01.nyt.com/images/2015/02/19/arts/international/19iht-btnumbers19A/19iht-btnumbers19A-facebookJumbo-v2.jpg" />
	<link rel="icon" href="<?php echo base_url(); ?>images/fav.png">
	<link rel="manifest" href="<?php echo base_url(); ?>manifest.json">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/index.fixed.css">
	<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-97318105-1', 'auto');
	ga('send', 'pageview');

</script> 
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
<title>Thoughtifies | Advertising your thoughts</title>
</head>
	<body class="login_body" >
        <div class="blur-content">
            <div  class="title flex-container" style="">
                <h5>Alpha testing... will open soon</h5>
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
                        <a href="credits">
                            Credits
                        </a>

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
                    <a href="contact">
                        Contact
                    </a>
                </div>
            </div>


        </div>
    <div id="chromebutton" class="flex-container hide" style="text-align: center" onclick="hideBlur()">
            {chrome_home}
    </div>

	</body>
<script src="<?php echo base_url(); ?>js/login_index.js"></script>

</html>
