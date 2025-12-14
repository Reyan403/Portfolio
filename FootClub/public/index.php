<?php
    require __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../src/Model/db.php';

    use DAO\PlayerDAO;
    use DAO\TeamDAO;
    use DAO\OpposingClubDAO;
    use DAO\PlayerHasTeamDAO;
    use DAO\GameDAO;

    $playerDAO = new PlayerDAO($connexion); 
    $players = $playerDAO->getAll();

    $teamDAO = new TeamDAO($connexion);
    $teams = $teamDAO->getAll();

    $opposingClubDAO = new OpposingClubDAO($connexion);
    $opposingClubs = $opposingClubDAO->getAll();

    $playerHasTeamDAO = new PlayerHasTeamDAO($connexion);
    $playerHasTeams = $playerHasTeamDAO->getAll();

    $gameDAO = new GameDAO($connexion);
    $games = $gameDAO->getAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Tableau de bord</title>
</head>

<body>

    <section class="players">
        <h1>Liste des joueurs</h1>
        <a href="Player/PlayerForm.php" class="btn-add">Ajouter un joueur</a>

        <table>
            <thead>
                <tr>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Date de naissance</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php for ($i = 0; $i < count($players); $i++): ?>
                <?php $player = $players[$i]; ?>
                <tr>
                    <td><?= htmlspecialchars($player->getFirstname()) ?></td>
                    <td><?= htmlspecialchars($player->getLastname()) ?></td>
                    <td><?= htmlspecialchars($player->getBirthdate()->format('d/m/Y')) ?></td>
                    <td class="action-links">
                        <a href="Player/EditPlayer.php?id=<?= $player->getId() ?>" class="btn-edit">Éditer</a>
                        <a href="Player/DeletePlayer.php?id=<?= $player->getId() ?>"
                        class="btn-delete"
                        onclick="return confirm('Voulez-vous vraiment supprimer ce joueur ?');">
                        Supprimer
                        </a>
                    </td>
                </tr>
            <?php endfor; ?>
            </tbody>
        </table>
    </section>

    <section class="team">
        <h1>Liste des équipes</h1>
        <a href="Team/TeamForm.php" class="btn-add">Ajouter une équipe</a>

        <table>
            <thead>
                <tr>
                    <th>Equipes</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php for ($i = 0; $i < count($teams); $i++): ?>
                <?php $team = $teams[$i]; ?>
                <tr>
                    <td><?= htmlspecialchars($team->getName()) ?></td>
                    <td class="action-links">
                        <a href="Team/EditTeam.php?id=<?= $team->getId() ?>" class="btn-edit">Éditer</a>
                        <a href="Team/DeleteTeam.php?id=<?= $team->getId() ?>"
                        class="btn-delete"
                        onclick="return confirm('Voulez-vous vraiment supprimer ce joueur ?');">
                        Supprimer
                        </a>
                    </td>
                </tr>
            <?php endfor; ?>
            </tbody>
        </table>
    </section>

    <section class="opposing_team">
        <h1>Liste des équipes adverses</h1>
        <a href="OpponentTeam/OpposingClubForm.php" class="btn-add">Ajouter une équipe adverse</a>

        <table>
            <thead>
                <tr>
                    <th>Villes</th>
                    <th>Adresses</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php for ($i = 0; $i < count($opposingClubs); $i++): ?>
                <?php $opposingClub = $opposingClubs[$i]; ?>
                <tr>
                    <td><?= htmlspecialchars($opposingClub->getCity()) ?></td>
                    <td><?= htmlspecialchars($opposingClub->getAddress()) ?></td>
                    <td class="action-links">
                        <a href="OpponentTeam/EditOpposingClub.php?id=<?= $opposingClub->getId() ?>" class="btn-edit">Éditer</a>
                        <a href="OpponentTeam/DeleteOpposingClub.php?id=<?= $opposingClub->getId() ?>"
                        class="btn-delete"
                        onclick="return confirm('Voulez-vous vraiment supprimer ce joueur ?');">
                        Supprimer
                        </a>
                    </td>
                </tr>
            <?php endfor; ?>
            </tbody>
        </table>
    </section>

    <section class="list">
        <h1>Liste des joueurs avec une équipe</h1>
        <a href="PlayerHasTeam/PlayerHasTeamForm.php" class="btn-add">Ajouter un joueur avec une équipe</a>

        <table>
            <thead>
                <tr>
                    <th>Joueur</th>
                    <th>Équipe</th>
                    <th>Rôle</th>
                    <th></th>
                </tr>
            </thead>
                <tbody>
            <?php for ($i = 0; $i < count($playerHasTeams); $i++): ?>
                <?php $playerHasTeam = $playerHasTeams[$i]; ?>
                <tr>
                    <td>
                        <?= htmlspecialchars($playerHasTeam['player_firstname'] . ' ' . $playerHasTeam['player_lastname']) ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($playerHasTeam['team_name']) ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($playerHasTeam['role']) ?>
                    </td>
                    <td class="action-links">
                        <a href="PlayerHasTeam/EditPlayerHasTeam.php?player_id=<?= $playerHasTeam['player_id'] ?>&team_id=<?= $playerHasTeam['team_id'] ?>" class="btn-edit">
                            Éditer
                        </a>

                        <a href="PlayerHasTeam/DeletePlayerHasTeam.php?player_id=<?= $playerHasTeam['player_id'] ?>&team_id=<?= $playerHasTeam['team_id'] ?>" 
                        class="btn-delete"
                        onclick="return confirm('Voulez-vous vraiment supprimer cette relation joueur/équipe ?');">
                            Supprimer
                        </a>
                    </td>
                </tr>
            <?php endfor; ?>
            </tbody>
        </table>
    </section>

    <section class="match">
        <h1>Liste des matchs</h1>
        <a href="Game/GameForm.php" class="btn-add">Ajouter un match</a>

        <table>
            <thead>
                <tr>
                    <th>Équipe</th>
                    <th>Équipe adverse</th>
                    <th>Score du match</th>
                    <th>Ville</th>
                    <th>Date du match</th>
                    <th></th>
                </tr>
            </thead>
                <tbody>
            <?php for ($i = 0; $i < count($games); $i++): ?>
                <?php $game = $games[$i]; ?>
                <tr>
                    <td>
                        <?= htmlspecialchars($game->getTeam()->getName()) ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($game->getOpposingClub()->getCity()) ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($game->getTeamScore() . ' - ' . $game->getOpponentScore()) ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($game->getCity()) ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($game->getDate()->format('d/m/Y')) ?>
                    </td>
                    <td class="action-links">
                        <a href="Game/EditGame.php?id=<?= $game->getId() ?>" class="btn-edit">Éditer</a>
                        <a href="Game/DeleteGame.php?id=<?= $game->getId() ?>" class="btn-delete"
                        onclick="return confirm('Voulez-vous vraiment supprimer ce game ?');">Supprimer</a>
                    </td>
                </tr>
            <?php endfor; ?>
            </tbody>
        </table>
    </section>

</body>
</html>
