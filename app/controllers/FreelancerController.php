<?php
require_once(__DIR__ . '/../models/User.php');
require_once(__DIR__ . '/../models/Project.php');
require_once(__DIR__ . '/../models/Testimonials.php');
require_once(__DIR__ . '/../models/Category.php');
require_once(__DIR__ . '/../models/SubCategory.php');
require_once(__DIR__ . '/../models/Offers.php');
class FreelancerController extends BaseController
{
   private $UserModel;
   private $ProjectModel;
   private $TestimonialModel;
   private $CategoryModel;
   private $SubCategoryModel;
   private $OfferModel;

   public function __construct()
   {
      $this->UserModel = new User();
      $this->ProjectModel = new Project();
      $this->TestimonialModel = new Testimonials();
      $this->CategoryModel = new Category();
      $this->SubCategoryModel = new SubCategory();
      $this->OfferModel = new Offer();
   }

   // =========================================================== projects methods ===========================================
   // show all projects
   public function Allprojects()
   {
      $filter_by_cat = isset($_GET['filter_by_cat']) ? $_GET['filter_by_cat'] : 'all';
      $filter_by_sub_cat = isset($_GET['filter_by_sub_cat']) ? $_GET['filter_by_sub_cat'] : 'all';
      $projectToSearch = isset($_GET['projectToSearch']) ? $_GET['projectToSearch'] : '';
      $filter_by_status = isset($_GET['filter_by_status']) ? $_GET['filter_by_status'] : '';

      $projects = $this->ProjectModel->allProjects($filter_by_cat, $filter_by_sub_cat, $filter_by_status, $projectToSearch);
      $categories = $this->CategoryModel->getCategoriesWithSubcategories();
      $subcategories = $this->SubCategoryModel->showSubCategories();
      $appliedProjects = $this->ProjectModel->getAppliedProjects();

      $this->renderDashboard('freelancer/projects', ["projects" => $projects, "categories" => $categories, "subcategories" => $subcategories, "appliedProjects" => $appliedProjects]);
   }

   // =========================================================== offers methods ===========================================
   // Add or modify offer code
   public function addModifyOffer()
   {
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
         if (isset($_POST["add_offre"])) {
            $montant = isset($_POST["montant_input"]) ? trim($_POST["montant_input"]) : '';
            $delai = isset($_POST["delai_input"]) ? trim($_POST["delai_input"]) : '';
            $user_id = $_SESSION['user_loged_in_id'];  // Use the logged-in user's ID
            $project_id = isset($_POST["project_id_input"]) ? trim($_POST["project_id_input"]) : '';
            $offer_id = isset($_POST["offre_id_input"]) ? trim($_POST["offre_id_input"]) : 0;

            if ($offer_id == 0) {
               $this->OfferModel->createOffer($montant, $delai, $user_id, $project_id);
               header("Location: /freelancer/projects");
            }
            // Modify existing offer if an offer ID is provided
            else {
               $this->OfferModel->updateDOffer($montant, $delai, $offer_id);
               header("Location: /freelancer/offers");
            }
         }
      }
   }

   // show freelancer offers
   public function freelancerOffers()
   {
      $freelancer_offers = $this->OfferModel->getFreelancerOffres();
      $this->renderDashboard('freelancer/offers', ["freelancer_offers" => $freelancer_offers]);
   }

   // delete an offer
   public function deleteOffer(){
      if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_offre'])) {
         $idOffre = $_POST['id_offre'];
         $this->OfferModel->deleteOffer($idOffre);
         // Redirect to avoid form resubmission after page reload
         header("Location: /freelancer/offers");
         exit();
     }
   }

   // =========================================================== testimonials methods ===========================================
   // show freelncaer testimonials
   public function testimonials()
    {
        $userId = $_SESSION['user_loged_in_id'] ?? null; // Use null for Admin
        $clientTestimonials  = $this->TestimonialModel->getClientTestimonials("Freelancer", $userId);
        $this->renderDashboard('/freelancer/testimonials', ["clientTestimonials" => $clientTestimonials ]);
    }
}
