document.getElementById('categoryModal').addEventListener('submit', function(event) {

    const categoryName = document.getElementById('categoryName').value;
    const categoryDescription = document.getElementById('categoryDescription').value;

    const nameRegex = /^[a-zA-Z0-9\s]{3,50}$/;
    const descriptionRegex = /^[a-zA-Z0-9\s,.;!?'"()-]{10,300}$/;

    let isValid = 1;
    let errorMessageName = '';
    let errorMessageDesc = '';

    if (!nameRegex.test(categoryName)) {
        isValid = 0;
        errorMessageName = 'Le nom de la catégorie doit contenir entre 3 et 50 caractères, avec des lettres, des chiffres et des espaces.\n';
    }

    if (!descriptionRegex.test(categoryDescription)) {
        isValid = 0;
        errorMessageDesc = 'La description de la catégorie doit contenir entre 10 et 300 caractères, avec des lettres, des chiffres, et des espaces.\n';
    }

    if (isValid === 0) {
        document.getElementById('error-message-desc').textContent = errorMessageDesc;
        document.getElementById('error-message-name').textContent = errorMessageName; 
        event.preventDefault();

    } else {
        console.log("Formulaire validé. Envoi des données...");
        document.getElementById('categoryModal').submit();
    }
});
