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
    <meta property="og:image" content="<?php echo base_url(); ?>images/coverWideNew.jpg" />
	<link rel="icon" href="<?php echo base_url(); ?>images/fav.png">
	<link rel="manifest" href="<?php echo base_url(); ?>manifest.json">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/index.fixed-0.0.3.css">
	<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-97318105-1', 'auto');
	ga('send', 'pageview');

    </script>
<title>Thoughtifies | Advertising your thoughts</title>
</head>
	<body class="login_body" style="">
        <div class="blur-content">
            <div  class="title flex-container" style="">
                <div>
                    <a href="index">
                        <img class="logo" src="<?php echo base_url(); ?>images/logo.png" alt="logo"/>
                    </a>
                    <span style="font-size: 10pt;
                    text-shadow: 0px 0px 6px black;
                    ">&beta;eta</span>
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

        </div>
        {description}
	</body>
<script src="<?php echo base_url(); ?>js/login_index.js"></script>

</html>
