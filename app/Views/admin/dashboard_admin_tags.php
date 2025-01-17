<?php
require_once __DIR__ . '../../../Models/Tags.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['addTag'])) {
        $tagName = htmlspecialchars($_POST['tag_name']);
        $tagDescription = htmlspecialchars($_POST['tag_description']);
        $Tag = new Tags($tagName, $tagDescription, null,null);
        $Tag->addTag();
        header('Location: ' . $_SERVER['PHP_SELF']);

    }

    if (isset($_POST['deletetag'])) {
        $tagId = htmlspecialchars($_GET['id']);
        $Tag = new Tags("", "", null,null);
        $Tag->deleteTag($tagId);
        header('Location: ' . $_SERVER['PHP_SELF']);
    }

    if (isset($_POST['updatetag'])) {
        $tagId = htmlspecialchars($_GET['id']);
        $tag = new Tags("", "", "", "");
        $res = $tag->getTagById($tagId);

    }

    if (isset($_POST['modifyTag'])) {
        $tagId = htmlspecialchars($_GET['id']);
        $tagName = htmlspecialchars($_POST['update_tag_name']);
        $tagDescription = htmlspecialchars($_POST['update_tag_description']);
        
        $Tag = new Tags($tagName, $tagDescription, null, null);
        $Tag->setId($tagId);
        $Tag->updateTag();

        header('Location: ' . $_SERVER['PHP_SELF']);
    }
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




                <!-- Categories Section -->
                <section id="tags" class="space-y-6">
    <!-- Gestion des tags -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h4 class="text-lg font-semibold">Gestion des Tags</h4>
            <button onclick="showAddTagModal()" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                Ajouter un tag
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4" id="tagsList">
            <?php
            $Tag = new Tags("", "", "");
            $rows = $Tag->showTags();
            foreach ($rows as $row) {
                echo ' <div class="bg-white p-4 rounded-lg shadow border">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h5 class="font-semibold">' . $row['tag_name'] . '</h5>
                                    <p class="text-sm text-gray-500">' . $row['tag_description'] . '</p>
                                    <p class="text-sm text-gray-500">' . $row['creation_date'] . '</p>
                                </div>
                                <div class="space-x-2">
                                    <form method="POST" action="?id=' . htmlspecialchars($row['tag_id']) . '">
                                        <button id="modifyTag" onclick="showAddTagModal()" class="text-indigo-600 hover:text-indigo-900" name="updatetag">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900" name="deletetag">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>';
            }
            ?>
        </div>
    </div>

    <!-- Formulaire d'ajout de tags -->
  
</section>

<!-- Modal Ajout Tag -->
<div id="tagModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white rounded-lg p-8 max-w-md w-full">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold">Ajouter un tag</h3>
            <button onclick="closeTagModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="tagForm" method="POST" class="space-y-4">
            <div>
                <label for="tagName" class="block text-sm font-medium text-gray-700">Nom du tag</label>
                <input type="text"
                    id="tagName"
                    required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" name="tag_name">
            </div>
            <div id="error-message-name" class="text-red-600 text-sm mt-2"></div>

            <div>
                <label for="tagDescription" class="block text-sm font-medium text-gray-700">Description du tag</label>
                <textarea id="tagDescription"
                    rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" name="tag_description"></textarea>
            </div>
            <div id="error-message-desc" class="text-red-600 text-sm mt-2"></div>

            <div class="flex justify-end space-x-3">
                <button onclick="closeTagModal()" class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-50">
                    Annuler
                </button>
                <button class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700" name="addTag">
                    Ajouter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Modification Tag -->
<div id="modifyTag" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center  justify-center <?php echo $formClass; ?>">
    <div class="bg-white rounded-lg p-8 max-w-md w-full">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold">Modifier un tag</h3>
            <button onclick="closeTagModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <?php echo '<form method="POST" action="?id=' . htmlspecialchars($res['tag_id']) . '">
            <div>
                <label for="tagName" class="block text-sm font-medium text-gray-700">Nom du tag</label>
                <input type="text"
                    value="' . $res["tag_name"] . '"
                    id="tagName"
                    required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" name="update_tag_name">
            </div>
            <div id="error-message-name" class="text-red-600 text-sm mt-2"></div>

            <div>
                <label for="tagDescription" class="block text-sm font-medium text-gray-700">Description du tag</label>
                <textarea id="tagDescription"
                    rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" name="update_tag_description">' . $res["tag_description"] . '</textarea>
            </div>
            <div id="error-message-desc" class="text-red-600 text-sm mt-2"></div>

            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeTagModal()" class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-50">
                    Annuler
                </button>
                <button class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700" name="modifyTag">
                    Modifier
                </button>
            </div>
        </form>'; ?>
    </div>
</div>

<script>
    function closeTagModal() {
        document.getElementById('tagModal').classList.remove('flex');
        document.getElementById('tagModal').classList.add('hidden');
        document.getElementById('tagForm').reset();
    }

    function showAddTagModal() {
        document.getElementById('tagModal').classList.remove('hidden');
        document.getElementById('tagModal').classList.add('flex');
        document.getElementById('modifyTag').classList.remove('flex');
        document.getElementById('modifyTag').classList.add('hidden');
    }
</script>
<script src="../../../public/assets/js/tags.js"></script>

</body>
</html>
