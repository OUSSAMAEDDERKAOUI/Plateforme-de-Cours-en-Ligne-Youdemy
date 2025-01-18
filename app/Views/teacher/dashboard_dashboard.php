<?php
require_once __DIR__ . '../../../Models/Course.php';
require_once __DIR__ . '../../../../config/database.php';

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addCourse'])) {

        $title = htmlspecialchars($_POST['title']);
        $description = htmlspecialchars($_POST['description']);
        $categoryId = htmlspecialchars($_POST['category']);
        $contenuUrl = htmlspecialchars($_POST['ContenuUrl']);
        $courseTags = isset($_POST['courseTags']) ? $_POST['courseTags'] : [];
        $teacherId = 1;
        echo $teacherId;

        $upload_img = $_FILES['course_image'];


        $course = new Course($title, $contenuUrl, $teacherId, null, null, $upload_img, $description, $categoryId);

        $course->addCourse();


        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }


    if (isset($_POST['deletecourse'])) {
        $courseId = htmlspecialchars($_GET['id']);
        echo $_GET['id'];

        course::deletecourse($courseId);
        // header('Location: ' . $_SERVER['PHP_SELF']);
    }


    if (isset($_POST['modifyCourse'])) {
        $courseId = $_POST['courseId']; // Récupérer l'ID du cours à modifier
        $title = htmlspecialchars($_POST['title']);
        $description = htmlspecialchars($_POST['description']);
        $categoryId = htmlspecialchars($_POST['category']);
        $contenuUrl = htmlspecialchars($_POST['ContenuUrl']);
        $courseTags = isset($_POST['courseTags']) ? $_POST['courseTags'] : [];

        // Traitement de l'image
        $courseImage = null;
        if (isset($_FILES['course_image']) && $_FILES['course_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'path/to/upload/directory/';
            $fileName = basename($_FILES['course_image']['name']);
            $uploadFilePath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['course_image']['tmp_name'], $uploadFilePath)) {
                $courseImage = $uploadFilePath;
            }
        }

        // Mettre à jour le cours dans la base de données
        $course = new Course($title, $description, $categoryId, $contenuUrl, $courseImage);
        $course->setCourseId($courseId); // Assurez-vous de définir l'ID du cours à modifier
        $course->updateCourse();

        // Mettre à jour les tags associés au cours
        if (!empty($courseTags)) {
            $course->updateCourseTags($courseTags);
        }

        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}
function getCategoryName($categoryId)
{
    // Connexion à la base de données

}

$courses = Course::showCourses();


?>






