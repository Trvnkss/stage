<div class="card-grid">
    <div class="card">
        <h3>Total Produits</h3>
        <div class="value"><?= $totalProduits ?></div>
    </div>

    <div class="card">
        <h3>Produits en Alerte</h3>
        <div class="value" style="color: var(--danger-text);"><?= $nbAlertesSansCmd ?></div>
        <div style="font-size: 0.85em; color: #555; margin-top: 4px;">sans commande en cours</div>
    </div>

    <div class="card">
        <h3>Alertes — Commande passée</h3>
        <div class="value" style="color: #d97706;"><?= $nbAlertesAvecCmd ?></div>
        <div style="font-size: 0.85em; color: #555; margin-top: 4px;">livraison en attente</div>
    </div>

    <div class="card">
        <h3>Fournisseurs Actifs</h3>
        <div class="value"><?= $fournisseurs ?></div>
    </div>
</div>

<div class="card" style="margin-bottom: 20px;">
    <h3>Actions Rapides</h3>
    <div style="margin-top: 15px; display: flex; gap: 10px;">
        <a href="<?= BASE_URL ?>/index.php?controleur=mouvement&action=create" class="btn">Entrer un stock</a>
        <a href="<?= BASE_URL ?>/index.php?controleur=produit&action=create" class="btn btn-secondary">Nouveau Produit</a>
        <a href="<?= BASE_URL ?>/index.php?controleur=commande&action=create" class="btn" style="background-color: #ffc107; color: #333;">Passer une Commande</a>
    </div>
</div>

<?php if ($ruptures > 0): ?>
<div class="card">
    <h3 style="color: var(--danger-text);">Produits nécessitant votre attention (<?= $ruptures ?>)</h3>

    <div class="table-responsive" style="margin-top: 15px;">
        <table class="table">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Nom</th>
                    <th>Stock Réel</th>
                    <th>Stock Attendu</th>
                    <th>Seuil d'alerte</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produits as $p): ?>
                    <?php
                        $commandeEnCours = $p['commande_en_cours'] ?? false;
                        $styleLigne = $commandeEnCours ? 'background-color: #fff8e1;' : 'background-color: #fff0f0;';
                    ?>
                    <tr style="<?= $styleLigne ?>">
                        <td><?= htmlspecialchars($p['id_prod'] ?? '') ?></td>
                        <td><?= htmlspecialchars($p['nom_prod'] ?? '') ?></td>
                        <td style="color: var(--danger-text); font-weight: bold;">
                            <?= htmlspecialchars($p['stock_actuel']) ?>
                        </td>
                        <td style="color: #17a2b8; font-weight: bold;">
                            <?= htmlspecialchars($p['stock_attendu']) ?>
                        </td>
                        <td><?= htmlspecialchars($p['seuil_alerte']) ?></td>
                        <td>
                            <?php if ($commandeEnCours): ?>
                                <span style="background:#ffc107; color:#333; border-radius:4px; padding:3px 8px; font-size:12px; font-weight:bold;">Commande en cours</span>
                            <?php else: ?>
                                <span style="background:#dc3545; color:white; border-radius:4px; padding:3px 8px; font-size:12px; font-weight:bold;">Stock critique</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php else: ?>
<div class="card">
    <h3 style="color: #28a745;">Tous les stocks sont au-dessus du seuil d'alerte</h3>
    <p style="margin-top: 15px; color: #555;">Aucun produit en alerte.</p>
</div>
<?php endif; ?>