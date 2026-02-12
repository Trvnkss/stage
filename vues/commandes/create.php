<div class="card" style="max-width: 650px; margin: 0 auto;">
    <h3>Passer une nouvelle commande</h3>

    <?php if (!empty($produitsEnAlerte)): ?>
        <div style="background:#fff8e1; border-left:4px solid #ffc107; padding:10px 15px; border-radius:4px; margin-top:15px;">
            <strong>⚠️ Produits en alerte de stock :</strong>
            <?php foreach ($produitsEnAlerte as $alerte): ?>
                <span style="display:inline-block; margin:3px 5px; background:#ffc107; color:#333; border-radius:4px; padding:2px 7px; font-size:12px;">
                    <?= htmlspecialchars($alerte['nom_prod']) ?>
                    (stock : <?= $alerte['stock_actuel'] ?> / seuil : <?= $alerte['seuil_alerte'] ?>)
                </span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>/index.php?controleur=commande&action=store" method="POST" style="margin-top: 20px;" id="formCommande">

        <div class="form-group">
            <label for="id_prod">Produit à commander</label>
            <select id="id_prod" name="id_prod" class="form-control" required onchange="majFournisseur(this)">
                <option value="">-- Sélectionner un produit --</option>
                <?php foreach ($produits as $p): ?>
                    <?php $enAlerte = in_array($p['id_prod'], $idsEnAlerte); ?>
                    <option value="<?= $p['id_prod'] ?>"
                        data-fourni="<?= $p['id_fourni'] ?>"
                        <?= $enAlerte ? 'style="font-weight:bold; color:#c0392b;"' : '' ?>>
                        <?= $enAlerte ? '⚠️ ' : '' ?><?= htmlspecialchars($p['nom_prod']) ?>
                        (fournisseur principal : <?= htmlspecialchars($p['nom_fourni'] ?? 'N/A') ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="id_fourni">Fournisseur à contacter</label>
            <select id="id_fourni" name="id_fourni" class="form-control" required>
                <option value="">-- Sélectionner un fournisseur --</option>
                <?php foreach ($fournisseurs as $f): ?>
                    <option value="<?= $f['id_fourni'] ?>">
                        <?= htmlspecialchars($f['nom_fourni']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <small style="color:#888;">Pré-rempli avec le fournisseur principal du produit, modifiable.</small>
        </div>

        <div class="form-group">
            <label for="quantite">Quantité à commander</label>
            <input type="number" id="quantite" name="quantite" class="form-control" min="1" value="1" required>
        </div>

        <div style="margin-top: 20px; display: flex; gap: 10px;">
            <button type="submit" class="btn">Enregistrer la commande</button>
            <a href="<?= BASE_URL ?>/index.php?controleur=commande&action=index" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>

<script>
// Données des fournisseurs principaux par produit
const fourniParProduit = {
<?php foreach ($produits as $p): ?>
    <?= $p['id_prod'] ?>: <?= $p['id_fourni'] ?>,
<?php endforeach; ?>
};

function majFournisseur(select) {
    const idProd   = parseInt(select.value);
    const idFourni = fourniParProduit[idProd];
    const selectFourni = document.getElementById('id_fourni');
    if (idFourni) {
        selectFourni.value = idFourni;
    }
}
</script>