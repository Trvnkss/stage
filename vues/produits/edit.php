<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h3>Modifier le Produit</h3>
    <form
        action="<?= BASE_URL ?>/index.php?controleur=produit&action=update&id=<?= htmlspecialchars($produit['id_prod']) ?>"
        method="POST" style="margin-top: 20px;">
        <div class="form-group">
            <label for="nom_prod">Nom du Produit</label>
            <input type="text" id="nom_prod" name="nom_prod" class="form-control"
                value="<?= htmlspecialchars($produit['nom_prod']) ?>" required>
        </div>

        <div class="form-group" style="display: flex; gap: 15px;">
            <div style="flex: 1;">
                <label for="unite">Unité</label>
                <select id="unite" name="unite" class="form-control" required>
                    <option value="Pièces" <?= $produit['unite'] == 'Pièces' ? 'selected' : '' ?>>Pièces</option>
                    <option value="Kg" <?= $produit['unite'] == 'Kg' ? 'selected' : '' ?>>Kg</option>
                    <option value="Litres" <?= $produit['unite'] == 'Litres' ? 'selected' : '' ?>>Litres</option>
                </select>
            </div>
            <div style="flex: 1;">
                <label for="stock_initial">Stock Initial</label>
                <input type="number" id="stock_initial" name="stock_initial" class="form-control"
                    value="<?= htmlspecialchars($produit['stock_initial']) ?>" min="0" required>
            </div>
            <div style="flex: 1;">
                <label for="seuil_alerte">Seuil d'alerte</label>
                <input type="number" id="seuil_alerte" name="seuil_alerte" class="form-control"
                    value="<?= htmlspecialchars($produit['seuil_alerte'] ?? 5) ?>" min="0" required>
            </div>
        </div>

        <div class="form-group">
            <label for="id_categ">Catégorie</label>
            <select id="id_categ" name="id_categ" class="form-control" required>
                <option value="">Sélectionner une catégorie</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= $c['id_categ'] ?>" <?= ($c['id_categ'] == $produit['id_categ']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['libelle_categ']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="id_fourni">Fournisseur</label>
            <select id="id_fourni" name="id_fourni" class="form-control" required>
                <option value="">Sélectionner un fournisseur</option>
                <?php foreach ($fournisseurs as $f): ?>
                    <option value="<?= $f['id_fourni'] ?>" <?= ($f['id_fourni'] == $produit['id_fourni']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($f['nom_fourni']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div style="margin-top: 20px; display: flex; gap: 10px;">
            <button type="submit" class="btn">Mettre à jour</button>
            <a href="<?= BASE_URL ?>/index.php?controleur=produit&action=index" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>