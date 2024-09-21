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
require('get_formulaire.php')

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
      NOTE
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
      <button  class="menu-btn"type="submit" name="page" value="Stats">Stats</button>
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
  
  <form class="forms2" enctype="multipart/form-data" method="post" action="get_formulaire4.php">

      <div class="container-3">
        <label for="idd"> <p>Le numero de cette personne : </p> </label>
        <input readonly class="inputo-personne" type="number" id="idd" name="idd" value="<?php if(!empty($row['id'])){ echo $row['id']; } ?>" /><br />  
      </div>
      <p class="da7ik"> VOTRE IMAGE  :</p>
      <div class="civ-label">
        <?php if(!empty($row['image'])){ ?>
        <div class="divcon" id="imageContainer"><?php  $row['image'];
           echo "<br><img src='images/" . $row['image'] . "' width='100'>";
            }
         ?></div> 
      <div class="divcon" id="imageContainer"></div>
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

          <input type="radio" value="militaire" name="civ" <?php if(!empty($row['Civilité']) && $row['Civilité'] == "militaire"){ echo "checked"; } ?> />
          <label for="militaire"> <p class="male">militaire</p> </label>
        </div>
      </div>
        <div id="nom">
          <label for="nom"> <p class="name-add">nom / prénom :</p> </label>
          <input
          readonly
            class="inputo"
            type="text"
            name="nom"
		      	value="<?php if(!empty($row['Nom_pre'])){ echo $row['Nom_pre']; } ?>"
          />
        </div>
        <div class="civ-label">
          <label for="filiere"><p class="name-add">filiere :</p> </label>
          <input readonly class="inputo"  type="text" name="filiere" id="filiereInput" value="<?php if(!empty($row['filiere'])){ echo $row['filiere']; } ?>">
          </div>
        <div class="civ-label">
         <label for="module"> <p class="name-add">Select a module:</p></label>         
         <select class="liste-se" id="module" name="module">
          <option value="none"> ---none----</option>
         </select>
         </div> 
        <div class="civ-label">
          <label for="codeInput"> <p class="namme-add"> code : </p></label>
          <input readonly class="inputo-personne" type="text" id="codeInput" name="codeInput">
          <label for="coefficient"> <p class="namme-add"> coefficient : </p></label>
          <input readonly class="inputo-personne" type="text" id="coefficientInput" name="coefficient">
         </div>

         <div class="civ-label-2">
         <label for="note"><p class="name-add"> Note :</p></label>
         <input type="text" class="inputo" name="note" id="note">
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
          <button class="afficher" type="submit" name="afficher_table" value="Afficher table"> bulltin de note</button>
         </div>
         
   </form>
   <button class="afficher-liste" onclick="afficherPagePHP()">
      Afficher la liste 
    </button>
  </body>
  <script>
    
  // Function to update the module options based on the selected "filiere" value
  function fc1() {
    const filiereInput = document.getElementById("filiereInput");
    const moduleSelect = document.getElementById("module");
    const filiereValue = filiereInput.value;

    // Send an AJAX request to your PHP script to fetch the module options based on the filiereValue
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "process_form.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        const options = JSON.parse(xhr.responseText);

        // Clear existing options
        moduleSelect.innerHTML = "";

        // Add the new options
        options.forEach((option) => {
          const optionElement = document.createElement("option");
          optionElement.value = option;
          optionElement.text = option;
          moduleSelect.appendChild(optionElement);
        });
      }
    };

    // Send the filiereValue to the server
    xhr.send("filiere=" + encodeURIComponent(filiereValue));
  }

  // Add an event listener to the "filiere" input to update the options when it changes
  document.getElementById("filiereInput").addEventListener("input", fc1);

  // Initially update the options based on the default value
  fc1();

// Function to fetch code and coefficient based on selected module
// Function to update the module options based on the selected "filiere" value
function updateCodeAndCoefficient() {
  const selectedModule = document.getElementById("module").value;
  const num_etudiant = parseInt(document.getElementById("idd").value, 10); // Parse as an integer

  // Send an AJAX request to fetch 'code module' and 'coefficient'
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "codecoef.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      const data = JSON.parse(xhr.responseText);
      document.getElementById("codeInput").value = data.code;
      document.getElementById("coefficientInput").value = data.coefficient;

      // After updating code and coefficient, fetch and display the note
      fetchNote(data.code, num_etudiant);
    }
  };

  xhr.send("module=" + encodeURIComponent(selectedModule));
}

function fetchNote(code, num_etudiant) {
  // Fetch and display the note based on code and num_etudiant
  const xhr2 = new XMLHttpRequest();
  xhr2.open("POST", "check_note.php", true);
  xhr2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr2.onreadystatechange = function () {
    if (xhr2.readyState === 4 && xhr2.status === 200) {
      const noteData = JSON.parse(xhr2.responseText);
      if (noteData.note !== null) {
        document.getElementById("note").value = noteData.note;
      } else {
        document.getElementById("note").value = "Note not typed";
      }
    }
  };

  xhr2.send("codeInput=" + encodeURIComponent(code) + "&idd=" + num_etudiant);
}

// Attach the event listener to the "module" select input
document.getElementById("module").addEventListener("change", updateCodeAndCoefficient);

// Call the function initially to handle the default module value
updateCodeAndCoefficient();

function afficherPagePHP() {
        window.location.href = "table4.php";
      }

</script>

</html>  