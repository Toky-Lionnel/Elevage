<form action="<?= constant('BASE_URL') ?>prevision" method="post" class="mt-5" id="previsionForm">
    <div class="mb-3 row">
        <label for="html5-date-input" class="col-md-2 col-form-label">Date de prevision</label>
        <div class="col-md-10">
            <input class="form-control" type="date" id="html5-date-input" name="date_prev" />
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-md-10 offset-md-2">
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </div>
    </div>
</form>



<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="page_prevision">


</div>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="page_stocks">


</div>



<script>
    var baseUrl = "<?= constant('BASE_URL') ?>";

    var form = document.getElementById('previsionForm');

    form.addEventListener("submit", function(event) {
        event.preventDefault();
        sendData();
    });

    function sendData() {
        var xhr = new XMLHttpRequest();
        var formData = new FormData(form);
        xhr.open("POST", baseUrl + "prevision", true); // Utiliser baseUrl ici

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var data = JSON.parse(xhr.responseText);

                // Générer le HTML pour les animaux
                generateAnimalHTML(data.animaux);

                // Générer le HTML pour les stocks (si nécessaire)
                generateStockHTML(data.stocks);
            }
        }
        xhr.send(formData);
    }

    function generateAnimalHTML(animals) {
        var htmlContent = '';

        animals.forEach(function(animal) {
            var animalHTML = `
        <div class="col">
            <div class="card h-100 shadow-sm">
                <!-- Affichage de l'image de l'animal -->
                <img class="card-img-top" src="${animal.image}" alt="Image de ${animal.animal}" />

                <div class="card-body text-center">
                    <h5 class="card-title">${animal.animal}</h5>

                    <p class="card-text">
                        <strong>Type :</strong> ${animal.type_animal}<br>
                        <strong>Poids Final :</strong> ${animal.poids_final} kg<br>
                        <strong>Poids Max :</strong> ${animal.poids_max} kg<br>
                        <strong>Dernier repas :</strong> ${animal.dernier_repas}<br>
                        <strong>Nb jours sans manger :</strong> ${animal.nombre_sans_manger}<br>
                        <strong>Statut :</strong> ${animal.statut}
                    </p>
                </div>
            </div>
        </div>
        `;
            htmlContent += animalHTML; // Ajouter chaque carte au contenu HTML
        });

        // Insérer le HTML généré dans la page
        document.getElementById('page_prevision').innerHTML = htmlContent;
    }


    function generateStockHTML(stocks) {
        var htmlContent = '';

        stocks.forEach(function(stock) {
            var stockHTML = `
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">${stock.nom_aliment}</h5>

                    <p class="card-text">
                        <strong>Type d'animal :</strong> ${stock.type_animal}<br>
                        <strong>Stock initial :</strong> ${stock.stock_initial} unités<br>
                        <strong>Stock disponible :</strong> ${stock.stock_final} unités<br>
                        <strong>Stock vidé le :</strong> ${stock.stock_vidé_le}<br>
                        <strong>Animaux nourris :</strong> ${stock.animaux_nourris}
                    </p>
                </div>
            </div>
        </div>
        `;
            htmlContent += stockHTML; // Ajouter chaque carte au contenu HTML
        });

        // Insérer le HTML généré dans la page
        document.getElementById('page_stocks').innerHTML = htmlContent;
    }


    function fetchData() {
        fetch('votre_script_php.php') // Remplacez par l'URL de votre script PHP
            .then(response => response.json())
            .then(data => {
                // Générer le HTML pour les animaux
                generateAnimalHTML(data.animaux);

                // Générer le HTML pour les stocks (si nécessaire)
                generateStockHTML(data.stocks);
            })
            .catch(error => console.error('Erreur lors de la récupération des données :', error));
    }

    // Appeler la fonction pour récupérer les données
    fetchData();
</script>