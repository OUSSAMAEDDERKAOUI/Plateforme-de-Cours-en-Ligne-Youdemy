document.getElementById('registerForm').addEventListener('submit', function(event) {
is_valid=0;
    // Récupérer les valeurs des champs
    const prenom = document.getElementById('prenom').value.trim();
    const nom = document.getElementById('nom').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();
    const role = document.getElementById('role').value.trim(); // Assurez-vous que role est bien trimé

    let errorMessage = '';

    // Regex pour le prénom et nom : lettres, espaces, apostrophes, tirets
    const nameRegex = /^[A-Za-zÀ-ÿÉéÈèÊêËëÏïÎîÔôÖöÙùÜüÇç' -]+$/;

    // Regex pour l'email
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

    // Regex pour le mot de passe : min 8 caractères, 1 majuscule, 1 chiffre, 1 caractère spécial
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

    // Validation des champs
    if (!prenom || !nom || !email || !password || !role) {
        errorMessage = 'Tous les champs sont obligatoires.';
        is_valid=0;

    } else if (!nameRegex.test(prenom)) {
        errorMessage = 'Le prénom ne doit contenir que des lettres, des espaces, des tirets ou des apostrophes.';
        is_valid=0;

    } else if (!nameRegex.test(nom)) {
        errorMessage = 'Le nom ne doit contenir que des lettres, des espaces, des tirets ou des apostrophes.';
        is_valid=0;

    } else if (!emailRegex.test(email)) {
        errorMessage = 'Veuillez entrer un email valide.';
        is_valid=0;

    } else if (!passwordRegex.test(password)) {
        errorMessage = 'Le mot de passe doit contenir au moins 8 caractères, une majuscule, un chiffre et un caractère spécial.';
        is_valid=0;

    }

    // Débogage: Afficher les valeurs dans la console pour vérifier les champs
    console.log("Prénom:", prenom);
    console.log("Nom:", nom);
    console.log("Email:", email);
    console.log("Mot de passe:", password);
    console.log("Rôle:", role);

    // Affichage du message d'erreur ou soumission du formulaire
    if (errorMessage) {
        document.getElementById('error-message').textContent = errorMessage;
    } else {
        // Si tout est valide, soumettre le formulaire
        // Débogage: Confirmer la soumission du formulaire
        console.log("Formulaire validé. Envoi des données...");
        is_valid=1;
    }
    if(is_valid===1){
        document.getElementById('registerForm').submit();
    }
    if(is_valid===0){
        event.preventDefault()  ;  }

    
});

