document.querySelectorAll('.finish-operation').forEach(function(button) {
    button.addEventListener('click', function() {
        const operationId = button.getAttribute('data-operation-id');
        fetch(`/operation/finish/${operationId}`, {
            method: 'POST', // ou 'GET' selon votre configuration
        })
        .then(response => {
            if (response.ok) {
                // L'opération a été terminée avec succès, masquez la ligne correspondante dans le tableau
                button.closest('tr').style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Erreur lors de la requête :', error);
        });
    });
});

const toggleCompletedCheckbox = document.getElementById('toggle-completed-operations');
toggleCompletedCheckbox.addEventListener('change', function() {
    const completedOperations = document.querySelectorAll('.completed-operation');
    completedOperations.forEach(function(operation) {
        operation.style.display = toggleCompletedCheckbox.checked ? 'table-row' : 'none';
    });
});
document.addEventListener('DOMContentLoaded', function () {
    // Sélectionnez tous les boutons "Terminer" avec la classe .finish-operation
    const finishButtons = document.querySelectorAll('.finish-operation');

    finishButtons.forEach(button => {
        button.addEventListener('click', function () {
            const emailUrl = button.getAttribute('data-email-url');

            // Redirigez l'utilisateur vers votre contrôleur d'e-mail
            window.location.href = emailUrl;
        });
    });
});



