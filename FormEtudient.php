
<?php

if (isset($_POST['rechercher'])) {

  $id = $_POST['id'];
  $db = mysqli_connect ('localhost', 'root', '', 'bddg8')   or die('Erreur de connexion '.mysqli_connect_error());

  // prepare and execute SQL query
  $requete = "SELECT * FROM personne WHERE id = ?";
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
      ETUDIANT
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
      <button  class="menu-btn"type="submit" name="page" value="Stats">Stats</button>
      <button  class="menu-btn"type="submit" name="page" value="PV">PV</button>
      <button  class="menu-btn"type="submit" name="page" value="users">Users</button>
    </div>
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
  
  <form class = "container-2"enctype="multipart/form-data" method="post" action="natio.php">
    <p> nationalité/ libéllé </p>
    <input class="inputo"
        type="text"
        name="nationalite"
        id="nationalite"
        placeholder="Saisissez une nationalité"
    />
    <input class="inputo"
        type="text"
        name="lib-nationalite"
        id="lib-nationalite"
        placeholder="le libéllé"
    />
    <button value="ajouter" type="submit" name="ajouter" class="afficher">Ajouter</button>
</form>

  
  <form class="forms" enctype="multipart/form-data" method="post" action="get_formulaire.php">

      <div class="container-3">
        <label for="idd"> <p>Le numero de cette personne : </p> </label>
        <input readonly class="inputo-personne" type="number" id="id" name="idd" value="<?php if(!empty($row['id'])){ echo $row['id']; } ?>" /><br />  
      </div>

      <p class="da7ik"> VOTRE IMAGE  :</p>
      <div class="civ-label">
        <?php if(!empty($row['image'])){ ?>
        <div class="divcon" id="imageContainer"><?php    echo "<br>votre image: " . $row['image'];
           echo "<br><img src='images/" . $row['image'] . "' width='100'>";
            }
             ?></div> 
      <div class="divcon" id="imageContainer"></div>
      <input class="afficher-file" type="file" id="fileInput" name="fileInput" />
</div>

      <div class="civ-label">
        <div id="civilité">
          <p class="civ-p">civilité :</p>
          <input type="radio" value="monsieur" name="civ" <?php if(!empty($row['Civilité']) && $row['Civilité'] == "monsieur"){ echo "checked"; } ?> />
          <label for="monsieur"> <p class="male">monsieur</p> </label>

          <input type="radio" value="madame" name="civ" <?php if(!empty($row['Civilité']) && $row['Civilité'] == "madame"){ echo "checked"; } ?> />
          <label for="madame"> <p class="female">madame</p> </label>

          <input type="radio" value="mademoiselle" name="civ" <?php if(!empty($row['Civilité']) && $row['Civilité'] == "mademoiselle"){ echo "checked"; } ?> />
          <label for="mademoiselle"> <p class="female">mademoiselle</p> </label>
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
		      	value="<?php if(!empty($row['Nom_pre'])){ echo $row['Nom_pre']; } ?>"
          />
        </div>
        <div id="adresse">
          <label for="adresse"> <p class="add">adresse :</p> </label>
          <input
            class="inputo"
            type="text"
            placeholder="Rue No Boite postale"
            name="adresse"
			      value="<?php if(!empty($row['Adresse'])){ echo $row['Adresse']; } ?>"
          />
        </div>
      </div>
      <div id="postal">
        <label class="postal" for="postale">
          <p>No postal / Localité :</p></label
        >
        <input class="inputo" type="text" value="<?php if(!empty($row['cod_post'])){ echo $row['cod_post']; } ?>" name="postal" />
        <input
          class="inputo"
          type="text"
          value="<?php if(!empty($row['localité'])){ echo $row['localité']; } ?>"
          name="Localité"
        />
      </div>

      <div id="plateforme" class="platform">
    <p>Platforme(s) :</p>
    <?php
    // Explode the platform values into an array
    $platformValues = !empty($row['plat_form']) ? explode(',', $row['plat_form']) : [];

    // Define the available platform options
    $availablePlatforms = ['windows', 'macintosh', 'unix', 'xxx'];

    // Loop through each option and display the checkbox
    foreach ($availablePlatforms as $platform) {
        $checked = in_array($platform, $platformValues) ? 'checked' : '';
    ?>
        <div>
            <input type="checkbox" value="<?php echo $platform; ?>" name="platformes[]" <?php echo $checked; ?> />
            <label for="<?php echo ucfirst($platform); ?>"> <p><?php echo $platform; ?></p> </label>
        </div>
    <?php
    }
    ?>
</div>


      <?php
        if (!empty($row['application'])) {
        $selected_options = explode(',', $row['application']);
      }?>
 <div id="applications" class="civ-label">
       <label for="applications[]"> <p>vos applications :</p> </label>
      <select class="liste-se-1" name="applications[]" multiple >
        <option name="applications[]" value="Brave" <?php if (isset($selected_options) && in_array('Brave', $selected_options)) echo 'selected'; ?>>Brave</option>
        <option name="applications[]" value="VisualstudioCode" <?php if (isset($selected_options) && in_array('VisualstudioCode', $selected_options)) echo 'selected'; ?>>VisualstudioCode</option>
        <option name="applications[]" value="bureau" <?php if (isset($selected_options) && in_array('bureau', $selected_options)) echo 'selected'; ?>>bureau</option>
        <option name="applications[]" value="paramétres" <?php if (isset($selected_options) && in_array('paramétres', $selected_options)) echo 'selected'; ?>>paramétres</option>
        <option name="applications[]" value="avast" <?php if (isset($selected_options) && in_array('avast', $selected_options)) echo 'selected'; ?>>avast</option>
        <option name="applications[]" value="xxx" <?php if (isset($selected_options) && in_array('xxx', $selected_options)) echo 'selected'; ?>>xxx</option>
      </select>
 </div>

      <?php
        if (!empty($row['filiere'])) {
        $selected_options = explode(',', $row['filiere']);
      }?>

  <div id="filieres" class="civ-label">
       <label for="filieres[]"> <p>votre filiere :</p> </label>
      <select class="liste-se-1" name="filieres[]" >
        <option name="filieres[]" value="tc" <?php if (isset($selected_options) && in_array('tc', $selected_options)) echo 'selected'; ?>>tc</option>
        <option name="filieres[]" value="2sc" <?php if (isset($selected_options) && in_array('2sc', $selected_options)) echo 'selected'; ?>>2sc</option>
        <option name="filieres[]" value="3isil" <?php if (isset($selected_options) && in_array('3isil', $selected_options)) echo 'selected'; ?>>3isil</option>
        <option name="filieres[]" value="3si" <?php if (isset($selected_options) && in_array('3si', $selected_options)) echo 'selected'; ?>>3si</option>
        <option name="filieres[]" value="m1" <?php if (isset($selected_options) && in_array('m1', $selected_options)) echo 'selected'; ?>>m1</option>
        <option name="filieres[]" value="m2isi" <?php if (isset($selected_options) && in_array('m2isi', $selected_options)) echo 'selected'; ?>>m2isi</option>
        <option name="filieres[]" value="m2wic" <?php if (isset($selected_options) && in_array('m2wic', $selected_options)) echo 'selected'; ?>>m2wic</option>
        <option name="filieres[]" value="m2rssi" <?php if (isset($selected_options) && in_array('m2rssi,', $selected_options)) echo 'selected'; ?>>m2rssi,</option>
        <option name="filieres[]" value="1ing" <?php if (isset($selected_options) && in_array('1ing', $selected_options)) echo 'selected'; ?>>1ing</option>
        <option name="filieres[]" value="2ing" <?php if (isset($selected_options) && in_array('2ing', $selected_options)) echo 'selected'; ?>>2ing</option>
      </select>
  </div>
      <?php
        if (!empty($row['sport'])) {
            $selected_options = explode(',', $row['sport']);
       }?>

  <div class="civ-label">
     <label for="sport"><p>Pays :</p></label>
     <select class="liste-se" name="sport" id="sport">
     <option value="Basketball" <?php if (isset($selected_options) && in_array('Basketball', $selected_options)) echo 'selected'; ?>>Basketball</option>
     <option value="FootBall" <?php if (isset($selected_options) && in_array('FootBall', $selected_options)) echo 'selected'; ?>>FootBall</option>
     <option value="Formula-1" <?php if (isset($selected_options) && in_array('Formula-1', $selected_options)) echo 'selected'; ?>>Formula-1</option>
     </select>
  </div>
          
        <?php
        if (!empty($row['pays'])) {
            $selected_options = explode(',', $row['pays']);
        }?>

   <div class="civ-label">
            <label for="pays"><p>sport :</p></label>
            <select class="liste-se" name="pays" id="pays">
              <option value="Algeria" <?php if (isset($selected_options) && in_array('Algeria', $selected_options)) echo 'selected'; ?>>Algeria</option>
              <option value="Germany" <?php if (isset($selected_options) && in_array('Germany', $selected_options)) echo 'selected'; ?>>Germany</option>
              <option value="France" <?php if (isset($selected_options) && in_array('France', $selected_options)) echo 'selected'; ?>>France</option>
              <option value="Japan" <?php if (isset($selected_options) && in_array('Japan', $selected_options)) echo 'selected'; ?>>Japan</option>
            </select>
   </div>

        <?php
        $conn = mysqli_connect('localhost', 'root', '', 'bddg8') or die('Erreur de connexion ' . mysqli_connect_error());

        if (!$conn) {
            die('Could not connect to the database: ' . mysqli_connect_error());
        }

        $sql = "SELECT nom_natio, libele FROM nationality";
        $result = mysqli_query($conn, $sql);

        $selectedNationality = ''; // Initialize the selected nationality variable

        if (!empty($row['natio_nalite'])) {
            $selectedNationality = $row['natio_nalite'];
        }
        ?>
          
        <div id="nationalites" class="civ-label">
        <label for="nationalites[]"><p>votre nationalité :</p></label>
          <select name="nationalites[]" class="liste-se-1" id="listeNationalites">
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    $optionText = $row['nom_natio'] . ' ' . $row['libele'];
                    $selected = ($row['nom_natio'] == $selectedNationality) ? 'selected' : '';
                    echo '<option value="' . $row['nom_natio'] . '" ' . $selected . '>' . $optionText . '</option>';
                }
                ?>
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
    <button class="afficher-liste-2" onclick="afficherListeNat()">
      Afficher la table nationalité
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
        window.location.href = "table.php";
      }
      function afficherStats() {
        window.location.href = "statistique.html";
      }
      function afficherPageNote() {
        window.location.href = "listenote.php";
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
