<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Dashboard Enseignant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/style.css">
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
                    <button onclick="openNewCourseModal()" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
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
                                            Catégorie
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Étudiants
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
                                    <!-- Les cours seront injectés ici -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Nouveau Cours -->
    <div id="newCourseModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8 max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <h2 class="text-2xl font-bold mb-6">Ajouter un nouveau cours</h2>
            <form id="newCourseForm" class="space-y-4">
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
                    <select name="category" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                        <option value="web">Développement Web</option>
                        <option value="mobile">Développement Mobile</option>
                        <option value="design">Design</option>
                        <option value="marketing">Marketing</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tags (séparés par des virgules)</label>
                    <input type="text" name="tags" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Contenu vidéo (URL)</label>
                    <input type="url" name="videoUrl" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Document du cours (PDF)</label>
                    <input type="file" name="courseDocument" accept=".pdf" class="mt-1 block w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Prix</label>
                    <input type="number" name="price" min="0" step="0.01" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeNewCourseModal()" class="px-4 py-2 border rounded-md hover:bg-gray-100">
                        Annuler
                    </button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Créer le cours
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="assets/js/teacher-dashboard.js"></script>
</body>
</html>
