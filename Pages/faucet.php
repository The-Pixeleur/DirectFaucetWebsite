<!DOCTYPE html>
<html lang="en">
<head>
	<title>DCF - Faucet List</title>
	<link rel="icon" type="image/x-icon" href="/IMG/Other/favicon.ico">
	
	<!-- Primary Meta Tags -->
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
	<meta name="title" content="Direct Crypto Faucet - Earn Free Cryptocurrency Instantly | Free Crypto Faucets">
	<meta name="description" content="Earn free cryptocurrency instantly with Direct Crypto Faucet. Simply enter your wallet address, solve a captcha, and receive free crypto. Curated list of legitimate crypto faucets by Pixeleur.">
	<meta name="keywords" content="crypto faucet, free cryptocurrency, earn crypto, bitcoin faucet, ethereum faucet, solana faucet, banano faucet, nano faucet, polygon faucet, algorand faucet, direct crypto, crypto earning, cryptocurrency faucet list, instant crypto, free crypto rewards, crypto airdrop, digital currency faucet">
	<meta name="author" content="Pixeleur - French Game Studio">
	<meta name="robots" content="index, follow">
	<meta name="language" content="English">
	<meta name="revisit-after" content="7 days">
	
	<!-- Open Graph / Facebook -->
	<meta property="og:type" content="website">
	<meta property="og:url" content="https://directfaucet.cc/">
	<meta property="og:title" content="Direct Crypto Faucet - Earn Free Cryptocurrency Instantly">
	<meta property="og:description" content="Earn free cryptocurrency instantly with Direct Crypto Faucet. Simply enter your wallet address, solve a captcha, and receive free crypto. Curated list of legitimate crypto faucets by Pixeleur.">
	<meta property="og:image" content="./IMG/Other/DCFlogo.png">
	
	<!-- Twitter -->
	<meta property="twitter:card" content="summary_large_image">
	<meta property="twitter:url" content="https://directfaucet.cc/">
	<meta property="twitter:title" content="Direct Crypto Faucet - Earn Free Cryptocurrency Instantly">
	<meta property="twitter:description" content="Earn free cryptocurrency instantly with Direct Crypto Faucet. Simply enter your wallet address, solve a captcha, and receive free crypto. Curated list of legitimate crypto faucets by Pixeleur.">
	<meta property="twitter:image" content="./IMG/Other/DCFlogo.png">
	
	<!-- Additional SEO Meta Tags -->
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-title" content="Direct Crypto Faucet">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="theme-color" content="#0f172a">
	
	<!-- Canonical URL -->
	<link rel="canonical" href="https://directfaucet.cc/">
	
	<!-- Stylesheets -->
	<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
	
	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-LEXZ71K4Q7"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());
	  gtag('config', 'G-LEXZ71K4Q7');
	</script>
    <!-- CoinGecko API Integration -->
    <script>
        let prices = {};
        let selectedCurrency = 'usd';
        const currencySymbols = {
            'usd': '$',
            'eur': '€',
            'gbp': '£',
            'btc': '₿'
        };

        // Special case mappings for CoinGecko IDs
        const coinGeckoMappings = {
            'btc': 'bitcoin',
            'pol': 'matic-network',  // MATIC is now POL but still uses matic-network ID
            'algo': 'algorand',
            'matic': 'matic-network' // Fallback for any old MATIC references
        };

        // Convert satoshis to BTC (1 BTC = 100,000,000 satoshis)
        function satoshiToBTC(satoshi) {
            return satoshi / 100000000;
        }

        // Convert BTC to satoshis
        function btcToSatoshi(btc) {
            return btc * 100000000;
        }

        async function fetchPrices(coinIds) {
            try {
                // Map the coin IDs to their CoinGecko IDs
                const geckoIds = coinIds.map(id => coinGeckoMappings[id.toLowerCase()] || id.toLowerCase());
                const response = await fetch(`https://api.coingecko.com/api/v3/simple/price?ids=${geckoIds.join(',')}&vs_currencies=usd,eur,gbp,btc`);
                const data = await response.json();
                prices = data;
                updateAllPrices();
            } catch (error) {
                console.error('Error fetching prices:', error);
            }
        }

        function updateAllPrices() {
            // Reset portfolio data
            portfolioData = {};

            document.querySelectorAll('.token-price').forEach(priceElement => {
                const coinId = priceElement.dataset.coinId.toLowerCase();
                const geckoId = coinGeckoMappings[coinId] || coinId;
                
                if (prices[geckoId]) {
                    let price = prices[geckoId][selectedCurrency];
                    
                    // Special handling for Bitcoin/satoshi display
                    if (coinId === 'btc') {
                        if (selectedCurrency === 'btc') {
                            price = '1 sat = 0.00000001 BTC';
                        } else {
                            price = `1 sat = ${(price / 100000000).toFixed(8)} ${currencySymbols[selectedCurrency]}`;
                        }
                        priceElement.textContent = price;
                    } else {
                        priceElement.innerHTML = `<span class="font-medium">${currencySymbols[selectedCurrency]}</span>${price.toFixed(8)}`;
                    }
                } else {
                    priceElement.innerHTML = `<span class="text-gray-500">Loading...</span>`;
                }
            });

            document.querySelectorAll('.token-total').forEach(totalElement => {
                const coinId = totalElement.dataset.coinId.toLowerCase();
                const geckoId = coinGeckoMappings[coinId] || coinId;
                const tokenAmount = parseFloat(totalElement.dataset.amount);
                const tokenSection = totalElement.closest('section');
                const tokenLogo = tokenSection ? tokenSection.querySelector('img').src : '';
                const displayName = tokenSection ? tokenSection.querySelector('h2').textContent.trim() : coinId.toUpperCase();
                
                if (prices[geckoId]) {
                    let price = prices[geckoId][selectedCurrency];
                    let total;
                    
                    // Special handling for Bitcoin/satoshi calculations
                    if (coinId === 'btc') {
                        const btcAmount = satoshiToBTC(tokenAmount);
                        if (selectedCurrency === 'btc') {
                            total = btcAmount;
                        } else {
                            total = btcAmount * price;
                        }
                    } else {
                        total = tokenAmount * price;
                    }
                    
                    // Animate the total value
                    const oldValue = parseFloat(totalElement.getAttribute('data-displayed-value') || '0');
                    const newValue = total;
                    
                    animateValue(totalElement, oldValue, newValue, 800);
                    totalElement.setAttribute('data-displayed-value', newValue);
                    
                    // Update portfolio data
                    portfolioData[coinId] = {
                        value: total,
                        amount: tokenAmount,
                        displayName: displayName,
                        logo: tokenLogo
                    };
                } else {
                    totalElement.innerHTML = `<span class="text-gray-500">Loading...</span>`;
                }
            });

            // Update portfolio display
            updatePortfolio();
        }
        
        // Function to animate numerical values
        function animateValue(element, start, end, duration) {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                const value = progress * (end - start) + start;
                element.innerHTML = `<span class="font-medium">${currencySymbols[selectedCurrency]}</span>${value.toFixed(4)}`;
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }

        function changeCurrency(currency) {
            selectedCurrency = currency;
            updateAllPrices();
            
            // Update active currency button
            document.querySelectorAll('.currency-btn').forEach(btn => {
                if (btn.dataset.currency === currency) {
                    btn.classList.add('active-currency');
                } else {
                    btn.classList.remove('active-currency');
                }
            });
        }
    </script>
    <style>
        /* Custom gradient backgrounds */
        .bg-crypto-gradient {
            background: linear-gradient(135deg, #4a148c 0%, #1a237e 50%, #0d47a1 100%);
        }
        
        /* Custom card styles */
        .crypto-card {
            background: rgba(26, 32, 44, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(66, 153, 225, 0.1);
            transition: all 0.3s ease;
        }
        
        .crypto-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(66, 153, 225, 0.1);
        }
        
        /* Custom table styles */
        .crypto-table th {
            background-color: rgba(45, 55, 72, 0.8);
            backdrop-filter: blur(4px);
            position: sticky;
            top: 0;
        }
        
        .crypto-table tr:hover td {
            background-color: rgba(45, 55, 72, 0.3);
        }
        
        /* Animated elements */
        .hover-scale {
            transition: transform 0.2s ease;
        }
        
        .hover-scale:hover {
            transform: scale(1.05);
        }
        
        /* Currency button active state */
        .currency-btn.active-currency {
            background-color: rgba(66, 153, 225, 0.5);
            border-color: rgba(66, 153, 225, 0.8);
            box-shadow: 0 0 12px rgba(66, 153, 225, 0.3);
        }
        
        /* Floating animation for hero image */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .animate-float {
            animation: float 5s ease-in-out infinite;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #1a202c;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #4a5568;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #718096;
        }

        #portfolioDetails {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-in-out;
        }
        #portfolioDetails:not(.hidden) {
            max-height: 1000px;
        }
        
        /* Quick nav item styles */
        .quick-nav-item {
            transition: all 0.2s ease;
            background: rgba(26, 32, 44, 0.8);
            border: 1px solid rgba(66, 153, 225, 0.2);
        }
        
        .quick-nav-item:hover {
            transform: translateY(-3px) scale(1.03);
            background: rgba(45, 55, 72, 0.8);
            border-color: rgba(66, 153, 225, 0.5);
            box-shadow: 0 8px 16px -4px rgba(66, 153, 225, 0.15);
        }
    </style>
