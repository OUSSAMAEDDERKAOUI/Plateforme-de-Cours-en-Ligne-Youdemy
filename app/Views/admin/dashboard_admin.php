<?php
session_start();
if (isset($_SESSION['user_role'])) {
    switch ($_SESSION['user_role']) {
        case 'admin':
            header('Location: ../admin/dashboard_tags.php');
            break;
       
        default:
            header('Location: ../user/login.php');
            break;
    }
    exit;
} else {
    header('Location: ../visiteur/visiteur.php');
    exit;
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
                    <li>
                        <a href="./dashboard_admin.php" class="w-full flex items-center p-2 hover:bg-indigo-700 rounded">
                            <i class="fas fa-chart-line w-6"></i>
                            <span>Tableau de bord</span>
                        </a>
                    </li>
                    <li>
                        <a href="./dashboard_admin_users.php" class="w-full flex items-center p-2 hover:bg-indigo-700 rounded">
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
                        <a href="./dashboard_admin_category_tags.php" class="w-full flex items-center p-2 hover:bg-indigo-700 rounded">
                            <i class="fas fa-tags w-6"></i>
                            <span>Catégories & Tags</span>
                        </a>
                    </li>
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
                        <button onclick="logout()" class="text-red-600 hover:text-red-800">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
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

                <!-- Users Section -->
                <section id="users" class=" space-y-6">
                   

                    <!-- Carte enseignant 3 -->
                    <div class="bg-gray-50 rounded-xl p-6 hover:bg-gray-100 transition duration-300">
                        <div class="bg-white rounded-xl p-8">
                            <div class="flex justify-between items-center mb-8">
                                <div>
                                    <h2 class="text-2xl font-semibold text-gray-800">Validation des comptes</h2>
                                    <p class="text-gray-500 mt-1">Gérez les demandes d'enseignants</p>
                                </div>
                                <span class="px-4 py-2 bg-blue-50 text-blue-600 rounded-lg font-medium">
                                    5 demandes en attente
                                </span>
                            </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <img src="https://ui-avatars.com/api/?name=Ahmed+Hassan&background=random" 
                                     alt="Ahmed Hassan" 
                                     class="w-12 h-12 rounded-full ring-2 ring-white">
                                <div>
                                    <h3 class="font-medium text-gray-900">Ahmed Hassan</h3>
                                    <p class="text-gray-500 text-sm">ahmed.hassan@example.com</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <button class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors duration-200">
                                    Approuver
                                </button>
                                <button class="px-4 py-2 bg-white text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                                    Rejeter
                                </button>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                                    Intelligence Artificielle
                                </span>
                                <span class="text-gray-500 text-sm">
                                    4 ans d'expérience
                                </span>
                            </div>
                            <span class="text-gray-400 text-sm">
                                Soumis le 14/01/2025
                            </span>
                        </div>
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

                <!-- Categories Section -->
                <section id="categories" class=" space-y-6">
                    
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-lg font-semibold">Gestion des Catégories</h4>
                            <button onclick="showAddCategoryModal()" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                                Ajouter une catégorie
                            </button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4" id="categoriesList">
                        <div class="bg-white p-4 rounded-lg shadow border">
            <div class="flex justify-between items-center">
                <div>
                    <h5 class="font-semibold">${category.name}</h5>
                    <p class="text-sm text-gray-500">${category.coursesCount} cours</p>
                </div>
                <div class="space-x-2">
                    <button onclick="editCategory(${category.id})" class="text-indigo-600 hover:text-indigo-900">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button onclick="deleteCategory(${category.id})" class="text-red-600 hover:text-red-900">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Gestion des tags</h3>
                        <form id="tagForm" class="max-w-2xl">
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">Ajouter des tags (séparés par des virgules)</label>
                                <input type="text" id="tagInput" 
                                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                                       placeholder="javascript, web, frontend">
                            </div>
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Ajouter les tags
                            </button>
                        </form>
                    </div>
                </section>
            </div>
        </main>
    </div>
<!-- Modal Ajout Catégorie -->
<div id="categoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white rounded-lg p-8 max-w-md w-full">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold">Ajouter une catégorie</h3>
            <button onclick="closeCategoryModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="categoryForm" onsubmit="submitCategory(event)" class="space-y-4">
            <div>
                <label for="categoryName" class="block text-sm font-medium text-gray-700">Nom de la catégorie</label>
                <input type="text" 
                       id="categoryName" 
                       required 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="categoryDescription" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="categoryDescription" 
                          rows="3" 
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" 
                        onclick="closeCategoryModal()" 
                        class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-50">
                    Annuler
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    Ajouter
                </button>
            </div>
        </form>
    </div>
</div>


</div>
    <!-- <script >
      // Données de démonstration
const mockData = {
    users: [
        { id: 1, name: 'John Doe', email: 'john@example.com', role: 'teacher', status: 'active' },
        { id: 2, name: 'Jane Smith', email: 'jane@example.com', role: 'student', status: 'active' },
        // Ajoutez plus d'utilisateurs ici
    ],
    courses: [
        { id: 1, title: 'JavaScript Avancé', teacher: 'John Doe', category: 'Programmation', students: 45 },
        { id: 2, title: 'Design UX/UI', teacher: 'Sarah Johnson', category: 'Design', students: 32 },
        // Ajoutez plus de cours ici
    ],
    categories: [
        { id: 1, name: 'Programmation', coursesCount: 15 },
        { id: 2, name: 'Design', coursesCount: 8 },
        { id: 3, name: 'Marketing', coursesCount: 12 },
        // Ajoutez plus de catégories ici
    ],
    stats: {
        totalUsers: 150,
        totalCourses: 45,
        totalTeachers: 12,
        totalStudents: 138,
        topTeachers: [
            { name: 'John Doe', courses: 8, students: 245 },
            { name: 'Sarah Johnson', courses: 6, students: 180 },
            { name: 'Mike Wilson', courses: 5, students: 156 }
        ]
    }
};

// Gestion de la navigation
function showSection(sectionId) {
    // Mise à jour du titre
    document.getElementById('sectionTitle').textContent = {
        'dashboard': 'Tableau de bord',
        'users': 'Gestion des utilisateurs',
        'courses': 'Gestion des cours',
        'categories': 'Gestion des catégories'
    }[sectionId];

    // Cacher toutes les sections
    document.querySelectorAll('main section').forEach(section => {
        section.classList.add('hidden');
    });

    // Afficher la section sélectionnée
    document.getElementById(sectionId).classList.remove('hidden');

    // Charger les données appropriées
    switch(sectionId) {
        case 'dashboard':
            loadDashboardData();
            break;
        case 'users':
            loadUsersData();
            break;
        case 'courses':
            loadCoursesData();
            break;
        case 'categories':
            loadCategoriesData();
            break;
    }
}

// Chargement des données du tableau de bord
function loadDashboardData() {
    // Mise à jour des statistiques
    document.getElementById('totalUsers').textContent = mockData.stats.totalUsers;
    document.getElementById('totalCourses').textContent = mockData.stats.totalCourses;
    document.getElementById('totalTeachers').textContent = mockData.stats.totalTeachers;
    document.getElementById('totalStudents').textContent = mockData.stats.totalStudents;

    // Mise à jour du tableau des top enseignants
    const topTeachersHTML = mockData.stats.topTeachers.map(teacher => `
        <tr>
            <td class="px-6 py-4 whitespace-nowrap">${teacher.name}</td>
            <td class="px-6 py-4 whitespace-nowrap">${teacher.courses}</td>
            <td class="px-6 py-4 whitespace-nowrap">${teacher.students}</td>
        </tr>
    `).join('');
    document.getElementById('topTeachersTable').innerHTML = topTeachersHTML;
}

// Chargement des données utilisateurs
function loadUsersData() {
    const usersHTML = mockData.users.map(user => `
        <tr>
            <td class="px-6 py-4 whitespace-nowrap">${user.name}</td>
            <td class="px-6 py-4 whitespace-nowrap">${user.email}</td>
            <td class="px-6 py-4 whitespace-nowrap">${user.role}</td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                    ${user.status}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button onclick="editUser(${user.id})" class="text-indigo-600 hover:text-indigo-900 mr-2">
                    <i class="fas fa-edit"></i>
                </button>
                <button onclick="deleteUser(${user.id})" class="text-red-600 hover:text-red-900">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    `).join('');
    document.getElementById('usersTable').innerHTML = usersHTML;
}

// Chargement des données des cours
function loadCoursesData() {
    const coursesHTML = mockData.courses.map(course => `
        <tr>
            <td class="px-6 py-4 whitespace-nowrap">${course.title}</td>
            <td class="px-6 py-4 whitespace-nowrap">${course.teacher}</td>
            <td class="px-6 py-4 whitespace-nowrap">${course.category}</td>
            <td class="px-6 py-4 whitespace-nowrap">${course.students}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button onclick="editCourse(${course.id})" class="text-indigo-600 hover:text-indigo-900 mr-2">
                    <i class="fas fa-edit"></i>
                </button>
                <button onclick="deleteCourse(${course.id})" class="text-red-600 hover:text-red-900">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    `).join('');
    document.getElementById('coursesTable').innerHTML = coursesHTML;
}

// Chargement des données des catégories
function loadCategoriesData() {
    const categoriesHTML = mockData.categories.map(category => `
        <div class="bg-white p-4 rounded-lg shadow border">
            <div class="flex justify-between items-center">
                <div>
                    <h5 class="font-semibold">${category.name}</h5>
                    <p class="text-sm text-gray-500">${category.coursesCount} cours</p>
                </div>
                <div class="space-x-2">
                    <button onclick="editCategory(${category.id})" class="text-indigo-600 hover:text-indigo-900">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button onclick="deleteCategory(${category.id})" class="text-red-600 hover:text-red-900">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `).join('');
    document.getElementById('categoriesList').innerHTML = categoriesHTML;
}

// Fonctions d'action (à implémenter)
function editUser(id) {
    console.log('Éditer utilisateur:', id);
}

function deleteUser(id) {
    if(confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
        console.log('Supprimer utilisateur:', id);
    }
}

function editCourse(id) {
    console.log('Éditer cours:', id);
}

function deleteCourse(id) {
    if(confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')) {
        console.log('Supprimer cours:', id);
    }
}

function editCategory(id) {
    console.log('Éditer catégorie:', id);
}

function deleteCategory(id) {
    if(confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')) {
        console.log('Supprimer catégorie:', id);
    }
}

function showAddCategoryModal() {
    console.log('Afficher modal d\'ajout de catégorie');
}

function logout() {
    if(confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) {
        window.location.href = 'login.html';
    }
}

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    // Afficher le tableau de bord par défaut
    showSection('dashboard');

    // Gestionnaires d'événements pour la recherche
    document.getElementById('userSearch').addEventListener('input', function(e) {
        console.log('Recherche utilisateurs:', e.target.value);
        // Implémenter la logique de recherche
    });

    document.getElementById('courseSearch').addEventListener('input', function(e) {
        console.log('Recherche cours:', e.target.value);
        // Implémenter la logique de recherche
    });

    // Gestionnaires d'événements pour les filtres
    document.getElementById('userFilter').addEventListener('change', function(e) {
        console.log('Filtre utilisateurs:', e.target.value);
        // Implémenter la logique de filtrage
    });

    document.getElementById('courseFilter').addEventListener('change', function(e) {
        console.log('Filtre cours:', e.target.value);
        // Implémenter la logique de filtrage
    });
});
// Ajouter ces fonctions à votre fichier admin.js existant

