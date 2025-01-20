<?php
session_start();
require_once __DIR__ . '../../../Models/Course.php';
require_once __DIR__ . '../../../Models/CourseDocument.php';
require_once __DIR__ . '../../../Models/CourseVideo.php';
require_once __DIR__ . '../../../Models/Users.php';
require_once __DIR__ . '../../../../config/database.php';

if (!Users::isAuth('visiteur')) {
    if (isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) {
        if($_SESSION['user_role']=='admin'){
            header('Location: ../admin/dashboard_category.php');
        }
        if($_SESSION['user_role']=='enseignant'){
            header('Location: ../teacher/dashboard.php');
        }
}
else {
    header('Location: ../user/login.php');

}
}

if (isset($_POST['dec'])) {
    session_unset();

    session_destroy();

    header('Location: ../user/login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Espace Étudiant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .course-card {
            transition: transform 0.2s ease-in-out;
        }
        .course-card:hover {
            transform: translateY(-5px);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
        }
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
        }
        .nav-link {
            transition: all 0.2s ease-in-out;
        }
        .nav-link:hover {
            background-color: rgba(79, 70, 229, 0.1);
        }
        .nav-link.active {
            background-color: #4F46E5;
            color: white;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Mobile Menu Button -->
    <button id="sidebarToggle" class="fixed top-4 left-4 z-50 md:hidden bg-white p-2 rounded-lg shadow-lg">
        <i class="fas fa-bars text-gray-600"></i>
    </button>

    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar w-64 bg-white shadow-lg fixed h-full z-40">
            <div class="p-6">
                <div class="flex items-center space-x-3 mb-8">
                    <div class="gradient-bg p-2 rounded-lg">
                        <i class="fas fa-graduation-cap text-white text-xl"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-800">Youdemy</span>
                </div>
                <nav class="space-y-2">
                  
                <a href="./etudiant.php" class="nav-link flex items-center space-x-3 p-3 rounded-lg text-gray-600" data-section="courses">
                        <i class="fas fa-book"></i>
                        <span>Mes cours</span>
                    </a>
                    <a href="./explorer.php" class="nav-link flex items-center space-x-3 p-3 rounded-lg text-gray-600" data-section="explore">
                        <i class="fas fa-search"></i>
                        <span>Explorer</span>
                    </a>
                    
                    <a href="./profile.php" class="nav-link flex items-center space-x-3 p-3 rounded-lg text-gray-600" data-section="profile">
                        <i class="fas fa-user"></i>
                        <span>Mon profil</span>
                    </a>
                    <form action="" method="POST">
                            <button name="dec" class="nav-link flex items-center space-x-3 p-3 rounded-lg text-gray-600 ">
                                <i class="fas fa-sign-out-alt mr-4"></i>
                                Déconnexion
                            </button>
                </form>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main id="mainContent" class="flex-1 ml-0 md:ml-64 p-8 main-content">
            <!-- Les sections -->
            <div id="dashboard-section" class="section active">
                <!-- Header -->
                <header class="flex justify-between items-center mb-8">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Bonjour, Alex 👋</h1>
                        <p class="text-gray-600">Continuez votre apprentissage</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" 
                                   placeholder="Rechercher un cours..." 
                                   class="pl-10 pr-4 py-2 rounded-lg border border-gray-200 w-64 focus:ring-2 focus:ring-indigo-400 focus:border-transparent">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        <div class="flex items-center space-x-3">
                            <button class="p-2 rounded-lg text-gray-600 hover:bg-gray-100 relative">
                                <i class="fas fa-bell"></i>
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">3</span>
                            </button>
                            <img src="https://ui-avatars.com/api/?name=Alex+Doe&background=4F46E5&color=fff" 
                                 alt="Profile" 
                                 class="w-10 h-10 rounded-lg cursor-pointer">
                        </div>
                    </div>
                </header>



            <!-- //////////////////////////////////////////////////////////////////: -->




            <div class="articles-grid grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6">
                <?php


                require_once '../classes/membre.php';

                $membre = new Membre("", "", "", "", "", "","");



                $id_article = $_GET['id'];


                $result = $membre->showDetails($id_article);
                if ($result) {
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

                        $image = $row['image'];
                        $image_user=$row['image_user'];
                        echo '  <article class="bg-white rounded-lg shadow-lg overflow-hidden animate__animated animate__fadeIn">
    <div class="relative">
        <img src="' . htmlspecialchars($image) . '" alt="" class="w-full h-96 object-cover">
       


        <div class="absolute top-0 right-0 m-2">
            <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-sm">
              ' . $row['categorieTitre'] . ' </span>
        </div>';
      
   echo' </div>
    <div class="p-6">';
                        echo '<div class="mb-8">';
                        echo ' <h1 class="text-4xl font-bold text-gray-900 mb-4">' . $row['articleTitre'] . '</h1>
        
        <div class="flex items-center gap-4 mb-6">
            <img src="'.htmlspecialchars($image_user).'" class="w-12 h-12 rounded-full" alt="Author">
            <div>
                <p class="font-semibold text-gray-900">' . ' ' . $row['nom'] . '  ' . $row['prenom'] . '  </p>
                <p class="text-gray-500 text-sm">Publié le ' . $row['date_publication'] . '</p>
            </div>
        </div>
    </div>
          <pre class="text-gray-800 mb-2 whitespace-pre-line">' . $row['contenu'] . '
        </pre>
        <br>';
            require_once '../classes/article_tag.php';
                $TagArticle=new TagArticle("","");
               $results= $TagArticle->getTagsByArticle($id_article);
               if(count($results) > 0){
                echo'<div class="flex  text-center gap-2 m-4 ">';
                foreach($results as $res){
                   echo' <div class="px-3 py-1  text-blue-600 rounded-full text-sm"># '.$res['nom_tag'].'</div>';
                }
                echo'</div>';
            }
      
   echo' </div>';
     
echo'</article> ';
                    }
                }
                
                echo'<div class="m-4 flex items-center gap-2">
                <a href="../functions/addLike.php?id='.$id_article.'">';
                
                  require_once '../classes/favoris.php';
                    $showLikes=new Favoris("","");
                    $Likes=$showLikes->showLikes($id_article);
               echo' <button class="bg-blue-500 text-white px-4 py-2 rounded flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                    </svg>
                  

                  '.$Likes['likescount'] .' J\'aimes
                   
               </button>
                </a>
                
            </div>'
                ?>

            </div>


            
            

            
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 mt-12">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div class="text-white">
                    <h3 class="text-2xl font-bold">MelodyHub</h3>
                    <p class="mt-2 text-gray-400">Votre passerelle vers la culture</p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-gray-300">
                        <i class="fab fa-facebook text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-gray-300">
                        <i class="fab fa-twitter text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-gray-300">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>


    </html>