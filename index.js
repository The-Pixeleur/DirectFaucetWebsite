let logos = ["./IMG/CryptoLogo/ethereum.webp", "./IMG/CryptoLogo/bitcoin.webp", "./IMG/CryptoLogo/litecion.webp", "./IMG/CryptoLogo/dogecoin.webp", "./IMG/CryptoLogo/avax.webp", "./IMG/CryptoLogo/matic.webp", "./IMG/CryptoLogo/Bnb.webp", "./IMG/CryptoLogo/Vite.png", "./IMG/CryptoLogo/digibyte.webp", "./IMG/CryptoLogo/stellar.webp", "./IMG/CryptoLogo/solana.webp"];
let cryptos = ["Ethereum", "Bitcoin", "Litecoin", "Dogecoin", "Avax", "Matic", "BNB", "Vite", "Digibyte", "Stellar lumen", "Solana"];
let index = 0;
setInterval(function() {
    document.getElementById("crypto-img").src = logos[index];
    document.getElementById("crypto-name").innerHTML = cryptos[index];
    index = (index + 1) % logos.length;
}, 2000);