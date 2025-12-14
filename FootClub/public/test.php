<?php 

/*
require_once __DIR__ . '/../Autoloader.php';
Autoloader::register();

// Connexion
require_once __DIR__ . '/../src/Model/db.php';

use Model\Team;
use Model\Game;
use Model\OpposingClub;
use Model\Player;
use Model\StaffMember;
use Model\PlayerHasTeam;

use DAO\GameDAO;
use DAO\TeamDAO;
use DAO\OpposingClubDAO;
use DAO\PlayerDAO;
use DAO\PlayerHasTeamDAO;
use DAO\StaffMemberDAO;

$teamDAO = new TeamDAO($connexion);
$opponentDAO = new OpposingClubDAO($connexion);
$playerDAO = new PlayerDAO($connexion);
$relationDAO = new PlayerHasTeamDAO($connexion);
$gameDAO = new GameDAO($connexion);
$staffDAO = new StaffMemberDAO($connexion);

// --- Equipes ---
$teams = [
    new Team(null, "Paris"),
    new Team(null, "Barça"),
    new Team(null, "Real Madrid")
];

foreach ($teams as $team) {
    $teamDAO->insert($team);
    $team->setId($connexion->lastInsertId());
}

// --- Joueurs ---
$players = [
    new Player(null, "Kylian", "Mbappé", new DateTime("1998-12-20"), "mbappe.png"),
    new Player(null, "Lionel", "Messi", new DateTime("1987-06-24"), "messi.png"),
    new Player(null, "Sergio", "Ramos", new DateTime("1986-03-30"), "ramos.png"),
    new Player(null, "Neymar", "Jr", new DateTime("1992-02-05"), "neymar.png")
];

foreach ($players as $player) {
    $playerDAO->insert($player);
    $player->setId($connexion->lastInsertId());
}

// --- Relations joueur-équipe (multi-possibilités) ---
$relations = [
    new PlayerHasTeam($players[0], $teams[0], "Attaquant"), 
    new PlayerHasTeam($players[0], $teams[1], "Milieu"),    
    new PlayerHasTeam($players[1], $teams[1], "Milieu"),    
    new PlayerHasTeam($players[1], $teams[2], "Attaquant"), 
    new PlayerHasTeam($players[2], $teams[2], "Défenseur"), 
    new PlayerHasTeam($players[3], $teams[0], "Attaquant"), 
    new PlayerHasTeam($players[3], $teams[1], "Attaquant")  
];

foreach ($relations as $relation) {
    $relationDAO->insert($relation);
    $relation->getPlayer()->addTeam($relation);
}

// --- Clubs adverses ---
$opponents = [
    new OpposingClub(null, "123 rue du Stade", "Paris"),
    new OpposingClub(null, "456 avenue du Parc", "Lyon"),
    new OpposingClub(null, "789 boulevard Central", "Madrid")
];

foreach ($opponents as $opponent) {
    $opponentDAO->insert($opponent);
    $opponent->setId($connexion->lastInsertId());
}

// --- Matchs (chaque équipe contre différents clubs) ---
$matches = [
    new Game(null, new DateTime("2023-09-15 18:00:00"), "Lyon", 3, 2, $teams[0], $opponents[0]),
    new Game(null, new DateTime("2023-10-01 20:00:00"), "Marseille", 1, 1, $teams[1], $opponents[1]),
    new Game(null, new DateTime("2023-11-10 19:30:00"), "Madrid", 2, 2, $teams[2], $opponents[2]),
    new Game(null, new DateTime("2023-12-05 21:00:00"), "Paris", 4, 1, $teams[0], $opponents[1]),
    new Game(null, new DateTime("2024-01-15 18:00:00"), "Barça", 2, 0, $teams[1], $opponents[0])
];

foreach ($matches as $match) {
    $gameDAO->insert($match);
    $match->setId($connexion->lastInsertId());
}

// --- Membres du staff ---
$staffMembers = [
    new StaffMember(null, "Zinedine", "Zidane", "zidane.png", "Entraîneur"),
    new StaffMember(null, "Didier", "Deschamps", "deschamps.png", "Assistant"),
    new StaffMember(null, "Pep", "Guardiola", "guardiola.png", "Coach"),
    new StaffMember(null, "Carlo", "Ancelotti", "ancelotti.png", "Physio")
];

foreach ($staffMembers as $staff) {
    $staffDAO->insert($staff);
    $staff->setId($connexion->lastInsertId());
}

*/

?>
