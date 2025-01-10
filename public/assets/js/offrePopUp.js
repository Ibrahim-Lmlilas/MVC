const offerModal = document.getElementById("offer_modal");
const closeOfferModal = document.getElementById("close_offer_modal");

// Show modal as add offer
const submitOffreButtons = document.querySelectorAll(".submit_offre_button");
submitOffreButtons.forEach((submitOffreButton) => {
  submitOffreButton.addEventListener("click", () => {
    offerModal.classList.remove("hidden");
    document.getElementById("project_id_input").value =
      submitOffreButton.getAttribute("data-project-id");
  });
});

// Show modal as modify offer
const modifyOffreButtons = document.querySelectorAll(".modify_offre_button");
modifyOffreButtons.forEach((modifyOffreButton) => {
  modifyOffreButton.addEventListener("click", () => {
    offerModal.classList.remove("hidden");
    document.getElementById("montant_input").value = modifyOffreButton
      .closest("tr")
      .querySelector(".offre_montant").textContent;
    document.getElementById("delai_input").value = modifyOffreButton
      .closest("tr")
      .querySelector(".offre_deali").textContent;
    document.getElementById("offre_id_input").value =
      modifyOffreButton.getAttribute("data-offre-id");
  });
});

// Close modal when clicking on the close button
closeOfferModal.addEventListener("click", () => {
  offerModal.classList.add("hidden");
});

// Close modal when clicking outside the modal content
window.addEventListener("click", (event) => {
  if (event.target === offerModal) {
    offerModal.classList.add("hidden");
  }
});
