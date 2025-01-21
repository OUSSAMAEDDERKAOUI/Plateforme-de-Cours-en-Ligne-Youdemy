
<?php
require_once __DIR__ . '../../../Models/Tags.php';
require_once __DIR__ . '../../../Models/Users.php';

session_start();
if (!Users::isAuth('visiteur')) {
    if (isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) {
        
        if($_SESSION['user_role']=='enseignant'){
            header('Location: ../teacher/dashboard.php');
        }
        if($_SESSION['user_role']=='etudiant'){
            header('Location: ../etudiant/dashboard.php');
        }
}
else {
    header('Location: ../visiteur/categories.php');

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
    <title>Youdemy - Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="bg-gray-100">
   
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="bg-indigo-800 text-white w-64 min-h-screen p-4">
            <div class="flex items-center mb-8">
                <i class="fas fa-graduation-cap text-3xl mr-3"></i>
                <div class="sidebar-text">
                    <h1 class="text-2xl font-bold">Youdemy</h1>
                    <p class="text-sm text-gray-300">Administration</p>
                </div>
            </div>
            <nav>
                <ul class="space-y-2">
                <ul class="space-y-2">
                    <li>
                        <a href="./dashboard_admin.php" class="w-full flex items-center p-2 hover:bg-indigo-700 rounded">
                            <i class="fas fa-chart-line w-6"></i>
                            <span>Tableau de bord</span>
                        </a>
                    </li>
                    <li>
                        <a href="./dashboard_users.php" class="w-full flex items-center p-2 hover:bg-indigo-700 rounded">
                            <i class="fas fa-users w-6"></i>
                            <span>Utilisateurs</span>
                        </a>
                    </li>
                    <li>
                        <a href="./dashboard_admin_coures.php" class="w-full flex items-center p-2 hover:bg-indigo-700 rounded">
                            <i class="fas fa-graduation-cap w-6"></i>
                            <span>Cours</span>
                        </a>
                    </li>
                    <li>
                        <a href="./dashboard_category.php" class="w-full flex items-center p-2 hover:bg-indigo-700 rounded">
                            <i class="fas fa-tags w-6"></i>
                            <span>Catégories</span>
                        </a>
                    </li>
                    <li>
                        <a href="./dashboard_tags.php" class="w-full flex items-center p-2 hover:bg-indigo-700 rounded">
                            <i class="fas fa-tags w-6"></i>
                            <span> Tags</span>
                        </a>
                    </li>
                </ul>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto">
            <!-- Header -->
            <header class="bg-white shadow-md p-4">
                <div class="flex items-center justify-between">
                    <h2 id="sectionTitle" class="text-xl font-semibold">Tableau de bord</h2>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">Admin</span>

                        <form action="" method="POST">
                            <button name="dec" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-sign-out-alt"></i>
                                Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Content Sections -->
            <div class="p-6">
                <!-- Dashboard Section -->
                <section id="dashboard" class="space-y-6">
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500">Total Utilisateurs</p>
                                    <h3 class="text-3xl font-bold" id="totalUsers">0</h3>
                                </div>
                                <div class="bg-blue-100 p-3 rounded-full">
                                    <i class="fas fa-users text-blue-600"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500">Total Cours</p>
                                    <h3 class="text-3xl font-bold" id="totalCourses">0</h3>
                                </div>
                                <div class="bg-green-100 p-3 rounded-full">
                                    <i class="fas fa-graduation-cap text-green-600"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500">Enseignants</p>
                                    <h3 class="text-3xl font-bold" id="totalTeachers">0</h3>
                                </div>
                                <div class="bg-purple-100 p-3 rounded-full">
                                    <i class="fas fa-chalkboard-teacher text-purple-600"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500">Étudiants</p>
                                    <h3 class="text-3xl font-bold" id="totalStudents">0</h3>
                                </div>
                                <div class="bg-yellow-100 p-3 rounded-full">
                                    <i class="fas fa-user-graduate text-yellow-600"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Top Teachers Table -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h4 class="text-lg font-semibold mb-4">Top 3 Enseignants</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Enseignant</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cours</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Étudiants</th>
                                    </tr>
                                </thead>
                                <tbody id="topTeachersTable" class="divide-y divide-gray-200">
                                <tr>
            <td class="px-6 py-4 whitespace-nowrap">${teacher.name}</td>
            <td class="px-6 py-4 whitespace-nowrap">${teacher.courses}</td>
            <td class="px-6 py-4 whitespace-nowrap">${teacher.students}</td>
        </tr>                                
    </tbody>
                            </table>
                        </div>
                    </div>
                </section>

              
                <!-- Courses Section -->
                <section id="courses" class=" space-y-6">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-lg font-semibold">Gestion des Cours</h4>
                            <div class="flex space-x-2">
                                <input type="text" 
                                       id="courseSearch" 
                                       placeholder="Rechercher..." 
                                       class="px-4 py-2 border rounded-lg">
                                <select id="courseFilter" class="px-4 py-2 border rounded-lg">
                                    <option value="all">Toutes catégories</option>
                                </select>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Titre</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Enseignant</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catégorie</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Étudiants</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="coursesTable" class="divide-y divide-gray-200">
                                <tr>
            <td class="px-6 py-4 whitespace-nowrap">${course.title}</td>
            <td class="px-6 py-4 whitespace-nowrap">${course.teacher}</td>
            <td class="px-6 py-4 whitespace-nowrap">${course.category}</td>
            <td class="px-6 py-4 whitespace-nowrap">${course.students}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button onclick="editCourse({course})" class="text-indigo-600 hover:text-indigo-900 mr-2">
                    <i class="fas fa-edit"></i>
                </button>
                <button onclick="deleteCourse({course})" class="text-red-600 hover:text-red-900">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

              

    </script>
</body>
</html>