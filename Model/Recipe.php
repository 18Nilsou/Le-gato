<?php

class Recipe{

    public static function create(array $A_postParams):array{
        $B_receive = Model::create($A_postParams, "recipe");
        if($B_receive){
            return array('message' => "Recette crée", 'status' => true);
        }
        return array('message' => "Recette non crée", 'status' => false);
    }

    /**
     * @param $A_postParams
     * @return array
     */
    public static function delete(int $I_id):array{
        $B_receive = Model::deleteById($I_id, "recipe");
        if($B_receive){
            return array('message' => "Recette supprimé", 'status' => true);
        }
        return array('message' => "Erreur de supression", 'status' => false);
    }

    /**
     * @param $A_postParams
     * @return array
     */
    public static function update(array $A_postParams):array{
        $B_receive = Model::updateById($A_postParams, "recipe");
        if($B_receive){
            return array('message' => "Changements enregistrés", 'status' => true);
        }
        return array('message' => "Erreur d'enregistrement", 'status' => false);
    }

    /**
     * @param $A_postParams
     * @return mixed
     */
    public static function selectById(int $I_id):array{
        return Model::selectById($I_id, "RECIPE");
    }

    /**
     * @return array
     */
    public static function randomRecipe():array{
        $I_IdMax = Model::selectHowMany("RECIPE");
        $A_usedId = array();
        $A_id = array();
        while (sizeof($A_id) < 3) {
            $I_randomId = rand(1, $I_IdMax);
            if(!in_array($I_randomId, $A_usedId)) {
                $A_id[] = $I_randomId;
                $A_usedId[] = $I_randomId;
            }
        }
        $A_data = array();
        foreach ($A_id as $I_id){
            $A_data[] = self::selectById($I_id, "RECIPE");
        }
        return $A_data;
    }

    public static function selectRecipeByUser(array $A_postParams):array{
        $I_id = $A_postParams['id'];
        $O_con = Model::initConnection();
        $S_sql = "SELECT * FROM RECIEPE WHERE user_id = :user";
        $sth = $O_con->prepare($S_sql);
        $sth->execute();
        $sth->bindValue(':user', $I_id, PDO::PARAM_INT);
        return $sth->fetchAll();
    }

}