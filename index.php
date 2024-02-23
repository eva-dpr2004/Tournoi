<?php
$mysqli = new mysqli("localhost", "root", "", "tournoi");

if ($mysqli->connect_error) {
    die("Erreur de connexion à la base de données: " . $mysqli->connect_error);
}

$tables = array(
    "Competition" => "SELECT Nom_Competition, Date_Competition, Duree_Match, Heure_Debut FROM Competition",
    "Equipe" => "SELECT Nom_Equipe, Categorie, Sexe FROM Equipe",
    "Matchs" => "SELECT Date_Heure_Match FROM Matchs",
    "Poule" => "SELECT Nom_Poule, Nombre_Equipes FROM Poule",
    "Terrain" => "SELECT Nom_Terrain, Localisation, Capacite FROM Terrain"
);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournoi de Football</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" href="https://game-icons.net/icons/delapouite/originals/svg/soccer-kick.svg" type="image/svg+xml">
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <style>
        body {
            background-image: url("football_field.jpg");
            background-size: cover;
            background-position: center;
            color: #fff;
        }
        
        .white-background {
            background-color: #dfdfdfde;
        }
        
        h2,h1 {
            text-align: center;
            margin-bottom: 20px;
            margin-top: 20px;
            font-size: 24px;
            text-transform: uppercase;
        }

        h1{
            font-size: 35px;
        }
        
        .table-container {
            overflow: hidden;
            width: 75%;
            margin: 0 auto;
        }

        .shadow {
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        }

        .football-icon {
            font-size: 24px;
            margin-right: 5px;
        }

        footer {
            text-align: center;
            background-color: rgba(0, 0, 0, 0.5);
        }

        footer p {
            padding: 15px;
            font-size: 15px;
        }
    </style>
</head>
<body>
<header>
    <h1 class="font-weight-bold" style="text-decoration: underline;">Tournoi de football</h1>
</header>
<main>
    <?php foreach ($tables as $table => $sql) : ?>
        <?php
        $result = $mysqli->query($sql);
        if ($result->num_rows > 0) : ?>
            <h2><span class='iconify' data-icon='game-icons:soccer-ball'></span> <?= $table ?></h2>
            <div class='table-responsive shadow table-container'>
                <table class='table table-bordered white-background'>
                    <thead class='thead-dark'>
                        <tr>
                            <?php $headers = array(); ?>
                            <?php while ($row = $result->fetch_assoc()) : ?>
                                <?php if (empty($headers)) : ?>
                                    <?php foreach ($row as $key => $value) : ?>
                                        <?php if (!empty($value)) : ?>
                                            <th><?= $key ?></th>
                                            <?php $headers[] = $key; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    </tr></thead><tbody><tr>
                                <?php endif; ?>
                                <?php foreach ($headers as $header) : ?>
                                    <td><?= $row[$header] ?></td>
                                <?php endforeach; ?>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                </table>
            </div>
        <?php else : ?>
            <p>Aucun résultat trouvé pour la table <?= $table ?>.</p>
        <?php endif; ?>
        <br>
    <?php endforeach; ?>
</main>
<footer>
    <p><?= date("Y") ?> Tournoi de Football.</p>
</footer>
</body>
</html>
