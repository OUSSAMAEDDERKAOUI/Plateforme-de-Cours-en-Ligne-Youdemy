
<?php

session_start();
require_once __DIR__ . '../../../Models/Course.php';
require_once __DIR__ . '../../../Models/CourseDocument.php';
require_once __DIR__ . '../../../Models/CourseVideo.php';
require_once __DIR__ . '../../../Models/Users.php';
require_once __DIR__ . '../../../../config/database.php';
require_once __DIR__ . '../../../Models/Category.php';


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
    header('Location: ../views/login.php');
}
}
if (isset($_POST['dec'])) {
    session_unset();

    session_destroy();

    header('Location: ../user/login.php');
    exit();
}
$categories = Category::showVisiteurCategory();
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
                  
                <a href="./mesCourses.php" class="nav-link flex items-center space-x-3 p-3 rounded-lg text-gray-600" data-section="courses">
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
                            <button name="dec" class="nav-link flex items-center space-x-3 p-3 rounded-lg text-gray-600">
                                <i class="fas fa-sign-out-alt"></i>
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
                        <h1 class="text-2xl font-bold text-gray-800">Bonjour, Découvrez Nos Différentes Catégories 👋</h1>
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

                <div class="max-w-7xl mx-auto">
            <div id="coursesList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php  foreach($categories AS $category) : ?>
<?php $image=$category->getCategoryConverture() ;?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <img src="/<?php echo htmlspecialchars($category->getCategoryConverture()) ;?>" alt="photo de converture" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl text-indigo-600 mb-2"><?php echo htmlspecialchars($category->getCategoryId()) ;?> <?php echo htmlspecialchars($category->getCategoryTitle()) ;?></h3>
                        <p class="text-gray-600 mb-4">crée le <?php echo htmlspecialchars($category->getCreationDate()) ;?></p>
                        <p class="text-gray-500 text-sm mb-4"><?php echo htmlspecialchars($category->getCategoryDescription()) ;?></p>
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-indigo-600">Gratuit</span>
                            <a href="./explorer_course.php?id=<?php echo htmlspecialchars($category->getCategoryId()) ;?>"><button
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                Détails
                            </button></a>
                        </div>
                    </div>
                </div>
                <?php endforeach ;?>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center items-center space-x-2 mt-8" id="pagination">
                <!-- La pagination sera injectée ici via JavaScript -->
            </div>
        </div>
    </main>

    <!-- Modal d'inscription -->
    <div id="registerModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8 max-w-md w-full">
            <h2 class="text-2xl font-bold mb-6">Créer un compte</h2>
            <form id="registerForm" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nom complet</label>
                    <input type="text" name="fullName" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Mot de passe</label>
                    <input type="password" name="password" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Rôle</label>
                    <select name="role" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                        <option value="student">Étudiant</option>
                        <option value="teacher">Enseignant</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" id="closeRegisterModal"
                        class="px-4 py-2 border rounded-md hover:bg-gray-100">
                        Annuler
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        S'inscrire
                    </button>
                </div>
            </form>
        </div>
    </div>

              

             

    
    <!-- <script src="assets/js/student-dashboard.js"></script> -->
</body>
</html>
