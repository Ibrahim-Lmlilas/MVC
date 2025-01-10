<?php require_once(__DIR__ . '/../../partials/header.php'); ?>

<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
    <div class="container px-6 py-8 mx-auto">
        <h3 class="text-3xl font-medium text-gray-700 mb-10">My Testimonials</h3>
        <table class="min-w-full">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Project Title</th>
                    <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Comment</th>
                    <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Amount</th>
                    <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Deadline</th>
                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <?php foreach ($clientTestimonials as $clientTestimonial): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            <div class="flex items-center">
                                <div class="text-sm leading-5 text-gray-500"><?= htmlspecialchars($clientTestimonial['titre_projet']); ?>
                                </div>
                        </td>

                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            <div class="testimonial_comment text-sm leading-5 text-gray-900 w-full"><?= htmlspecialchars($clientTestimonial['commentaire']); ?></div>
                        </td>

                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            <div class="text-sm leading-5 text-gray-900 w-full"><?= htmlspecialchars($clientTestimonial['montant']); ?></div>
                        </td>

                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            <div class="text-sm leading-5 text-gray-900 w-full"><?= htmlspecialchars($clientTestimonial['delai']); ?></div>
                        </td>

                        <td class="px-6 py-4 text-sm font-medium leading-5 text-right whitespace-no-wrap border-b border-gray-200 flex justify-evenly">
                            <!-- modify button -->
                            <button data-testimonial-id="<?= htmlspecialchars($clientTestimonial['id_temoignage']); ?>" data-offre-id="<?= htmlspecialchars($clientTestimonial['id_offre']); ?>" class="modify_testimonial_button text-indigo-600 hover:text-indigo-900">Modify</button>
                            <!-- Remove User Form with Confirmation -->
                            <form method="POST" action="/client/testimonials/removeTestimonial" class="mb-0" onsubmit="return confirm('Are you sure you want to remove this Testimonial?');">
                                <input type="hidden" name="id_temoignage" value="<?= $clientTestimonial['id_temoignage']; ?>">
                                <button type="submit" name="remove_testimonial" class="text-indigo-600 hover:text-indigo-900">Remove</button>
                            </form>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php require_once(__DIR__ . '/testimonialsPopUp.php'); ?>
<?php require_once(__DIR__ . '/../../partials/footer.php'); ?>