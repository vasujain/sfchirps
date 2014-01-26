<!DOCTYPE html>
<!--[if IE 7]> <html lang="en" class="ie7"> <![endif]-->  
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->  
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->  
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->  

<head>
    <title>SF Chirps (Beta)</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSS Global Compulsory-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="css/style_responsive.css">
    <link rel="shortcut icon" href="img/favicon.ico">
	<!-- http://www.favicon.cc/?action=icon&file_id=710333 -->
    <!-- CSS Implementing Plugins -->    
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/countdown.css">
    <!-- CSS Theme -->    
    <link rel="stylesheet" href="css/default.css" id="style_color">
</head>

<body class="coming-soon-page">

<div class="coming-soon-border"></div>

<!--=== Content Part ===-->    
<div class="container">
    <!-- Coming Soon Content -->
	<div class="row-fluid coming-soon indexHeader">
		<a href="index.php">
			<h1>SF-Chirps (Beta)</h1>
		</a>
<!--		<p>A tweet list by cool startups in sf bay... !</p><br>-->
		<p>A curated collection of tweets by hottest startups in San Francisco bay area.. !</p><br>
	</div>

	<div class="row-fluid">
		<div class="span3 coming-soon">
			<?php

			ini_set('display_errors', 1);
			require_once('TwitterAPIExchange.php');

			/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
			$settings = array(
				'oauth_access_token' => "35442559-oe10vPLAUFfhij2smP5sQOSEaKRokGjpm98T7UmI",
				'oauth_access_token_secret' => "45EArsvp2HPU6XcF8bGVRUeEsvj7ZHEZejveudeic",
				'consumer_key' => "ABLNj9jKpnCrcYvxMcMA",
				'consumer_secret' => "yvWYWDqXsRz9Z1VHIXtQc5ob1ZXFGnPacpzG6GA"
			);

			/**
			 * URL for REST request, see: https://dev.twitter.com/docs/api/1.1/
			 * https://dev.twitter.com/docs/misc/cursoring
			 * https://dev.twitter.com/docs/api/1.1/get/lists/members
			 *
			 * curl
			 * --get 'https://api.twitter.com/1.1/lists/members.json'
			 * --data 'cursor=-1&owner_screen_name=vasujain&slug=sf-startups'
			 * --header 'Authorization: OAuth oauth_consumer_key="ABLNj9jKpnCrcYvxMcMA",
			 * 							oauth_nonce="5edc5d45255cb57d9d1f33c2934fd2a1",
			 * 							oauth_signature="LtapAymHpOs3hJCE4ToFvbJ1efk%3D",
			 * 							oauth_signature_method="HMAC-SHA1",
			 * 							oauth_timestamp="1390351909",
			 * 							oauth_token="35442559-oe10vPLAUFfhij2smP5sQOSEaKRokGjpm98T7UmI",
			 * 							oauth_version="1.0"'
			 * 							twitterid: owner_id=35442559
			 **/

			/**
			 	Perform a GET request and echo the response
				This one will fetch next few pages with N Results on each page. Pretty much like pagination
				Twitter API Sucks
		 	**/

			$cursor = -1;
			$ownerScreenName = 'vasujain';
			$slugName = 'sf-startups';

			while($cursor != 0) {
				$url = 'https://api.twitter.com/1.1/lists/members.json';
				$getfield = '?cursor=' . $cursor . '&owner_screen_name='. $ownerScreenName . '&slug=' .$slugName;
				$requestMethod = 'GET';
				$twitter = new TwitterAPIExchange($settings);
				$jsonResultSet =  $twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();

				$jsonObjectLoop = json_decode($jsonResultSet);
				$numberOfMembers = count($jsonObjectLoop->users);
				for($i=0;$i<$numberOfMembers;$i++){
					$imgUrl = $jsonObjectLoop->users[$i]->profile_image_url;
					$screenName = $jsonObjectLoop->users[$i]->screen_name;
					$username = $jsonObjectLoop->users[$i]->name;
					$twitterUrl = "https://twitter.com/";

					echo "<a href=$twitterUrl" . "$screenName target='_blank' class='tooltipBootstrap' title='$username'><img class='memberDisplayPic fade' src=$imgUrl></a>";
				}
				$cursor = $jsonObjectLoop->next_cursor;
			}

			// POST Request


			//	$url = 'https://api.twitter.com/1.1/lists/members.json';
			//	$requestMethod = 'POST';
			//
			//	/** POST fields required by the URL above. See relevant docs as above **/
			//	$postfields = array(
			//		'screen_name' => 'usernameToBlock',
			//		'skip_status' => '1'
			//	);
			//
			//	/** Perform a POST request and echo the response **/
			//	$twitter = new TwitterAPIExchange($settings);
			//	echo $twitter->buildOauth($url, $requestMethod)->setPostfields($postfields)->performRequest();

			?>
		</div>
        <div class="span6 coming-soon">
			<a class="twitter-timeline" href="https://twitter.com/vasujain/sf-startups" data-widget-id="425727156388241408" height="1024" width="100%" data-tweet-limit="20">Tweets from https://twitter.com/vasujain/sf-startups</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        </div>
		<div class="span3 coming-soon" style="text-align: left">
			<p>Want to Suggest a Company to add ?</p>
			<form id="registration-form" class="form-search" action="mailer.php" method="post">
				<div class="control-group">
					<div class="controls">
						<input type="text" class="input-large" name="twitterhandle" id="twitterhandle" placeholder="Twitter Handle">
					</div>
				</div>
				<div class="spacing5"></div>
				<div class="control-group">
					<div class="controls">
						<input type="text" class="input-large" name="name" id="name" placeholder="Your Name">
					</div>
				</div>
				<div class="spacing5"></div>
				<div class="control-group">
					<div class="controls">
						<input type="text" class="input-large" name="email" id="email" placeholder="Your Email">
					</div>
				</div>
				<div class="spacing5"></div>
				<div class="control-group">
					<div class="controls">
						<textarea class="xxlarge" name="message" id="message" placeholder="Some text ? May be ?"></textarea>
					</div>
				</div>
				<div class="spacing5"></div>
				<button type="submit" class="btn-u">Shoot !!</button>
			</form>
			<br/><br/>
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) return;
					js = d.createElement(s); js.id = id;
					js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=539834869395251";
					fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));</script>

			<div id="fb-root"></div>

			<!-- Twitter share -->
			<!-- https://about.twitter.com/resources/buttons#tweet -->
			<span class="text-deco-none">
				<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.sfchirps.com/" data-text="Check out #sfchirps .. curated tweets by hottest #sf startups" data-via="vasujain" data-hashtags="sanfrancisco" style="vertical-align: bottom;">Tweet</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

				<!-- Facebook share -->
				<!-- https://developers.facebook.com/docs/plugins/share-button/ -->
				<div class="fb-share-button" data-href="http://www.sfchirps.com/" data-type="button_count"></div>
			</span>
			<br/><br/><br/>
			<div class="follow-us">
				<ul class="social-icons">
					<li><a href="http://facebook.com/vasujain" target="_blank" data-original-title="Facebook" class="social_facebook"></a></li>
					<li><a href="http://twitter.com/vasujain" target="_blank" data-original-title="Twitter" class="social_twitter"></a></li>
					<li><a href="http://linkedin.com/in/vasujain" target="_blank" data-original-title="LinkedIn" class="social_linkedin"></a></li>
					<li><a href="http://github.com/vasujain" target="_blank" data-original-title="Github" class="social_github"></a></li>
				</ul>
			</div>
			<br/><br/>
			<div class="coming-soon-copyright made-with-love">
				Made with love in SF bay by <a href="mailto:vasu@windowsvj.com">VJ</a>
			</div>
			<br/><br/>
			<div class="popoverAbtMe">
				<a href="#" id="popoverAboutMe" class="btn btn-success" rel="popover" data-content="Developed by Vasu Jain in SF bay area" data-original-title="about sfchirps">About us..</a>
			</div>
		</div>
	</div>

