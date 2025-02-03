INSERT INTO elevage_Alimentation (nom_aliment, image_url, gain) VALUES
('Maïs', 'url_maïs.jpg', 5.00),
('Soja', 'url_soja.jpg', 6.50),
('Foin', 'url_foin.jpg', 2.50),
('Granulés', 'url_granules.jpg', 7.00),
('Herbe', 'url_herbe.jpg', 3.00);

INSERT INTO elevage_Type_Animal (nom_type, poids_min_vente, poids_maximal, prix_vente_kg, nb_jour_sans_manger, perte_poids, id_alimentation) VALUES
('Poulet', 1.20, 3.50, 5.00, 3, 0.10, 1),
('Bœuf', 250.00, 900.00, 4.50, 5, 10.00, 2),
('Mouton', 30.00, 80.00, 6.00, 4, 2.00, 3),
('Cochon', 50.00, 150.00, 5.50, 4, 5.00, 4),
('Lapin', 2.00, 5.00, 7.00, 2, 0.20, 5);

-- Inserting data into elevage_Animal
INSERT INTO elevage_Animal (id_type_animal, poids_initial, image_animal, nom_animal, en_vente)
VALUES 
(1, 1.5, 'poulet1.jpg', 'Poulet A', 0),
(1, 1.6, 'poulet2.jpg', 'Poulet B', 0),
(1, 1.7, 'poulet3.jpg', 'Poulet C', 1),
(1, 1.8, 'poulet4.jpg', 'Poulet D', 0),
(1, 1.9, 'poulet5.jpg', 'Poulet E', 0),
(2, 2.0, 'boeuf1.jpg', 'Bœuf A', 0),
(2, 2.1, 'boeuf2.jpg', 'Bœuf B', 0),
(2, 2.2, 'boeuf3.jpg', 'Bœuf C', 1),
(2, 2.3, 'boeuf4.jpg', 'Bœuf D', 0),
(2, 2.4, 'boeuf5.jpg', 'Bœuf E', 0),
(3, 30.0, 'mouton1.jpg', 'Mouton A', 0),
(3, 31.0, 'mouton2.jpg', 'Mouton B', 0),
(3, 32.0, 'mouton3.jpg', 'Mouton C', 1),
(3, 33.0, 'mouton4.jpg', 'Mouton D', 0),
(3, 34.0, 'mouton5.jpg', 'Mouton E', 0),
(4, 50.0, 'cochon1.jpg', 'Cochon A', 0),
(4, 51.0, 'cochon2.jpg', 'Cochon B', 0),
(4, 52.0, 'cochon3.jpg', 'Cochon C', 1),
(4, 53.0, 'cochon4.jpg', 'Cochon D', 0),
(4, 54.0, 'cochon5.jpg', 'Cochon E', 0),
(5, 2.0, 'lapin1.jpg', 'Lapin A', 0),
(5, 2.2, 'lapin2.jpg', 'Lapin B', 0),
(5, 2.4, 'lapin3.jpg', 'Lapin C', 1),
(5, 2.6, 'lapin4.jpg', 'Lapin D', 0),
(5, 2.8, 'lapin5.jpg', 'Lapin E', 0);


INSERT INTO elevage_Historique_Alimentaion (id_animal, date_alimentation, poids) VALUES
(1, '2025-01-28', 2.5),
(1, '2025-02-01', 2.6),
(2, '2025-01-25', 300.0),
(2, '2025-01-30', 305.5),
(3, '2025-01-26', 40.2),
(3, '2025-02-02', 41.0),
(4, '2025-01-29', 100.0),
(5, '2025-01-27', 4.2),
(5, '2025-02-03', 4.3);


INSERT INTO elevage_Argent(argent) VALUES(0);

INSERT INTO elevage_Stock (id_alimentation, quantite) VALUES (1, 100);
INSERT INTO elevage_Stock (id_alimentation, quantite) VALUES (2, 20);
INSERT INTO elevage_Stock (id_alimentation, quantite) VALUES (3, 3);
INSERT INTO elevage_Stock (id_alimentation, quantite) VALUES (4, 40);
INSERT INTO elevage_Stock (id_alimentation, quantite) VALUES (5, 5);

UPDATE elevage_Alimentation
SET gain = CASE 
    WHEN nom_aliment = 'Maïs' THEN 5.00
    WHEN nom_aliment = 'Soja' THEN 6.50
    WHEN nom_aliment = 'Foin' THEN 2.50
    WHEN nom_aliment = 'Granulés' THEN 7.00
    WHEN nom_aliment = 'Herbe' THEN 3.00
    ELSE gain
END;
