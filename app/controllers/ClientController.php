<?php
require_once(__DIR__ . '/../models/User.php');
require_once(__DIR__ . '/../models/Project.php');
require_once(__DIR__ . '/../models/Testimonials.php');
require_once(__DIR__ . '/../models/Category.php');
require_once(__DIR__ . '/../models/SubCategory.php');
require_once(__DIR__ . '/../models/Offers.php');
class ClientController extends BaseController
{
    // private $UserModel;
    private $ProjectModel;
    private $TestimonialModel;
    private $CategoryModel;
    private $SubCategoryModel;
    private $OfferModel;

    public function __construct()
    {
        // $this->UserModel = new User();
        $this->ProjectModel = new Project();
        $this->TestimonialModel = new Testimonials();
        $this->CategoryModel = new Category();
        $this->SubCategoryModel = new SubCategory();
        $this->OfferModel = new Offer();
    }

    // =========================================================== projects methods ===========================================
    // show all projects
    public function myprojects()
    {
        $filter_by_cat = isset($_GET['filter_by_cat']) ? $_GET['filter_by_cat'] : 'all';
        $filter_by_sub_cat = isset($_GET['filter_by_sub_cat']) ? $_GET['filter_by_sub_cat'] : 'all';
        $projectToSearch = isset($_GET['projectToSearch']) ? $_GET['projectToSearch'] : '';
        $filter_by_status = isset($_GET['filter_by_status']) ? $_GET['filter_by_status'] : '';

        $projects = $this->ProjectModel->allProjects($filter_by_cat, $filter_by_sub_cat, $filter_by_status, $projectToSearch);
        $categories = $this->CategoryModel->getCategoriesWithSubcategories();
        $subcategories = $this->SubCategoryModel->showSubCategories();

        $this->renderDashboard('client/projects', ["projects" => $projects,"categories"=>$categories,"subcategories"=>$subcategories]);
    }
    // Add or modify project code
    public function addModifyProject(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["save_project"])) {
    
                $project_title = trim($_POST["project_title_input"]);
                $project_description = trim($_POST["project_description_input"]);
                $project_category = $_POST["project_category_input"];
                $project_subcategory = $_POST["project_subcategory_input"];
                $project_id = isset($_POST["project_id_input"]) ? trim($_POST["project_id_input"]) : 0;
                $project_status=(int)$_POST["project_status_input"];
    
                // Check if required fields are not empty
                if (!empty($project_title) && !empty($project_description) && !empty($project_category) && !empty($project_subcategory)) {
                    // Add new project if no ID provided
                    if ($project_id == 0) {
                        $this->ProjectModel->createProject($project_title,$project_description,$project_category,$project_subcategory);
                    }
                    // Modify existing project if ID is provided
                    else {
                        $this->ProjectModel->updateProject($project_title,$project_description,$project_category,$project_subcategory,$project_status,$project_id);
                    }
                    header("Location: /client/projects");
                } else {
                    echo "Please fill in all fields.";
                }
            }
        }
    }
    
    // delete a project
   public function removeProject()
   {
      if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_project'])) {
         $idProject = $_POST['id_projet'];
         $this->ProjectModel->removeProject($idProject);
         header("Location: /client/projects");
         exit();
      }
   }

    // // =========================================================== offres methods ===========================================
    // show offers
    public function clientOffers()
    {
        $client_offers = $this->OfferModel->clientOffers();
        $id_offre_having_testimonial = $this->TestimonialModel->getClientTestimonialsIds();
        // var_dump($id_offre_having_testimonial);
        // die();
        $this->renderDashboard('client/offers', ["client_offers"=>$client_offers,"id_offre_having_testimonial"=>$id_offre_having_testimonial]);
    }
    
    // accept an offer
    public function acceptOffre(){
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accept_offre'])) {
            $idOffre = (int)$_POST['id_offre'];
            $this->OfferModel->acceptOffre($idOffre);
            header("Location: /client/offers");
            exit();
        }
    }

    // // =========================================================== testimonials methods ===========================================

    // add or modify a testimoial
    
    public function addModifyTestimonial(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['save_testimonial'])) {
                // Retrieve and sanitize form inputs
                $idTemoignage = isset($_POST['testimonial_id_input']) ? intval(trim($_POST['testimonial_id_input'])) : 0;
                $commentaire = isset($_POST['commentaire_input']) ? trim($_POST['commentaire_input']) : '';
                $idOffre = isset($_POST['offre_id_input']) ? intval(trim($_POST['offre_id_input'])) : 0;
                $idUtilisateur = $_SESSION['user_loged_in_id']; // Logged-in user ID
        
                // Validate inputs
                if (!empty($commentaire) && $idOffre >= 0) {
                    if ($idTemoignage == 0) { // Add new testimonial
                        $this->TestimonialModel->createTestimonila($commentaire, $idUtilisateur, $idOffre);
                        header("Location: /client/offers");
                    } else { 
                        // Modify existing testimonial
                        $this->TestimonialModel->updateTestimonial($commentaire, $idTemoignage);
                        header("Location: /client/testimonials");
                    }
                } else {
                    echo "Please fill in all required fields.";
                }
            }
        }
    }
    // show all testimonials
    public function testimonials()
    {
        $userId = $_SESSION['user_loged_in_id'] ?? null; // Use null for Admin
        $clientTestimonials  = $this->TestimonialModel->getClientTestimonials("Client", $userId);
        $this->renderDashboard('/client/testimonials', ["clientTestimonials" => $clientTestimonials ]);
    }

    // remove testimonial
    public function removeTestimonial()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_testimonial'])) {
            $idtesTimonial = $_POST['id_temoignage'];
            $this->TestimonialModel->removeTestimonial($idtesTimonial);
            header("Location: /client/testimonials");
            exit();
        }
    }
}
