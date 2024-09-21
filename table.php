<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/styles/table.css">
    <title>table</title>
</head>
<body>
    <h1>  la table personne :</h1>
    <?php  
     $db = mysqli_connect ('localhost', 'root', '', 'bddg8')  or die('Erreur de connexion '.mysqli_connect_error());
      $requete = "
        select* 
        from personne
        ";
      $resultat = mysqli_query($db,$requete);

      if (!$resultat) {
        echo "erreur au niveau de la requete".mysqli_error($db);
      } else {
		  
     ?>
            <table class="table">
                <theat>
                <tr>
                    <th> id </th>
                    <th> Civilité </th>
                    <th> nom_pre </th>
                    <th> Adresse </th>
                    <th> cod_post </th>
                    <th> localité </th>
                    <th> plat_form</th>
                    <th> pays </th>
                    <th> application </th>
                    <th> filiere </th>
                    <th> nationalité </th>
                    <th> sport </th>
                    <th> image </th>
                </tr>
                <theat>
                <tbody>
                <?php while ($ligne = mysqli_fetch_array($resultat)) {  
			
                ?>
                <tr>
                    <td><?php echo $ligne[('id')] ?> </td>
                    <td><?php echo $ligne[('Civilité')] ?></td>
                    <td><?php echo $ligne[('Nom_pre')] ?></td>
                    <td><?php echo $ligne[('Adresse')] ?></td>
                    <td><?php echo $ligne[('cod_post')] ?></td>
                    <td><?php echo $ligne[('localité')] ?></td>
                    <td><?php echo $ligne[('plat_form')] ?></td>
                    <td><?php echo $ligne[('pays')] ?></td>
                    <td><?php echo $ligne[('application')] ?></td>
                    <td><?php echo $ligne[('filiere')] ?></td>
                    <td><?php echo $ligne[('natio_nalite')] ?></td>
                    <td><?php echo $ligne[('sport')] ?></td>
                    <td><?php echo $ligne[('image')] ?></td>
                </tr>
                <?php } 
                ?>
                </tbody>
            </table>
      <?php }
     ?>
</body>
</html>