<?php
// session_start();
// if (isset($_SESSION['user_role'])) {
//     switch ($_SESSION['user_role']) {
//         case 'admin':
//             header('Location: ../admin/dashboard_tags.php');
//             break;
       
//         default:
//             header('Location: ../user/login.php');
//             break;
//     }
//     exit;
// } else {
//     header('Location: ../visiteur/visiteur.php');
//     exit;
// }
require_once __DIR__ . '../../../Models/Category.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['addCategory'])) {
        $titre = htmlspecialchars($_POST['titre']);
        $description = htmlspecialchars($_POST['description']);
        $upload_img = $_FILES['category_image'];

        $Category = new Category(null,$titre, $description, null, null,$upload_img);

        $Category->addCategory();
        header('Location: ' . $_SERVER['PHP_SELF']);

    }
    if (isset($_POST['delete'])) {
        $categoryId = htmlspecialchars($_GET['id']);
        echo $_GET['id'];
        $Category = new Category("","", "", "", "","");

        $Category->deleteCategory($categoryId);
        header('Location: ' . $_SERVER['PHP_SELF']);
    }
    if (isset($_POST['update'])) {
        $categoryId = htmlspecialchars($_GET['id']);
        $Category = new Category("","", "", "", "","");

        $resu=$Category->getCategoryById($categoryId);

    }
    if (isset($_POST['modifyCat'])) {
        $titre = htmlspecialchars($_POST['updateTitle']);
        $description = htmlspecialchars($_POST['updateDescription']);
        $categoryId = htmlspecialchars($_GET['id']);

        $upload_cvr = $_FILES['update_image'];

        echo $description;
        $Category = new Category(null,$titre, $description, null, null,$upload_cvr);

        $Category->setCategoryId($categoryId);
        
        $Category->updateCategory( );
        header('Location: ' . $_SERVER['PHP_SELF']);

    }

    }

    if (isset($_POST['dec'])) {
        session_unset();
    
        session_destroy();
    
        header('Location: ../user/login.php');
        exit();
    }


$formClass = '';

if ($_SERVER['REQUEST_METHOD']!=='POST' || isset($_POST['delete'])) {
    $formClass = 'hidden';  
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
                        <a href="./dashboard_admin_category.php" class="w-full flex items-center p-2 hover:bg-indigo-700 rounded">
                            <i class="fas fa-tags w-6"></i>
                            <span>Catégories</span>
                        </a>
                    </li>
                    <li>
                        <a href="./dashboard_admin_tags.php" class="w-full flex items-center p-2 hover:bg-indigo-700 rounded">
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
                            <?php
                            $Category = new Category("","", "", "", "", "");
                            $rows = $Category->showCategory();
                            foreach ($rows as $row) {
                                echo ' <div class="bg-white p-4 rounded-lg shadow border">
                                             <div class="flex justify-between items-center">
                                     <div>
                                     <h5 class="font-semibold">' . $row['category_title'] . '</h5>
                                     <p class="text-sm text-gray-500">' . $row['category_description'] . '</p>
                                    <p class="text-sm text-gray-500">' . $row['creation_date'] . '</p>

                                 </div>
                                 <div class="space-x-2">
                                 <form method="POST" action="?id=' . htmlspecialchars($row['category_id']) . '">
                                  <button id="modifyCategory" onclick="showAddCategoryModal()" class="text-indigo-600 hover:text-indigo-900" name="update">
                                         <i class="fas fa-edit"></i>
                                     </button>
                                     <button  class="text-red-600 hover:text-red-900" name="delete">
                                         <i class="fas fa-trash"></i>
                                     </button>
                                 </form>
                                 
                                    
                                 </div>
                                             </div>
                                                    </div>   ';
                            }

                            ?>
                        </div>
                    </div>
                    <div class=" bg-white rounded-xl shadow-sm p-6 mb-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Gestion des tags</h3>
                        <form id=" tagForm" class="max-w-2xl">
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
        <form id="categoryForm" method="POST" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label for="categoryName" class="block text-sm font-medium text-gray-700">Nom de la catégorie</label>
                <input type="text"
                    id="categoryName"
                    required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" name="titre">
            </div>
            <div id="error-message-name" class="text-red-600 text-sm mt-2"></div>

            <div>
                <label for="categoryDescription" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="categoryDescription"
                    rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" name="description"></textarea>
            </div>
            <div id="error-message-desc" class="text-red-600 text-sm mt-2"></div>

            <div>
                <label for="categoryImage" class="block text-sm font-medium text-gray-700">Image de la catégorie</label>
                <input type="file"
                    id="categoryImage"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" name="category_image" accept="image/*">
            </div>
            <div id="error-message-image" class="text-red-600 text-sm mt-2"></div>

            <div class="flex justify-end space-x-3">
                <button
                    onclick="closeCategoryModal()"
                    class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-50">
                    Annuler
                </button>
                <button
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700" name="addCategory">
                    Ajouter
                </button>
            </div>
        </form>
    </div>
</div>


<div id="modifyCategory2" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center <?php echo $formClass; ?> ">
    <div class="bg-white rounded-lg p-8 max-w-md w-full">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold">Modifier une catégorie</h3>
            <button onclick="closeCategoryModall()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <?php echo '
        <form method="POST" enctype="multipart/form-data" action="?id=' . htmlspecialchars($resu['category_id']) . '">
            <div>
                <label for="categoryName" class="block text-sm font-medium text-gray-700">Nom de la catégorie</label>
                <input type="text"
                    value="' . $resu["category_title"] . '"
                    id="categoryName"
                    required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" name="updateTitle">
            </div>
            <div id="error-message-name" class="text-red-600 text-sm mt-2"></div>

            <div>
                <label for="categoryDescription" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="categoryDescription"
                    rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" name="updateDescription">' . $resu["category_description"] . '</textarea>
            </div>
            <div id="error-message-desc" class="text-red-600 text-sm mt-2"></div>

            <div>
                <label for="categoryImage" class="block text-sm font-medium text-gray-700">Image de la catégorie</label>
                <input type="file"
                    id="categoryImage"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" name="update_image">
                <div class="text-sm text-gray-500 mt-2">Formats autorisés : jpg, jpeg, png, gif.</div>
            </div>

            <div class="flex justify-end space-x-3">
                <button
                    type="button"
                    onclick="closeCategoryModall()"
                    class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-50">
                    Annuler
                </button>
                <button
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700" name="modifyCat">
                    Modifier
                </button>
            </div>
        </form>';
        ?>
    </div>
</div>



    </div>

    <script>
        function closeCategoryModal() {
            document.getElementById('categoryModal').classList.remove('flex');
            document.getElementById('categoryModal').classList.add('hidden');
            document.getElementById('categoryForm').reset();
        }

        function closeCategoryModall() {
            document.getElementById('modifyCategory2').classList.remove('flex');
            document.getElementById('modifyCategory2').classList.add('hidden');
            document.getElementById('categoryForm2').reset();
        }

        function showAddCategoryModal() {
            document.getElementById('categoryModal').classList.remove('hidden');
            document.getElementById('categoryModal').classList.add('flex');
            document.getElementById('modifyCategory2').classList.remove('flex');
            document.getElementById('modifyCategory2').classList.add('hidden');
        }
    </script>
    <!-- <script src="../../../public/assets/js/category.js"></script> -->

</body>

</html>