</head>
<body class="bg-gray-900 text-white min-h-screen flex flex-col">
	<!-- Header with enhanced gradient background -->
	<header class="bg-crypto-gradient shadow-lg border-b border-blue-900">
		<div class="container mx-auto px-4 py-4">
			<div class="flex justify-between items-center">
				<div class="flex items-center space-x-3">
					<img src="./IMG/Other/DCFlogo.png" alt="DCF Logo" class="h-12 w-12 hover-scale">
					<h1 class="text-2xl font-bold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-400">Direct Crypto Faucet</h1>
				</div>
				
				<!-- Desktop Navigation -->
				<nav class="hidden md:flex space-x-8">
					<a href="/" class="text-white hover:text-blue-300 transition font-medium relative group">
                        Home
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-400 transition-all group-hover:w-full"></span>
                    </a>
					<a href="/faucet" class="text-white hover:text-blue-300 transition font-medium relative group">
                        Faucet List
                        <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-blue-400"></span>
                    </a>
				</nav>
				
				<!-- Mobile Navigation -->
				<div class="md:hidden">
					<button id="mobile-menu-button" class="text-white focus:outline-none p-2 rounded-lg hover:bg-blue-800 transition">
						<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
						</svg>
					</button>
				</div>
			</div>
			
			<!-- Mobile Menu (Hidden by default) -->
			<div id="mobile-menu" class="md:hidden hidden mt-4 bg-gray-800 rounded-lg p-4 border border-blue-900 shadow-xl">
				<a href="/" class="block py-3 px-4 text-white hover:bg-blue-800 rounded-md transition mb-1">Home</a>
				<a href="/faucet" class="block py-3 px-4 text-white bg-blue-900 rounded-md transition">Faucet List</a>
			</div>
		</div>
	</header>

	<!-- Content Area -->
	<div class="bg-gradient-to-b from-gray-900 to-gray-800 min-h-screen">
		<div class="container mx-auto px-4 py-10 max-w-7xl">
			<!-- Enhanced Header Section -->
            <div class="mb-16">
                <!-- Hero Section -->
                <div class="bg-gradient-to-r from-indigo-900 via-blue-800 to-purple-900 rounded-2xl p-8 mb-10 shadow-xl transform hover:scale-[1.01] transition-all duration-300">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div class="mb-6 md:mb-0 md:mr-8">
                            <h2 class="text-5xl font-bold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-blue-300 to-purple-300">Crypto Faucet Explorer</h2>
                            <p class="text-blue-100 max-w-2xl text-lg">Discover the best ways to earn free cryptocurrency directly to your wallet. Our curated list is regularly updated with the most reliable faucets available.</p>
                        </div>
                        <div class="relative">
                            <img src="./IMG/Other/DCFlogo.png" alt="Crypto Coins" class="h-32 md:h-44 filter drop-shadow-xl animate-float">
                            <div class="absolute top-0 right-0 -mr-2 -mt-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-lg animate-pulse">Updated Daily</div>
                        </div>
                    </div>
                </div>
                
                <!-- Control Panel -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Currency Selector Panel -->
                    <div class="crypto-card rounded-xl shadow-lg overflow-hidden bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 transform hover:translate-y-[-5px] transition-all duration-300">
                        <div class="px-6 py-5">
                            <div class="flex items-center space-x-3 mb-4">
                                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-xl font-semibold">Select Display Currency</span>
                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-center">
                                <button onclick="changeCurrency('usd')" class="currency-btn rounded-lg px-4 py-3 bg-gray-700 hover:bg-blue-700 focus:bg-blue-700 transition-colors border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 active-currency" data-currency="usd">
                                    <div class="text-2xl font-bold">$</div>
                                    <div class="text-xs mt-1">USD</div>
                                </button>
                                <button onclick="changeCurrency('eur')" class="currency-btn rounded-lg px-4 py-3 bg-gray-700 hover:bg-blue-700 transition-colors border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" data-currency="eur">
                                    <div class="text-2xl font-bold">€</div>
                                    <div class="text-xs mt-1">EUR</div>
                                </button>
                                <button onclick="changeCurrency('gbp')" class="currency-btn rounded-lg px-4 py-3 bg-gray-700 hover:bg-blue-700 transition-colors border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" data-currency="gbp">
                                    <div class="text-2xl font-bold">£</div>
                                    <div class="text-xs mt-1">GBP</div>
                                </button>
                                <button onclick="changeCurrency('btc')" class="currency-btn rounded-lg px-4 py-3 bg-gray-700 hover:bg-blue-700 transition-colors border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" data-currency="btc">
                                    <div class="text-2xl font-bold">₿</div>
                                    <div class="text-xs mt-1">BTC</div>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Portfolio Panel -->
                    <div class="crypto-card rounded-xl shadow-lg overflow-hidden bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 transform hover:translate-y-[-5px] transition-all duration-300 lg:col-span-2">
                        <button onclick="togglePortfolio()" class="w-full px-6 py-5 flex justify-between items-center hover:bg-gray-700 transition-colors text-left">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-blue-900 bg-opacity-50 rounded-lg">
                                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M3 12h18m-18 6h18"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-xl font-semibold">Your Potential Portfolio</span>
                                    <p class="text-gray-400 text-sm">Estimated value if you claim from all faucets</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div class="text-right">
                                    <div class="text-sm text-gray-400">Total Value</div>
                                    <span id="totalPortfolioValue" class="text-green-400 font-bold text-xl">Calculating...</span>
                                </div>
                                <div class="bg-gray-700 rounded-full p-1">
                                    <svg id="portfolioArrow" class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </button>
                        <div id="portfolioDetails" class="hidden">
                            <div class="px-6 py-4 border-t border-gray-700">
                                <div class="space-y-3" id="portfolioBreakdown">
                                    <!-- Portfolio items will be dynamically inserted here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Navigation -->
                <div class="crypto-card rounded-xl shadow-lg overflow-hidden bg-gradient-to-b from-gray-800 to-gray-900 border border-gray-700 p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4">
                        <div class="flex items-center space-x-3 mb-3 sm:mb-0">
                            <div class="p-2 bg-blue-900 bg-opacity-50 rounded-lg">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold">Jump to Crypto</h3>
                        </div>
                        <div class="text-sm text-gray-400 italic">Click any coin to jump to its faucets</div>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3" id="quickNavLinks">
                        <!-- Quick nav links will be dynamically generated by PHP -->
                    </div>
                </div>
            </div>
			
			<?php
			// Function declarations - moved to top and protected against redeclaration
			if (!function_exists('getTokenDisplayName')) {
				function getTokenDisplayName($tokenName) {
					$tokenMap = [
						'MATIC' => 'POL',
						'BTC' => 'sats',
						'ALGO' => 'Algorand'
					];
					return isset($tokenMap[$tokenName]) ? $tokenMap[$tokenName] : $tokenName;
				}
			}
			
			if (!function_exists('getCoinGeckoId')) {
				function getCoinGeckoId($tokenName) {
					$tokenName = strtolower($tokenName);
					if ($tokenName === 'matic') return 'pol';
					if ($tokenName === 'btc') return 'btc';
					if ($tokenName === 'algo') return 'algo';
					return $tokenName;
				}
			}

			// Check which path to data.php is correct
			$pathOne = __DIR__ . '/../data/data.php';
			$pathTwo = __DIR__ . '/data/data.php';
			$pathThree = __DIR__ . '/../../data/data.php';
			
			if (file_exists($pathOne)) {
				require_once $pathOne;
				echo "<!-- Debug: Loaded data.php from $pathOne -->\n";
			} elseif (file_exists($pathTwo)) {
				require_once $pathTwo;
				echo "<!-- Debug: Loaded data.php from $pathTwo -->\n";
			} elseif (file_exists($pathThree)) {
				require_once $pathThree;
				echo "<!-- Debug: Loaded data.php from $pathThree -->\n";
			} else {
				echo "<!-- Debug: Cannot find data.php file. Path issue detected. -->\n";
				echo '<div class="bg-red-900 text-white p-6 rounded-lg shadow-lg mb-8 mx-auto max-w-2xl">';
				echo '<div class="flex items-center mb-4">';
				echo '<svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">';
				echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>';
				echo '</svg>';
				echo '<h3 class="text-lg font-semibold">Database Configuration Error</h3>';
				echo '</div>';
				echo '<p>Could not find the data.php file. Please check the server configuration.</p>';
				echo '</div>';
				exit;
			}

			try {
				// Try to get a database connection
				$conn = getDbConnection();

				// Fetch data from the CryptoFaucet table
				$sql = "SELECT * FROM CryptoFaucet";
				$result = $conn->query($sql);

				// Create an array to hold the data for each section
				$sections = array();

				if ($result->num_rows > 0) {
					// Loop through each row of the result
					while ($row = $result->fetch_assoc()) {
						$tokenName = $row["TokenName"];
						// If section doesn't exist, create it
						if (!isset($sections[$tokenName])) {
							$sections[$tokenName] = array();
						}
						// Add the row to the appropriate section
						$sections[$tokenName][] = $row;
					}
				}

				// Populate dynamic Quick Navigation
				if (count($sections) > 0) {
					echo '<script>const quickNavContainer = document.getElementById("quickNavLinks");</script>';
					
					foreach (array_keys($sections) as $tokenName) {
						// Find logo and token data
						$logo = '';
						$totalPayout = 0;
						$faucetCount = count($sections[$tokenName]);
						
						foreach ($sections[$tokenName] as $row) {
							if (!empty($row["TokenLogo"])) {
								$logo = $row["TokenLogo"];
							}
							$totalPayout += floatval(str_replace([' ', $row["TokenName"]], '', $row["AveragePayout"]));
						}
						
						$displayTokenName = getTokenDisplayName($tokenName);
						
						echo '<script>';
						echo 'quickNavContainer.innerHTML += `
							<a href="#'.strtolower($tokenName).'" class="quick-nav-item p-3 rounded-xl flex items-center gap-3 hover:bg-blue-800">
								<img src="' . $logo . '" alt="' . $displayTokenName . '" class="w-10 h-10 rounded-full shadow-lg">
								<div class="flex-1">
									<div class="font-semibold">' . $displayTokenName . '</div>
									<div class="flex justify-between text-xs text-gray-400">
										<span>' . $faucetCount . ' faucet' . ($faucetCount != 1 ? 's' : '') . '</span>
										<span class="text-green-400">' . $totalPayout . ' ' . $displayTokenName . '</span>
									</div>
								</div>
							</a>
						`;';
						echo '</script>';
					}
				}

				// Output the sections and their respective tables
				foreach ($sections as $tokenName => $sectionData) {
					echo '<section id="' . strtolower($tokenName) . '" class="mb-16 scroll-mt-20">';
					echo '<div class="flex items-center space-x-3 mb-6">';
					echo '<img src="' . $sectionData[0]["TokenLogo"] . '" alt="' . $tokenName . '" class="w-10 h-10 rounded-full shadow-lg p-1 bg-gray-700">';
					echo '<h2 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-400">' . $tokenName . '</h2>';
					echo '</div>';
					
					echo '<div class="overflow-x-auto bg-gray-800 rounded-xl shadow-lg border border-gray-700">';
					echo '<table class="min-w-full divide-y divide-gray-700 crypto-table">';
					echo '<thead class="bg-gray-700">';
					echo '<tr>';
					echo '<th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Site Name</th>';
					echo '<th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Token/Blockchain</th>';
					echo '<th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Current Price</th>';
					echo '<th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Time Between Withdrawals</th>';
					echo '<th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Average Payout</th>';
					echo '</tr>';
					echo '</thead>';
					echo '<tbody class="bg-gray-800 divide-y divide-gray-700">';
					
					$rowClass = 'bg-gray-800';
					$totalPayout = 0;
					
					foreach ($sectionData as $row) {
						$rowClass = $rowClass === 'bg-gray-800' ? 'bg-gray-750' : 'bg-gray-800';
						$displayTokenName = getTokenDisplayName($row["TokenName"]);
						$totalPayout += floatval(str_replace([' ', $row["TokenName"]], '', $row["AveragePayout"]));
						
						echo '<tr class="' . $rowClass . ' hover:bg-gray-700 transition-colors">';
						echo '<td class="px-6 py-4 whitespace-nowrap">';
						echo '<a href="' . $row["SiteURL"] . '" class="text-blue-400 hover:text-blue-300 font-medium hover:underline flex items-center" target="_blank">';
                        echo '<span>' . $row["SiteName"] . '</span>';
                        echo '<svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">';
                        echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>';
                        echo '</svg>';
                        echo '</a>';
						echo '</td>';
						echo '<td class="px-6 py-4 whitespace-nowrap">';
						echo '<div class="flex items-center">';
						echo '<img src="' . htmlspecialchars($row["BlockchainLogo"]) . '" alt="' . htmlspecialchars($displayTokenName) . '" class="w-8 h-8 mr-2 rounded-full object-cover">';
						echo '<span>' . htmlspecialchars($displayTokenName) . '</span>';
						echo '</div>';
						echo '</td>';
						echo '<td class="px-6 py-4 whitespace-nowrap">';
						echo '<span class="token-price" data-coin-id="' . getCoinGeckoId($row["TokenName"]) . '">No data</span>';
						echo '</td>';
						echo '<td class="px-6 py-4 whitespace-nowrap">' . $row["Delay"] . '</td>';
						echo '<td class="px-6 py-4 whitespace-nowrap font-medium text-green-400">' . str_replace($row["TokenName"], $displayTokenName, $row["AveragePayout"]) . '</td>';
						echo '</tr>';
					}
					
					echo '</tbody>';
					echo '</table>';
					echo '<div class="mt-1 p-4 bg-gradient-to-r from-gray-700 to-gray-800 rounded-b-lg">';
					echo '<div class="flex justify-between items-center">';
					echo '<span class="font-medium flex items-center"><svg class="w-5 h-5 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>Total Possible Payout:</span>';
					echo '<div class="flex items-center space-x-4">';
					echo '<span class="text-green-400 font-bold">' . $totalPayout . ' ' . getTokenDisplayName($tokenName) . '</span>';
					echo '<span class="token-total bg-gray-900 px-3 py-1 rounded-lg shadow-inner" data-coin-id="' . getCoinGeckoId($tokenName) . '" data-amount="' . $totalPayout . '">No data</span>';
					echo '</div>';
					echo '</div>';
					echo '</div>';
					echo '</div>';
					echo '</section>';
				}

				// If there's an issue, show a no faucets message
				if (count($sections) === 0) {
					echo '<div class="text-center py-16 crypto-card rounded-xl">';
					echo '<svg class="w-20 h-20 mx-auto text-gray-500 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">';
					echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
					echo '</svg>';
					echo '<h3 class="text-2xl font-semibold mb-4">No Faucets Available</h3>';
					echo '<p class="text-gray-400">We\'re currently updating our faucet list. Please check back soon!</p>';
					echo '</div>';
				}

				$conn->close();
			} catch (Exception $e) {
				echo '<div class="bg-red-900 text-white p-6 rounded-lg shadow-lg mb-8 mx-auto max-w-2xl">';
				echo '<div class="flex items-center mb-4">';
				echo '<svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">';
				echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>';
				echo '</svg>';
				echo '<h3 class="text-lg font-semibold">Database Connection Error</h3>';
				echo '</div>';
				echo '<p>We\'re experiencing technical difficulties. Please try again later.</p>';
				echo '</div>';
			}
			?>
			
		</div>
	</div>

	<!-- Footer -->
	<footer class="bg-gray-900 mt-auto border-t border-gray-800">
		<div class="container mx-auto px-4 py-16">
			<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
				<!-- About Us Column -->
				<div>
					<div class="flex items-center mb-6">
						<img src="./IMG/Other/DCFlogo.png" alt="DCF Logo" class="h-10 w-10 mr-3">
						<h3 class="text-xl font-bold">Direct Crypto Faucet</h3>
					</div>
					<p class="text-gray-400 mb-6">
						Find every way to earn free crypto! Faucet list to your direct wallet, apps to play-to-earn, and much more!
					</p>
					<!-- CoinGecko Attribution -->
					<div class="flex items-center mt-8 p-4 bg-gray-800 rounded-lg border border-gray-700">
						<img src="https://static.coingecko.com/s/coingecko-logo-8903d34ce19ca4be1c81f0db30e924154750d208683fad7ae6f2ce06c76d0a56.png" alt="CoinGecko Logo" class="h-6 mr-3">
						<div class="text-sm text-gray-400">
							Cryptocurrency prices powered by <a href="https://www.coingecko.com/" class="text-blue-400 hover:underline" target="_blank">CoinGecko API</a>
						</div>
					</div>
				</div>
				
				<!-- Navigation Links -->
				<div>
					<h3 class="text-xl font-bold mb-6">Quick Links</h3>
					<ul class="space-y-3">
						<li><a href="/" class="text-gray-400 hover:text-white transition flex items-center">
							<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
							</svg>
							Home
						</a></li>
						<li><a href="/faucet" class="text-gray-400 hover:text-white transition flex items-center">
							<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
							</svg>
							Faucet List
						</a></li>
						<li><a href="/faq" class="text-gray-400 hover:text-white transition flex items-center">
							<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
							</svg>
							FAQ
						</a></li>
						<li><a href="/getting-started" class="text-gray-400 hover:text-white transition flex items-center">
							<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
							</svg>
							Getting Started
						</a></li>
					</ul>
				</div>
				
				<!-- Contact Info -->
				<div>
					<h3 class="text-xl font-bold mb-6">Contact Us</h3>
					<ul class="space-y-3">
						<li class="flex items-center text-gray-400">
							<svg class="w-5 h-5 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
							</svg>
							<a href="mailto:support@directfaucet.cc" class="hover:text-blue-400 transition">support@directfaucet.cc</a>
						</li>
						<li class="flex items-center text-gray-400">
							<svg class="w-5 h-5 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
							</svg>
							<a href="/faq" class="hover:text-blue-400 transition">FAQ & Support</a>
						</li>
					</ul>
					
					<!-- Back to Top Button -->
					<div class="mt-8">
						<a href="#" class="flex items-center justify-center gap-2 p-3 bg-blue-900 bg-opacity-50 hover:bg-opacity-70 rounded-lg transition transform hover:translate-y-[-3px]">
							<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11l7-7 7 7M5 19l7-7 7 7"></path>
							</svg>
							<span class="font-medium">Back to Top</span>
						</a>
					</div>
				</div>
			</div>
			
			<div class="border-t border-gray-800 mt-12 pt-8">
				<div class="flex flex-col md:flex-row justify-between items-center">
					<p class="text-gray-500 mb-4 md:mb-0">
						Copyright © <script>document.write(new Date().getFullYear());</script> | Direct Crypto Faucet | All Rights Reserved
					</p>
					<div class="flex space-x-6">
						<a href="/privacy-policy" class="text-gray-500 hover:text-gray-400 transition">Privacy Policy</a>
						<a href="/tos" class="text-gray-500 hover:text-gray-400 transition">Terms of Service</a>
						<a href="/cookies" class="text-gray-500 hover:text-gray-400 transition">Cookie Policy</a>
					</div>
				</div>
			</div>
		</div>
	</footer>

	<script>
		// Mobile menu toggle
		document.getElementById('mobile-menu-button').addEventListener('click', function() {
			document.getElementById('mobile-menu').classList.toggle('hidden');
		});
		
		// Close mobile menu when clicking outside
		document.addEventListener('click', function(event) {
			const mobileMenu = document.getElementById('mobile-menu');
			const mobileMenuButton = document.getElementById('mobile-menu-button');
			
			if (!mobileMenu.contains(event.target) && !mobileMenuButton.contains(event.target) && !mobileMenu.classList.contains('hidden')) {
				mobileMenu.classList.add('hidden');
			}
		});

        // Enhanced portfolio toggle function with animation
        function togglePortfolio() {
            const details = document.getElementById('portfolioDetails');
            const arrow = document.getElementById('portfolioArrow');
            
            if (details.classList.contains('hidden')) {
                details.classList.remove('hidden');
                details.style.maxHeight = '0';
                setTimeout(() => {
                    details.style.maxHeight = details.scrollHeight + 'px';
                }, 10);
                arrow.classList.add('rotate-180');
            } else {
                details.style.maxHeight = '0';
                arrow.classList.remove('rotate-180');
                setTimeout(() => {
                    details.classList.add('hidden');
                }, 300);
            }
        }

        // Enhanced portfolio display
        let portfolioData = {};

        function updatePortfolio() {
            const breakdown = document.getElementById('portfolioBreakdown');
            const totalValueElement = document.getElementById('totalPortfolioValue');
            let totalValue = 0;
            let portfolioHtml = '';

            // Sort tokens by value
            const sortedTokens = Object.entries(portfolioData)
                .sort(([,a], [,b]) => b.value - a.value);
                
            if (sortedTokens.length === 0) {
                portfolioHtml = `
                    <div class="flex justify-center items-center p-6 text-gray-400">
                        <svg class="w-5 h-5 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Loading portfolio data...
                    </div>
                `;
            } else {
                for (const [token, data] of sortedTokens) {
                    if (data.value > 0) {
                        portfolioHtml += `
                            <div class="flex justify-between items-center p-3 rounded bg-gray-750 hover:bg-gray-700 transition-all duration-200 transform hover:scale-102">
                                <div class="flex items-center space-x-3">
                                    <img src="${data.logo}" alt="${data.displayName}" class="w-6 h-6 rounded-full">
                                    <span>${data.displayName}</span>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm text-gray-400">${data.amount} ${data.displayName}</div>
                                    <div class="text-green-400 font-medium">${currencySymbols[selectedCurrency]}${data.value.toFixed(4)}</div>
                                </div>
                            </div>
                        `;
                        totalValue += data.value;
                    }
                }
            }

            breakdown.innerHTML = portfolioHtml;
            
            // Animate counting up for total value
            const currentValue = parseFloat(totalValueElement.getAttribute('data-value') || '0');
            const duration = 1000; // ms
            const framesCount = 20;
            const step = (totalValue - currentValue) / framesCount;
            
            let currentFrame = 0;
            const interval = setInterval(() => {
                currentFrame++;
                const progress = currentFrame / framesCount;
                const displayValue = currentValue + (totalValue - currentValue) * progress;
                
                totalValueElement.textContent = `${currencySymbols[selectedCurrency]}${displayValue.toFixed(4)}`;
                
                if (currentFrame === framesCount) {
                    clearInterval(interval);
                    totalValueElement.setAttribute('data-value', totalValue);
                }
            }, duration / framesCount);
        }

        // Scroll effects for sections
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize active currency
            document.querySelector(`.currency-btn[data-currency="${selectedCurrency}"]`).classList.add('active-currency');
            
            // Add smooth scrolling for navigation links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);
                    
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 100,
                            behavior: 'smooth'
                        });
                        
                        // Highlight the section briefly
                        targetElement.classList.add('highlight-section');
                        setTimeout(() => {
                            targetElement.classList.remove('highlight-section');
                        }, 1500);
                        
                        // Add visual feedback to clicked navigation item
                        const allNavItems = document.querySelectorAll('.quick-nav-item');
                        allNavItems.forEach(item => item.classList.remove('ring-2', 'ring-blue-500'));
                        
                        if (this.classList.contains('quick-nav-item')) {
                            this.classList.add('ring-2', 'ring-blue-500');
                            setTimeout(() => {
                                this.classList.remove('ring-2', 'ring-blue-500');
                            }, 2000);
                        }
                    }
                });
            });
            
            // Add the highlighting style
            document.head.insertAdjacentHTML('beforeend', `
                <style>
                    @keyframes section-highlight {
                        0% { box-shadow: 0 0 0 0 rgba(66, 153, 225, 0); }
                        50% { box-shadow: 0 0 0 10px rgba(66, 153, 225, 0.3); }
                        100% { box-shadow: 0 0 0 0 rgba(66, 153, 225, 0); }
                    }
                    
                    .highlight-section {
                        animation: section-highlight 1.5s ease-in-out;
                    }
                    
                    @media (prefers-reduced-motion: reduce) {
                        .highlight-section {
                            animation: none;
                        }
                    }
                </style>
            `);
            
            // Initialize CoinGecko price fetching
            const coinIds = Array.from(document.querySelectorAll('.token-price'))
                                .map(el => el.dataset.coinId)
                                .filter((value, index, self) => self.indexOf(value) === index);
            
            if (coinIds.length > 0) {
                fetchPrices(coinIds);
                // Add a visual loading indicator
                document.querySelectorAll('.token-price, .token-total').forEach(el => {
                    el.innerHTML = `<span class="flex items-center"><svg class="w-4 h-4 mr-1 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg> Loading...</span>`;
                });
                
                // Refresh prices every 5 minutes
                setInterval(() => {
                    console.log("Refreshing crypto prices...");
                    fetchPrices(coinIds);
                }, 300000);
            }
        });
	</script>
</body>
</html>