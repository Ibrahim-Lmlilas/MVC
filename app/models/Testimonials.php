<?php
require_once(__DIR__ . '/../config/db.php');
class Testimonials extends Db
{

    public function __construct()
    {
        parent::__construct();
    }

    // create testimonial metos
    public function createTestimonila($commentaire, $idUtilisateur, $idOffre){
        try{
            $query = $this->conn->prepare("INSERT INTO temoignages (commentaire, id_utilisateur, id_offre) VALUES (?, ?, ?)");
            $query->execute([$commentaire, $idUtilisateur, $idOffre]);
        }
        catch(PDOException $e){
            echo "error: ".$e;
        }
    }
    // udate tetimonial
    public function updateTestimonial($commentaire, $idTemoignage){
        $query = $this->conn->prepare("UPDATE temoignages SET commentaire = ? WHERE id_temoignage = ?");
        $query->execute([$commentaire, $idTemoignage]);
    }
    // methode to see all testimonials
    function allTestimonials() {
        // Base query
        $queryStr = "SELECT p.titre_projet, t.commentaire, t.id_temoignage, o.montant, o.delai, o.id_offre
                    FROM temoignages t
                    JOIN offres o ON t.id_offre = o.id_offre
                    JOIN projets p ON o.id_projet = p.id_projet";

        $query = $this->conn->prepare($queryStr);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // methode to delete a testimonal
    public function removeTestimonial($idtesTimonial){
        $removeTestimonial = $this->conn->prepare("DELETE FROM temoignages WHERE id_temoignage=?");
        $removeTestimonial->execute([$idtesTimonial]);
    }

    // methode to get client testimonials ids
    public function getClientTestimonialsIds() {
        $user_id = $_SESSION['user_loged_in_id'];
        $query = $this->conn->prepare("SELECT o.id_offre AS id_offre_having_testimonial
                                 FROM offres o
                                 INNER JOIN temoignages t ON t.id_offre = o.id_offre
                                 WHERE t.id_utilisateur = ?;");
        $query->execute([$user_id]);
        
        // Fetch only the id_offre column
        $id_offre_having_testimonial = $query->fetchAll(PDO::FETCH_COLUMN, 0);
    
        return $id_offre_having_testimonial;
    }

    // methode to get client testimonials
    public function getClientTestimonials($role, $userId = null) {
        // Base query
        $queryStr = "SELECT p.titre_projet, t.commentaire, t.id_temoignage, o.montant, o.delai, o.id_offre
                    FROM temoignages t
                    JOIN offres o ON t.id_offre = o.id_offre
                    JOIN projets p ON o.id_projet = p.id_projet";

        // Modify query based on the role
        $params = [];
        if ($role === 'Freelancer') {
            $queryStr .= " WHERE o.id_utilisateur = ?";
            $params[] = $userId;
        } elseif ($role === 'Client') {
            $queryStr .= " WHERE p.id_utilisateur = ?";
            $params[] = $userId;
        }
        // Admin has no additional conditions, so no modification to the query

        // Prepare and execute the query
        $query = $this->conn->prepare($queryStr);
        $query->execute($params);

        // Fetch and return results
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
