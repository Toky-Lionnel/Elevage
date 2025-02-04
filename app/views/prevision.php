<form action="<?= constant('BASE_URL')?>prevision" method="post" class="mt-5" id="previsionForm">
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



<script>
    // Injecter la base URL dans une variable JavaScript
    var baseUrl = "<?= constant('BASE_URL') ?>";

    var form = document.getElementById('previsionForm');

    form.addEventListener("submit", function(event) {
        event.preventDefault();
        sendData();
    });

    function sendData() {
        var xhr = new XMLHttpRequest();
        var formData = new FormData(form);
        xhr.open("POST", baseUrl + "prevision", true);  // Utiliser baseUrl ici

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                generateAnimalHTML(xhr.responseText);
            }
        }
        xhr.send(formData);
    }


    function generateAnimalHTML(data) {
        // Parse des données JSON
        var animals = JSON.parse(data);
        var htmlContent = '';

        // Parcours des animaux et génération du HTML pour chaque animal
        animals.forEach(function(animal) {
            var animalHTML = `
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <!-- Affichage de l'image de l'animal -->
                    <img class="card-img-top" src="${animal.image}" alt="Image de l'${animal.animal}" />

                    <div class="card-body text-center">
                        <h5 class="card-title">${animal.animal}</h5>

                        <p class="card-text">
                            <strong>Type :</strong> ${animal.type_animal}<br>
                            <strong>Poids Final :</strong> ${animal.poids_final} kg<br>
                            <strong>Stock initial :</strong> ${animal.stock_initial} unités<br>
                            <strong>Stock disponible :</strong> ${animal.stock_final} unités<br>
                            <strong>Stock vidé :</strong> ${animal.stock_vidé_le} unités<br>
                            <strong>Dernier repas :</strong> ${animal.dernier_repas}
                        </p>
                    </div>
                </div>
            </div>
            `;
            htmlContent += animalHTML; // Ajouter chaque carte au contenu HTML
        });

        document.getElementById('page_prevision').innerHTML = htmlContent;
    }

</script>