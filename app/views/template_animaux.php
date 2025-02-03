<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des animaux</title>
</head>
<body>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Type</th>
            <th>Poids (kg)</th>
            <th>Image</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($animaux)): ?>
            <?php foreach ($animaux as $animal): ?>
                <tr>
                    <td><?php echo $animal['id_animal']; ?></td>
                    <td><?php echo $animal['nom_animal'] ?: 'Non défini'; ?></td>
                    <td><?php echo $animal['id_type_animal']; ?></td>
                    <td><?php echo $animal['poids_initial']; ?> kg</td>
                    <td><img src="<?php echo $animal['image_animal']; ?>" alt="Image de l'animal" width="100"></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Aucun animal en vente.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>