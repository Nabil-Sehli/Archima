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
      color: var(--color-secondary);
      border-radius: 10px;
      padding: 4px 12px;
      font-size: 16px;
      font-weight: bold;
      font-family: 'Arial', sans-serif;
      transition: background-color 0.3s ease;
    }

    .btn-custom:hover {
      background-color: var(--color-primary);
      
      box-shadow: 11px 16px 51px -9px rgba(0,0,0,0.75);
    
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

    nav{
      background-color: transparent;
      backdrop-filter: blur(5px);
    }
    .navbar-brand{
      -webkit-text-fill-color: rgb(73, 197, 182);
    }

   
    .navbar-custom{
      background-color: rgba(0, 37, 33, 0.39);
      backdrop-filter: blur(5px);
      
    }

    .card{
      background-color: aliceblue;
      transition: background-color 0.5s ease-out;
    }

    .card-custom:hover{
      background-color: rgb(73, 197, 182);
      cursor: pointer;
      box-shadow: -1px 27px 60px -16px rgba(0,0,0,0.75);
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light navbar-custom">
    <a style="font-weight: bold; font-size:34px; " class="navbar-brand" href="#">Archima</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <button class="btn btn-custom"><a class="nav-link" href="../inscription/inscription.php" style="color: white;">Architecte ! Inscriver-vous</a></button>
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
    <div class="row">
      <div class="col-md-6 mx-auto">
        <h2  class="text-center d-inline-block" style="color: black; font-weight: bold; text-shadow: 2px 2px whitesmoke;">
          Contactez notre Architecte ! Démarrez votre projet
        </h2>
        <div class="form-group d-flex">
          <select class="form-control mr-2" id="villeSelect" name="ville" style="color: black;">
            <option value="">Sélectionner une ville</option>
            <?php
            require("../connexion.php");

            $query = "SELECT * FROM ville";
            $result = mysqli_query($con, $query);

            while ($row = mysqli_fetch_assoc($result)) {
              echo '<option value="' . $row['id_ville'] . '">' . $row['nom_ville'] . '</option>';
            }

            mysqli_free_result($result);
            mysqli_close($con);
            ?>
          </select>

          <button class="btn btn-custom d-inline-block" onclick="rechercher()"><i class="fas fa-search"></i></button>
        </div>
      </div>
    </div>
    <?php
      require("../connexion.php");

      $query = "SELECT * FROM annonce";
      $result = mysqli_query($con, $query);
   

      while ($row = mysqli_fetch_assoc($result)) {
        $titre = $row['titre'];
        $description = $row['description'];
     

        echo '<div class="card mb-3 card-custom">';
        echo '<div class="card-body" >';
        echo '<h5 class="card-title">' . $titre . '</h5>';
        echo '<p class="card-text">' . $description . '</p>'; 
       
        echo '</div>';
        echo '</div>';
      }

      mysqli_free_result($result);
      mysqli_close($con);
      ?>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
    function rechercher() {
      var ville = document.getElementById("villeSelect").value;
      if (ville !== "") {
        // Redirect to the architectes page with the selected city as a parameter
        window.location.href = "architectes.php?ville=" + ville;
      } else {
        // Aucune ville sélectionnée
        console.log("Veuillez sélectionner une ville.");
      }
    }
  </script>
</body>
</html>
