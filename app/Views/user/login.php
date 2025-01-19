<?php
require_once __DIR__.'../../../Models/Users.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
    echo'1';
    if(isset($_POST['login'])){
        echo'2';
       
        $postEmail = htmlspecialchars(trim(string: $_POST['email']));
        $postPassword =htmlspecialchars( $_POST['password']);

        if (empty($postEmail) || empty($postPassword)) {
            echo'3';

            echo "Veuillez remplir tous les champs.";
        }else {
            echo'4';

            $user = new Users("","","","","","");

            $loggedInUser = $user->login( $postEmail, $postPassword);

            if ($loggedInUser) {
                
                session_start();

                $_SESSION['user_id'] = $loggedInUser->getidUser();
                $_SESSION['user_prenom'] = $loggedInUser->getfName();
                $_SESSION['user_nom'] = $loggedInUser->getlName();
                $_SESSION['user_email'] = $loggedInUser->getEmail();
                $_SESSION['user_role'] = $loggedInUser->getRole();

                if (isset($_SESSION['user_role'])) {
                    // Rediriger selon le rôle de l'utilisateur
                    switch ($_SESSION['user_role']) {
                        case 'admin':
                            header('Location: ../admin/dashboard_tags.php');
                            break;
                        case 'etudiant':
                            header('Location: ../etudiant/dashboard.php');
                            break;
                        case 'enseignant':
                            header('Location: ../teacher/dashboard.php');
                            break;
                        default:
                            // Rediriger vers la page d'accueil par défaut
                            header('Location: ../visiteur/visiteur.php');
                            break;
                    }
                    exit;
                } else {
                    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
                    header('Location: ../visiteur/visiteur.php');
                    exit;
                }
                
                // header('Location: __DIR__ . ../ " . $_SESSION['user_role'] . ".php;');



                // header('Location: ../views/'.$_SESSION['user_role'].'.php');
                // if($_SESSION['user_role'] ==='admin'){
                //     header("Location: ../views/admin.php");
                // }else if($_SESSION['user_role'] ==='membre'){
                //     header("Location: ../views/membre.php");
                // } else if($_SESSION['user_role'] ==='auteur'){
                //     header("Location: ../views/auteur.php");
                    
                // }


                exit;
            } else {
                echo'6--------------------------';

                echo "Identifiants incorrects.";
            }
        }
        
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CultureConnect - Login</title>
    <link rel="icon" type="../assets/img/logo.png" href="../../assets/img/logo.png">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    
    <main class="redirection flex justify-center drop-shadow-2xl items-center h-screen relative ">
    <div class="absolute inset-0">
        <img src="/public/assets/images/Udemy-vs-Coursera--1-.webp" alt="Background Image" class="object-cover w-full h-full ">
    </div>
    <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-green-500 opacity-70"></div>
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-lg animate__animated animate__fadeIn">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Connectez-vous à votre compte
                </h2>
                
            </div>
            <form method="POST" action="" id="loginForm" class="mt-8 space-y-6">
                <div class="rounded-md shadow-sm flex flex-col gap-5">
                    <div>
                        <label for="email" class="sr-only">Adresse email</label>
                        <input id="email" name="email" type="email" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-purple-500 focus:border-purple-500 focus:z-10 sm:text-sm" placeholder="Adresse email">
                    </div>
                    <div>
                        <label for="password" class="sr-only">Mot de passe</label>
                        <input id="password" name="password" type="password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-purple-500 focus:border-purple-500 focus:z-10 sm:text-sm" placeholder="Mot de passe">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                            Se souvenir de moi
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-medium text-purple-600 hover:text-purple-500">
                            Mot de passe oublié ?
                        </a>
                    </div>
                </div>
                <div id="error-message" class="text-red-600 text-sm mt-2"></div>
                <div>
                    <button type="submit" name="login" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-lock"></i>
                        </span>
                        Se connecter
                    </button>
                    <p class="mt-2 text-center text-sm text-gray-600">
                 
                    <a href="signup.php" class="font-medium text-purple-600 hover:text-purple-500">
                        créez un nouveau compte ?
                    </a>
                </p>
                </div>
            </form>
        </div>
    </main>
    <script src="../../../public/assets/js/regex_login.js"></script>

</body>
</html>