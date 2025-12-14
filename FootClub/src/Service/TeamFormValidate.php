<?php

namespace Service;

class TeamFormValidate extends Errors
{
    // METHODES
    public function champVide(): void 
    {
        if (empty($_POST['name']))
        {
            $this->errors['name'] = "Le nom de l'équipe est obligatoire";
        }
    }

    public function caracteresSpeciaux(): void 
    {
        if (!empty($_POST['name']) && !preg_match('/^[A-Za-zÀ-ÖØ-öø-ÿ\s-]+$/u', $_POST['name']))  
        {
            $this->errors['name'] = "Le nom de l'équipe ne doit contenir que des lettres";
        }
    }
}