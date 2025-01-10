<?php
require_once(__DIR__ . '/../config/db.php');
class Category extends Db
{

    public function __construct()
    {
        parent::__construct();
    }

    public function allCategories()
    {
        $categoriesQuery = $this->conn->prepare("SELECT * FROM categories");
        $categoriesQuery->execute([]);

        // Fetch and return results
        $categories = $categoriesQuery->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    }

    // get categories with their sub categories
    function getCategoriesWithSubcategories()
    {
        try {
            $query = $this->conn->prepare("SELECT c.id_categorie,c.nom_categorie,sc.id_sous_categorie,sc.nom_sous_categorie
                                     FROM categories c
                                     LEFT JOIN sous_categories sc ON c.id_categorie = sc.id_categorie");
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_ASSOC);

            $categories = [];
            foreach ($results as $row) {
                $id_categorie = $row['id_categorie'];

                // Initialize category if not present
                if (!isset($categories[$id_categorie])) {
                    $categories[$id_categorie] = [
                        'id_categorie' => $id_categorie,
                        'nom_categorie' => $row['nom_categorie'],
                        'sous_categories' => []
                    ];
                }

                // Add subcategories
                if (!empty($row['id_sous_categorie'])) {
                    $categories[$id_categorie]['sous_categories'][] = [
                        'id_sous_categorie' => $row['id_sous_categorie'],
                        'nom_sous_categorie' => $row['nom_sous_categorie']
                    ];
                }
            }

            return $categories;
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
            return [];
        }
    }

    // creat category method
    public function creatCategory($category_name){
        try {
            $AddCategoryQuery = $this->conn->prepare("INSERT INTO categories (nom_categorie) VALUES (:category_name)");
            $AddCategoryQuery->execute([':category_name' => $category_name]);
         } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
         }
    }

    // modify category method
    public function modifyCategory($category_name, $category_id){
        try {
            $modifyCategoryQuery = $this->conn->prepare("UPDATE categories SET nom_categorie = ? WHERE id_categorie = ?");
            $modifyCategoryQuery->execute([$category_name, $category_id]);
         } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
         }
    }
    
    // delete category method
    public function deleteCategory($id_categorie){
        $deleteCategorieQuery=$this->conn->prepare("DELETE FROM categories WHERE id_categorie=?");
        $deleteCategorieQuery->execute([$id_categorie]);
    }
}