// Gestion du modal catégorie
function showAddCategoryModal() {
    document.getElementById('categoryModal').classList.remove('hidden');
    document.getElementById('categoryModal').classList.add('flex');
}

function closeCategoryModal() {
    document.getElementById('categoryModal').classList.remove('flex');
    document.getElementById('categoryModal').classList.add('hidden');
    document.getElementById('categoryForm').reset();
}

function submitCategory(event) {
    event.preventDefault();
    const name = document.getElementById('categoryName').value;
    const description = document.getElementById('categoryDescription').value;

    // Simuler l'ajout d'une catégorie
    console.log('Nouvelle catégorie:', { name, description });
    
    // Ajouter la catégorie aux données mockées
    mockData.categories.push({
        id: mockData.categories.length + 1,
        name: name,
        coursesCount: 0
    });

    // Recharger la liste des catégories
    loadCategoriesData();
    
    // Fermer le modal
    closeCategoryModal();
}

// Gestion du modal tags
function showTagModal() {
    document.getElementById('tagModal').classList.remove('hidden');
    document.getElementById('tagModal').classList.add('flex');
    loadExistingTags();
}

function closeTagModal() {
    document.getElementById('tagModal').classList.remove('flex');
    document.getElementById('tagModal').classList.add('hidden');
    document.getElementById('tagsList').value = '';
}

function submitBulkTags() {
    const tagsInput = document.getElementById('tagsList').value;
    const tags = tagsInput.split(',').map(tag => tag.trim()).filter(tag => tag);

    // Simuler l'ajout des tags
    console.log('Nouveaux tags:', tags);
    
    // Actualiser l'affichage des tags
    loadExistingTags();
    
    // Vider le champ
    document.getElementById('tagsList').value = '';
}

function loadExistingTags() {
    // Simuler des tags existants
    const mockTags = ['JavaScript', 'HTML', 'CSS', 'React', 'Node.js', 'Python'];
    
    const tagsHTML = mockTags.map(tag => `
        <div class="bg-gray-100 px-3 py-1 rounded-full flex items-center">
            <span class="text-sm">${tag}</span>
            <button onclick="deleteTag('${tag}')" class="ml-2 text-gray-500 hover:text-red-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `).join('');
    
    document.getElementById('existingTags').innerHTML = tagsHTML;
}

function deleteTag(tag) {
    if(confirm(`Êtes-vous sûr de vouloir supprimer le tag "${tag}" ?`)) {
        console.log('Supprimer tag:', tag);
        // Implémenter la suppression réelle du tag
        loadExistingTags();
    }
}
 -->

    </script>
</body>
</html>