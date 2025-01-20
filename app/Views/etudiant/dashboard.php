
<?php
session_start();
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
                    <a href="./etudiant_explorer.php" class="nav-link flex items-center space-x-3 p-3 rounded-lg text-gray-600" data-section="explore">
                        <i class="fas fa-search"></i>
                        <span>Explorer</span>
                    </a>
                    
                    <a href="./etudiant_profile.php" class="nav-link flex items-center space-x-3 p-3 rounded-lg text-gray-600" data-section="profile">
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

               

              

                
            </div>

            <!-- Autres sections (initialement cachées) -->
            <div id="courses-section" class="section ">
                <h2 class="text-2xl font-bold mb-6">Mes cours</h2>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Liste des cours -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-start space-x-4">
                            <img src="https://placehold.co/200x150" alt="Course" class="w-32 h-24 object-cover rounded-lg">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold mb-2">JavaScript Moderne</h3>
                                <div class="flex items-center text-sm text-gray-500 mb-2">
                                    <i class="fas fa-user-tie mr-2"></i>
                                    <span>Prof. Sarah Johnson</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-500 mb-3">
                                    <i class="fas fa-clock mr-2"></i>
                                    <span>20h total • Progression : 65%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: 65%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-start space-x-4">
                            <img src="https://placehold.co/200x150" alt="Course" class="w-32 h-24 object-cover rounded-lg">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold mb-2">Python pour Data Science</h3>
                                <div class="flex items-center text-sm text-gray-500 mb-2">
                                    <i class="fas fa-user-tie mr-2"></i>
                                    <span>Dr. Michael Chen</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-500 mb-3">
                                    <i class="fas fa-clock mr-2"></i>
                                    <span>40h total • Progression : 30%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: 30%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-start space-x-4">
                            <img src="https://placehold.co/200x150" alt="Course" class="w-32 h-24 object-cover rounded-lg">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold mb-2">React.js Avancé</h3>
                                <div class="flex items-center text-sm text-gray-500 mb-2">
                                    <i class="fas fa-user-tie mr-2"></i>
                                    <span>Alex Thompson</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-500 mb-3">
                                    <i class="fas fa-clock mr-2"></i>
                                    <span>35h total • Progression : 85%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: 85%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-start space-x-4">
                            <img src="https://placehold.co/200x150" alt="Course" class="w-32 h-24 object-cover rounded-lg">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold mb-2">UX/UI Design Fondamentaux</h3>
                                <div class="flex items-center text-sm text-gray-500 mb-2">
                                    <i class="fas fa-user-tie mr-2"></i>
                                    <span>Emma Rodriguez</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-500 mb-3">
                                    <i class="fas fa-clock mr-2"></i>
                                    <span>25h total • Progression : 45%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: 45%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
                 

                </div>
            </div>

          

        </main>
    </div>



    
    <script src="assets/js/student-dashboard.js"></script>
</body>
</html>
