<?php
require_once __DIR__ . '../../../Models/Course.php';
require_once __DIR__ . '../../../Models/CourseDocument.php';
require_once __DIR__ . '../../../Models/CourseVideo.php';
require_once __DIR__ . '../../../Models/Users.php';

require_once __DIR__ . '../../../../config/database.php';

if (isset($_POST['dec'])) {
    session_unset();

    session_destroy();

    header('Location: ../user/login.php');
    exit();
}

session_start();
if (isset($_SESSION['user_role'])) {
    switch ($_SESSION['user_role']) {
        case 'enseignant':
            header('Location: ../teacher/dashboard.php');
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addCourse'])) {
        $title = htmlspecialchars($_POST['title']);
        $description = htmlspecialchars($_POST['description']);
        $categoryId = htmlspecialchars($_POST['category']);
        $course_type = htmlspecialchars($_POST['course_type']);
        $courseTags = isset($_POST['courseTags']) ? $_POST['courseTags'] : [];
        $teacherId = 1; 

        $upload_img = $_FILES['course_image'];

        $upload_file = $_FILES['course_file'];

        if ($course_type === 'document') {
            $course = new CourseDocument(null, $title, $upload_file, $teacherId, null, null, $upload_img, $description, $categoryId, $course_type);
        } else if ($course_type === 'video') {
            $course = new CourseVideo(null, $title, $upload_file, $teacherId, null, null, $upload_img, $description, $categoryId, $course_type);
        }

        try {
            $course->addCourse();
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        } catch (Exception $e) {

            echo "Erreur : " . $e->getMessage();
        }
    }

    if (isset($_POST['deletecourse'])) {
        $coursId = $_GET['id'];
        $deleteCourse = Course::deletecourse($coursId);
    }


    if (isset($_GET['id'])) {
        $courseId = $_GET['id'];
    
        $course = Course::getCourseById($courseId); 
        if ($course) {
            $courseTitle = $course->getCourseTitle();
            $courseDescription = $course->getCoursesDescription();         
            $categoryId = $course->getCategoryId();
            $courseStatus = $course->getCourseStatus();
            $courseFile = $course->getCreationDate(); 
            $courseType = $course->getCourseType(); 
        }
    } else {
        header('Location: ' . $_SERVER['PHP_SELF']);
                exit;

    }
    if(isset($_POST['modifyCourse'])){
        $title = htmlspecialchars($_POST['modify_title']);
        $description = htmlspecialchars($_POST['modify_description']);
        $categoryId = htmlspecialchars($_POST['modify_category']);
        $course_type = htmlspecialchars($_POST['modify_course_type']);
        $courseTags = isset($_POST['modify_courseTags']) ? $_POST['modify_courseTags'] : [];
        $courseId = $_GET['id'];

        $teacherId = 1; 

        $upload_img = $_FILES['course_image'];

        $upload_file = $_FILES['course_file'];
        if ($course_type === 'document') {
            $course = new CourseDocument($courseId, $title, $upload_file, $teacherId, null, null, $upload_img, $description, $categoryId, $course_type);
        } else if ($course_type === 'video') {
            $course = new CourseVideo($courseId, $title, $upload_file, $teacherId, null, null, $upload_img, $description, $categoryId, $course_type);
        }

        try {
            $course->updateCourse();
      
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        } catch (Exception $e) {

            echo "Erreur : " . $e->getMessage();
        }
    }
   
}


$coursesDocument = CourseDocument::showCourses();
$coursesVideo = CourseVideo::showCourses();





