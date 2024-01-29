<?php
session_start();


if (!isset($_SESSION['email'])) {
    
    header("Location: login.php");
    exit();
}


require("../connexion.php");

$email = $_SESSION['email'];
$sql = "SELECT * FROM utilisateur WHERE email = '$email'";
$result = mysqli_query($con, $sql);
$userData = mysqli_fetch_assoc($result);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    
    $updateSql = "UPDATE utilisateur SET nom = '$name', prenom = '$surname', email = '$email', mot_de_passe = '$password', telephone = '$phone', adresse = '$address' WHERE email = '$email'";
    mysqli_query($con, $updateSql);

    
    header("Location: userinfo.php?message=success");
    exit();
}


mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Info</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>User Info</h1>
        
        <?php if (isset($_GET['message']) && $_GET['message'] === 'success'): ?>
            <div class="alert alert-success">Information updated successfully.</div>
        <?php endif; ?>

        <form method="POST" action="userinfo.php">
            <div class="form-group">
                <label for="name">First Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $userData['nom']; ?>" required>
            </div>
            <div class="form-group">
                <label for="surname">Last Name</label>
                <input type="text" class="form-control" id="surname" name="surname" value="<?php echo $userData['prenom']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $userData['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" value="<?php echo $userData['mot_de_passe']; ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $userData['telephone']; ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo $userData['adresse']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
