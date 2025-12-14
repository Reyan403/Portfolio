<?php

namespace Enumeration;

enum PlayerRole : string 
{
    case ATTAQUANT = 'Attaquant';
    case DEFENSEUR = 'Defenseur';
    case MILIEU = 'Milieu';
    case GARDIEN = 'Gardien';
}