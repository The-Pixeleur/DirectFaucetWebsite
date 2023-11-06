document.addEventListener("DOMContentLoaded", function() {
    let logos = ["./IMG/CryptoLogo/ethereum.webp", "./IMG/CryptoLogo/bitcoin.webp", "./IMG/CryptoLogo/litecion.webp", "./IMG/CryptoLogo/dogecoin.webp", "./IMG/CryptoLogo/avax.webp", "./IMG/CryptoLogo/matic.webp", "./IMG/CryptoLogo/Bnb.webp", "./IMG/CryptoLogo/Vite.png", "./IMG/CryptoLogo/digibyte.webp", "./IMG/CryptoLogo/stellar.webp", "./IMG/CryptoLogo/solana.webp"];
    let cryptos = ["Ethereum", "Bitcoin", "Litecoin", "Dogecoin", "Avax", "Matic", "BNB", "Vite", "Digibyte", "Stellar lumen", "Solana"];
    let index = 0;

    const cryptoContainer = document.querySelector(".crypto-container");

    function changeCrypto() {
        cryptoContainer.style.transform = "translateX(-100%)"; // Slide out to the left
        cryptoContainer.style.opacity = 0; // Fade out

        setTimeout(function() {
            document.getElementById("crypto-img").src = logos[index];
            document.getElementById("crypto-name").innerHTML = cryptos[index];

            cryptoContainer.style.transform = "translateX(0)"; // Slide in from the left
            cryptoContainer.style.opacity = 1; // Fade in

            index = (index + 1) % logos.length;
        }, 500); // Adjust this timeout to control the timing of the animation
    }

    setInterval(changeCrypto, 2000);
    changeCrypto(); // Call the function to display the initial crypto
});


