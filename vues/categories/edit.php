<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h3>Modifier la Catégorie</h3>
    <form
        action="<?= BASE_URL ?>/index.php?controleur=categorie&action=update&id=<?= htmlspecialchars($categorie['id_categ']) ?>"
        method="POST" style="margin-top: 20px;">
        <div class="form-group">
            <label for="libelle_categ">Nom de la Catégorie</label>
            <input type="text" id="libelle_categ" name="libelle_categ" class="form-control"
                value="<?= htmlspecialchars($categorie['libelle_categ']) ?>" required>
        </div>

        <div style="margin-top: 20px; display: flex; gap: 10px;">
            <button type="submit" class="btn">Mettre à jour</button>
            <a href="<?= BASE_URL ?>/index.php?controleur=categorie&action=index" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>