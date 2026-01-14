<div class="card" style="max-width: 600px; margin: 0 auto;">
    <form action="<?= BASE_URL ?>/index.php?controleur=fournisseur&action=store" method="POST">

        <div class="form-group">
            <label for="nom_fourni">Nom du Fournisseur</label>
            <input type="text" id="nom_fourni" name="nom_fourni" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="tel_fourni">Téléphone</label>
            <input type="text" id="tel_fourni" name="tel_fourni" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="rue_fourni">Rue / Adresse</label>
            <input type="text" id="rue_fourni" name="rue_fourni" class="form-control" required>
        </div>

        <div style="display: flex; gap: 20px;">
            <div class="form-group" style="flex: 1;">
                <label for="cp_fourni">Code Postal</label>
                <input type="text" id="cp_fourni" name="cp_fourni" class="form-control" required>
            </div>

            <div class="form-group" style="flex: 2;">
                <label for="ville_fourni">Ville</label>
                <input type="text" id="ville_fourni" name="ville_fourni" class="form-control" required>
            </div>
        </div>

        <div style="margin-top: 20px; display: flex; gap: 10px;">
            <button type="submit" class="btn">Enregistrer</button>
            <a href="<?= BASE_URL ?>/index.php?controleur=fournisseur&action=index"
                class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>