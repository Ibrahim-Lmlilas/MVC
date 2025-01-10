<?php
require_once(__DIR__ . '/../config/db.php');
class Project extends Db
{

    public function __construct()
    {
        parent::__construct();
    }

    // methode to see all projects
    function allProjects($filter_by_cat, $filter_by_sub_cat, $filter_by_status, $projectToSearch = '')
    {
        $query = "SELECT p.id_projet, p.titre_projet, p.description,
                     p.id_categorie, p.id_sous_categorie, p.id_utilisateur,
                     p.project_status, c.nom_categorie AS nom_categorie,
                     sc.nom_sous_categorie AS nom_sous_categorie
            FROM projets p
            JOIN categories c ON c.id_categorie = p.id_categorie
            JOIN sous_categories sc ON sc.id_sous_categorie = p.id_sous_categorie
            WHERE 1=1";

        $params = [];
        // Add condition to show only client projects
        if (strstr($_SERVER['REQUEST_URI'], "Client")) {
            $query .= " AND p.id_utilisateur = :user_id";
            $params['user_id'] = $_SESSION['user_loged_in_id'];
        }

        // Add filter by category if not 'all'
        if ($filter_by_cat !== 'all') {
            $query .= " AND c.nom_categorie = :filter_by_cat";
            $params['filter_by_cat'] = $filter_by_cat;
        }

        // Add filter by subcategory if not 'all'
        if ($filter_by_sub_cat !== 'all') {
            $query .= " AND sc.nom_sous_categorie = :filter_by_sub_cat";
            $params['filter_by_sub_cat'] = $filter_by_sub_cat;
        }

        // Add filter by status if not 'all'
        if (!empty($filter_by_status) && $filter_by_status !== 'all') {
            $query .= " AND p.project_status = :filter_by_status";
            $params['filter_by_status'] = $filter_by_status;
        }

        // Add search condition if a search term is provided
        if ($projectToSearch) {
            $query .= " AND p.titre_projet LIKE :search_term";
            $params['search_term'] = "%$projectToSearch%";
        }

        // Prepare and execute the query
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);

        // Fetch and return results
        $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $projects;
    }

    // creat project method
    public function createProject($project_title,$project_description,$project_category,$project_subcategory){
        try {
            $addProjectQuery = $this->conn->prepare("INSERT INTO projets (titre_projet, description, id_categorie, id_sous_categorie, id_utilisateur) 
                                            VALUES (:project_title, :project_description, :project_category, :project_subcategory, :user_id)");
            $addProjectQuery->execute([
                ':project_title' => $project_title,
                ':project_description' => $project_description,
                ':project_category' => $project_category,
                ':project_subcategory' => $project_subcategory,
                ':user_id' => $_SESSION['user_loged_in_id']  // Use the logged-in user's ID
            ]);
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
        }
    }

    // update project
    public function updateProject($project_title,$project_description,$project_category,$project_subcategory,$project_status,$project_id){
        try {
            $modifyProjectQuery = $this->conn->prepare("UPDATE projets SET titre_projet = ?, description = ?, id_categorie = ?, id_sous_categorie = ?,project_status=?
                                                WHERE id_projet = ?");
            $modifyProjectQuery->execute([
                $project_title, 
                $project_description, 
                $project_category, 
                $project_subcategory,
                $project_status,
                $project_id
            ]);
            echo "Project updated successfully!";
            header("Location: ../../Client/my_projects.php");
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
        }
    }

    // methode to delete a project
    function removeProject($idProject){
        try{
            $deleteProject = $this->conn->prepare("DELETE FROM projets WHERE id_projet=?");
            $deleteProject->execute([$idProject]);
        }
        catch (PDOException $e){
            error_log("Error deleting project with ID $idProject: " . $e->getMessage());
        }
    }
    
    // metjode to get project applied for by a freelancer
    function getAppliedProjects() {
        $user_id = $_SESSION['user_loged_in_id'];

        $query = $this->conn->prepare("SELECT id_projet FROM offres WHERE id_utilisateur = ?");
        $query->execute([$user_id]);
        $appliedProjects = $query->fetchAll(PDO::FETCH_COLUMN);

        return $appliedProjects; // Return project IDs as an array
    }
}
