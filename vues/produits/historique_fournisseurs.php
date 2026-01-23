<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h3>Historique des Commandes Fournisseur</h3>
    <a href="<?= BASE_URL ?>/index.php?controleur=produit&action=index" class="btn btn-secondary">Retour aux
        Produits</a>
</div>

<div class="card">
    <h4 style="margin-bottom: 15px; color: var(--primary-color);">Produit :
        <?= htmlspecialchars($nom_produit) ?>
    </h4>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Date de Commande</th>
                    <th>Fournisseur</th>
                    <th>Quantité Reçue (Entrée)</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($historique)): ?>
                    <tr>
                        <td colspan="3" style="text-align: center;">Vous n'avez passé commande chez aucun fournisseur pour
                            l'instant.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($historique as $h): ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars((new DateTime($h['date_mouv']))->format('d/m/Y H:i:s')) ?>
                            </td>
                            <td style="font-weight: bold;">
                                <?= htmlspecialchars($h['nom_fourni']) ?>
                            </td>
                            <td style="color: var(--success-bg); font-weight: bold;">+
                                <?= htmlspecialchars($h['qte_mouv']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>