<?php
// session_start();
// echo $_SESSION['user_role'];
require_once __DIR__ . '../../../Models/Category.php';
require_once __DIR__ . '../../../Models/Course.php';
require_once __DIR__ . '../../../Models/CourseDocument.php';
require_once __DIR__ . '../../../Models/CourseVideo.php';


$course_cat_id=$_GET['id'];
$courses= CourseDocument::showCategoryCourses($course_cat_id);
$CoursesVideo= CourseVideo::showCategoryCourses($course_cat_id);

$course = Course::getCourseById($courseId); 

print_r($courses);

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
        <h3 class="text-xl font-semibold mb-6 mt-16">Mes cours De Type Document</h3>
            <div id="coursesList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php  foreach($courses AS $course) : ?>
                    <?php $categoryTitle = Course::getCategoryTitleById($course->getCategoryId()); ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="relative">
                                    <img  img src="/<?php echo htmlspecialchars($course->getCourseConverture()) ;?>" alt="photo de converture" class="w-full h-48 object-cover">
                                    <div class="absolute top-0 right-0 m-2">
                                        <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-sm">
                                        <?php echo htmlspecialchars($categoryTitle) ;?>
                                        </span>
                                    </div>
                                </div>
                    <div class="p-6">
                        <h3 class="text-xl text-indigo-600 mb-2"><?php echo htmlspecialchars($course->getCourseTitle()) ;?></h3>
                        <p class="text-gray-600 mb-4"> crée le <?php echo htmlspecialchars($course->getCreationDate()) ;?></p>
                        <p class="text-gray-500 text-sm mb-4"><?php echo htmlspecialchars($course->getCoursesDescription()) ;?></p>
                        <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-indigo-600"><?php echo htmlspecialchars($course->getCourseType()) ;?></span>
                            <span class="text-lg font-bold text-indigo-600">Gratuit</span>
                            <a href="../user/login.php">
                            <button onclick=""
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                Détails
                            </button>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach ;?>
            </div>



            <h3 class="text-xl font-semibold mb-6 mt-16">Mes cours De Type Vidéo </h3>
            <div id="coursesList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php  foreach($CoursesVideo AS $CourseVideo) : ?>
                    <?php $categoryTitle = Course::getCategoryTitleById($CourseVideo->getCategoryId()); ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="relative">
                                    <img  img src="/<?php echo htmlspecialchars($CourseVideo->getCourseConverture()) ;?>" alt="photo de converture" class="w-full h-48 object-cover">
                                    <div class="absolute top-0 right-0 m-2">
                                        <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-sm">
                                        <?php echo htmlspecialchars($categoryTitle) ;?>
                                        </span>
                                    </div>
                                </div>
                    <div class="p-6">
                        <h3 class="text-xl text-indigo-600 mb-2"><?php echo htmlspecialchars($CourseVideo->getCourseTitle()) ;?></h3>
                        <p class="text-gray-600 mb-4"> crée le <?php echo htmlspecialchars($CourseVideo->getCreationDate()) ;?></p>
                        <p class="text-gray-500 text-sm mb-4"><?php echo htmlspecialchars($CourseVideo->getCoursesDescription()) ;?></p>
                        <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-indigo-600"><?php echo htmlspecialchars($CourseVideo->getCourseType()) ;?></span>
                            <span class="text-lg font-bold text-indigo-600">Gratuit</span>
                            <a href="../user/login.php">
                            <button onclick=""
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                Détails
                            </button>
                            </a>
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



    <!-- <script src="/public/assets/js/visitor.js"></script> -->
</body>

</html>