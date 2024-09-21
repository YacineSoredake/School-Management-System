<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/styles/table.css">
    <title>table</title>
</head>
<body>
    <h1>  la table enseignant :</h1>
    <?php  
     $db = mysqli_connect ('localhost', 'root', '', 'bddg8')  or die('Erreur de connexion '.mysqli_connect_error());
      $requete = "
        select* 
        from enseignant
        ";
      $resultat = mysqli_query($db,$requete);

      if (!$resultat) {
        echo "erreur au niveau de la requete".mysqli_error($db);
      } else {
		  
     ?>
            <table class="table">
                <theat>
                <tr>
                    <th> ID </th>
                    <th> numero </th>
                    
                    <th> civilité </th>
                    <th> nom prenom </th>
                    <th> adresse </th>
                    <th> date de naissance </th>
                    <th> lieu de naissance</th>
                    <th> pays </th>
                    <th> garde </th>
                    <th> specialite </th>
                    <th> nationalite </th>

                </tr>
                <theat>
                <tbody>
                <?php while ($ligne = mysqli_fetch_array($resultat)) {  
			
                ?>
                <tr>
                    <td><?php echo $ligne[('ID')] ?> </td>
                    <td><?php echo $ligne[('numero')] ?></td>
                    
                    <td><?php echo $ligne[('civilite')] ?></td>
                    <td><?php echo $ligne[('nom_pre')] ?></td>
                    <td><?php echo $ligne[('adresse')] ?></td>
                    <td><?php echo $ligne[('dnaissance')] ?></td>
                    <td><?php echo $ligne[('Lnaissance')] ?></td>
                    <td><?php echo $ligne[('pays')] ?></td>
                    <td><?php echo $ligne[('grade')] ?></td>
                    <td><?php echo $ligne[('specialite')] ?></td>
                    <td><?php echo $ligne[('na_tiona_lite')] ?></td>
                </tr>
                <?php } 
                ?>
                </tbody>
            </table>
      <?php }
     ?>
</body>
</html>