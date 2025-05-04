-- Create CryptoFaucet table with base64 image support
CREATE TABLE `CryptoFaucet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `SiteURL` varchar(255) DEFAULT NULL,
  `SiteName` varchar(255) DEFAULT NULL,
  `TokenLogo` MEDIUMTEXT DEFAULT NULL,
  `TokenName` varchar(50) DEFAULT NULL,
  `BlockchainLogo` MEDIUMTEXT DEFAULT NULL,
  `Delay` varchar(50) DEFAULT NULL,
  `AveragePayout` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add indexes for better performance
ALTER TABLE `CryptoFaucet`
ADD INDEX `idx_token_name` (`TokenName`),
ADD INDEX `idx_site_name` (`SiteName`); 