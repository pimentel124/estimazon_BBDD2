INSERT INTO `shippingcompany` (`id`, `name`) VALUES
(1, 'Envíos Rápidos Express'),
(2, 'Logística Nacional SL'),
(3, 'Mensajería Ágil SA');


INSERT INTO `shipping_provinces` (`id`, `province_id`, `shipping_company_id`) VALUES
(1, 8, 1),   -- Barcelona -> Envíos Rápidos Express
(2, 28, 1),  -- Madrid -> Envíos Rápidos Express
(3, 41, 1),  -- Sevilla -> Envíos Rápidos Express
(4, 3, 2),   -- Alicante/Alacant -> Logística Nacional SL
(5, 16, 2),  -- Córdoba -> Logística Nacional SL
(6, 30, 2),  -- Murcia -> Logística Nacional SL
(7, 50, 2),  -- Zaragoza -> Logística Nacional SL
(8, 1, 3),   -- Albacete -> Mensajería Ágil SA
(9, 33, 3),  -- Asturias -> Mensajería Ágil SA
(10, 12, 3), -- Castellón/Castelló -> Mensajería Ágil SA
(11, 51, 3); -- Ceuta -> Mensajería Ágil SA


