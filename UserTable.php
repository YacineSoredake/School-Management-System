<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/styles/table3.css">
    <title>table</title>
</head>
<body>
    <h1>  la table user :</h1>
    <?php  
     $db = mysqli_connect ('localhost', 'root', '', 'bddg8')  or die('Erreur de connexion '.mysqli_connect_error());
      $requete = "
        select* 
        from user
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
                    <th> EMAIL </th>
                    <th> PASSWROD </th>
                    <th> ROLE </th>
                    <th> student_id </th>
                   
                </tr>
                <theat>
                <tbody>
                <?php while ($ligne = mysqli_fetch_array($resultat)) {  
			
                ?>
                <tr>
                    <td><?php echo $ligne[('id')] ?> </td>
                    <td><?php echo $ligne[('email')] ?> </td>
                    <td><?php echo $ligne[('mdp')] ?></td>
                    <td><?php echo $ligne[('role')] ?></td>
                    <td><?php echo $ligne[('id_etudient')] ?></td>
                </tr>
                <?php } 
                ?>
                </tbody>
            </table>
      <?php }
     ?>
</body>
</html>