</div><!--/container-->
<!--=== End Content Part ===-->

<!-- JS Global Compulsory -->           
<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="js/modernizr.custom.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<!-- JS Implementing Plugins -->           
<script type="text/javascript" src="js/jquery.countdown.js"></script>
<script type="text/javascript" src="js/jquery.backstretch.min.js"></script>
<script type="text/javascript" src="js/back-to-top.js"></script>
<!-- JS Page Level -->           
<script type="text/javascript" src="js/app.js"></script>

<script>
    $.backstretch([
      "img/1.png",
      "img/3.png",
      "img/2.png"
      ], {
        fade: 1000,
        duration: 7000
    });
</script>

<script type="text/javascript">
    jQuery(document).ready(function() {
        App.init();
    });
</script>
<!--[if lt IE 9]>
    <script src="js/respond.js"></script>
<![endif]-->

<!-- Validate plugin -->
<script src="js/jquery.validate.js"></script>


<!-- Scripts specific to this page -->
<script src="js/script.js"></script>

<!-- Google Analytics -->

<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-35884073-2', 'sfchirps.com');
	ga('send', 'pageview');

</script>

<!-- Twitter Tooltip -->
<script>
	$('.tooltipBootstrap').tooltip();
	$("#popoverAboutMe").popover();
</script>


