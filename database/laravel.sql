INSERT INTO `collaborators` (`id`, `name`, `email`, `password`, `telephone`, `cpf`, `rg`, `status`, `perfil`, `created_at`, `updated_at`, `deleted_at`, `collaborators_inclusion_id`, `collaborators_change_id`, `collaborators_exclusion_id`) VALUES (1, 'admin', 'admin12345@gmail.com', '$2y$12$GHkKfIQpKcARWuO7F0au/us/cUzNTLlF.2nwCxHAimk2/ilxLsAwO', '(45) 99842-0205', '098.765.432-10', NULL, '2', 'admin', '2024-12-04 21:28:23', NULL, NULL, NULL, NULL, NULL);

INSERT INTO `devices` (`id`, `model`, `numbering`, `qr`, `mode`, `time_on`, `period`, `status`, `update_status`, `created_at`, `updated_at`, `deleted_at`, `user_id`, `plant_id`, `pump_id`, `collaborators_inclusion_id`, `collaborators_change_id`, `collaborators_exclusion_id`) VALUES
(1, 'SIF', '00000001', NULL, '1', NULL, NULL, 2, '0', '2024-12-04 21:52:00', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL);


INSERT INTO `plants` (`id`, `common_name`, `scientific_name`, `water_need`, `soil_type`, `humidity_tolerance`, `temperature_tolerance`, `image`, `status`, `obs`, `created_at`, `updated_at`, `deleted_at`, `collaborators_inclusion_id`, `collaborators_change_id`, `collaborators_exclusion_id`) VALUES
(8, 'Morango', 'Fragaria × ananassa', 'medium', 'humus', 20, 29, NULL, 8, 'Os morangos são frutas agregadas ou seja cada semente visível é uma pequena fruta', '2024-09-12 21:27:58', NULL, NULL, 1, NULL, NULL),
(9, 'Melancia', 'Citrullus lanatus', 'tall', 'sandy', 80, 40, NULL, 8, NULL, '2024-09-12 21:27:58', NULL, NULL, 1, NULL, NULL),
(10, 'Jiló', 'Solanum gilo', 'medium', 'humus', 45, 35, NULL, 8, NULL, '2024-09-12 21:27:58', NULL, NULL, 1, NULL, NULL),
(11, 'Quiabo', 'Abelmoschus esculentus', 'tall', 'humus', 75, 40, NULL, 8, NULL, '2024-09-12 21:27:58', NULL, NULL, 1, NULL, NULL),
(12, 'Batata', 'Solanum tuberosum', 'medium', 'clayey', 50, 35, NULL, 8, NULL, '2024-09-12 21:27:58', NULL, NULL, 1, NULL, NULL),
(13, 'Abobrinha', 'Cucurbita pepo', 'tall', 'humus', 50, 35, NULL, 8, NULL, '2024-09-12 21:27:58', NULL, NULL, 1, NULL, NULL),
(14, 'Ervilha', 'Pisum sativum', 'tall', 'humus', 80, 35, NULL, 8, NULL, '2024-09-12 21:27:58', NULL, NULL, 1, NULL, NULL),
(15, 'Salsa', 'Petroselinum crispum', 'medium', 'humus', 45, 30, NULL, 8, NULL, '2024-09-12 21:27:58', NULL, NULL, 1, NULL, NULL),
(16, 'Cebolinha', 'Allium schoenoprasum', 'medium', 'humus', 50, 35, NULL, 8, NULL, '2024-09-12 21:27:58', NULL, NULL, 1, NULL, NULL),
(17, 'Beterraba', 'Beta vulgaris', 'medium', 'humus', 60, 35, NULL, 8, NULL, '2024-09-12 21:27:58', NULL, NULL, 1, NULL, NULL),
(18, 'Pepino', 'Cucumis sativus', 'tall', 'humus', 85, 35, NULL, 8, NULL, '2024-09-12 21:27:58', NULL, NULL, 1, NULL, NULL),
(19, 'Rabanete', 'Raphanus sativus', 'medium', 'humus', 55, 30, NULL, 8, NULL, '2024-09-12 21:27:58', NULL, NULL, 1, NULL, NULL),
(20, 'Pimentão', 'Capsicum annuum', 'tall', 'humus', 50, 30, NULL, 8, NULL, '2024-09-12 21:27:58', NULL, NULL, 1, NULL, NULL),
(21, 'Manjericão', 'Ocimum basilicum', 'medium', 'sandy', 45, 35, NULL, 8, NULL, '2024-09-12 21:27:58', NULL, NULL, 1, NULL, NULL),
(22, 'Couve', 'Brassica oleracea var acephala', 'medium', 'humus', 55, 35, NULL, 8, NULL, '2024-09-12 21:27:58', NULL, NULL, 1, NULL, NULL),
(23, 'Espinafre', 'Spinacia oleracea', 'tall', 'humus', 75, 30, NULL, 8, NULL, '2024-09-12 21:27:58', NULL, NULL, 1, NULL, NULL),
(24, 'Brócolis', 'Brassica oleracea', 'medium', 'humus', 55, 30, NULL, 8, NULL, '2024-09-12 21:27:58', NULL, NULL, 1, NULL, NULL),
(25, 'Cenoura', 'Daucus carota', 'medium', 'sandy', 45, 30, NULL, 8, NULL, '2024-09-12 21:27:58', NULL, NULL, 1, NULL, NULL),
(26, 'Tomate', 'Solanum lycopersicum', 'tall', 'humus', 50, 30, NULL, 8, NULL, '2024-09-12 21:27:58', NULL, NULL, 1, NULL, NULL),
(27, 'Alface', 'Lactuca sativa', 'tall', 'humus', 75, 30, NULL, 8, NULL, '2024-09-12 21:27:58', NULL, NULL, 1, NULL, NULL),
(29, 'Alho Poró', 'Allium ampeloprasum', 'medium', 'humus', 60, 25, NULL, 8, NULL, '2024-09-14 21:33:51', NULL, NULL, 1, NULL, NULL),
(30, 'Milho', 'Zea mays', 'medium', 'humus', 80, 30, NULL, 8, NULL, '2024-09-14 21:34:33', NULL, NULL, 1, NULL, NULL),
(31, 'Soja', 'Glycine max', 'medium', 'humus', 85, 25, NULL, 8, NULL, '2024-09-14 21:50:21', NULL, NULL, 1, NULL, NULL),
(32, 'Hortelã', 'Mentha spicata', 'medium', 'humus', 90, 30, NULL, 8, NULL, '2024-09-14 21:50:40', NULL, NULL, 1, NULL, NULL),
(43, 'Samambaia ', 'Nephrolepis extallta', 'tall', 'humus', 40, 30, NULL, 8, NULL, '2024-09-20 20:07:10', NULL, NULL, 1, NULL, NULL),
(44, 'Margarida ', 'Bellis perennis', 'medium', 'humus', 40, 30, NULL, 8, NULL, '2024-09-20 16:16:20', NULL, NULL, 1, NULL, NULL);


