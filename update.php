<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    require("./connect.php");
    if ($_GET['update']) { // Si l'id de l'article se trouve dans l'URL sous la clé 'update' 
        $stmt = $db->prepare("SELECT * FROM article WHERE id=?"); // Requête SQL pour récupérer l'article par son 'id'
        $stmt->bind_param("i", $_GET['update']);
        $stmt->execute();

        $result = $stmt->get_result(); // Récupère l'article correspondant
        if ($result->num_rows > 0) { // S'il y a plus de 0 articles
            $article = $result->fetch_assoc(); // Stocke l'article dans la variable 'article' 
            // Affichez ici le formulaire avec les valeurs $article['title'], $article['content'] et $article['image_url']
    ?>
            <form method="post">
                <label for="title">Titre</label> <br>
                <input type="text" value="<?= $article['title'] ?>" name="title" id="title" placeholder="Le titre de l'article"> <br>
                <label for="content">Contenu</label> <br>
                <textarea name="content" id="content" cols="30" rows="10" placeholder="Le contenu de l'article"><?= $article["content"] ?></textarea> <br>
                <label for="image_url">Image URL</label> <br>
                <input type="text" name="image_url" value="<?= $article['image_url'] ?>" id="image_url" placeholder="L'URL de l'image de l'article"> <br>
                <input type="submit" value="Publier">
            </form>

    <?php

            if ($_POST) { // Si le formulaire POST est soumis
                $stmt = $db->prepare("UPDATE article SET title=?, content=?, image_url=? WHERE id=?"); // Requête SQL pour modifier l'article 
                $stmt->bind_param("sssi", $_POST['title'], $_POST['content'], $_POST['image_url'],  $article['id']);
                $stmt->execute();

                header("Location: index.php"); // Redirige l'utilisateur vers la page principale après la modification
            }
        }
    }
    ?>
</body>

</html>