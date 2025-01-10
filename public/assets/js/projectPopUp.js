const modal = document.getElementById("project_modal");
document.getElementById("close_project_modal").onclick = () => closeModal();

// Show modal as add project
document.getElementById("add_project_button").onclick = () => {
  showModal();
  document.getElementById("project_form").classList.remove("hidden");
};

// Show modal as modify project
const modifyProjectButtons = document.querySelectorAll(
  ".modify_project_button"
);
modifyProjectButtons.forEach((modifyProjectButton) => {
  modifyProjectButton.onclick = () => {
    showModal();
    document.getElementById("project_title_input").value = modifyProjectButton
      .closest("tr")
      .querySelector(".project_title").textContent;
    document.getElementById("project_description_input").value =
      modifyProjectButton
        .closest("tr")
        .querySelector(".project_description").textContent;
    document.getElementById("project_category_input").value =
      modifyProjectButton
        .closest("tr")
        .querySelector(".project_category")
        .getAttribute("data-category-id");
    document.getElementById("project_subcategory_input").value =
      modifyProjectButton
        .closest("tr")
        .querySelector(".project_sub_category")
        .getAttribute("data-sous-category-id");
    document.getElementById("project_id_input").value =
      modifyProjectButton.getAttribute("data-project-id");
    document.getElementById("status_select").classList.remove("hidden");
  };
});

function showModal() {
  modal.classList.remove("hidden");
}

function closeModal() {
  modal.classList.add("hidden");
  document.getElementById("status_select").classList.add("hidden");
  document.getElementById("project_form").reset();
}
window.onclick = (event) => {
  if (event.target === modal) {
    closeModal();
  }
};