INSERT INTO `pumps` (`id`, `model`, `flow`, `image`, `status`, `obs`, `created_at`, `updated_at`, `deleted_at`, `collaborators_inclusion_id`, `collaborators_change_id`, `collaborators_exclusion_id`) VALUES
(7, 'Periferica BP500 ', 33, NULL, 8, 'liters por minuto', '2024-09-14 21:27:58', '2024-11-16 19:48:19', NULL, 1, NULL, NULL),
(8, 'Pressurizada BFL300', 60, NULL, 8, NULL, '2024-09-14 21:27:58', '2024-11-16 19:48:19', NULL, 1, NULL, NULL),
(9, 'Submersa Ac 9000 Ocean Tech', 150, NULL, 8, NULL, '2024-09-14 21:27:58', '2024-11-16 19:48:19', NULL, 1, NULL, NULL),
(10, 'Genérica Submersa Aquário', 30, NULL, 8, NULL, '2024-09-14 21:27:58', '2024-11-16 19:48:19', NULL, 1, NULL, NULL),
(11, 'Motopumps Periférica CP60H', 30, NULL, 8, 'aaaaaaaaaaa', '2024-09-14 21:27:58', '2024-11-16 19:48:19', NULL, 1, NULL, NULL),
(12, 'pumps aquario', 1, NULL, 8, NULL, '2024-09-14 21:27:58', '2024-11-16 19:48:19', NULL, 1, NULL, NULL);



INSERT INTO `users` (`id`, `name`, `email`, `password`, `telephone`, `cpf`, `status`, `perfil`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Teste', 'teste123@gmail.com', '$2y$12$f6Xd86K66u5hs7/.vy.Oy.0sTKMzSAjihSp5x88ZMLUnlWwujTkOq', '(45) 99842-0205', '077.329.589-50', '2', 'regular', '2024-12-05 00:58:34', '2024-12-05 00:58:34', NULL);

