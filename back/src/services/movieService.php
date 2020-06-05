<?php

use Prophecy\Call\Call;


 class MovieService  {

    public static function Check($email,$pwd)
    {
        $bd= new Database(DB_DVD);
        $user= new UserApp($bd);
        $user->getbyLogin($email);
        $user->checkPwd($pwd);
		return $user;
	}
	
    public static function GetCategorie($bdd, $id)
    {
        $category = new Category($bdd);
        $category->getbyId($id);
        return $category;
    }

    public static function GetGenre($bdd, $idMovie)
    {
        $genre = new Genre($bdd);
        return $genre->getMovieGenre($idMovie);
    }

    public static function GetMovieById( $idMovie, $bdd)
    {
        if (isset($bdd))
        {
            $movie= new Movie($bdd);
        }
        else{
            $bd= new Database(DB_DVD);
            $movie= new Movie($bd);
        }
        
        $movie->getbyId($idMovie);
        return $movie;
    }

    public static function GetMovieStockById( $idMovie, $bdd)
    {
        if (isset($bdd))
        {
            $movieSt= new MovieStock($bdd);
        }
        else{
            $bd= new Database(DB_DVD);
            $movieSt= new MovieStock($bd);
        }
        
        $movieSt->getbyIdMovie($idMovie);
        return $movieSt;
    }

    public static function GetTop4(){
        $bd= new Database(DB_DVD);
        $movie= new Movie($bd);
        return $movie->getTop4('top');
    }

    public static function GetChild4(){
        $bd= new Database(DB_DVD);
        $movie= new Movie($bd);
        return $movie->getTop4('child');
    }

    public static function GetBest4(){
        $bd= new Database(DB_DVD);
        $movie= new Movie($bd);
        return $movie->getTop4('best');
    }

    public static function GetAllForfait(){
        $bd= new Database(DB_DVD);
        $forfait= new Forfait($bd);
        return $forfait->getAll();
    }

    public static function GetAllGenre(){
        $bd= new Database(DB_DVD);
        $genre= new Genre($bd);
        return $genre->getAll();
    }
    public static function GetAllCategorie(){
        $bd= new Database(DB_DVD);
        $categorie= new Category($bd);
        return $categorie->getAll();
    }

    public static function GetAllMovie($filter){
        $bd= new Database(DB_DVD);
        $movie= new Movie($bd);
        return $movie->getAllSearch($filter);
    }

    public static function SaveMovie($movieSend){
        $bd= new Database(DB_DVD);
        $movie= new Movie($bd);
        if ($bd->beginTransaction())
        {
            if (isset($movieSend->id)&& $movieSend->id!=("0"))
            {
                if ($movie->update($movieSend))
                {
                    $movieStock = new MovieStock($bd);
                    $movieStock->getbyIdMovie($movie->getId());
                    $movieSend->idstock = $movieStock->getId();
                    if ($movieStock->update($movieSend))
                    {
                        if ($bd->commit())
                        return true;
                    }
                }
            }
            else 
            {
                if ($movie->add($movieSend))
                {
                    $movieStock = new MovieStock($bd);
                    if ($movieStock->add($movie->getId(),$movieSend))
                    {
                        if ($bd->commit())
                        return true;
                    }
                }
            }
            $bd->rollBack();    
        }
        return  false;
    }
}