<?php
require_once(__DIR__ . '/../config/db.php');
class Offer extends Db
{

    public function __construct()
    {
        parent::__construct();
    }
    // creaate offer methode
    public function createOffer($montant,$delai,$user_id,$project_id){
        try {
            $addOfferQuery = $this->conn->prepare("INSERT INTO offres (montant, delai, id_utilisateur, id_projet) 
                                            VALUES (:montant, :delai, :user_id, :project_id)");
            $addOfferQuery->execute([
                ':montant' => $montant,
                ':delai' => $delai,
                ':user_id' => $user_id,
                ':project_id' => $project_id
            ]);
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
        } 
    }

    // update offer methode
    public function updateDOffer($montant,$delai,$offer_id){
        try {
            $modifyOfferQuery = $this->conn->prepare("UPDATE offres SET montant = ?, delai = ?
                                                WHERE id_offre = ?");
            $modifyOfferQuery->execute([
                $montant, 
                $delai, 
                $offer_id
            ]);
            echo "Offer updated successfully!";
            header("Location: ../../Freelancer/my_offers.php"); // Redirect after success
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
        }
    }
    // methode to get client offers
    public function clientOffers(){
        $user_id = $_SESSION['user_loged_in_id'];
        $query = $this->conn->prepare("SELECT o.delai,o.montant,o.id_offre,o.id_utilisateur,o.id_projet,o.status,p.titre_projet FROM offres o
                                JOIN projets p ON p.id_projet=o.id_projet
                                WHERE p.id_utilisateur=?
                                AND o.status!=3;");
        $query->execute([$user_id]);
        $client_offers = $query->fetchAll(PDO::FETCH_ASSOC);
        return $client_offers;
    }

    // methode to get freelancer offers
    function getFreelancerOffres() {
        $user_id = $_SESSION['user_loged_in_id'];
        $query = $this->conn->prepare("SELECT o.delai,o.montant,o.id_offre,o.id_utilisateur,o.id_projet,o.status,p.titre_projet FROM offres o
                                JOIN projets p ON p.id_projet=o.id_projet
                                WHERE o.id_utilisateur=?;");
        $query->execute([$user_id]);
        $freelancer_offers = $query->fetchAll(PDO::FETCH_ASSOC);

        return $freelancer_offers;
    }
    // methode to accept an offer
    public function acceptOffre($idOffre){
        $acceptOffre = $this->conn->prepare("UPDATE offres
                                        SET status=2
                                        WHERE id_offre=?");
        $acceptOffre->execute([$idOffre]);
    }

    // methode to delete an offer
    public function deleteOffer($idOffre){
        $removeOffre = $this->conn->prepare("DELETE FROM offres WHERE id_offre=?");
        $removeOffre->execute([$idOffre]);
    }
}
