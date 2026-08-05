-- Database Backup for 'project1'
-- Generated: 2025-12-26 17:10:01

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_cart_item` (`user_id`,`product_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `cart` VALUES("1","1","9","1","2025-12-24 21:37:04");
INSERT INTO `cart` VALUES("2","1","7","1","2025-12-24 21:37:24");


DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



DROP TABLE IF EXISTS `medicinal_plants`;
CREATE TABLE `medicinal_plants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `uses` text DEFAULT NULL,
  `advantages` text DEFAULT NULL,
  `dosage_vata` varchar(255) DEFAULT NULL,
  `dosage_pitta` varchar(255) DEFAULT NULL,
  `dosage_kapha` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `medicinal_plants` VALUES("1","Amala","Digestion, Immune Booster, Hair Health","Rich in Vitamin C, acts as a powerful antioxidant.","1 tsp powder with sesame oil","1 tsp powder with ghee","1 tsp powder with honey");
INSERT INTO `medicinal_plants` VALUES("2","Ashwagandha","Stress relief, Energy booster, Strength","Reduces cortisol levels, improves sleep quality.","1/2 tsp with warm milk","1/2 tsp with ghee (rarely used for high Pitta)","1/2 tsp with honey or warm water");
INSERT INTO `medicinal_plants` VALUES("3","Tulsi","Cough, Cold, Respiratory health","Adaptogen, fights infections, supports heart health.","Tea with ginger","Tea with rose petals","Tea with black pepper");
INSERT INTO `medicinal_plants` VALUES("4","Silajit","Stamina, Anti-aging, Vitality","Contains fulvic acid, rejuvenates the body.","Pea-sized resin with warm milk","Pea-sized resin with milk (caution required)","Pea-sized resin with honey and triphala");
INSERT INTO `medicinal_plants` VALUES("5","Kutki","Liver health, Fever, Skin issues","Excellent hepatoprotective (liver protecting) herb.","High dose not recommended (cooling)","1/4 tsp with aloe vera juice","1/4 tsp with honey");
INSERT INTO `medicinal_plants` VALUES("6","Barro","Eye health, Hair growth, Digestion","One of the three fruits in Triphala.","Powder with oil","Powder with ghee","Powder with honey");
INSERT INTO `medicinal_plants` VALUES("7","Bojho","Speech clarity, Memory, Sore throat","Improves voice and cognitive function.","Small piece cheated or powder with warm water","Not recommended (heating)","Powder with honey");
INSERT INTO `medicinal_plants` VALUES("8","Chiraito","Fever, Skin diseases, Blood purification","Bitter tonic, good for infections.","Use with caution (drying)","Cold infusion (soak overnight)","Decoction or powder");
INSERT INTO `medicinal_plants` VALUES("9","Harro","Digestion, Detox, Vision","King of medicines in Ayurveda (Haritaki).","With ghee","With sugar","With rock salt");
INSERT INTO `medicinal_plants` VALUES("10","Pachaula","Gastric trouble, Indigestion","Improves appetite and digestive fire.","Powder with warm water","Avoid excess use","Powder with honey");
INSERT INTO `medicinal_plants` VALUES("11","Sarpaganda","Hypertension, Insomnia, Anxiety","Lowers blood pressure naturally.","With warm milk before bed for sleep","With rose water","With honey");
INSERT INTO `medicinal_plants` VALUES("12","Satuwa","Poison antidote, Fever, Wounds","Traditional remedy for snake bites and infections.","Paste externally or small internal dose","Paste with cooling herbs","Paste with turmeric");
INSERT INTO `medicinal_plants` VALUES("13","Timur","Toothache, Digestion, Circulation","Warming spice, good for cold climate.","In food or oil massage","Avoid (very heating)","Chew seeds or tea");
INSERT INTO `medicinal_plants` VALUES("14","Yarsagumba","Libido, Stamina, Lung health","Himalayan Viagra, boosts immunity.","Boiled in milk","With milk and ghee","With honey");


DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `order_items` VALUES("1","1","1","2","99.00");
INSERT INTO `order_items` VALUES("2","2","9","1","279.00");
INSERT INTO `order_items` VALUES("3","3","9","1","279.00");


DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) DEFAULT 'unspecified',
  `payment_status` enum('pending','paid','failed') DEFAULT 'pending',
  `transaction_id` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `orders` VALUES("1","1","1500.00","unspecified","pending","","Pending","2025-12-23 15:58:02");
INSERT INTO `orders` VALUES("2","3","279.00","unspecified","pending","","pending","2025-12-24 15:11:00");
INSERT INTO `orders` VALUES("3","1","279.00","unspecified","pending","","pending","2025-12-24 21:08:28");


DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productName` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `products` VALUES("1","Patanjali GonyIe 1Ltr.","99.00","https://images.pexels.com/photos/4041392/pexels-photo-4041392.jpeg?auto=compress&cs=tinysrgb&w=800","","2025-12-23 12:09:22");
INSERT INTO `products` VALUES("2","Patanjali Saundarya Shower Gel 250ml","250.00","https://images.pexels.com/photos/3738374/pexels-photo-3738374.jpeg","","2025-12-23 12:09:22");
INSERT INTO `products` VALUES("3","Patanjali Beauty Cream Advance SPF 15","150.00","https://images.pexels.com/photos/3738365/pexels-photo-3738365.jpeg","","2025-12-23 12:09:22");
INSERT INTO `products` VALUES("4","Patanjali Saundarya Aloe Vera Gel 150ml","150.00","https://images.pexels.com/photos/3738341/pexels-photo-3738341.jpeg","","2025-12-23 12:09:22");
INSERT INTO `products` VALUES("5","Kesh Kanti Hair Cleaner 200ml","210.00","https://images.pexels.com/photos/3738345/pexels-photo-3738345.jpeg","","2025-12-23 12:09:22");
INSERT INTO `products` VALUES("6","Patanjali Honey 500g","450.00","https://images.pexels.com/photos/842519/pexels-photo-842519.jpeg?auto=compress&cs=tinysrgb&w=800","","2025-12-23 12:09:22");
INSERT INTO `products` VALUES("7","Liver Restore Tablets","566.00","https://images.pexels.com/photos/3738439/pexels-photo-3738439.jpeg?auto=compress&cs=tinysrgb&w=300","","2025-12-23 12:57:09");
INSERT INTO `products` VALUES("8","Apple Cider Vinegar","264.00","https://images.pexels.com/photos/3738374/pexels-photo-3738374.jpeg?auto=compress&cs=tinysrgb&w=300","","2025-12-23 12:57:09");
INSERT INTO `products` VALUES("9","Herboslim Tablets","279.00","https://images.pexels.com/photos/3738365/pexels-photo-3738365.jpeg?auto=compress&cs=tinysrgb&w=300","","2025-12-23 12:57:09");
INSERT INTO `products` VALUES("10","Liver Care Tablets","478.00","https://images.pexels.com/photos/3738341/pexels-photo-3738341.jpeg?auto=compress&cs=tinysrgb&w=300","","2025-12-23 12:57:09");
INSERT INTO `products` VALUES("12","yarsagumba","1000.00","ourProductmages/yarsagumba.jpg","","2025-12-23 15:40:48");


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(20) DEFAULT 'customer',
  `points` int(11) DEFAULT 0,
  `streak_count` int(11) DEFAULT 0,
  `last_active_date` date DEFAULT NULL,
  `last_quiz_date` date DEFAULT NULL,
  `last_remedy_date` date DEFAULT NULL,
  `dosha` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` VALUES("1","abin","$2y$10$DlpAL0nb358c0arIAZO1C.CYVbYYZV5XZc14vyLMSeVksHQmora.e","2025-12-23 12:18:51","admin","20","1","2025-12-24","2025-12-24","2025-12-24","vata");
INSERT INTO `users` VALUES("2","admin","$2y$10$1V9K6gjSX8H/Rib0vZGCwuj1dIPDOMj684KLBTY4Hy3VmzH3OvWeC","2025-12-23 16:06:07","admin","20","1","2025-12-26","","","");
INSERT INTO `users` VALUES("3","prabin","$2y$10$HfyR83vqV1R0QOsqxkPDvejNtETSi6TILkTU87EwYzKg237sgfWAS","2025-12-24 14:40:58","customer","0","0","","","","");


COMMIT;
