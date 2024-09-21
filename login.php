<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'bddg8') or die('Erreur de connexion ' . mysqli_connect_error());

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['valider'])) {
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $password = mysqli_real_escape_string($db, $_POST['password']);

        // Utilisez des requêtes préparées pour éviter les attaques par injection SQL
        $stmt = $db->prepare("SELECT * FROM `user` WHERE `email`=? AND `mdp`=?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            // Utilisateur trouvé
            if ($row['role'] == 'admin') {
                header("Location: FormEtudient.php");
            } elseif ($row['role'] == 'user') {
                $_SESSION['email'] = $email; // Stocker l'email dans la session pour une utilisation ultérieure
                header("Location: bulltin.php");
            }
        } else {
            // Utilisateur inexistant
            echo "User Inexistant. Inscrivez-vous";
        }
    } elseif (isset($_POST['inscription'])) {
        // Redirection vers inscription.php
        header("Location: inscription.html");
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Form</title>
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Rubik:400,700'>
  <link rel="stylesheet" href="/styles/login1.css">
</head>
<body>

<div class="login-form">
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <h1>Login</h1>
    <div class="content">
      <div class="input-field">
        <label for="email"></label>
        <input type="email" id="email" name="email" placeholder="Email" autocomplete="nope" >
      </div>

      <div class="input-field">
        <label for="mdp"></label>
        <input type="password" id="mdp" name="password" placeholder="Password" autocomplete="new-password">
      </div>
    </div>
    <div class="action">
      <button type="submit" name="valider">Valider</button>
      <button type="submit" name="inscription">Inscription</button>
    </div>
  </form>
</div>



</body>
</html>