</body>
</html>


<?php
/**

{
	"id":1316672252,
	"id_str":"1316672252",
	"name":"Jelly",
	"screen_name":"askjelly",
	"location":"San Francisco",
	"description":"Let's help each other.",
	"url":"http:\/\/t.co\/3brYnU0qEo",
	"entities":{
	"url":{
		"urls":[
			{
				"url":"http:\/\/t.co\/3brYnU0qEo",
				"expanded_url":"http:\/\/jelly.co",
				"display_url":"jelly.co",
				"indices":[
				0,
				22
				]
			}
			]
	},
	"description":{
		"urls":[]
		}
	},
	"protected":false,
	"followers_count":9716,
	"friends_count":9,
	"listed_count":222,
	"created_at":"Sat Mar 30 15:39:43 +0000 2013",
	"favourites_count":366,
	"utc_offset":-25200,
	"time_zone":"Arizona",
	"geo_enabled":false,
	"verified":true,
	"statuses_count":124,
	"lang":"en",
		"status":{
			"created_at":"Sat Jan 25 06:35:22 +0000 2014",
			"id":426966507277385728,
			"id_str":"426966507277385728",
			"text":"@WesleyTech we made some improvements. People should be able to answer on the web now.",
			"source":"\u003ca href=\"http:\/\/twitter.com\/download\/android\" rel=\"nofollow\"\u003eTwitter for Android\u003c\/a\u003e",
			"truncated":false,
			"in_reply_to_status_id":426935442642964481,
			"in_reply_to_status_id_str":"426935442642964481",
			"in_reply_to_user_id":16102378,
			"in_reply_to_user_id_str":"16102378",
			"in_reply_to_screen_name":"WesleyTech",
			"geo":null,
			"coordinates":null,
			"place":null,
			"contributors":null,
			"retweet_count":0,
			"favorite_count":0,
			"entities":{
				"hashtags":[

				],
				"symbols":[

				],
				"urls":[

				],
				"user_mentions":[
				{
				"screen_name":"WesleyTech",
				"name":"WesleyTech",
				"id":16102378,
				"id_str":"16102378",
				"indices":[
					0,
					11
					]
				}
			  	]
			},
			"favorited":false,
			"retweeted":false,
			"lang":"en"
		},
	"contributors_enabled":false,
	"is_translator":false,
	"profile_background_color":"EEEEEE",
	"profile_background_image_url":"http:\/\/abs.twimg.com\/images\/themes\/theme1\/bg.png",
	"profile_background_image_url_https":"https:\/\/abs.twimg.com\/images\/themes\/theme1\/bg.png",
	"profile_background_tile":false,
	"profile_image_url":"http:\/\/pbs.twimg.com\/profile_images\/378800000699917014\/f5afde1bb618cf59e4739e1ce5d8fe12_normal.png",
	"profile_image_url_https":"https:\/\/pbs.twimg.com\/profile_images\/378800000699917014\/f5afde1bb618cf59e4739e1ce5d8fe12_normal.png",
	"profile_banner_url":"https:\/\/pbs.twimg.com\/profile_banners\/1316672252\/1383687521",
	"profile_link_color":"D97833",
	"profile_sidebar_border_color":"FFFFFF",
	"profile_sidebar_fill_color":"DDEEF6",
	"profile_text_color":"333333",
	"profile_use_background_image":false,
	"default_profile":false,
	"default_profile_image":false,
	"following":true,
	"follow_request_sent":false,
	"notifications":false
}

**/

?>