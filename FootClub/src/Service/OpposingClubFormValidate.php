<?php

namespace Service;

class OpposingClubFormValidate extends Errors
{
    // METHODES 
    public function champVide(): void 
    {
        if(empty($_POST['city'])) 
        {
            $this->errors['city'] = "La ville est obligatoire";
        }

        if(empty($_POST['address'])) 
        {
            $this->errors['address'] = "L'adresse est obligatoire";
        }
    }
    
    public function caracteresSpeciaux() : void 
    {
        if (!empty($_POST['city']) && !preg_match('/^[A-Za-zÀ-ÖØ-öø-ÿ\s-]+$/u', $_POST['city'])) {
            $this->errors['city'] = "La ville ne doit contenir que des lettres.";
        }
    }
}