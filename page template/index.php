<?php session_start(); 
	require_once("theme-functions.php"); 
	require_once("admin-functions.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=320"/>
		<title>Imaginalien</title>
		<link rel="stylesheet" media="only screen and (max-device-width: 400px)" href="mobile-device.css"/>
		<link rel="stylesheet" media="only screen and (min-device-width: 401px)" href="desktop.css"/>
		<link rel="icon" type="image/ico" href="images/icon.ico"/>
		<script type="text/javascript" src="validation.js"></script>
		
		<style type="text/css" media="only screen and (min-width: 401px)">#daily-theme {display: none;}</style>
	</head>
	<body>
	<div id="fb-root"></div>
	<div id="container">

		<div id="header">
			<?php
				ob_start();
				include 'header.php';
				$out = ob_get_contents();
				ob_end_clean();
				echo $out;
			?>
		</div>
		<div id="nav">
			<?php
				ob_start();
				include 'navigation.php';
				$out = ob_get_contents();
				ob_end_clean();
				echo $out;
			?>
		</div>

		<div id="login">
				<?php
				ob_start();
				include 'login.php';
				$out = ob_get_contents();
				ob_end_clean();
				echo $out;
			?>
		</div>
		<div id="content">
			<iframe width="756" height="567" src="http://www.youtube.com/embed/WvEYV72h9ik" frameborder="0" allowfullscreen class="center-image desktop-only"></iframe>
			<iframe width="300" height="225" src="http://www.youtube.com/embed/WvEYV72h9ik" frameborder="0" allowfullscreen class="center-image mobile-only"></iframe>
			<hr/>
			<br/>
			<div id="right-column-home" class="desktop-only">
				<p id="mission-pic"><img src="images/mission.jpg" width="200" height="200" title="Daily mission"/></p>
				<p id="mission-text">'<?php echo get_daily_theme(); ?>'</p>
				
				<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2FImaginalien&amp;width=290&amp;height=395&amp;show_faces=false&amp;colorscheme=light&amp;stream=true&amp;border_color&amp;header=false" 
				scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:290px; height:395px;" allowTransparency="true"></iframe>
			</div>
			<div id="left-column-home">
				<h3>Current News</h3>
				<hr/>
				<p>
				<!-- PUT NEWS HERE ************************************************************************************************ -->
				Welcome to week 2 of Imaginalien!
				</p>
				<p>
				Login, upload some photos and check out your current points now! Don't forget to check your place on the leaderboard
				and the recently submitted photos.
				</p>
				<p>
				Voting has commenced! Vote for top photos of last week, the winner will recieve bonus points. If you haven't already, please like the 
				Facebook page at: <a href="https://www.facebook.com/Imaginalien">facebook.com/Imaginalien</a>.
				</p>
				<h3>What Is It?</h3>
				<hr/>
					<p>Imaginalien is a photo-based game that will be played at Swinburne from the 6th to the 31st of May. 
					All you need to play is a mobile phone with a camera and a keen imagination.</p>
					<p><img src="images/barPics.jpg" width="480" height="80" class="desktop-only"/></p>
				<h3>How Do I Play?</h3>
				<hr/>
				<div id="left-info">
					<p><img src="images/info-1.jpg" width="200" height="200" title="Check the daily challenge"/></p>
					<p><strong>1. Get your mission</strong></p>
					<p>Access the website from your mobile and view the daily mission.</p>
				</div>
				<div class="right-info">
					<p><img src="images/info-2.jpg" width="200" height="200" title="Take a photo"/></p>
					<p><strong>2. Take your photos</strong></p>
					<p>Search the Swinburne campus for the best photo opportunities and shoot them on your mobile or camera.</p>
				</div>
				<div class="half-column clear-columnn">
					<p><img src="images/info-3.jpg" width="200" height="200" title="Upload your photos"/></p>
					<p><strong>3. Upload your photos</strong></p>
					<p>Upload your photos to the website and try to top the leaderboards, becoming the ultimate <em>minion of the month</em>.</p>
					<br/>
					<p><a href="instructions.php" title="Instructions">Full instructions</a></p>
				</div>
				<hr/>
				<h3>Who is Kodack?</h3>
				<p>You have been recruited by Kodack, the leader of an alien race that has set their eye's upon Swinburne.
				They are searching for greater knowledge of mankind and it's up to you to find them the Intel. 
				Fetch your cameras and be ready for his first mission.
				</p>
			</div>
		</div>
		<div id="footer">
			<?php
				ob_start();
				include 'footer.php';
				$out = ob_get_contents();
				ob_end_clean();
				echo $out;
			?>
		</div>
	</div>
	</body>
</html>