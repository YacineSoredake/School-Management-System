
<?php

if (isset($_POST['rechercher'])) {

  $id = $_POST['id'];
  $db = mysqli_connect ('localhost', 'root', '', 'bddg8')   or die('Erreur de connexion '.mysqli_connect_error());

  // prepare and execute SQL query
  $requete = "SELECT * FROM enseignant WHERE id = ?";
  $stmt = $db->prepare($requete);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $resultat = $stmt->get_result();

  // display the result in table format
  if ($resultat->num_rows > 0) {
 $row = $resultat->fetch_assoc();
  } else {
    echo "Aucun résultat trouvé pour l'ID " . $id;
  }
}
require('get_formulaire2.php')

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/styles/paw3.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Acme&family=IBM+Plex+Sans&display=swap"
      rel="stylesheet"
    />
    <title>
      ENSEIGNANT
    </title>
  </head>
  <body>
  <form class="header" method="get" action="page_selection.php">
    <p class="choose"> choisit un formulaire</p>
    <div class="buttons">
      <button class="menu-btn" type="submit" name="page" value="etudiant">Formulaire Étudiant</button>
      <button class="menu-btn"type="submit" name="page" value="enseignant">Formulaire Enseignant</button>
      <button  class="menu-btn"type="submit" name="page" value="module">Formulaire Module</button>
      <button  class="menu-btn"type="submit" name="page" value="note">bulltin de note</button>
      <button  class="menu-btn"type="submit" name="page" value="PV">PV</button>
    </div>
  </form>
  <form method="post">
      <div class="container">
        <label for="id"><p>Numéro :</p></label>
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
    
  <form class="forms" enctype="multipart/form-data" method="post" action="get_formulaire2.php">

      <div class="container-3">
        <label for="idd"> <p>L'id de l'enseignant : </p> </label>
        <input readonly class="inputo-personne" type="number" id="id" name="idd" value="<?php if(!empty($row['ID'])){ echo $row['ID']; } ?>" /><br />  
      </div>

      <div class="civ-label">
        <label for="numero"><p> le numero de l'enseignant :</p></label>
        <input class="inputo" type="number" id="numero" name="numero" value="<?php if(!empty($row['numero'])){ echo $row['numero']; } ?>" /> 
      </div>
      <div class="civ-label">
        <div id="civilité">
          <p class="civ-p">civilité :</p>
          <input type="radio" value="monsieur" name="civ" <?php if(!empty($row['civilite']) && $row['civilite'] == "monsieur"){ echo "checked"; } ?> />
          <label for="monsieur"> <p class="male">monsieur</p> </label>

          <input type="radio" value="madame" name="civ" <?php if(!empty($row['civilite']) && $row['civilite'] == "madame"){ echo "checked"; } ?> />
          <label for="madame"> <p class="female">madame</p> </label>

          <input type="radio" value="mademoiselle" name="civ" <?php if(!empty($row['civilite']) && $row['civilite'] == "mademoiselle"){ echo "checked"; } ?> />
          <label for="mademoiselle"> <p class="female">mademoiselle</p> </label>

          <input type="radio" value="militaire" name="civ" <?php if(!empty($row['civilite']) && $row['civilite'] == "militaire"){ echo "checked"; } ?> />
          <label for="militaire"> <p class="male">militaire</p> </label>
        </div>
      </div>
      <div class="names">
        <div id="nom">
          <label for="nom"> <p class="name-add">nom / prénom :</p> </label>
          <input
            class="inputo"
            type="text"
            name="nom"
            placeholder="EX : Blaha Yacine"
		      	value="<?php if(!empty($row['nom_pre'])){ echo $row['nom_pre']; } ?>"
          />
        </div>
        <div id="adresse">
          <label for="adresse"> <p class="add">adresse :</p> </label>
          <input
            class="inputo"
            type="text"
            placeholder="Rue No Boite postale"
            name="adresse"
			      value="<?php if(!empty($row['adresse'])){ echo $row['adresse']; } ?>"
          />
        </div>
      </div>
      
      <div class="civ-label">
        <label for="naissance"><p>date de naissance:</p></label>
        <input class="inputo" type="date" id="naissance" name="naissance" value="<?php echo $row['dnaissance']; ?>">
      </div>


      <div class ="civ-label">
        <label for="lieunaissance"> <p>lieu de naissance :</p></label>
        <input class="inputo" type="text" id="lieunaissance" name="lieunaissance" placeholder="sidi-bel-abbes" value="<?php if(!empty($row['Lnaissance'])){ echo $row['Lnaissance']; } ?>" />
      </div>

      <?php
        if (!empty($row['pays'])) {
        $selected_options = explode(',', $row['pays']);
      }?>

      <div class="civ-label">
        <label for="pays"><p>Pays :</p></label>
        <select class="liste-se" name="pays" id="pays">
          <option value="Japan" <?php if (isset($selected_options) && in_array('Japan', $selected_options)) echo 'selected'; ?>>- Japan -</option>
          <option value="Algeria" <?php if (isset($selected_options) && in_array('Algeria', $selected_options)) echo 'selected'; ?>>Algeria</option>
          <option value="canada" <?php if (isset($selected_options) && in_array('canada', $selected_options)) echo 'selected'; ?>>Canada</option>
          <option value="USA" <?php if (isset($selected_options) && in_array('USA', $selected_options)) echo 'selected'; ?>>USA</option>
          <option value="south korea" <?php if (isset($selected_options) && in_array('south korea', $selected_options)) echo 'selected'; ?>>South korea</option>
          <option value="xxx" <?php if (isset($selected_options) && in_array('xxx', $selected_options)) echo 'selected'; ?>>xxx</option>
        </select>
      </div>

      <?php
        if (!empty($row['grade'])) {
        $selected_options = explode(',', $row['grade']);
      }?>

      <div class="civ-label">
        <label for="grade"><p>grade :</p></label>
        <select class="liste-se" name="grade" id="grade">
          <option value="assistant" <?php if (isset($selected_options) && in_array('assistant', $selected_options)) echo 'selected'; ?>>assistant</option>
          <option value="MAA" <?php if (isset($selected_options) && in_array('MAA', $selected_options)) echo 'selected'; ?>>MAA</option>
          <option value="MAB" <?php if (isset($selected_options) && in_array('MAB', $selected_options)) echo 'selected'; ?>>MAB</option>
          <option value="MCB" <?php if (isset($selected_options) && in_array('MCB', $selected_options)) echo 'selected'; ?>>MCB</option>
          <option value="MCA" <?php if (isset($selected_options) && in_array('MCA ', $selected_options)) echo 'selected'; ?>> MCA</option>
          <option value="Professeur" <?php if (isset($selected_options) && in_array('Professeur', $selected_options)) echo 'selected'; ?>>Professeur</option>
        </select>
      </div>

      <?php
        if (!empty($row['specialite'])) {
        $selected_options = explode(',', $row['specialite']);
      }?>

      <div class="civ-label">
        <label for="specialite"><p>specialite :</p></label>
        <select class="liste-se" name="specialite" id="specialite">
          <option value="informatique" <?php if (isset($selected_options) && in_array('informatique', $selected_options)) echo 'selected'; ?>> informatique </option>
          <option value="mathematique" <?php if (isset($selected_options) && in_array('mathematique', $selected_options)) echo 'selected'; ?>>mathematique</option>
          <option value="anglais" <?php if (isset($selected_options) && in_array('anglais', $selected_options)) echo 'selected'; ?>>anglais</option>
          <option value="autres" <?php if (isset($selected_options) && in_array('autres', $selected_options)) echo 'selected'; ?>>autres</option>
        </select>
      </div>

      <?php
        if (!empty($row['na_tiona_lite'])) {
        $selected_options = explode(',', $row['na_tiona_lite']);
      }?>

      <div class="civ-label">
        <label for="specialite"><p>nationalite :</p></label>
        <select class="liste-se" name="nationality" id="nationality">
          <option value="algerien" <?php if (isset($selected_options) && in_array('algerien', $selected_options)) echo 'selected'; ?>> algerien </option>
          <option value="etranger" <?php if (isset($selected_options) && in_array('etranger', $selected_options)) echo 'selected'; ?>>etranger</option>
        </select>
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
    </form>
    <button class="afficher-liste" onclick="afficherPagePHP()">
      Afficher la liste 
    </button>
    <script>
      const fileInput = document.getElementById("fileInput");
      const imageContainer = document.getElementById("imageContainer");

      fileInput.addEventListener("change", () => {
        const file = fileInput.files[0];
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => {
          const img = document.createElement("img");
          img.src = reader.result;
          imageContainer.appendChild(img);
        };
      });
      function afficherPagePHP() {
        window.location.href = "table2.php";
      }
 
function afficherListeNat() {
        window.location.href = "tablenat.php";
      }
function goToEnseingnant() {
        window.location.href = "FormEtudient.php";
      }
    </script>
  </body>
</html>
