<div class="card" style="max-width: 600px; margin: 0 auto;">
    <form action="<?= BASE_URL ?>/index.php?controleur=mouvement&action=store" method="POST">

        <div class="form-group">
            <label for="id_type_mouvement">Type de mouvement</label>
            <select id="id_type_mouvement" name="id_type_mouvement" class="form-control" required>
                <option value="">-- Sélectionner --</option>
                <?php foreach ($typesMouvement as $tm): ?>
                    <option value="<?= htmlspecialchars($tm['id_type_mouvement']) ?>">
                        <?= htmlspecialchars($tm['libelle_type_mouvement']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="id_prod">Produit</label>
            <select id="id_prod" name="id_prod" class="form-control" required>
                <option value="">-- Sélectionner un produit --</option>
                <?php foreach ($produits as $p): ?>
                    <option value="<?= htmlspecialchars($p['id_prod']) ?>">
                        <?= htmlspecialchars($p['nom_prod']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="qte_mouv">Quantité</label>
            <input type="number" id="qte_mouv" name="qte_mouv" class="form-control" min="1" required>
        </div>

        <div style="margin-top: 20px; display: flex; gap: 10px;">
            <button type="submit" class="btn">Enregistrer le mouvement</button>
            <a href="<?= BASE_URL ?>/index.php?controleur=mouvement&action=index" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>