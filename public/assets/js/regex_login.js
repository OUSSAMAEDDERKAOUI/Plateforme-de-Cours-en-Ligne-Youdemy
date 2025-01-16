document.getElementById('loginForm').addEventListener('submit', function(event) {
    is_valid=0;
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();
    
        let errorMessage = '';
    
       
        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    
        if ( !email || !password ) {
            errorMessage = 'Tous les champs sont obligatoires.';
            is_valid=0;
        }
  else if (!emailRegex.test(email)) {
            errorMessage = 'Veuillez entrer un email valide.';
            is_valid=0;
    
        } else if (!passwordRegex.test(password)) {
            errorMessage = 'Le mot de passe doit contenir au moins 8 caractères, une majuscule, un chiffre et un caractère spécial.';
            is_valid=0;
    
        }
    
       
        console.log("Email:", email);
        console.log("Mot de passe:", password);
    
        if (errorMessage) {
            document.getElementById('error-message').textContent = errorMessage;
        } else {
            
            console.log("Formulaire validé. Envoi des données...");
            is_valid=1;
        }
        if(is_valid===1){
            document.getElementById('registerForm').submit();
        }
        if(is_valid===0){
            event.preventDefault()  ;  }
    
        
    });
    
    