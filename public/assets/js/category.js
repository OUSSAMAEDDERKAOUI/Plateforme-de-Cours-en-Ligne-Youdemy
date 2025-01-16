    // Fonction de validation du formulaire
    document.getElementById('categoryModal').addEventListener('submit', function(event) {
        // Empêche l'envoi du formulaire par défaut
        event.preventDefault();

        // Récupérer les valeurs des champs du formulaire
        const categoryName = document.getElementById('categoryName').value;
        const categoryDescription = document.getElementById('categoryDescription').value;

        // Regex pour le nom de la catégorie (lettres, chiffres, et espaces autorisés, entre 3 et 50 caractères)
        const nameRegex = /^[a-zA-Z0-9\s]{3,50}$/;
        // Regex pour la description (lettres, chiffres, espaces et caractères spéciaux autorisés, entre 10 et 300 caractères)
        const descriptionRegex = /^[a-zA-Z0-9\s,.;!?'"()-]{10,300}$/;

        let isValid = 1; // Initialement, on considère que tout est valide
        let errorMessageName = '';
        let errorMessageDesc ='';
        // Validation du nom de la catégorie
        if (!nameRegex.test(categoryName)) {
            isValid = 0; // Si invalidé, changer isValid à false
            errorMessageName = 'Le nom de la catégorie doit contenir entre 3 et 50 caractères, avec des lettres, des chiffres et des espaces.\n';
        }

        // Validation de la description
        if (!descriptionRegex.test(categoryDescription)) {
            isValid = 0; // Si invalidé, changer isValid à false
            errorMessageDesc = 'La description de la catégorie doit contenir entre 10 et 300 caractères, avec des lettres, des chiffres, et des espaces.\n';
        }

        // Si des erreurs sont présentes
        if (isValid===0) {
            document.getElementById('error-message-desc').textContent = errorMessageDesc;
            document.getElementById('error-message-name').textContent = errorMessageName; 
        } else {
            // Si tout est valide, soumettre le formulaire
            console.log("Formulaire validé. Envoi des données...");
            document.getElementById('categoryModal').submit(); // Soumettre le formulaire
        }
    });