<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Dashboard Enseignant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-indigo-800 text-white p-6">
            <div class="mb-8">
                <h1 class="text-2xl font-bold">Youdemy</h1>
                <p class="text-sm text-indigo-200">Dashboard Enseignant</p>
            </div>
            <nav>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-700 mb-1 bg-indigo-900">
                    Tableau de bord
                </a>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-700 mb-1">
                    Mes cours
                </a>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-700 mb-1">
                    Ajouter un cours
                </a>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-700">
                    Statistiques
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <header class="flex justify-between items-center mb-8">
                    <h2 class="text-2xl font-bold">Dashboard Enseignant</h2>
                    <button onclick="openNewCourse()" id="openNewCourse" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        + Nouveau cours
                    </button>
                </header>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold mb-2">Total Étudiants</h3>
                        <p class="text-3xl font-bold text-indigo-600">245</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold mb-2">Cours Actifs</h3>
                        <p class="text-3xl font-bold text-green-600">12</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold mb-2">Revenus du mois</h3>
                        <p class="text-3xl font-bold text-yellow-600">2,450€</p>
                    </div>
                </div>

                <!-- Charts -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-xl font-semibold mb-4">Inscriptions par cours</h3>
                        <canvas id="courseEnrollmentsChart"></canvas>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-xl font-semibold mb-4">Progression mensuelle</h3>
                        <canvas id="monthlyProgressChart"></canvas>
                    </div>
                </div>

                <!-- Course List -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-4">Mes cours</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Titre
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Categorie
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Description
                                        </th>

                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Statut
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="coursesList" class="bg-white divide-y divide-gray-200">
                                    <?php foreach ($courses as $course) : ?>
                                        <?php $categoryTitle = Course::getCategoryTitleById($course->getCategoryId()); ?>
                                        <!-- $teacherName = Course::getTeacherNameById($course->getTeacherId()); // Récupérer le nom de l'enseignant -->

                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($course->getCourseTitle()); ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900"><?php echo " $categoryTitle " ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500"><?php echo htmlspecialchars($course->getCoursesDescription()); ?></div>
                                            </td>


                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    <?php echo ($course->getCourseStatus() === 'accepté') ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                                                    <?php echo htmlspecialchars($course->getCourseStatus()); ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <?php echo '<form method="POST" action="?id='.htmlspecialchars($course->getTeacherId()).' ">';?>
                                                    <button id="modifycourse" onclick="" class="text-indigo-600 hover:text-indigo-900 mr-6" name="modifycourse">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="text-red-600 hover:text-red-900" name="deletecourse">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Nouveau Cours -->
    <div id="newCourseModal" class=" fixed hidden inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8 max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <h2 class="text-2xl font-bold mb-6">Ajouter un nouveau cours</h2>
            <form id="newCourseForm" class="space-y-4" method="POST" enctype="multipart/form-data">

                <div>
                    <label class="block text-sm font-medium text-gray-700">Titre du cours</label>
                    <input type="text" name="title" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Catégorie</label>
                    <?php
                    require_once '../../Models/Category.php';
                    $categories = new Category("", "", "", "", "");
                    $rows = $categories->showCategory();
                    echo '<select name="category" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">';
                    foreach ($rows as $row) {
                        echo '<option value="' . $row['category_id'] . '">' . $row['category_title'] . '</option>';
                    }
                    echo '</select>';
                    ?>
                </div>

                <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                <?php
                require_once '../../Models/Tags.php';
                $tags = new Tags("", "", "", "");
                $results = $tags->showTags();
                echo '<div class="flex flex-wrap">';
                foreach ($results as $result) {
                    echo '<div class="w-1/4 p-2">';
                    echo '<input type="checkbox" name="courseTags[]" value="' . $result['tag_id'] . '" id="tag_' . $result['tag_id'] . '">';
                    echo '<label for="tag_' . $result['tag_id'] . '">' . $result['tag_name'] . '</label>';
                    echo '</div>';
                }
                echo '</div>';
                ?>



                <div>
                    <label class="block text-sm font-medium text-gray-700">Contenu (URL)</label>
                    <input type="url" name="ContenuUrl" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>

                <!-- Image du cours (Couverture) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Image de couverture</label>
                    <input type="file" name="course_image" accept="image/*" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>

                <!-- Boutons -->
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeNewCourseModal()" class="px-4 py-2 border rounded-md hover:bg-gray-100">
                        Annuler
                    </button>
                    <button type="submit" name="addCourse" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Créer le cours
                    </button>
                </div>
            </form>
        </div>
    </div>




    <div id="modifyCourseModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8 max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <h2 class="text-2xl font-bold mb-6">Modifier un cours</h2>
            <form id="modifyCourseForm" class="space-y-4" method="POST" enctype="multipart/form-data">
                <!-- Champ caché pour l'ID du cours à modifier -->
                <input type="hidden" name="courseId" value="<?php echo $courseId; ?>">

                <!-- Titre du cours -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Titre du cours</label>
                    <input type="text" name="title" value="<?php echo htmlspecialchars($courseData['course_title']); ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>

                <!-- Description du cours -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border"><?php echo htmlspecialchars($courseData['course_content']); ?></textarea>
                </div>

                <!-- Catégorie -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Catégorie</label>
                    <?php
                    require_once '../../Models/Category.php';
                    $categories = new Category("", "", "", "", "");
                    $rows = $categories->showCategory();
                    echo '<select name="category" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">';
                    foreach ($rows as $row) {
                        // Vérifier si la catégorie actuelle est sélectionnée
                        $selected = ($courseData['category_id'] == $row['category_id']) ? 'selected' : '';
                        echo '<option value="' . $row['category_id'] . '" ' . $selected . '>' . $row['category_title'] . '</option>';
                    }
                    echo '</select>';
                    ?>
                </div>

                <!-- Tags -->
                <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                <?php
                require_once '../../Models/Tags.php';
                $tags = new Tags("", "", "", "");
                $results = $tags->showTags();
                echo '<div class="flex flex-wrap">';
                foreach ($results as $result) {
                    // Vérifier si le tag est déjà associé au cours
                    $checked = in_array($result['tag_id'], $currentTags) ? 'checked' : '';
                    echo '<div class="w-1/4 p-2">';
                    echo '<input type="checkbox" name="courseTags[]" value="' . $result['tag_id'] . '" id="tag_' . $result['tag_id'] . '" ' . $checked . '>';
                    echo '<label for="tag_' . $result['tag_id'] . '">' . $result['tag_name'] . '</label>';
                    echo '</div>';
                }
                echo '</div>';
                ?>

                <!-- Contenu (URL) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Contenu (URL)</label>
                    <input type="url" name="ContenuUrl" value="<?php echo htmlspecialchars($courseData['course_content_url']); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>

                <!-- Image de couverture -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Image de couverture</label>
                    <input type="file" name="course_image" accept="image/*" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                    <p class="text-xs text-gray-500">Si vous ne souhaitez pas changer l'image, laissez ce champ vide.</p>
                    <?php if ($courseData['course_image']) : ?>
                        <img src="<?php echo $courseData['course_image']; ?>" alt="Couverture actuelle" class="mt-2 w-32 h-32 object-cover">
                    <?php endif; ?>
                </div>

                <!-- Boutons -->
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeModifyCourseModal()" class="px-4 py-2 border rounded-md hover:bg-gray-100">
                        Annuler
                    </button>
                    <button type="submit" name="modifyCourse" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Modifier le cours
                    </button>
                </div>
            </form>
        </div>
    </div>
    </main>

    <script>
        function showAddTagModal() {
        document.getElementById('newCourseModal').classList.remove('hidden');
        document.getElementById('newCourseModal').classList.add('flex');
        // document.getElementById('modifyTag').classList.remove('flex');
        document.getElementById('modifyCourseModal').classList.add('hidden');
    }
        document.getElementById('openNewCourse').addEventListener('click', function() {
            document.getElementById('newCourseModal').classList.remove('hidden');
        })
        // Ouvrir le modal de nouveau cours
        function openNewCourse() {
            document.getElementById('newCourseModal').classList.remove('hidden');
        }

        // Fermer le modal de nouveau cours
        function closeNewCourseModal() {
            document.getElementById('newCourseModal').classList.add('hidden');
        }
    </script>
</body>

</html>