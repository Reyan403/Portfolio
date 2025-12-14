<?php

namespace Service;

Class PlayerHasTeamFormValidate extends Errors 
{ 
    // METHODES
    public function champVide() : void 
    {
        if(empty($_POST['player']))
        {
            $this->errors['player'] = "Le joueur est obligatoire.";
        }

        if(empty($_POST['team']))
        {
            $this->errors['team'] = "L'équipe est obligatoire.";
        }

        if(empty($_POST['role']))
        {
            $this->errors['role'] = "Le rôle est obligatoire.";
        }
    }

}