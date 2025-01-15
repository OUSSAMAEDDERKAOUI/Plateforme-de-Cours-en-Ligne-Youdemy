// Données simulées pour les cours
const coursesData = Array.from({ length: 50 }, (_, i) => ({
    id: i + 1,
    title: `Cours ${i + 1}: ${['JavaScript Avancé', 'Python pour Débutants', 'Design UX/UI', 'Marketing Digital'][i % 4]}`,
    instructor: `Instructeur ${i + 1}`,
    price: i % 3 === 0 ? 'Gratuit' : `${(i + 1) * 10}€`,
    image: `https://picsum.photos/seed/${i + 1}/300/200`,
    category: ['web', 'mobile', 'design', 'marketing'][i % 4],
    description: `Description détaillée du cours ${i + 1}. Ce cours couvre tous les aspects essentiels du sujet.`
}));

// Configuration de la pagination
const itemsPerPage = 9;
let currentPage = 1;
let filteredCourses = [...coursesData];

// Fonction pour afficher les cours
function displayCourses(courses, page = 1) {
    const coursesList = document.getElementById('coursesList');
    coursesList.innerHTML = '';

    const start = (page - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const paginatedCourses = courses.slice(start, end);

    paginatedCourses.forEach(course => {
        const courseCard = `
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <img src="${course.image}" alt="${course.title}" class="w-full h-48 object-cover">
                <div class="p-6">
                    <div class="text-sm text-indigo-600 mb-2">${course.category}</div>
                    <h3 class="text-xl font-semibold mb-2">${course.title}</h3>
                    <p class="text-gray-600 mb-4">Par ${course.instructor}</p>
                    <p class="text-gray-500 text-sm mb-4">${course.description}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-indigo-600">${course.price}</span>
                        <button onclick="viewCourseDetails(${course.id})" 
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Détails
                        </button>
                    </div>
                </div>
            </div>
        `;
        coursesList.innerHTML += courseCard;
    });

    updatePagination(courses.length);
}

// Fonction pour mettre à jour la pagination
function updatePagination(totalItems) {
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    const pagination = document.getElementById('pagination');
    pagination.innerHTML = '';

    // Bouton précédent
    pagination.innerHTML += `
        <button onclick="changePage(${currentPage - 1})" 
                class="px-3 py-1 rounded-md ${currentPage === 1 ? 'bg-gray-200 cursor-not-allowed' : 'bg-indigo-600 text-white hover:bg-indigo-700'}"
                ${currentPage === 1 ? 'disabled' : ''}>
            Précédent
        </button>
    `;

    // Pages
    for (let i = 1; i <= totalPages; i++) {
        pagination.innerHTML += `
            <button onclick="changePage(${i})" 
                    class="px-3 py-1 rounded-md ${currentPage === i ? 'bg-indigo-600 text-white' : 'bg-gray-200 hover:bg-gray-300'}">
                ${i}
            </button>
        `;
    }

    // Bouton suivant
    pagination.innerHTML += `
        <button onclick="changePage(${currentPage + 1})" 
                class="px-3 py-1 rounded-md ${currentPage === totalPages ? 'bg-gray-200 cursor-not-allowed' : 'bg-indigo-600 text-white hover:bg-indigo-700'}"
                ${currentPage === totalPages ? 'disabled' : ''}>
            Suivant
        </button>
    `;
}

// Fonction pour changer de page
function changePage(page) {
    const totalPages = Math.ceil(filteredCourses.length / itemsPerPage);
    if (page >= 1 && page <= totalPages) {
        currentPage = page;
        displayCourses(filteredCourses, currentPage);
    }
}

// Fonction pour filtrer les cours
function filterCourses() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const categoryFilter = document.getElementById('categoryFilter').value;
    const priceFilter = document.getElementById('priceFilter').value;

    filteredCourses = coursesData.filter(course => {
        const matchesSearch = course.title.toLowerCase().includes(searchTerm) || 
                            course.description.toLowerCase().includes(searchTerm);
        const matchesCategory = !categoryFilter || course.category === categoryFilter;
        const matchesPrice = !priceFilter || 
                           (priceFilter === 'free' && course.price === 'Gratuit') ||
                           (priceFilter === 'paid' && course.price !== 'Gratuit');

        return matchesSearch && matchesCategory && matchesPrice;
    });

    currentPage = 1;
    displayCourses(filteredCourses, currentPage);
}

// Gestion du modal d'inscription
const registerModal = document.getElementById('registerModal');
const openRegisterModal = document.getElementById('openRegisterModal');
const closeRegisterModal = document.getElementById('closeRegisterModal');
const registerForm = document.getElementById('registerForm');

openRegisterModal.addEventListener('click', () => {
    registerModal.classList.remove('hidden');
});

closeRegisterModal.addEventListener('click', () => {
    registerModal.classList.add('hidden');
});

registerForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const formData = new FormData(registerForm);
    const userData = Object.fromEntries(formData.entries());
    console.log('Données d\'inscription:', userData);
    // Ici, vous ajouteriez la logique pour envoyer les données au backend
    alert('Inscription réussie !');
    registerModal.classList.add('hidden');
});

// Event listeners pour la recherche et les filtres
document.getElementById('searchButton').addEventListener('click', filterCourses);
document.getElementById('searchInput').addEventListener('keyup', (e) => {
    if (e.key === 'Enter') filterCourses();
});
document.getElementById('categoryFilter').addEventListener('change', filterCourses);
document.getElementById('priceFilter').addEventListener('change', filterCourses);

// Fonction pour voir les détails d'un cours
function viewCourseDetails(courseId) {
    const course = coursesData.find(c => c.id === courseId);
    if (course) {
        alert(`Détails du cours "${course.title}"\nPrix: ${course.price}\nInstructeur: ${course.instructor}`);
        // Ici, vous pourriez rediriger vers une page de détails du cours
    }
}

// Initialisation
document.addEventListener('DOMContentLoaded', () => {
    displayCourses(coursesData);
});
