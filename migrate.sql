

   INFO  Running migrations.

  2023_11_22_192126_create_estimazon_table ...............................................................................
  ⇂ create table `address` (`id` bigint unsigned not null auto_increment primary key, `direction` varchar(255) null, `municipe_id` smallint unsigned null, `number` varchar(255) null, `floor` varchar(255) null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'
  ⇂ alter table `address` add index `municipe_id`(`municipe_id`)
  ⇂ create table `categories` (`id` bigint unsigned not null auto_increment primary key, `name` varchar(255) not null, `slug` varchar(255) null, `description` varchar(255) null, `parent_category` bigint unsigned null comment 'Parent category') default character set utf8mb4 collate 'utf8mb4_unicode_ci'
  ⇂ alter table `categories` add index `parent_category`(`parent_category`)
  ⇂ create table `ccaa` (`id` tinyint unsigned not null, `name` varchar(100) not null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'
  ⇂ alter table `ccaa` comment = 'Lista de Comunicades Autónomas'
  ⇂ alter table `ccaa` add primary key (`id`)
  ⇂ create table `incidences` (`id` bigint unsigned not null auto_increment primary key, `description` varchar(255) null, `order_id` bigint null, `product_id` bigint null, `vendor_id` bigint null, `controller_id` bigint null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'
  ⇂ alter table `incidences` add index `order_id`(`order_id`)
  ⇂ alter table `incidences` add index `product_id`(`product_id`)
  ⇂ alter table `incidences` add index `vendor_id`(`vendor_id`)
  ⇂ alter table `incidences` add index `controller_id`(`controller_id`)
  ⇂ create table `municipes` (`id` smallint unsigned not null auto_increment primary key, `idProvince` smallint unsigned not null, `codMunicipe` int not null, `DC` int not null, `name` varchar(100) not null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'
  ⇂ alter table `municipes` comment = 'Lista de Municipios'
  ⇂ alter table `municipes` add index `idProvince`(`idProvince`)
  ⇂ create table `order_items` (`order_id` bigint null, `product_id` bigint null, `quantity` int null default '1', `vendor_id` bigint null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'
  ⇂ alter table `order_items` add index `order_id`(`order_id`)
  ⇂ alter table `order_items` add index `product_id`(`product_id`)
  ⇂ alter table `order_items` add index `vendor_id`(`vendor_id`)
  ⇂ create table `orders` (`id` bigint unsigned not null auto_increment primary key, `user_id` bigint null, `status` enum('pending', 'confirmed', 'sent', 'recieved', 'canceled', 'returned') null, `delivery_address` bigint null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'
  ⇂ alter table `orders` add index `user_id`(`user_id`)
  ⇂ alter table `orders` add index `delivery_address`(`delivery_address`)
  ⇂ create table `product_stock` (`id` bigint unsigned not null auto_increment primary key, `amount` int null, `unit_price` decimal(10, 2) null, `product_id` bigint null, `vendor_id` bigint null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'
  ⇂ alter table `product_stock` add index `product_id`(`product_id`)
  ⇂ alter table `product_stock` add index `vendor_id`(`vendor_id`)
  ⇂ create table `products` (`id` bigint unsigned not null auto_increment primary key, `name` varchar(255) null, `description` varchar(255) null, `image_url` varchar(255) null, `merchant_id` bigint null, `status` enum('out_of_stock', 'in_stock', 'running_low') null, `category` bigint null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'
  ⇂ alter table `products` add index `merchant_id`(`merchant_id`)
  ⇂ alter table `products` add index `category`(`category`)
  ⇂ create table `provinces` (`id` smallint unsigned not null, `idCCAA` tinyint unsigned not null, `name` varchar(30) null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'
  ⇂ alter table `provinces` comment = 'Lista de Provincias. El campo idProvincia coincide con los dos primeros dígitos del código postal # de la provincia (los que tienen un dígito, añadir el 0 delante).'
  ⇂ alter table `provinces` add primary key (`id`)
  ⇂ alter table `provinces` add index `idCCAA`(`idCCAA`)
  ⇂ create table `users` (`id` bigint unsigned not null auto_increment primary key, `full_name` varchar(255) null, `password` varchar(255) not null, `NIF` varchar(255) null, `email` varchar(255) not null, `role_id` int not null, `address` bigint null, `remember_token` varchar(100) null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'
  ⇂ alter table `users` add unique `users_email_unique`(`email`)
  ⇂ alter table `users` add index `address`(`address`)
  ⇂ alter table `address` add constraint `address_ibfk_1` foreign key (`municipe_id`) references `municipes` (`id`) on delete NO ACTION on update NO ACTION
  ⇂ alter table `categories` add constraint `categories_parent_category_foreign` foreign key (`parent_category`) references `categories` (`id`) on delete NO ACTION on update NO ACTION
  ⇂ alter table `incidences` add constraint `incidences_product_id_foreign` foreign key (`product_id`) references `products` (`id`) on delete NO ACTION on update NO ACTION
  ⇂ alter table `incidences` add constraint `incidences_controller_id_foreign` foreign key (`controller_id`) references `users` (`id`) on delete NO ACTION on update NO ACTION
  ⇂ alter table `incidences` add constraint `incidences_order_id_foreign` foreign key (`order_id`) references `orders` (`id`) on delete NO ACTION on update NO ACTION
  ⇂ alter table `incidences` add constraint `incidences_vendor_id_foreign` foreign key (`vendor_id`) references `users` (`id`) on delete NO ACTION on update NO ACTION
  ⇂ alter table `municipes` add constraint `municipes_ibfk_1` foreign key (`idProvince`) references `provinces` (`id`) on delete NO ACTION on update NO ACTION
  ⇂ alter table `order_items` add constraint `order_items_ibfk_2` foreign key (`product_id`) references `products` (`id`) on delete NO ACTION on update NO ACTION
  ⇂ alter table `order_items` add constraint `order_items_ibfk_1` foreign key (`order_id`) references `orders` (`id`) on delete NO ACTION on update NO ACTION
  ⇂ alter table `order_items` add constraint `order_items_ibfk_3` foreign key (`vendor_id`) references `users` (`id`) on delete NO ACTION on update NO ACTION
  ⇂ alter table `orders` add constraint `orders_ibfk_2` foreign key (`delivery_address`) references `address` (`id`)
  ⇂ alter table `orders` add constraint `orders_ibfk_1` foreign key (`user_id`) references `users` (`id`)
  ⇂ alter table `product_stock` add constraint `product_stock_ibfk_2` foreign key (`vendor_id`) references `users` (`id`)
  ⇂ alter table `product_stock` add constraint `product_stock_ibfk_1` foreign key (`product_id`) references `products` (`id`)
  ⇂ alter table `products` add constraint `products_ibfk_2` foreign key (`category`) references `categories` (`id`)
  ⇂ alter table `products` add constraint `products_ibfk_1` foreign key (`merchant_id`) references `users` (`id`)
  ⇂ alter table `provinces` add constraint `provinces_ibfk_1` foreign key (`idCCAA`) references `ccaa` (`id`) on delete NO ACTION on update NO ACTION
  ⇂ alter table `users` add constraint `users_ibfk_1` foreign key (`address`) references `address` (`id`)

