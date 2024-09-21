<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/styles/table3.css">
    <title>table</title>
</head>
<body>
    <h1>  la table module :</h1>
    <?php  
     $db = mysqli_connect ('localhost', 'root', '', 'bddg8')  or die('Erreur de connexion '.mysqli_connect_error());
      $requete = "
        select* 
        from note
        ";
      $resultat = mysqli_query($db,$requete);

      if (!$resultat) {
        echo "erreur au niveau de la requete".mysqli_error($db);
      } else {
		  
     ?>
            <table class="table">
                <theat>
                <tr>
                    <th> num_etudient </th>
                    <th> code_module </th>
                    <th> filiere </th>
                    <th> coefficient </th>
                    <th> note </th>
                </tr>
                <theat>
                <tbody>
                <?php while ($ligne = mysqli_fetch_array($resultat)) {  
			
                ?>
                <tr>
                    <td><?php echo $ligne[('num_etudient')] ?> </td>
                    <td><?php echo $ligne[('code_module')] ?> </td>
                    <td><?php echo $ligne[('filiere')] ?></td>
                    <td><?php echo $ligne[('coefficient')] ?></td>
                    <td><?php echo $ligne[('note')] ?></td>
                </tr>
                <?php } 
                ?>
                </tbody>
            </table>
      <?php }
     ?>
</body>
</html>