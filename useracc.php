<?php
session_start();

if (!isset($_SESSION['email'])) {
    require("../fonctions.php");
    redirection("../ArchiMA/login.php");
    exit();
}

require("../connexion.php");
$email = $_SESSION['email'];

$sql = "SELECT * FROM utilisateur WHERE email = '$email'";
$result = mysqli_query($con, $sql);
$userData = mysqli_fetch_assoc($result);

if (!empty($userData) && isset($userData['id'])) {
    $annoncesSql = "SELECT a.*, c.categorie, sc.sous_categorie 
                FROM annonce a 
                INNER JOIN categorie c ON a.id_categorie = c.id 
                INNER JOIN sous_categorie sc ON a.id_sous_categorie = sc.id 
                INNER JOIN utilisateur u ON a.id_architecte = u.id_utilisateur
                WHERE u.email = '$email'";

    $annoncesResult = mysqli_query($con, $annoncesSql);
} else {
    echo "User data not found";
}

mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon compte</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: sans-serif;
    }

    :root {
        --color-primary: rgb(39, 121, 167);
        --color-secondary: rgb(73, 197, 182);
        --color-black: rgb(0, 0, 0);
    }

    nav {
        width: 100%;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #cccccc;
        background: var(--color-black);
        position: fixed;
        top: 0;
        z-index: 1000;
        padding-bottom: 10px;

    }

    nav .left .logo img {
        width: 100px;
        margin: 5px 0;
        cursor: pointer;
    }

    nav .left {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 10px;
    }

    nav .center {
        color: #fff;

    }

    .navbar-brand {
        color: #fff;

    }

    .card {
        margin-bottom: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease-in-out;
    }

    .card:hover {
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
    }

    .card-body:hover {
        background-color: var(--color-secondary);
        color: #fff;
    }

    .modal-header {
        background-color: var(--color-secondary);
        color: #fff;
    }

    .modal-close {
        color: #fff;
    }

    .modal-footer {
        background-color: var(--color-primary);
        color: #fff;
    }

    .btn-primary {
        background-color: var(--color-primary);
        border-color: var(--color-primary);
    }

    .btn-primary:hover {
        background-color: var(--color-primary);
        border-color: var(--color-secondary);
    }

    .btn-danger {
        background-color: #d21717;
        border-color: #d21717;
    }

    .btn-danger:hover {
        background-color: #f55757;
        border-color: #f55757;
    }

    .container {
        margin-top: 80px;
    }
</style>

<body>
    <nav>
        <div class="left">
            <a style="font-weight: bold; font-size:34px; color: var(--color-primary);" class="navbar-brand" href="#">Archima</a>
        </div>
        <div class="center">
            <div class="logo">
                <?php echo $userData['prenom']; ?> <?php echo $userData['nom']; ?>
            </div>
            <button class="btn btn-primary" id="myButton">Mon compte</button>
            <button id="mylogout" class="btn btn-danger">Déconnecter</button>
        </div>
    </nav>
    <div class="container">
        <?php
        require("../connexion.php");
        $sql = "SELECT * FROM annonce ";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id_annonce'];
                $title = $row['titre'];
                $description = $row['description'];
        ?>
                <div class="card" id="card-<?php echo $id; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $title; ?></h5>
                        <p class="card-text"><?php echo $description; ?></p>
                        <button class="btn btn-sm btn-primary edit-button" data-toggle="modal" data-target="#editModal" data-announcement-id="<?php echo $id; ?>">Edit</button>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "No announcements found.";
        }
        $con->close();
        ?>
    </div>

    <div id="editModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Announcement</h5>
                    <button type="button" class="close modal-close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="editTitle">Title:</label>
                            <input type="text" class="form-control" id="editTitle" name="editTitle">
                        </div>
                        <div class="form-group">
                            <label for="editDescription">Description:</label>
                            <textarea class="form-control" id="editDescription" name="editDescription"></textarea>
                        </div>
                        <!-- Add other fields for editing here -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="saveButton" data-announcement-id="">Save</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.getElementById("myButton").addEventListener("click", function() {

            window.location.href = "userinfo.php";
        });
        document.getElementById("mylogout").addEventListener("click", function() {

            window.location.href = "index.php";
        });

        $(document).on("click", ".edit-button", function() {
            var announcementId = $(this).attr("data-announcement-id");
            $("#editModal .edit-button").removeClass("active");
            $(this).addClass("active");
            $("#saveButton").attr("data-announcement-id", announcementId);

            var card = $("#card-" + announcementId);
            var title = card.find(".card-title").text();
            var description = card.find(".card-text").text();

            $("#editTitle").val(title);
            $("#editDescription").val(description);
        });





        $(document).ready(function() {
            var announcementId;


            $('.edit-button').click(function() {
                announcementId = $(this).data('announcement-id');
                var title = $('#card-' + announcementId + ' .card-title').text();
                var description = $('#card-' + announcementId + ' .card-text').text();

                $('#editTitle').val(title);
                $('#editDescription').val(description);
                $('#saveButton').attr('data-announcement-id', announcementId);
            });


            $('#saveButton').click(function() {
                var updatedTitle = $('#editTitle').val();
                var updatedDescription = $('#editDescription').val();


                if (updatedTitle.trim() === '' || updatedDescription.trim() === '') {
                    alert('Please enter a title and description.');
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: 'update_announcement.php',
                    data: {
                        id: announcementId,
                        title: updatedTitle,
                        description: updatedDescription
                    },
                    success: function(response) {

                        $('#card-' + announcementId + ' .card-title').text(updatedTitle);
                        $('#card-' + announcementId + ' .card-text').text(updatedDescription);


                        sessionStorage.setItem('announcement-' + announcementId + '-title', updatedTitle);
                        sessionStorage.setItem('announcement-' + announcementId + '-description', updatedDescription);


                        $('#editModal').modal('hide');
                    },
                    error: function() {
                        alert('Error updating the announcement.');
                    }
                });
            });


            $('.card').each(function() {
                var cardId = $(this).attr('id').replace('card-', '');
                var updatedTitle = sessionStorage.getItem('announcement-' + cardId + '-title');
                var updatedDescription = sessionStorage.getItem('announcement-' + cardId + '-description');

                if (updatedTitle && updatedDescription) {
                    $('#card-' + cardId + ' .card-title').text(updatedTitle);
                    $('#card-' + cardId + ' .card-text').text(updatedDescription);
                }
            });
        });
    </script>

</html>