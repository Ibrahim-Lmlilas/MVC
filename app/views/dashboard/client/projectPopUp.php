<!-- Add Project Popup -->
<div id="project_modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center">
    <div id="modal_content" class="flex flex-col w-11/12 md:w-5/12 overflow-y-auto scrollbar-hidden mx-auto mt-10 p-4 bg-gray-200 rounded-sm shadow-lg">
        <div class="flex justify-between">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl">Add Project</h1>
            <!-- Close Icon -->
            <button id="close_project_modal" class="flex justify-end items-center mb-4 float-right text-xl">&times;</button>
        </div>
        <!-- Add Project Form -->
        <form method="POST" action="/client/projects/addModifyProject" id="project_form" class="mt-[25%] md:px-10">
            <!-- Project Title -->
            <div class="flex w-full mb-4">
                <label for="project_title_input" class="text-gray-900 font-semibold w-1/3">Project Title:</label>
                <input type="text" name="project_title_input" id="project_title_input" value="" class="w-2/3 border-gray-300 rounded-md" required>
            </div>

            <!-- Description -->
            <div class="flex w-full mb-4">
                <label for="project_description_input" class="text-gray-900 font-semibold w-1/3">Description:</label>
                <textarea name="project_description_input" id="project_description_input" rows="4" class="w-2/3 border-gray-300 rounded-md" required></textarea>
            </div>

            <!-- Category -->
            <div class="flex w-full mb-4">
                <label for="project_category_input" class="text-gray-900 font-semibold w-1/3">Category:</label>
                <select name="project_category_input" id="project_category_input" class="w-2/3 border-gray-300 rounded-md" required>
                    <option value="">Select a category</option>
                    <?php foreach ($categories as $categorie): ?>
                        <option value="<?= htmlspecialchars($categorie['id_categorie']); ?>">
                            <?= htmlspecialchars($categorie['nom_categorie']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Subcategory -->
            <div class="flex w-full mb-4">
                <label for="project_subcategory_input" class="text-gray-900 font-semibold w-1/3">Subcategory:</label>
                <select name="project_subcategory_input" id="project_subcategory_input" class="w-2/3 border-gray-300 rounded-md" required>
                    <option value="">Select a subcategory</option>
                    <?php foreach ($subcategories as $subcategorie): ?>
                        <option value="<?= htmlspecialchars($subcategorie['id_sous_categorie']); ?>">
                            <?= htmlspecialchars($subcategorie['nom_sous_categorie']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- status select -->
            <div id="status_select" class="hidden flex w-full mb-4">
                <label for="project_status_input" class="text-gray-900 font-semibold w-1/3">Status:</label>
                <select name="project_status_input" id="project_status_input" class="w-2/3 border-gray-300 rounded-md" required>
                    <option value="1">Pending</option>
                    <option value="2">In Progress</option>
                    <option value="3">Completed</option>
                </select>
            </div>

            <!-- id category in case of inpur -->
            <input type="text" class="hidden" name="project_id_input" value="0" id="project_id_input">

            <div class="flex justify-end">
                <input type="submit" name="save_project" value="Save" class="text-gray-100 bg-gray-700 border-2 border-gray-700 hover:bg-gray-900 px-8 py-1 mt-6 rounded-sm">
            </div>
        </form>
    </div>
</div>
<script src="/assets/js/projectPopUp.js"></script>