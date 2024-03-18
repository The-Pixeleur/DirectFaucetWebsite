<?php

session_start();

// Get the target page parameter
$targetPage = isset($_GET['P']) ? $_GET['P'] : '0';

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Direct crypto faucet - Home</title>
	<meta charset="UTF-8">
	<meta name="description" content="Discover the best ways to earn free cryptocurrency with our list of faucets, mobile games, and community of crypto enthusiasts on Discord."> 
	<meta name="keywords" content="crypto, cryptocurrencies, currencies, cryptomonnaie, monnaie, money, faucet, faucet crypto, crypto faucet, robinet, robinet crypto, sol, solana, ban, banano, nano, matic, polygon, algo, algorand, direct faucet, direct">
	<meta name="author" content="Paraxe Paradise">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="./CSS/Maincss.css">
	<link href="./IMG/ServerDiscord/DCFlogo.png" rel="icon">
	<link rel="icon" type="image/x-icon" href="/images/favicon.ico">
	
</head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-LEXZ71K4Q7"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-LEXZ71K4Q7');
</script>
    <!-- Header -->
    <header >
		<h1>Direct Crypto Faucet</h1>
		<nav>
		<div class="hamburger-menu">
			<input id="menu__toggle" type="checkbox" />
			<label class="menu__btn" for="menu__toggle">
			  <span></span>
			</label>
			<ul class="menu__box">
				<li><a class="menu__item" href="?P=0" title="Home menu">Home</a></li>
				<li><a class="menu__item" href="?P=1" title="Faucet list">Faucet list</a></li>
				<li><a class="menu__item" href="?P=2" title="App to earn">play to earn</a></li>
        		<li><a class="menu__item" href="https://pixeleur.fr/?P=Inside_The_Hallway" title="Inside The Hallway">Inside the hallway</a></li>
        		<li><a class="menu__item" href="?P=03" title="Discord server list">Discord Server</a></li>
				<hr id="hr_menu" width="80%" style="margin: auto;">
			</ul>
		</div>
		</nav>
	</header>

    <!-- Content Area -->
    <div class="content">
        <div>
            <?php
            // Get the target page parameter
            $targetPage = isset($_GET['P']) ? $_GET['P'] : '0';

            // Define a mapping of page numbers to corresponding content files
            $contentFiles = [
                '0' => './Pages/home.php',
                '1' => './Pages/faucet.php',
                '2' => './Pages/app.php',
                '3' => './Pages/discord.php',

                '404' => './Pages/unknown.php',
            ];

            // Include the content file based on the target page parameter
            if (isset($contentFiles[$targetPage])) {
                include $contentFiles[$targetPage];
            } else {
                echo '<p>Invalid page parameter</p>';
            }
            ?>
        </div>
    </div>
		  
	<footer class="site-footer">
		<div class="container">
		  <div class="row">
			<div class="col-md-4">
			  <h3>About Us</h3>
			  <p>Find every way to earn free crypto ! Faucet list to your direct wallet, apps to play-to-earn, discord server to earn and much more !</p>
			  <ul class="list-unstyled social-icons">
				<li><a href="https://twitter.com/DCF_faucet" target="_blank"><img src="./IMG/Other/TwitterSN.png" alt="twitter"><i class="fab fa-twitter"></i></a></li>
				<li><a href="https://discord.gg/AEr5zQHnty" target="_blank"><img src="./IMG/Other/discordSN.jpg" alt="discord"><i class="fab fa-discord"></i></a></li>
			  </ul>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-12">
			  <div class="border-top pt-3">
				<p>If you want to tip me here my address : <br></p><p id="wallet_address">0x10e6cd9E2272BaC1b40746F99d9F24daA8f98457</p> <br>
				<p class="text-center">
				  <small class="text-muted">Copyright © 
					<script>document.write(new Date().getFullYear());</script> 
					 | Direct crypto faucet
				  </small>
				</p>
			  </div>
			</div>
		  </div>
		</div>
	</footer>
	<script src="./JS/index.js"></script>
</body>
</html>
