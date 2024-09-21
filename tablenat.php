<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/styles/table.css">
    <title>table</title>
</head>
<body>
    <h1>  la table nationality :</h1>
    <?php  
     $db = mysqli_connect ('localhost', 'root', '', 'bddg8')  or die('Erreur de connexion '.mysqli_connect_error());
      $requete = "
        select* 
        from nationality
        ";
      $resultat = mysqli_query($db,$requete);

      if (!$resultat) {
        echo "erreur au niveau de la requete".mysqli_error($db);
      } else {
		  
     ?>
            <table class="table">
                <theat>
                <tr>
                    <th> nationalité </th>
                    <th> libélé </th>
                </tr>
                <theat>
                <tbody>
                <?php while ($ligne = mysqli_fetch_array($resultat)) {  
			
                ?>
                <tr>
                    <td><?php echo $ligne[('nom_natio')] ?></td>
                    <td><?php echo $ligne[('libele')] ?></td>
                </tr>
                <?php } 
                ?>
                </tbody>
            </table>
      <?php }
     ?>
</body>
</html>