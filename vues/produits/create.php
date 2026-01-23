<div class="card" style="max-width: 600px; margin: 0 auto;">
    <form action="<?= BASE_URL ?>/index.php?controleur=produit&action=store" method="POST">

        <div class="form-group">
            <label for="nom_prod">Nom du Produit</label>
            <input type="text" id="nom_prod" name="nom_prod" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="id_categ">Catégorie</label>
            <select id="id_categ" name="id_categ" class="form-control" required>
                <option value="">-- Sélectionner une catégorie --</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= htmlspecialchars($c['id_categ']) ?>">
                        <?= htmlspecialchars($c['libelle_categ']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="id_fourni">Fournisseur Principal</label>
            <select id="id_fourni" name="id_fourni" class="form-control" required>
                <option value="">-- Sélectionner un fournisseur --</option>
                <?php foreach ($fournisseurs as $f): ?>
                    <option value="<?= htmlspecialchars($f['id_fourni']) ?>">
                        <?= htmlspecialchars($f['nom_fourni']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div style="display: flex; gap: 20px;">
            <div class="form-group" style="flex: 1;">
                <label for="stock_initial">Stock Initial</label>
                <input type="number" id="stock_initial" name="stock_initial" class="form-control" min="0" value="0"
                    required>
            </div>

            <div class="form-group" style="flex: 1;">
                <label for="seuil_alerte">Seuil d'alerte</label>
                <input type="number" id="seuil_alerte" name="seuil_alerte" class="form-control" min="0" value="5"
                    required>
            </div>

            <div class="form-group" style="flex: 1;">
                <label for="unite">Unité de mesure</label>
                <select id="unite" name="unite" class="form-control" required>
                    <option value="">-- Choisir --</option>
                    <option value="Pièces">Pièces</option>
                    <option value="Kg">Kg</option>
                    <option value="Litres">Litres</option>
                </select>
            </div>
        </div>

        <div style="margin-top: 20px; display: flex; gap: 10px;">
            <button type="submit" class="btn">Enregistrer</button>
            <a href="<?= BASE_URL ?>/index.php?controleur=produit&action=index" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>