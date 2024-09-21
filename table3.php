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
        from module
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
                    <th> code </th>
                    <th> designation </th>
                    <th> coefficient </th>
                    <th> Volume Horaire </th>
                    <th> filiere </th>
                    <th> type </th>

                </tr>
                <theat>
                <tbody>
                <?php while ($ligne = mysqli_fetch_array($resultat)) {  
			
                ?>
                <tr>
                    <td><?php echo $ligne[('ID')] ?> </td>
                    <td><?php echo $ligne[('code')] ?> </td>
                    <td><?php echo $ligne[('designation')] ?></td>
                    <td><?php echo $ligne[('coefficient')] ?></td>
                    <td><?php echo $ligne[('volume')] ?></td>
                    <td><?php echo $ligne[('Filiere')] ?></td>
                    <td><?php echo $ligne[('type')] ?></td>
                </tr>
                <?php } 
                ?>
                </tbody>
            </table>
      <?php }
     ?>
</body>
</html>