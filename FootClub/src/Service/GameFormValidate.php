<?php

namespace Service;

Class GameFormValidate extends Errors
{
    public function champVide(): void
    {
        if (empty($_POST['teamScore'])) {
            $this->errors['teamScore'] = "Le score de l'équipe est obligatoire.";
        }

        if (empty($_POST['opponentScore'])) {
            $this->errors['opponentScore'] = "Le score de l'adversaire est obligatoire.";
        }

        if (empty($_POST['date'])) {
            $this->errors['date'] = "La date du match est obligatoire.";
        }

        if (empty($_POST['city'])) {
            $this->errors['city'] = "La ville est obligatoire.";
        }

        if (empty($_POST['teamMatch'])) {
            $this->errors['teamMatch'] = "L'équipe est obligatoire.";
        }

        if (empty($_POST['opponentClubMatch'])) {
            $this->errors['opponentClubMatch'] = "Le club adverse est obligatoire.";
        }
    }

    public function caracteresSpeciaux(): void
    {
        if (!empty($_POST['city']) && !preg_match('/^[A-Za-zÀ-ÖØ-öø-ÿ\s-]+$/u', $_POST['city'])) {
            $this->errors['city'] = "La ville ne doit contenir que des lettres.";
        }
    }
}