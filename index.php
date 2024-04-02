<!DOCTYPE html>
<html lang="fr-FR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <form method="post">
    <label for="title">Titre</label> <br>
    <input type="text" name="title" id="title" placeholder="Le titre de l'article"> <br>
    <label for="content">Contenu</label> <br>
    <textarea name="content" id="content" cols="30" rows="10" placeholder="Le contenu de l'article"></textarea> <br>
    <label for="image_url">Image URL</label> <br>
    <input type="text" name="image_url" id="image_url" placeholder="L'URL de l'image de l'article"> <br>
    <input type="submit" value="Publier">
  </form>
</body>

</html>

<?php

require("./connect.php");

if ($_POST) { // Si le formulaire POST est soumis
  $stmt = $db->prepare("INSERT INTO article (title, content, image_url) VALUES (?, ?, ?)"); // Requête SQL pour ajouter un nouvel article en base
  $stmt->bind_param("sss", $_POST['title'], $_POST['content'], $_POST['image_url']);
  $stmt->execute();

  header("Location: index.php"); // Redirige l'utilisateur vers la page principale après l'insertion
}

$result = $db->query("SELECT * FROM article"); // Requête SQL pour récupérer tous les articles en base

if ($result->num_rows > 0) { // S'il y a plus de 0 articles
  // Parcours et affiche chacun des articles enregistrés en base
  while($article = $result->fetch_assoc()) {
  //foreach ($result->fetch_assoc() as $article) {
    echo "<article><h2>{$article["title"]}</h2>";
    echo "<a href='update.php?update={$article['id']}'>Modifier</a> <a href='delete.php?delete={$article['id']}'>Supprimer</a> <br>";
    echo "<img src={$article["image_url"]} width='220px' alt={$article["title"]}><br>";
    echo "<p>{$article["content"]}</p></article>";
  }
} else {
  echo "Aucun article trouvé...";
}
?>