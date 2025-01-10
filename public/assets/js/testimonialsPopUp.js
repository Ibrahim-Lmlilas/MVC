const testimonialModal = document.getElementById("testimonial_modal");
const closeTestimonialModal = document.getElementById(
  "close_testimonial_modal"
);
const addTestimonialButtons = document.querySelectorAll(
  ".add_testimonial_button"
); // Select all add testimonial buttons

// Show modal for adding a testimonial
addTestimonialButtons.forEach((addTestimonialButton) => {
  addTestimonialButton.onclick = () => {
    showModal();
    document.getElementById("testimonial_form").classList.remove("hidden");
    // Clear fields for adding
    document.getElementById("testimonial_form").reset();
    document.getElementById("offre_id_input").value =
      addTestimonialButton.getAttribute("data-offre-id");
  };
});

// Show modal for modifying a testimonial
const modifyTestimonialButtons = document.querySelectorAll(
  ".modify_testimonial_button"
);

modifyTestimonialButtons.forEach((modifyTestimonialButton) => {
  modifyTestimonialButton.onclick = () => {
    showModal();
    document.getElementById("testimonial_form").classList.remove("hidden");

    document.getElementById("commentaire_input").value = modifyTestimonialButton
      .closest("tr")
      .querySelector(".testimonial_comment").textContent;
    document.getElementById("testimonial_id_input").value =
      modifyTestimonialButton.getAttribute("data-testimonial-id");
    document.getElementById("offre_id_input").value =
      modifyTestimonialButton.getAttribute("data-offre-id");
  };
});

// Close modal when clicking the close button
closeTestimonialModal.onclick = () => closeModal();

// Close modal when clicking outside the modal content
window.addEventListener("click", (event) => {
  if (event.target === testimonialModal) {
    closeModal();
  }
});

function showModal() {
  testimonialModal.classList.remove("hidden");
}

function closeModal() {
  testimonialModal.classList.add("hidden");
  document.getElementById("testimonial_form").classList.add("hidden");
}
