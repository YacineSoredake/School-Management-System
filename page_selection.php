<?php
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    
    // Rediriger en fonction de la sélection
    switch ($page) {
        case 'etudiant':
            header("Location: FormEtudient.php");
            break;
        case 'enseignant':
            header("Location: FormEnseignant.php");
            break;
        case 'module':
            header("Location: FormModule.php");
            break;
        case 'note':
            header("Location: FormNote.php");
            break;    
        case 'PV':
            header("Location: grades_page.php");
            break;
        case 'Stats':
            header("Location: moymoy.html");
            break;  
        case 'users':
            header("Location: user.php");       
        default:
            echo "Page non valide";
    }
}
?>
