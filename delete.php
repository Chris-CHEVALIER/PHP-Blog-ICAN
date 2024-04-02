<?php
require("connect.php");

if($_GET['delete']) { // Si l'id de la tâche est dans l'URL
  $stmt = $db->prepare("DELETE FROM article WHERE id=?"); // Requête SQL pour supprimer la tâche
  $stmt->bind_param("i", $_GET['delete']);
  $stmt->execute();

  header("Location: index.php"); // Redirige l'utilisateur vers la page principale après la suppression
}
?>