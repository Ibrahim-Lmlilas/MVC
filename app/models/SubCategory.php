<?php
require_once(__DIR__ . '/../config/db.php');
class SubCategory extends Db
{

    public function __construct()
    {
        parent::__construct();
    }

    // show all sub categories
    function showSubCategories() {
        $subCategoriesQuery = $this->conn->prepare("SELECT * FROM sous_categories");
        $subCategoriesQuery->execute([]);
            
        // Fetch and return results
        $subcategories = $subCategoriesQuery->fetchAll(PDO::FETCH_ASSOC);
        return $subcategories;
    }

    // creat subcategory method
    public function createSubCategory($subcategory_name,$category_id){
        try {
            $AddSubCategoryQuery = $this->conn->prepare("INSERT INTO sous_categories (nom_sous_categorie, id_categorie) VALUES (:subcategory_name, :category_id)");
            $AddSubCategoryQuery->execute([':subcategory_name' => $subcategory_name, ':category_id' => $category_id]);
         } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
         }
    }

    // modify sub category method
    public function modifySubCategory($subcategory_name, $subcategory_id){
        try {
            $modifySubCategoryQuery = $this->conn->prepare("UPDATE sous_categories SET nom_sous_categorie = ? WHERE id_sous_categorie = ?");
            $modifySubCategoryQuery->execute([$subcategory_name, $subcategory_id]);
         } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
         }
    }
    
    // delete category method
    public function deleteCategory($id_sous_categorie){
        $deleteSubCategorieQuery=$this->conn->prepare("DELETE FROM sous_categories WHERE id_sous_categorie=?");
        $deleteSubCategorieQuery->execute([$id_sous_categorie]);
    }
}
