<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Baraque - Connexion</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>

<body class="login-body">

    <div class="login-card">
        <h2>Connexion</h2>

        <?php if (isset($erreur)): ?>
            <div class="alert-danger">
                <?= htmlspecialchars($erreur) ?>
            </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/index.php?controleur=auth&action=authenticate" method="POST">
            <div class="form-group">
                <label for="login">Identifiant</label>
                <input type="text" id="login" name="login" class="form-control" required>
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-block">Se connecter</button>
        </form>
    </div>

</body>

</html>