CREATE TABLE `address` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `direction` varchar(255),
  `municipe_id` int,
  `number` varchar(255),
  `floor` varchar(255)
);

CREATE TABLE `users` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `full_name` varchar(255),
  `password` varchar(255),
  `created_at` timestamp,
  `updated_at` timestamp,
  `country_code` int,
  `NIF` varchar(255),
  `mail` varchar(255),
  `role_id` int DEFAULT 1,
  `address` int
);

CREATE TABLE `order_items` (
  `order_id` int,
  `product_id` int,
  `quantity` int DEFAULT 1
);

CREATE TABLE `orders` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `user_id` int,
  `status` ENUM ('pending', 'confirmed', 'sent', 'recieved', 'canceled', 'returned'),
  `created_at` timestamp COMMENT 'When order created',
  `updated_at` timestamp,
  `delivery_address` int
);

CREATE TABLE `products` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255),
  `description` varchar(255),
  `image_url` varchar(255),
  `merchant_id` int,
  `unit_price` int,
  `status` ENUM ('out_of_stock', 'in_stock', 'running_low'),
  `created_at` datetime DEFAULT (now()),
  `category` int
);

CREATE TABLE `categories` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255),
  `slug` varchar(255),
  `description` varchar(255),
  `parent_category` int COMMENT 'Subcategories'
);

CREATE TABLE `incidences` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `description` varchar(255),
  `created_at` timestamp,
  `order_id` int,
  `product_id` int,
  `vendor_id` int,
  `controller_id` int
);

CREATE TABLE `CCAA` (
  `id` int PRIMARY KEY,
  `name` varchar(255)
);

CREATE TABLE `Province` (
  `id` int PRIMARY KEY,
  `name` varchar(255),
  `CCAA_id` int
);

CREATE TABLE `Municipe` (
  `id` int PRIMARY KEY,
  `name` varchar(255),
  `code` int,
  `Province_id` int
);

ALTER TABLE `address` ADD FOREIGN KEY (`municipe_id`) REFERENCES `Municipe` (`id`);

ALTER TABLE `users` ADD FOREIGN KEY (`address`) REFERENCES `address` (`id`);

ALTER TABLE `order_items` ADD FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

ALTER TABLE `order_items` ADD FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

ALTER TABLE `orders` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `orders` ADD FOREIGN KEY (`delivery_address`) REFERENCES `address` (`id`);

ALTER TABLE `products` ADD FOREIGN KEY (`merchant_id`) REFERENCES `users` (`id`);

ALTER TABLE `products` ADD FOREIGN KEY (`category`) REFERENCES `categories` (`id`);

ALTER TABLE `categories` ADD FOREIGN KEY (`parent_category`) REFERENCES `categories` (`id`);

ALTER TABLE `incidences` ADD FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

ALTER TABLE `incidences` ADD FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

ALTER TABLE `incidences` ADD FOREIGN KEY (`vendor_id`) REFERENCES `users` (`id`);

ALTER TABLE `incidences` ADD FOREIGN KEY (`controller_id`) REFERENCES `users` (`id`);

ALTER TABLE `Province` ADD FOREIGN KEY (`CCAA_id`) REFERENCES `CCAA` (`id`);

ALTER TABLE `Municipe` ADD FOREIGN KEY (`Province_id`) REFERENCES `Province` (`id`);
