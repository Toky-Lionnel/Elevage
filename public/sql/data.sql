INSERT INTO elevage_Alimentation (nom_aliment) VALUES
('Maïs'),
('Soja'),
('Foin'),
('Granulés'),
('Herbe');

INSERT INTO elevage_Type_Animal (nom_type, poids_min_vente, poids_maximal, prix_vente_kg, nb_jour_sans_manger, perte_poids, id_alimentation) VALUES
('Poulet', 1.20, 3.50, 5.00, 3, 0.10, 1),
('Bœuf', 250.00, 900.00, 4.50, 5, 10.00, 2),
('Mouton', 30.00, 80.00, 6.00, 4, 2.00, 3),
('Cochon', 50.00, 150.00, 5.50, 4, 5.00, 4),
('Lapin', 2.00, 5.00, 7.00, 2, 0.20, 5);
