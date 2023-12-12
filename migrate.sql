

   INFO  Running migrations.  

  2019_12_14_000001_create_personal_access_tokens_table .................  
  ⇂ create table `personal_access_tokens` (`id` bigint unsigned not null auto_increment primary key, `tokenable_type` varchar(255) not null, `tokenable_id` bigint unsigned not null, `name` varchar(255) not null, `token` varchar(64) not null, `abilities` text null, `last_used_at` timestamp null, `expires_at` timestamp null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ alter table `personal_access_tokens` add index `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type`, `tokenable_id`)  
  ⇂ alter table `personal_access_tokens` add unique `personal_access_tokens_token_unique`(`token`)  
  2023_11_22_192126_create_estimazon_table ..............................  
  ⇂ create table `address` (`id` bigint unsigned not null auto_increment primary key, `direction` varchar(255) null, `municipe_id` smallint unsigned null, `number` varchar(255) null, `floor` varchar(255) null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ alter table `address` add index `municipe_id`(`municipe_id`)  
  ⇂ create table `categories` (`id` bigint unsigned not null auto_increment primary key, `name` varchar(255) not null, `slug` varchar(255) null, `description` varchar(255) null, `parent_category` bigint unsigned null comment 'Parent category') default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ alter table `categories` add index `parent_category`(`parent_category`)  
  ⇂ create table `ccaa` (`id` tinyint unsigned not null, `name` varchar(100) not null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ alter table `ccaa` comment = 'Lista de Comunicades Autónomas'  
  ⇂ alter table `ccaa` add primary key (`id`)  
  ⇂ create table `incidences` (`id` bigint unsigned not null auto_increment primary key, `description` varchar(255) null, `order_id` bigint unsigned null, `product_id` bigint unsigned null, `vendor_id` bigint unsigned null, `controller_id` bigint unsigned null, `intentos` smallint not null default '0') default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ alter table `incidences` add index `order_id`(`order_id`)  
  ⇂ alter table `incidences` add index `product_id`(`product_id`)  
  ⇂ alter table `incidences` add index `vendor_id`(`vendor_id`)  
  ⇂ alter table `incidences` add index `controller_id`(`controller_id`)  
  ⇂ create table `municipes` (`id` smallint unsigned not null auto_increment primary key, `idProvince` smallint unsigned not null, `codMunicipe` int not null, `DC` int not null, `name` varchar(100) not null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ alter table `municipes` comment = 'Lista de Municipios'  
  ⇂ alter table `municipes` add index `idProvince`(`idProvince`)  
  ⇂ create table `order_items` (`order_id` bigint unsigned null, `product_id` bigint unsigned null, `quantity` int null default '1', `vendor_id` bigint unsigned null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ alter table `order_items` add index `order_id`(`order_id`)  
  ⇂ alter table `order_items` add index `product_id`(`product_id`)  
  ⇂ alter table `order_items` add index `vendor_id`(`vendor_id`)  
  ⇂ create table `orders` (`id` bigint unsigned not null auto_increment primary key, `user_id` bigint unsigned null, `status` enum('pending', 'confirmed', 'sent', 'recieved', 'canceled', 'returned') null, `created_at` timestamp null, `updated_at` timestamp null, `delivery_address` bigint unsigned null, `shippingcompany` bigint unsigned null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ alter table `orders` add index `user_id`(`user_id`)  
  ⇂ alter table `orders` add index `delivery_address`(`delivery_address`)  
  ⇂ alter table `orders` add index `shippingcompany`(`shippingcompany`)  
  ⇂ create table `product_stock` (`id` bigint unsigned not null auto_increment primary key, `amount` int null, `unit_price` decimal(10, 2) null, `created_at` timestamp null, `updated_at` timestamp null, `product_id` bigint unsigned null, `vendor_id` bigint unsigned null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ alter table `product_stock` add index `product_id`(`product_id`)  
  ⇂ alter table `product_stock` add index `vendor_id`(`vendor_id`)  
  ⇂ create table `products` (`id` bigint unsigned not null auto_increment primary key, `name` varchar(255) null, `description` varchar(255) null, `image_url` varchar(255) null, `status` enum('out_of_stock', 'in_stock', 'running_low') null, `category` bigint unsigned null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ alter table `products` add index `category`(`category`)  
  ⇂ create table `provinces` (`id` smallint unsigned not null, `idCCAA` tinyint unsigned not null, `name` varchar(30) null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ alter table `provinces` comment = 'Lista de Provincias. El campo idProvincia coincide con los dos primeros dígitos del código postal # de la provincia (los que tienen un dígito, añadir el 0 delante).'  
  ⇂ alter table `provinces` add primary key (`id`)  
  ⇂ alter table `provinces` add index `idCCAA`(`idCCAA`)  
  ⇂ create table `users` (`id` bigint unsigned not null auto_increment primary key, `full_name` varchar(255) null, `password` varchar(255) not null, `NIF` varchar(255) null, `status` varchar(255) null, `avisos` int not null default '0', `email` varchar(255) not null, `role_id` int not null default '1', `address` bigint unsigned null, `remember_token` varchar(100) null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ alter table `users` add unique `users_email_unique`(`email`)  
  ⇂ alter table `users` add index `address`(`address`)  
  ⇂ create table `shippingcompany` (`id` bigint unsigned not null auto_increment primary key, `name` varchar(255) null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ create table `shipping_provinces` (`id` bigint unsigned not null auto_increment primary key, `province_id` smallint unsigned not null, `shipping_company_id` bigint unsigned not null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ alter table `shipping_provinces` add index `province_id`(`province_id`)  
  ⇂ alter table `shipping_provinces` add index `shipping_company_id`(`shipping_company_id`)  
  ⇂ alter table `address` add constraint `address_municipe_id_foreign` foreign key (`municipe_id`) references `municipes` (`id`) on delete NO ACTION on update NO ACTION  
  ⇂ alter table `categories` add constraint `categories_parent_category_foreign` foreign key (`parent_category`) references `categories` (`id`) on delete NO ACTION on update NO ACTION  
  ⇂ alter table `incidences` add constraint `incidences_product_id_foreign` foreign key (`product_id`) references `products` (`id`) on delete NO ACTION on update NO ACTION  
  ⇂ alter table `incidences` add constraint `incidences_controller_id_foreign` foreign key (`controller_id`) references `users` (`id`) on delete NO ACTION on update NO ACTION  
  ⇂ alter table `incidences` add constraint `incidences_order_id_foreign` foreign key (`order_id`) references `orders` (`id`) on delete NO ACTION on update NO ACTION  
  ⇂ alter table `incidences` add constraint `incidences_vendor_id_foreign` foreign key (`vendor_id`) references `users` (`id`) on delete NO ACTION on update NO ACTION  
  ⇂ alter table `municipes` add constraint `municipes_idprovince_foreign` foreign key (`idProvince`) references `provinces` (`id`) on delete NO ACTION on update NO ACTION  
  ⇂ alter table `order_items` add constraint `order_items_product_id_foreign` foreign key (`product_id`) references `products` (`id`) on delete NO ACTION on update NO ACTION  
  ⇂ alter table `order_items` add constraint `order_items_order_id_foreign` foreign key (`order_id`) references `orders` (`id`) on delete NO ACTION on update NO ACTION  
  ⇂ alter table `order_items` add constraint `order_items_vendor_id_foreign` foreign key (`vendor_id`) references `users` (`id`) on delete NO ACTION on update NO ACTION  
  ⇂ alter table `orders` add constraint `orders_delivery_address_foreign` foreign key (`delivery_address`) references `address` (`id`)  
  ⇂ alter table `orders` add constraint `orders_user_id_foreign` foreign key (`user_id`) references `users` (`id`)  
  ⇂ alter table `orders` add constraint `orders_shippingcompany_foreign` foreign key (`shippingcompany`) references `shippingcompany` (`id`)  
  ⇂ alter table `product_stock` add constraint `product_stock_vendor_id_foreign` foreign key (`vendor_id`) references `users` (`id`)  
  ⇂ alter table `product_stock` add constraint `product_stock_product_id_foreign` foreign key (`product_id`) references `products` (`id`)  
  ⇂ alter table `products` add constraint `products_category_foreign` foreign key (`category`) references `categories` (`id`)  
  ⇂ alter table `provinces` add constraint `provinces_idccaa_foreign` foreign key (`idCCAA`) references `ccaa` (`id`) on delete NO ACTION on update NO ACTION  
  ⇂ alter table `shipping_provinces` add constraint `shipping_provinces_province_id_foreign` foreign key (`province_id`) references `provinces` (`id`)  
  ⇂ alter table `shipping_provinces` add constraint `shipping_provinces_shipping_company_id_foreign` foreign key (`shipping_company_id`) references `shippingcompany` (`id`)  
  ⇂ alter table `users` add constraint `users_address_foreign` foreign key (`address`) references `address` (`id`)  
  ActualizarEstadoVendedorProcedure .....................................  
  ⇂ DROP PROCEDURE IF EXISTS actualizar_estado_vendedor  
  ⇂ SHOW PROCEDURE STATUS LIKE 'actualizar_estado_vendedor'  
  ⇂ CREATE PROCEDURE actualizar_estado_vendedor(IN vendedor_id INT) BEGIN DECLARE total_avisos INT; DECLARE estado_actual VARCHAR(255); -- Obtener el número actual de avisos SELECT COALESCE(avisos, 0) INTO total_avisos FROM users WHERE id = vendedor_id; -- Obtener el estado actual del vendedor/a SELECT status INTO estado_actual FROM users WHERE id = vendedor_id; -- Incrementar el número de avisos SET total_avisos = total_avisos + 1; -- Actualizar el número de avisos UPDATE users SET avisos = total_avisos WHERE id = vendedor_id; -- Lógica para cambiar el estado según el número de avisos IF total_avisos > 3 AND estado_actual IS NULL THEN UPDATE users SET status = "SOSPITOS" WHERE id = vendedor_id; ELSEIF total_avisos > 6 AND estado_actual = "SOSPITOS" THEN UPDATE users SET status = "DOLENT" WHERE id = vendedor_id; END IF; END  

