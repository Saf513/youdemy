// Sample course data (replace with your actual data from PHP)
const courses = [
    { id: 1, title: "Introduction à la programmation", createdAt: "2024-05-15", enrollments: 25 },
    { id: 2, title: "Marketing digital pour débutants", createdAt: "2024-06-20", enrollments: 50 },
     { id: 3, title: "Le leadership inspirant", createdAt: "2024-07-20", enrollments: 50 },
    // ... more courses
];

const categories = [
      {id: 1, name: "Programmation"},
       {id: 2, name: "Marketing"},
     {id: 3, name: "Leadership"}

];


const courseList = document.getElementById('existing-courses-list').querySelector('ul');
const courseTemplate = document.querySelector('.template-course');

courses.forEach(course => {
    const newCourseItem = courseTemplate.cloneNode(true);
    newCourseItem.classList.remove('hidden','template-course');

    newCourseItem.querySelector('h3').textContent = course.title;
    newCourseItem.querySelector('.created-at').textContent = `Créé le : ${course.createdAt}`;
    newCourseItem.querySelector('.enrollments').textContent = `Inscriptions: ${course.enrollments}`;

     // Edit Course Form
    const editForm = newCourseItem.querySelector('.edit-form');
    editForm.action = `/pages/courses/edit_course.php`; // Replace with your actual edit page URL
    editForm.querySelector('input[name="course_id"]').value = course.id;


    // Delete Course Form
   const deleteForm =  newCourseItem.querySelector('.delete-form');
    deleteForm.onsubmit = function() {
        return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?');
    };
   deleteForm.querySelector('input[name="course_id"]').value = course.id;



    courseList.appendChild(newCourseItem);

});




// Function to dynamically add course cards
function addCourseCard(course) {

}

// Add existing courses initially (replace with your dynamic data)

// Set values for profile form (replace with user's actual data)
document.getElementById('full_name').value = "<?= htmlspecialchars($user->getFullName()) ?>";
document.getElementById('email').value = "<?= htmlspecialchars($user->getEmail()) ?>";
document.getElementById('bio').value = "<?= htmlspecialchars($user->getBio() ?? '') ?>"; // Default to empty if null
document.getElementById('speciality').value = "<?= htmlspecialchars($user->getSpeciality() ?? '') ?>"; // Default to empty if null




// Event listener for profile form submission (you'll handle the actual submission in PHP)
document.getElementById('profile-form').addEventListener('submit', function(event) {
    // Your JavaScript form submission logic here (if needed)
});


// Course creation logic
const createCourseForm = document.getElementById('create-course-form');
const courseCreationErrorDiv = document.getElementById('course-creation-error');

createCourseForm.innerHTML = `
    <div class="mb-4">
        <label for="title" class="block text-gray-700 font-medium mb-2">Titre</label>
        <input type="text" id="title" name="title" class="border border-gray-400 p-2 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" required>
    </div>

    <div class="mb-4">
        <label for="category_id" class="block text-gray-700 font-medium mb-2">Category</label>
        <select id="category_id" name="category_id" class="border border-gray-400 p-2 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent">
            ${categories.map(category => `<option value="${category.id}">${category.name}</option>`).join('')}
        </select>
    </div>

    <div class="mb-4">
        <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
        <textarea id="description" name="description" rows="4" class="border border-gray-400 p-2 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" required></textarea>
    </div>

    <div class="mb-4">
        <label for="content" class="block text-gray-700 font-medium mb-2">Content</label>
        <textarea id="content" name="content" rows="4" class="border border-gray-400 p-2 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" required></textarea>
    </div>

    <div class="mb-4">
        <label for="content_type" class="block text-gray-700 font-medium mb-2">Content Type</label>
        <select id="content_type" name="content_type" class="border border-gray-400 p-2 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent">
            <option value="video">Video</option>
            <option value="document">Document</option>
        </select>
    </div>

    <div class="mb-4">
        <label for="content_url" class="block text-gray-700 font-medium mb-2">Content URL</label>
        <input type="text" id="content_url" name="content_url" class="border border-gray-400 p-2 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" required>
    </div>
    <div class="mb-4">
        <label for="tags" class="block text-gray-700 font-medium mb-2">Tags (comma separated)</label>
        <input type="text" id="tags" name="tags" class="border border-gray-400 p-2 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent">
    </div>




    <button type="submit" name="create_course" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
        Créer le Cours
    </button>
`;



createCourseForm.addEventListener('submit', function(event) {
    // event.preventDefault();  If you're handling form submission with JavaScript, uncomment this

     //Course creation logic to handle form data using fetch or XMLHttpRequest
      // Show or hide success/error messages
});


courseTemplate.innerHTML = `
 <div class="flex justify-between items-center">
     <div>
        <h3 class="font-semibold"></h3>
         <p class="text-gray-600 text-sm created-at"></p>
       </div>
       <div class="flex space-x-2">
        <form method="POST" class="edit-form" style="display: inline;">
             <input type="hidden" name="course_id" value="">
            <button class="text-blue-500 hover:text-blue-700" type="submit">Éditer</button>
       </form>
           <form method="post" class="delete-form" style="display: inline;">
               <input type="hidden" name="course_id" value="">
                <button type="submit" name="delete_course" class="text-red-500 hover:text-red-700">Supprimer</button>
         </form>
       </div>

   </div>
   <div class="mt-2">
       <p class="text-sm text-gray-600 enrollments"></p>
    </div>
`;