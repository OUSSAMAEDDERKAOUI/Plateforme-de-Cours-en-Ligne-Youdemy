<?php
// session_start();
// echo $_SESSION['user_role'];
require_once __DIR__ . '../../../Models/Category.php';
$categories = Category::showVisiteurCategory();
print_r($categories);

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Catalogue des cours</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <a href="index.html" class="text-2xl font-bold text-indigo-600">Youdemy</a>
                <div class="flex items-center space-x-4">
                    <a href="/app/views/user/signup.php" id="openRegisterModal" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Créer un compte
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <main class="mt-16 p-8">
        <!-- Barre de recherche -->
        <div class="max-w-4xl mx-auto mb-8">
            <div class="flex gap-4">
                <input type="text" id="searchInput"
                    class="w-full p-3 rounded-lg border focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400"
                    placeholder="Rechercher un cours...">
                <button id="searchButton"
                    class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    Rechercher
                </button>
            </div>
            <!-- Filtres -->
            <div class="flex flex-wrap gap-4 mt-4">
                <select id="categoryFilter" class="p-2 rounded-lg border">
                    <option value="">Toutes les catégories</option>
                    <option value="web">Développement Web</option>
                    <option value="mobile">Développement Mobile</option>
                    <option value="design">Design</option>
                    <option value="marketing">Marketing</option>
                </select>
                <select id="priceFilter" class="p-2 rounded-lg border">
                    <option value="">Tous les prix</option>
                    <option value="free">Gratuit</option>
                    <option value="paid">Payant</option>
                </select>
            </div>
        </div>
     
        <!-- Liste des cours -->
        <div class="max-w-7xl mx-auto">
            <div id="coursesList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php  foreach($categories AS $category) : ?>
<?php $image=$category->getCategoryConverture() ;?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <img src="/<?php echo htmlspecialchars($category->getCategoryConverture()) ;?>" alt="photo de converture" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl text-indigo-600 mb-2"><?php echo htmlspecialchars($category->getCategoryTitle()) ;?></h3>
                        <p class="text-gray-600 mb-4">crée le <?php echo htmlspecialchars($category->getCreationDate()) ;?></p>
                        <p class="text-gray-500 text-sm mb-4"><?php echo htmlspecialchars($category->getCategoryDescription()) ;?></p>
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-indigo-600">Gratuit</span>
                            <button onclick=""
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                Détails
                            </button>
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

    <!-- <script src="/public/assets/js/visitor.js"></script> -->
</body>

</html>