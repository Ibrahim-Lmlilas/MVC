<?php require_once(__DIR__ . '/../../partials/header.php'); ?>

<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
    <div class="container px-6 py-8 mx-auto">
        <h3 class="text-3xl font-medium text-gray-700 mb-10">My Offres</h3>
        <table class="min-w-full text-left">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Title</th>
                    <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Amount</th>
                    <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Deadline</th>
                    <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Status</th>
                    <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase border-b border-gray-200 bg-gray-50"></th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <!-- projects -->
                <?php foreach ($client_offers as $client_offer): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            <div class="flex items-center">
                                <div class="text-sm font-medium leading-5 text-gray-900"><?= htmlspecialchars($client_offer['titre_projet']); ?></div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            <div class="offre_montant text-sm leading-5 text-gray-900 w-full"><?= htmlspecialchars($client_offer['montant']); ?></div>
                        </td>

                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            <div class="offre_deali text-sm leading-5 text-gray-900 w-full"><?= htmlspecialchars($client_offer['delai']); ?></div>
                        </td>

                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            <div class="text-sm leading-5 text-gray-900 w-full"><?= $client_offer['status'] == 1 ? "Pending" : ($client_offer['status'] == 2 ? "Accepted" : "Rejected") ?></div>
                        </td>

                        <td class="px-6 py-4 text-sm font-medium leading-5 text-right whitespace-no-wrap border-b border-gray-200 flex justify-evenly">
                            <!-- accept offre -->
                            <?php if ($client_offer['status'] != 2) { ?>
                                <form method="POST" action="/client/offers/acceptOffre" class="mb-0" onsubmit="return confirm('Are you sure you want to accept this offre?');">
                                    <input type="hidden" name="id_offre" value="<?= $client_offer['id_offre']; ?>">
                                    <button type="submit" name="accept_offre" class="text-indigo-600 hover:text-indigo-900">Accept</button>
                                </form>
                            <?php } ?>

                            <!-- add testimonila button -->
                            <?php if ($client_offer['status'] == 2 && !in_array($client_offer['id_offre'], $id_offre_having_testimonial)) { ?>
                                <button data-offre-id="<?= htmlspecialchars($client_offer['id_offre']); ?>" class="add_testimonial_button text-indigo-600 hover:text-indigo-900">Add Testimonial</button>
                            <?php } ?>

                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php require_once(__DIR__ . '/testimonialsPopUp.php'); ?>
<?php require_once(__DIR__ . '/../../partials/footer.php'); ?>