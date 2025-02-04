
-- Initialisation des données
INSERT INTO elevage_Alimentation (nom_aliment, image_url, gain, prix) VALUES
('Maïs', 'url_maïs.jpg', 5.00, 1.50),
('Soja', 'url_soja.jpg', 6.50, 2.00),
('Foin', 'url_foin.jpg', 2.50, 0.80),
('Granulés', 'url_granules.jpg', 7.00, 2.50),
('Herbe', 'url_herbe.jpg', 3.00, 0.50);

INSERT INTO elevage_Type_Animal (nom_type, poids_min_vente, poids_maximal, prix_vente_kg, nb_jour_sans_manger, perte_poids, id_alimentation, quota) VALUES
('Poulet', 1.20, 3.50, 5.00, 3, 0.10, 1, 0.50),
('Boeuf', 250.00, 900.00, 4.50, 5, 10.00, 2, 15.00),
('Mouton', 30.00, 80.00, 6.00, 4, 2.00, 3, 5.00),
('Cochon', 50.00, 150.00, 5.50, 4, 5.00, 4, 10.00),
('Lapin', 2.00, 5.00, 7.00, 2, 0.20, 5, 0.30);

INSERT INTO elevage_Animal (id_type_animal, poids_initial, image_animal, nom_animal, en_vente, auto_vente, date_mort)
VALUES
-- Poulets
(1, 1.5, 'images/poulet1.jpg', 'Poulet A', 0, 0, NULL),
(1, 1.6, 'images/poulet2.jpg', 'Poulet B', 1, 1, NULL),
(1, 2.4, 'images/poulet3.jpg', 'Poulet C', 0, 1, NULL),
(1, 1.7, 'images/poulet4.jpg', 'Poulet D', 1, 0, NULL),
(1, 1.3, 'images/poulet5.jpg', 'Poulet E', 0, 0, NULL),

-- Moutons
(3, 50.0, 'images/mouton1.jpg', 'Mouton A', 1, 0, NULL),
(3, 30.5, 'images/mouton2.jpg', 'Mouton B', 0, 1, NULL),
(3, 40.3, 'images/mouton3.jpg', 'Mouton C', 1, 1, NULL),
(3, 32.1, 'images/mouton4.jpg', 'Mouton D', 0, 0, NULL),
(3, 60.8, 'images/mouton5.jpg', 'Mouton E', 1, 0, NULL),

-- Bœufs
(2, 278.0, 'images/boeuf1.jpg', 'Boeuf A', 1, 1, NULL),
(2, 300.0, 'images/boeuf2.jpg', 'Boeuf B', 0, 0, NULL),
(2, 400.5, 'images/boeuf3.jpg', 'Boeuf C', 1, 0, NULL),
(2, 800.7, 'images/boeuf4.jpg', 'Boeuf D', 0, 1, NULL),
(2, 900.3, 'images/boeuf5.jpg', 'Boeuf E', 1, 1, NULL),

-- Lapins
(5, 3.2, 'images/lapin1.jpg', 'Lapin A', 0, 0, NULL),
(5, 2.8, 'images/lapin2.jpg', 'Lapin B', 1, 1, NULL),
(5, 3.5, 'images/lapin3.jpg', 'Lapin C', 0, 1, NULL),
(5, 3.0, 'images/lapin4.jpg', 'Lapin D', 1, 0, NULL),
(5, 2.9, 'images/lapin5.jpg', 'Lapin E', 0, 0, NULL),

-- Cochons
(4, 50.0, 'images/cochon1.jpg', 'Cochon A', 1, 1, NULL),
(4, 85.2, 'images/cochon2.jpg', 'Cochon B', 0, 0, NULL),
(4, 72.7, 'images/cochon3.jpg', 'Cochon C', 1, 0, NULL),
(4, 58.3, 'images/cochon4.jpg', 'Cochon D', 0, 1, NULL),
(4, 64.1, 'images/cochon5.jpg', 'Cochon E', 1, 1, NULL);


UPDATE elevage_Argent SET argent = 1000.00;

INSERT INTO elevage_Stock (id_alimentation, quantite) VALUES 
(1, 100),
(2, 20),
(3, 3),
(4, 40),
(5, 5);
