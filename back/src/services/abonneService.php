<?php


 class AbonneService  {

    public static function GetPanier()
    {
        $bd= new Database(DB_DVD);
        
        $panier= new Location($bd);
        
		return $panier->getPanier();
    }
    
    public static function SavePanier()
    {
        $bd= new Database(DB_DVD);
        $panier= new Location($bd);
        if ($bd->beginTransaction())
        {
            $client = json_decode($_SESSION["client"]);
            if (!$panier->checkClient($client))
            {
                $bd->rollBack();
                return "Votre abonnement ne permet pas d'avoir de louer ces dvds.";
            }
            
            
            if (!$panier->add($client))
            {
                $bd->rollBack();
                return "Votre location n'est pas possible. Des Dvds ne sont pas en stock";
            }
            
            
            
            if ($bd->commit())
                return "";
            
            
            $bd->rollBack();
        }
        return  "Erreur serveur";
    }
	
    
   

}