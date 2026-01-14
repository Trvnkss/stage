<div style="display: flex; gap: 20px;">
    <!-- Liste des catégories -->
    <div class="card" style="flex: 2;">
        <h3>Liste des Catégories</h3>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom de la Catégorie</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($categories)): ?>
                        <tr>
                            <td colspan="3" style="text-align: center;">Aucune catégorie trouvée.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($categories as $c): ?>
                            <tr>
                                <td>
                                    <?= htmlspecialchars($c['id_categ']) ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars($c['libelle_categ']) ?>
                                </td>
                                <td>
                                    <a href="<?= BASE_URL ?>/index.php?controleur=categorie&action=edit&id=<?= $c['id_categ'] ?>"
                                        class="btn btn-secondary"
                                        style="padding: 5px 10px; font-size: 12px; text-decoration: none; display: inline-block;">Modifier</a>
                                    <a href="<?= BASE_URL ?>/index.php?controleur=categorie&action=delete&id=<?= $c['id_categ'] ?>"
                                        class="btn btn-danger"
                                        style="padding: 5px 10px; font-size: 12px; background-color: #dc3545; color: white; border: none; text-decoration: none; display: inline-block;"
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Formulaire d'ajout -->
    <div class="card" style="flex: 1; height: fit-content;">
        <h3>Ajouter une Catégorie</h3>
        <form action="<?= BASE_URL ?>/index.php?controleur=categorie&action=store" method="POST"
            style="margin-top: 20px;">
            <div class="form-group">
                <label for="libelle_categ">Nom de la Catégorie</label>
                <input type="text" id="libelle_categ" name="libelle_categ" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-block" style="margin-top: 10px;">Enregistrer</button>
        </form>
    </div>
</div>