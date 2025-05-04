# Direct Crypto Faucet 💧

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)

A comprehensive platform listing legitimate cryptocurrency faucets that allow users to earn free crypto directly to their wallets. No investment needed!

<p align="center">
  <img src="./IMG/Other/DCFlogo.png" alt="Direct Crypto Faucet Logo" width="180">
</p>

## 🌟 Features

- **Curated Faucet List**: 30+ verified and working crypto faucets
- **Multiple Cryptocurrencies**: Support for 14+ different tokens
- **Direct Payments**: Receive crypto directly in your wallet
- **Real-time Price Data**: Integrated with CoinGecko API
- **Portfolio Tracker**: Calculate potential earnings
- **Mobile Friendly**: Responsive design for all devices
- **User-friendly Interface**: Modern, clean UI built with Tailwind CSS

## 🚀 Live Site

Visit the site: [Direct Crypto Faucet](https://directfaucet.cc)

## 📊 Supported Cryptocurrencies

- Bitcoin (BTC/sats)
- Polygon (POL/MATIC)
- Algorand (ALGO)
- Solana (SOL)
- Banano (BAN)
- Nano (NANO)
- And many more...

## 🛠️ Tech Stack

- **Frontend**: HTML, CSS (Tailwind), JavaScript
- **Backend**: PHP with Simple Router
- **Database**: MySQL
- **API Integration**: CoinGecko API for real-time crypto prices
- **Deployment**: Apache/Nginx web server

## 📋 Project Structure

```
├── API/                # Admin API endpoints       // not included here
├── IMG/                # Images and assets
├── Pages/              # PHP page templates
├── data/               # Database configuration
├── vendor/             # Composer dependencies
├── .htaccess           # Apache configuration
├── composer.json       # PHP dependencies
├── index.php           # Entry point
└── router.php          # URL routing
```

## 🔧 Setup & Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/The-Pixeleur/DirectFaucetWebsite.git
   cd DirectFaucetWebsite
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Database setup**
   - Create a MySQL database
   - Import `data/crypto_faucet.sql`
   - Create a `.env` file with your database credentials:
     ```
     DB_HOST=localhost
     DB_USERNAME=your_username
     DB_PASSWORD=your_password
     DB_NAME=your_database
     ```

4. **Web server configuration**
   - Point your web server to the project directory
   - Ensure your web server supports PHP

## 🏗️ Contributing

Contributions are welcome! Here's how you can help:

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🤝 Contact

For questions or suggestions, please contact support@directfaucet.cc

---

<p align="center">
  Made with ❤️ by <a href="https://pixeleur.fr">Pixeleur - French Game Studio</a>
</p>
