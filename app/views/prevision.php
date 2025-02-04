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


<h2 class="mt-5 text-center text-primary" id="prev_anim"> </h2>
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="page_prevision"></div>

<h2 class="mt-5 text-center text-success" id="prev_stock"> </h2>
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="page_stocks"></div>

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
        var htmlContent = "";

        animals.forEach(function(animal) {
            var animalHTML = `
            <div class="col mt-5">
    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden mt-5 hover-shadow">
        
        <img class="card-img-top img-fluid" src="${animal.image}" alt="Image de ${animal.animal}" style="height: 200px; object-fit: cover;">

        <div class="card-body text-center p-4">
            <h5 class="card-title text-dark fw-bold mb-3">${animal.animal}</h5>

            <div class="text-start">
                <p class="mb-2">
                    <i class="fas fa-paw me-2 text-primary"></i>
                    <strong>Type :</strong> ${animal.type_animal}
                </p>
                <p class="mb-2">
                    <i class="fas fa-weight me-2 text-warning"></i>
                    <strong>Poids Max :</strong> ${animal.poids_max} kg
                </p>
                <p class="mb-2">
                    <i class="fas fa-tag me-2 text-info"></i>
                    <strong>État :</strong> ${getLettreAutoVente(animal.auto_vente)}
                </p>
                <p class="mb-2">
                    <i class="fas fa-calendar-day me-2 text-secondary"></i>
                    <strong>Dernier repas :</strong> ${animal.dernier_repas}
                </p>
                <p class="mb-2">
                    <i class="fas fa-clock me-2 text-danger"></i>
                    <strong>Jours sans manger :</strong> ${animal.nombre_sans_manger}
                </p>
                <p class="mb-2">
                    <i class="fas fa-utensils me-2 text-primary"></i>
                    <strong>Quota :</strong> ${animal.quota}
                </p>
                <p class="mb-0">
                    <i class="fas fa-info-circle me-2 text-dark"></i>
                    <strong>Statut :</strong>
                    <span class="badge ${animal.statut === 'Vivant' ? 'bg-success' : animal.statut === 'Mort' ? 'bg-danger' : 'bg-warning'}">
                        ${animal.statut}
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>`;

            htmlContent += animalHTML;
        });

        document.getElementById('page_prevision').innerHTML = htmlContent;
        document.getElementById('prev_anim').innerHTML = "Prévision de l'état des animaux";
    }

    function generateStockHTML(stocks) {
        var htmlContent = "";

        stocks.forEach(function(stock) {
            var stockHTML = `
                <div class="col mt-5">
                    <div class="card h-100 shadow-sm border-0 rounded-4 mt-5">
                        <div class="card-body text-center p-3">
                            <h5 class="card-title text-dark fw-bold">${stock.nom_aliment}</h5>
                            <p class="card-text text-muted">
                                <strong>Type d'animal :</strong> ${stock.type_animal}<br>
                                <strong>Stock initial :</strong> ${stock.stock_initial} unités<br>
                                <strong>Stock disponible :</strong> ${formatNumber(stock.stock_final)} unités<br>
                                <strong>Stock vidé le :</strong> ${stock.stock_vidé_le}<br>
                            </p>
                        </div>
                    </div>
                </div>
            `;
            htmlContent += stockHTML;
        });

        document.getElementById('page_stocks').innerHTML = htmlContent;
        document.getElementById('prev_stock').innerHTML = "Prévision des stocks";
    }


    function getLettreAutoVente(valeur) {
        if (valeur === 0) {
            return "En Auto Vente";
        }
        return "Vente Manuel"
    }



    function formatNumber(number, decimals = 2, defaultValue = "N/A") {
        if (typeof number === 'number') {
            return number.toFixed(decimals);
        } else {
            console.error("Invalid input: Expected a number, but got", typeof number, "Value:", number);
            return defaultValue;
        }
    }
</script>