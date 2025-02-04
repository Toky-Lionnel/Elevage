public function alimenterAnimaux($date_debut, $date_fin)
{
    $types_animaux = $this->getTypesAnimaux();
    $situation_animaux = [];
    $situation_stocks = [];

    foreach ($types_animaux as $type) {
        // Récupérer les informations nécessaires
        $stock_info = $this->getStockInfo($type['id_alimentation']);
        $stock_disponible = $stock_info['quantite'];
        $stock_initial = $stock_disponible;
        $stock_vidé = null;
        $nom_aliment = $stock_info['nom_aliment'];
        $gain = $stock_info['gain'];
        $jours_max_sans_manger = $type['nb_jour_sans_manger'];
        $perte_poids = $type['perte_poids'];

        $animaux = $this->getAnimauxParType($type['id_type_animal']);
        $dates_animaux = $this->getDernieresDatesAlimentation();

        // Simuler l'alimentation sur la période donnée
        $this->simulerAlimentation($animaux, $dates_animaux, $stock_disponible, $date_debut, $date_fin, $gain, $perte_poids, $jours_max_sans_manger, $stock_vidé);

        // Construire la situation finale des animaux et du stock
        $situation_animaux = array_merge($situation_animaux, $this->genererSituationAnimaux($animaux, $dates_animaux, $type, $date_fin, $jours_max_sans_manger));
        $situation_stocks[] = $this->genererSituationStock($nom_aliment, $stock_initial, $stock_disponible, $stock_vidé);
    }

    return [
        'animaux' => $situation_animaux,
        'stocks' => $situation_stocks
    ];
}

/**
 * Récupère les informations sur l'alimentation et le stock.
 */
private function getStockInfo($id_alimentation)
{
    $stmt = $this->db->prepare("SELECT nom_aliment, gain, quantite FROM elevage_Alimentation 
                                JOIN elevage_Stock ON elevage_Alimentation.id_alimentation = elevage_Stock.id_alimentation
                                WHERE elevage_Alimentation.id_alimentation = ?");
    $stmt->execute([$id_alimentation]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Récupère les dernières dates d'alimentation des animaux.
 */
private function getDernieresDatesAlimentation()
{
    $dernieres_dates = $this->getDernierHistoriqueParAnimal();
    $dates_animaux = [];

    foreach ($dernieres_dates as $historique) {
        $dates_animaux[$historique['id_animal']] = $historique['derniere_date'];
    }

    return $dates_animaux;
}

/**
 * Simule l'alimentation des animaux jour après jour.
 */
private function simulerAlimentation(&$animaux, &$dates_animaux, &$stock_disponible, $date_debut, $date_fin, $gain, $perte_poids, $jours_max_sans_manger, &$stock_vidé)
{
    for ($jour = strtotime($date_debut); $jour <= strtotime($date_fin); $jour += 86400) {
        $date_actuelle = date('Y-m-d', $jour);

        foreach ($animaux as &$animal) {
            $dernier_repas = $dates_animaux[$animal['id_animal']] ?? $date_debut;
            $jours_sans_manger = (strtotime($date_actuelle) - strtotime($dernier_repas)) / 86400;

            if ($jours_sans_manger > $jours_max_sans_manger) {
                $animal['statut'] = "Mort";
                continue;
            } else {
                $animal['statut'] = "Vivant";
            }

            if ($stock_disponible > 0) {
                $animal['poids_initial'] += $gain;
                $stock_disponible -= 1;
                $dates_animaux[$animal['id_animal']] = $date_actuelle;
            } else {
                $animal['poids_initial'] -= ($animal['poids_initial'] * ($perte_poids / 100));

                if ($stock_vidé === null) {
                    $stock_vidé = $date_actuelle;
                }
            }
        }
    }
}

/**
 * Génère la situation finale des animaux après la simulation.
 */
private function genererSituationAnimaux($animaux, $dates_animaux, $type, $date_fin, $jours_max_sans_manger)
{
    $result = [];

    foreach ($animaux as $animal) {
        $dernier_repas = $dates_animaux[$animal['id_animal']] ?? "Jamais nourri";
        $jours_sans_manger = (strtotime($date_fin) - strtotime($dernier_repas)) / 86400;
        $statut = ($jours_sans_manger > $jours_max_sans_manger) ? "Mort" : "Vivant";

        $result[] = [
            'id_animal' => $animal['id_animal'],
            'animal' => $animal['nom_animal'],
            'image' => $animal['image_animal'],
            'poids_final' => $this->verifPoidsMax($animal['poids_initial'], $animal['poids_maximal']),
            'poids_max' => $animal['poids_maximal'],
            'type_animal' => $type['nom_type'],
            'dernier_repas' => $dernier_repas,
            'nombre_sans_manger' => $jours_sans_manger,
            'statut' => $statut
        ];
    }

    return $result;
}

/**
 * Génère la situation finale du stock.
 */
private function genererSituationStock($nom_aliment, $stock_initial, $stock_final, $stock_vidé)
{
    return [
        'nom_aliment' => $nom_aliment,
        'stock_initial' => $stock_initial,
        'stock_final' => $stock_final,
        'stock_vidé_le' => $stock_vidé ?? "Non vidé"
    ];
}
