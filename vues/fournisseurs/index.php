<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h3>Liste des Fournisseurs</h3>
    <a href="<?= BASE_URL ?>/index.php?controleur=fournisseur&action=create" class="btn">Ajouter Nouveau Fournisseur</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Téléphone</th>
                    <th>Adresse</th>
                    <th>Code Postal</th>
                    <th>Ville</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($fournisseurs)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center;">Aucun fournisseur trouvé.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($fournisseurs as $f): ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars($f['id_fourni']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($f['nom_fourni']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($f['tel_fourni']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($f['rue_fourni']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($f['cp_fourni']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($f['ville_fourni']) ?>
                            </td>
                            <td>
                                <a href="<?= BASE_URL ?>/index.php?controleur=fournisseur&action=edit&id=<?= $f['id_fourni'] ?>"
                                    class="btn btn-secondary"
                                    style="padding: 5px 10px; font-size: 12px; text-decoration: none; display: inline-block;">Modifier</a>
                                <a href="<?= BASE_URL ?>/index.php?controleur=fournisseur&action=delete&id=<?= $f['id_fourni'] ?>"
                                    class="btn btn-danger"
                                    style="padding: 5px 10px; font-size: 12px; background-color: #dc3545; color: white; border: none; text-decoration: none; display: inline-block;"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce fournisseur ?');">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>