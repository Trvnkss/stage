<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Baraque</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>
    <div class="wrapper">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>La Baraque</h2>
            </div>
            <ul class="sidebar-nav">
                <li>
                    <a href="<?= BASE_URL ?>/index.php?controleur=dashboard&action=index" class="<?= $controllerName === 'dashboard' ? 'active' : '' ?>">Tableau de bord</a>
                </li>
            </ul>
        </aside>
        <main class="main-content">
            <header class="topbar">
                <h2><?= htmlspecialchars($pageTitle ?? 'Tableau de bord') ?></h2>
                <div class="user-info">
                    Bonjour, <?= htmlspecialchars($_SESSION['user_nom'] ?? 'Utilisateur') ?>
                    <span style="color: #6b7280; font-size: 0.9em;">(<?= htmlspecialchars($_SESSION['user_role'] ?? '') ?>)</span>
                    | <a href="<?= BASE_URL ?>/index.php?controleur=auth&action=logout" class="logout-btn">Déconnexion</a>
                </div>
            </header>
            <div class="content">
                <?= $content ?>
            </div>
        </main>
    </div>
</body>
</html>
