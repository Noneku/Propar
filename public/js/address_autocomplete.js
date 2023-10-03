// address_autocomplete.js
$(document).ready(function () {
    $("#registration_client_form_adresse").keyup(function (e) {
        e.preventDefault();

        var input = $("#registration_client_form_adresse");
        var resultList = $("#adresse-suggestions"); // Créez une div ou un élément pour afficher les suggestions

        $.ajax({
            url: input.attr('data-api-url'),
            type: 'get',
            data: {
                q: input.val()
            },
            success: function (response) {
                resultList.empty(); // Effacez les suggestions précédentes

                if (response.features && response.features.length > 0) {
                    response.features.forEach(function (feature) {
                        var suggestion = $("<div>" + feature.properties.label + "</div>");
                        suggestion.addClass("suggestion"); // Ajoutez une classe CSS à chaque suggestion

                        suggestion.on("click", function () {
                            input.val(feature.properties.label); // Mettez à jour le champ d'adresse lorsqu'une suggestion est sélectionnée
                            resultList.empty(); // Effacez les suggestions après la sélection
                        });

                        resultList.append(suggestion);
                    });
                }
            },
            error: function (response) {
                console.log('error');
            }
        });
    });
});
