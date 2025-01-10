
const modal = document.getElementById('categorie_modal');
document.getElementById('close_categorie_modal').onclick = () => closeModal();
// show modal as add category
document.getElementById('add_categorie_button').onclick = () => {
    showModal();
    document.getElementById('category_form').classList.remove("hidden");
}
// show modal as add modify subcategory
const modifyCategoryButtons =document.querySelectorAll(".modify_category_button");

  modifyCategoryButtons.forEach(modifyCategoryButton=>{
    modifyCategoryButton.onclick = () => {
    showModal();
    document.getElementById('category_form').classList.remove("hidden");
    document.getElementById("category_id_input").value=modifyCategoryButton.closest(".category_box").getAttribute("data-category-id");                
    document.getElementById("category_name_input").value=modifyCategoryButton.closest(".category_box")?.querySelector("h3").textContent;
    
}
});
function showModal(){
    modal.classList.remove('hidden');
}
function closeModal(){
    modal.classList.add('hidden');
    document.getElementById('category_form').classList.add("hidden");
    document.getElementById('category_form').reset();
    document.getElementById('sub_category_form').classList.add("hidden");
    document.getElementById('sub_category_form').reset();
}

  // show modal as add subcategory
const addSubCategoryButtons =document.querySelectorAll(".add_sub_cat");
addSubCategoryButtons.forEach(addSubCategoryButton=>{
    addSubCategoryButton.onclick = () => {
    showModal();
    document.getElementById('sub_category_form').classList.remove("hidden");       
    document.getElementById("category_parent_id_input").value=addSubCategoryButton.closest(".category_box").getAttribute("data-category-id");                        
}
});

  // show modal as modify subcategory
const modifySubCategoryButtons =document.querySelectorAll(".modify_sub_cat");
modifySubCategoryButtons.forEach(modifySubCategoryButton=>{
    modifySubCategoryButton.onclick = () => {
    showModal();
    document.getElementById('sub_category_form').classList.remove("hidden");       
    document.getElementById("category_parent_id_input").value=modifySubCategoryButton.closest(".category_box").getAttribute("data-category-id");
    document.getElementById("subcategory_id_input").value=modifySubCategoryButton.closest(".sub_cat_box").getAttribute("data-sub-category-id");
    document.getElementById("subcategory_name_input").value=modifySubCategoryButton.closest(".sub_cat_box")?.querySelector("span").textContent;
}
});