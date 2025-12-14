<?php

namespace Service;

Class PlayerFormValidate extends Errors
{
    // METHODES
    public function champVide() : void 
    {
        if(empty($_POST['firstname'])) 
        {
             $this->errors['firstname'] = "Le prénom est obligatoire.";
        }

        if(empty($_POST['lastname']))
        {
            $this->errors['lastname'] = "Le nom est obligatoire.";
        }

        if(empty($_POST['birthdate']))
        {
            $this->errors['birthdate'] = "La date d'anniversaire est obligatoire.";
        }
    }

    public function caracteresSpeciaux(): void
    {
        if (!empty($_POST['firstname']) && !preg_match('/^[A-Za-zÀ-ÖØ-öø-ÿ\s-]+$/u', $_POST['firstname'])) {
            $this->errors['firstname'] = "Le prénom ne doit contenir que des lettres.";
        }

        if (!empty($_POST['lastname']) && !preg_match('/^[A-Za-zÀ-ÖØ-öø-ÿ\s-]+$/u', $_POST['lastname'])) {
            $this->errors['lastname'] = "Le nom ne doit contenir que des lettres.";
        }
    }
}