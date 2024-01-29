<!DOCTYPE html>
<html>
<head>
  <title>Archima</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    /* Styles pour les boutons */
    :root {
        --color-primary: rgb(39, 121, 167);
        --color-secondary: rgb(73, 197, 182);
        --color-black: rgb(0, 0, 0);
    }




    .btn-custom {
      background-color: #333;
      color: #fff;
      border-radius: 10px;
      padding: 4px 12px;
      font-size: 16px;
      font-weight: bold;
      font-family: 'Arial', sans-serif;
      transition: background-color 0.3s ease;
    }

    .btn-custom:hover {
      background-color: #d21717;
    }

    /* Style pour la police de caractères */
    body {
      font-family: 'Arial', sans-serif;
      background-image: url(images/bd.jpeg);
      background-repeat: no-repeat;
      background-size: 100%;
      background-attachment: fixed;
    }

    /* Styles pour le centrage de la phrase */
    .centered-text {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      padding-top: 10%;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a style="font-weight: bold; font-size:34px; color: #d21717;" class="navbar-brand" href="#">Archima</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <button class="btn btn-custom"><a class="nav-link" href="../inscription/inscription.php" style="color: white;">Architecte ! Inscrivez-vous</a></button>
        </li>
        <li class="nav-item">
          <span class="navbar-text mx-2"></span>
        </li>
        <li class="nav-item">
          <button class="btn btn-custom"><a class="nav-link" href="login.php" style="color: rgb(255, 255, 255);">Mon compte</a></button>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container">
  <?php
    require("../connexion.php");

    $ville = isset($_GET['ville']) ? $_GET['ville'] : '';
    $cityName = '';

    $query = "SELECT a.titre, a.description, v.nom_ville
              FROM annonce a
              INNER JOIN ville v ON a.id_ville = v.id_ville";

    if (!empty($ville)) {
      $query .= " WHERE v.id_ville = '$ville'";
      $cityQuery = "SELECT nom_ville FROM ville WHERE id_ville = '$ville'";
      $cityResult = mysqli_query($con, $cityQuery);
      $cityData = mysqli_fetch_assoc($cityResult);
      $cityName = $cityData['nom_ville'];
      mysqli_free_result($cityResult);
    }

    $query .= " ORDER BY v.nom_ville";

    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
      echo '<h1>Les architectes disponibles à ' . $cityName . ' sont:</h1>';

      while ($row = mysqli_fetch_assoc($result)) {
        $titre = $row['titre'];
        $description = $row['description'];

        echo '<div class="card mb-3">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $titre . '</h5>';
        echo '<p class="card-text">' . $description . '</p>';

        echo '</div>';
        echo '</div>';
      }
    } else {
      echo '<h1>Aucun architecte n\'est disponible à ' . $cityName . '.</h1>';
    }

    mysqli_free_result($result);
    mysqli_close($con);
  ?>
</div>


  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
