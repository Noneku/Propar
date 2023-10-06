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


