
<?php

if (isset($_POST['rechercher'])) {

  $id = $_POST['id'];
  $db = mysqli_connect ('localhost', 'root', '', 'bddg8')   or die('Erreur de connexion '.mysqli_connect_error());

  // prepare and execute SQL query
  $requete = "SELECT * FROM module WHERE id = ?";
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
require('get_formulaire3.php')

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
     MODULE
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
    </div>
  </form>

  <form class="search-form" method="post">
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
    
  <form class="forms" enctype="multipart/form-data" method="post" action="get_formulaire3.php">

      <div class="container-3">
        <label for="idd"> <p>L'id du module : </p> </label>
        <input readonly class="inputo-personne" type="number" id="id" name="idd" value="<?php if(!empty($row['ID'])){ echo $row['ID']; } ?>" /><br />  
      </div>
      
      <div class="civ-label">
        <label for="code"><p> le code du module :</p></label>
        <input class="inputo" type="text" id="code" name="code" value="<?php if(!empty($row['code'])){ echo $row['code']; } ?>" /> 
      </div>

      <div class="names">
        <div id="designation">
          <label for="designation"> <p class="name-add"> désignation du module :</p> </label>
          <input
            class="inputo"
            type="text"
            name="designation"
            placeholder="EX : Algebre"
		      	value="<?php if(!empty($row['designation'])){ echo $row['designation']; } ?>"
          />
        </div>
       </div>
      
       <div class="container-3">
        <label for="coeff"> <p> coefficient, : </p> </label>
        <input class="inputo-personne" type="number" id="coeff" name="coeff" value="<?php if(!empty($row['coefficient'])){ echo $row['coefficient']; } ?>" /><br />  
      </div>

      <div class="container-3">
        <label for="volumeH"> <p> Volume Horaire : </p> </label>
        <input class="inputo-personne" type="number" id="volumeH" name="volumeH" value="<?php if(!empty($row['volume'])){ echo $row['volume']; } ?>" /><br />  
      </div>

      <?php
        if (!empty($row['Filiere'])) {
        $selected_options = explode(',', $row['Filiere']);
      }?>

      <div class="civ-label">
        <label for="filiere"><p>filiere :</p></label>
        <select class="liste-se" name="filiere" id="filiere">
          <option value="tc" <?php if (isset($selected_options) && in_array('tc', $selected_options)) echo 'selected'; ?>>tc</option>
          <option value="2sc" <?php if (isset($selected_options) && in_array('2sc', $selected_options)) echo 'selected'; ?>>2sc</option>
          <option value="3isil" <?php if (isset($selected_options) && in_array('3isil', $selected_options)) echo 'selected'; ?>>3isil</option>
          <option value="3si" <?php if (isset($selected_options) && in_array('3si', $selected_options)) echo 'selected'; ?>>3si</option>
          <option value="1ing" <?php if (isset($selected_options) && in_array('1ing', $selected_options)) echo 'selected'; ?>>1ing</option>
          <option value="2ing" <?php if (isset($selected_options) && in_array('2ing', $selected_options)) echo 'selected'; ?>>2ing</option>
          <option value="m1" <?php if (isset($selected_options) && in_array('m1', $selected_options)) echo 'selected'; ?>>m1</option>
          <option value="m2isi" <?php if (isset($selected_options) && in_array('m2isi', $selected_options)) echo 'selected'; ?>>m2isi</option>
          <option value="m2wic" <?php if (isset($selected_options) && in_array('m2wic', $selected_options)) echo 'selected'; ?>>m2wic</option>
          <option value="m2rssi" <?php if (isset($selected_options) && in_array('m2rssi', $selected_options)) echo 'selected'; ?>>m2rssi</option>
        </select>
      </div>

      <div class="civ-label">
        <div id="type">
          <p class="civ-p">type :</p>
          <input type="radio" value="semestrielle" name="type" <?php if(!empty($row['type']) && $row['type'] == "semestrielle"){ echo "checked"; } ?> />
          <label for="semestrielle"> <p class="male">semestrielle</p> </label>

          <input type="radio" value="anuelle" name="type" <?php if(!empty($row['type']) && $row['type'] == "anuelle"){ echo "checked"; } ?> />
          <label for="anuelle"> <p class="female">anuelle</p> </label>
        </div>
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
      function result() {
        const civ = document.querySelector('input[name="civ"]:checked').value;
        const nom = document.querySelector('input[name="nom"]').value;
        const adresse = document.querySelector('input[name="adresse"]').value;
        const localité = document.querySelector('input[name="Localité"]').value;
        const postal = document.querySelector('input[name="postal"]').value;
        const pays = document.querySelector('select[name="pays"]').value;
        const naissance = document.querySelector(
          'input[name="naissance"]'
        ).value;
        const rendezvous = document.querySelector(
          'input[name="rendezvous"]'
        ).value;

        const platformes = document.querySelectorAll(
          'input[name="platformes[]"]:checked'
        );
        const platformesValues = Array.from(platformes).map(
          (checkbox) => checkbox.value
        );
        const applications = document.querySelectorAll(
          'select[name="applications[]"] option:checked'
        );

        const applicationsValues = Array.from(applications).map(
          (option) => option.value
        );

        const nationalites = document.querySelectorAll(
          'select[name="nationalites[]"] option:checked'
        );
        const nationalitesValues = Array.from(nationalites).map(
          (option) => option.value
        );

        const sports = document.querySelectorAll(
          'select[name="sports[]"] option:checked'
        );
        const sportssValues = Array.from(sports).map((option) => option.value);

        const resultString =
          "votre Civilité: " +
          civ +
          "\nVotre Nom et prénom: " +
          nom +
          "\nVotre Adresse: " +
          adresse +
          "\nVotre Localité: " +
          localité +
          "\nCode postal: " +
          postal +
          "\nVotre Pays: " +
          pays +
          "\nVotre date de naissance: " +
          naissance +
          "\nVous avez un rendez-vous: " +
          rendezvous +
          "\nVos Plateforme(s): " +
          platformesValues.join(", ") +
          "\nVos Applications: " +
          applicationsValues.join(", ") +
          "\nVotre nationalité : " +
          nationalitesValues.join(", ") +
          "\nVos sport: " +
          sportssValues.join(", ");
        alert(resultString);
      }
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
        window.location.href = "table3.php";
      }
      function ajouterNationalite() {
    // Récupérer la valeur saisie dans le champ de texte
    var nationalite = document.getElementById("nationalite").value;
    var libele = document.getElementById("lib-nationalite").value;
    // Récupérer la liste déroulante
    var liste = document.getElementById("listeNationalites");

    // Créer une nouvelle option avec la valeur de la nationalité saisie
    var option = document.createElement("option");
    option.text = nationalite +" "+ libele;
    option.value = nationalite + " "+ libele;

    // Ajouter l'option à la liste déroulante
    liste.add(option);

    // Effacer le champ de texte après l'ajout
    document.getElementById("nationalite").value = "";
    document.getElementById("lib-nationalite").value = "";
}
function afficherListeNat() {
        window.location.href = "tablenat.php";
      }
    </script>
  </body>
</html>
