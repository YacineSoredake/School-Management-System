<?php
if (isset($_POST['rechercher'])) {
    $id = $_POST['id'];
    $db = mysqli_connect('localhost', 'root', '', 'bddg8') or die('Erreur de connexion ' . mysqli_connect_error());

    // prepare and execute SQL query
    $requete = "SELECT * FROM user WHERE id = ?";
    $stmt = $db->prepare($requete);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $resultat = $stmt->get_result();

    // fetch the result
    if ($resultat->num_rows > 0) {
        $row = $resultat->fetch_assoc();
    } else {
        echo "Aucun résultat trouvé pour l'ID " . $id;
    }
}

require('get_user.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <style>
       body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 600px;
    margin: 20px auto;  
    padding: 20px;
    border-radius: 8px;
   
}

form {
    display: flex;
    flex-direction: column;
}

label {
    margin-bottom: 8px;
    font-weight: bold;
}

input, select {
    padding: 10px;
    margin-bottom: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    background-color: #3498db;
    color: #fff;
    padding: 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
.display-but{
    background-color: #3498db;
    color: #fff;
    padding: 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-left: 620px;
}
button:hover {
    background-color: #2980b9;
}

.error {
    color: #e74c3c;
    margin-bottom: 16px;
}
.buttons{
    display: flex;
    justify-content: space-between;

}
    </style>
</head>
<body>
   <form class="search-form" method="post">
      <div class="container">
        <label for="id"><p>ID :</p></label>
        <input class="inputo" type="text" name="id" id="id" />
        <button
          class="afficher"
          type="submit"
          value="rechercher"
          name="rechercher"
        >
          Rechercher
        </button>
      </div>
  </form>
  <button class="display-but" id="js-Liste"> afficher la table user </button>
    <form method="post" action="get_user.php">
        <div class="container">
            <div class="miniDiv">
                <label for="id">ID:</label>
                <input class="inputo" type="number" name="id" readonly value="<?php echo isset($row['id']) ? $row['id'] : ''; ?>">
            </div>
            <div class="miniDiv">
                <label for="email">Email:</label>
                <input class="inputo" type="email" name="email" placeholder="Enter email here" value="<?php echo isset($row['email']) ? $row['email'] : ''; ?>">
            </div>
            <div class="miniDiv">
                <label for="mdp">Mot de passe:</label>
                <input class="inputo" type="text" name="mdp" placeholder="Password" value="<?php echo isset($row['mdp']) ? $row['mdp'] : ''; ?>">
            </div>
            <div class="miniDiv">
                <label for="role">Role:</label>
                <select name="role">
                    <option value="user" <?php echo (isset($row['role']) && $row['role'] == 'user') ? 'selected' : ''; ?>>User</option>
                    <option value="admin" <?php echo (isset($row['role']) && $row['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                </select>
                <label for="id_etudient"> ID Etudient</label>
                <input class="inputo" type="number" name="id_etudient" value="<?php echo isset($row['id_etudient']) ? $row['id_etudient'] : ''; ?>">
            </div>
            
            <div class="buttons">
        <p>
          <input
            class="afficher"
            type="submit"
            name="enregistrer"
            value="enregistrer"
          />
        </p>
        <p>
          <input
            class="afficher"
            type="submit"
            name="modifier"
            value="modifier"
          />
        </p>
        <p>
          <input
            class="afficher"
            type="submit"
            name="supprimer"
            value="supprimer"
          />
        </p>

      </div>
        </div>
    </form>
</body>
<script>
    listeUser = document.getElementById('js-Liste');
    
    listeUser.addEventListener('click' ,function(){
        window.location.href = 'UserTable.php';
    });

</script>
</html>