$formClass = '';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || isset($_POST['deletecourse'])) {
    $formClass = 'hidden';
}
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
                <form action="" method="POST">
                            <button name="dec" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-700">
                                <i class="fas fa-sign-out-alt"></i>
                                Déconnexion
                            </button>
                </form>
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
                        <h3 class="text-xl font-semibold mb-4">Mes cours De Type Document</h3>
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
                                    <?php foreach ($coursesDocument as $courseDocument) : ?>
                                        <?php $categoryTitle = Course::getCategoryTitleById($courseDocument->getCategoryId()); ?>
                                        <!-- $teacherName = Course::getTeacherNameById($course->getTeacherId()); // Récupérer le nom de l'enseignant -->

                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($courseDocument->getCourseTitle()); ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900"><?php echo " $categoryTitle " ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500"><?php echo htmlspecialchars($courseDocument->getCoursesDescription()); ?></div>
                                            </td>


                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    <?php echo ($courseDocument->getCourseStatus() === 'accepté') ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                                                    <?php echo htmlspecialchars($courseDocument->getCourseStatus()); ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <?php echo '<form method="POST" action="?id=' . htmlspecialchars($courseDocument->getcourseId()) . ' ">'; ?>
                                                <button id="modifycourse" onclick="showmodifyModal()" class="text-indigo-600 hover:text-indigo-900 mr-6" name="modifycourse">
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
                            <h3 class="text-xl font-semibold mb-6 mt-16">Mes cours De Type Vidéo</h3>
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
                                    <?php foreach ($coursesVideo as $courseVideo) : ?>
                                        <?php $categoryTitle = Course::getCategoryTitleById($courseVideo->getCategoryId()); ?>
                                        <!-- $teacherName = Course::getTeacherNameById($course->getTeacherId()); // Récupérer le nom de l'enseignant -->

                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($courseVideo->getCourseTitle()); ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900"><?php echo " $categoryTitle " ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500"><?php echo htmlspecialchars($courseVideo->getCoursesDescription()); ?></div>
                                            </td>


                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                    <?php echo ($courseVideo->getCourseStatus() === 'accepté') ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                                                    <?php echo htmlspecialchars($courseVideo->getCourseStatus()); ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <?php echo '<form method="POST" action="?id=' . htmlspecialchars($courseVideo->getcourseId()) . ' ">'; ?>
                                                <button id="modifycourse" onclick="showmodifyModal()" class="text-indigo-600 hover:text-indigo-900 mr-6" name="modifycourse">
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
                    <label class="block text-sm font-medium text-gray-700">Image de couverture</label>
                    <input type="file" name="course_image" accept="image/*" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
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
                    <label class="block text-sm font-medium text-gray-700">Type de Contenu</label>

                    <select name="course_type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                        <option value="document"> document</option>
                        <option value="video"> vidéo </option>
                    </select>

                </div>

                <!-- Image du cours (Couverture) -->

                <div>
                    <label class="block text-sm font-medium text-gray-700">Télécharger un document PDF</label>
                    <input type="file" name="course_file" accept="application/pdf/mp4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
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







    <div id="modifyCourseModal" class=" fixed  inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 <?php echo $formClass; ?> ">
        <div class="bg-white rounded-lg p-8 max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <h2 class="text-2xl font-bold mb-6">Modifier cours</h2>
            <form id="newCourseForm" class="space-y-4" method="POST" enctype="multipart/form-data">

                <div>
                    <label class="block text-sm font-medium text-gray-700">Titre du cours</label>
                    <input type="text" name="modify_title" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" value="<?php echo htmlspecialchars($courseTitle); ?>">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Image de couverture</label>
                    <input type="file" name="course_image" accept="image/*" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="modify_description" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border"><?php echo htmlspecialchars( $courseDescription); ?></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Catégorie</label>
                    <?php
                    require_once '../../Models/Category.php';
                    $categories = new Category("", "", "", "", "");
                    $rows = $categories->showCategory();
                    echo '<select name="modify_category" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">';
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
                    echo '<input type="checkbox" name="modify_courseTags[]" value="' . $result['tag_id'] . '" id="tag_' . $result['tag_id'] . '">';
                    echo '<label for="tag_' . $result['tag_id'] . '">' . $result['tag_name'] . '</label>';
                    echo '</div>';
                }
                echo '</div>';
                ?>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Type de Contenu</label>

                    <select name="modify_course_type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                        <option value="document"> document</option>
                        <option value="video"> vidéo </option>
                    </select>

                </div>

                <!-- Image du cours (Couverture) -->

                <div>
                    <label class="block text-sm font-medium text-gray-700">Télécharger contenu</label>
                    <input type="file" name="course_file" accept="application/pdf/mp4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>

                <!-- Boutons -->
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeNewCourseModal()" class="px-4 py-2 border rounded-md hover:bg-gray-100">
                        Annuler
                    </button>
                    <button type="submit" name="modifyCourse" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Modifier le cours
                    </button>
                </div>
            </form>
        </div>
    </div>






    </div>
    </main>

    <script>
        function openNewCourse() {
            document.getElementById('newCourseModal').classList.remove('hidden');
            // document.getElementById('modifyCourseModal').classList.remove('hidden');

        }

        function closeNewCourseModal() {
            document.getElementById('newCourseModal').classList.add('hidden');
            document.getElementById('modifyCourseModal').classList.add('hidden');


        }
    </script>
</body>

</html>