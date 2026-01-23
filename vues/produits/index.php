<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h3>Liste des Produits</h3>
    <a href="<?= BASE_URL ?>/index.php?controleur=produit&action=create" class="btn">Ajouter Nouveau Produit</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom du Produit</th>
                    <th>Catégorie</th>
                    <th>Fournisseur</th>
                    <th>Stock Réel</th>
                    <th>Stock Attendu</th>
                    <th>Seuil Alerte</th>
                    <th>Unité</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($produits)): ?>
                    <tr>
                        <td colspan="9" style="text-align: center;">Aucun produit trouvé.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($produits as $p): ?>
                        <?php
                            $stockActuel   = $p['quantite_stock'];
                            $seuilAlerte   = $p['seuil_alerte'] ?? 5;
                            $stockAttendu  = $p['stock_attendu'];
                            $estEnAlerte   = $stockActuel <= $seuilAlerte;
                            // Commande couvre le seuil si stock_attendu > seuil
                            $commandeEnCours = $estEnAlerte && ($stockAttendu > $seuilAlerte);

                            if ($commandeEnCours) {
                                $styleLigne = 'background-color: #fff8e1;'; // orange clair
                            } elseif ($estEnAlerte) {
                                $styleLigne = 'background-color: #fff0f0;'; // rouge clair
                            } else {
                                $styleLigne = '';
                            }
                        ?>
                        <tr style="<?= $styleLigne ?>">
                            <td><?= htmlspecialchars($p['id_prod']) ?></td>
                            <td>
                                <?= htmlspecialchars($p['nom_prod']) ?>
                                <?php if ($commandeEnCours): ?>
                                    <span title="Commande en cours" style="background:#ffc107; color:#333; border-radius:4px; padding:2px 6px; font-size:11px; margin-left:5px;">Cmd en cours</span>
                                <?php elseif ($estEnAlerte): ?>
                                    <span title="Stock critique" style="background:#dc3545; color:white; border-radius:4px; padding:2px 6px; font-size:11px; margin-left:5px;">Alerte</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($p['libelle_categ'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($p['nom_fourni'] ?? 'N/A') ?></td>

                            <td style="font-weight: bold; color: <?= $estEnAlerte ? 'var(--danger-text)' : 'inherit' ?>;">
                                <?= htmlspecialchars($stockActuel) ?>
                            </td>

                            <td style="color: #17a2b8; font-weight: bold;">
                                <?= htmlspecialchars($stockAttendu) ?>
                            </td>

                            <td><?= htmlspecialchars($seuilAlerte) ?></td>

                            <td><?= htmlspecialchars($p['unite']) ?></td>

                            <td>
                                <a href="<?= BASE_URL ?>/index.php?controleur=produit&action=edit&id=<?= $p['id_prod'] ?>"
                                    class="btn btn-secondary"
                                    style="padding: 5px 10px; font-size: 12px; text-decoration: none; display: inline-block; margin-bottom: 4px;">Modifier</a>

                                <a href="<?= BASE_URL ?>/index.php?controleur=produit&action=delete&id=<?= $p['id_prod'] ?>"
                                    class="btn btn-danger"
                                    style="padding: 5px 10px; font-size: 12px; background-color: #dc3545; color: white; border: none; text-decoration: none; display: inline-block; margin-bottom: 4px;"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">Supprimer</a>
                                <br>
                                <a href="<?= BASE_URL ?>/index.php?controleur=mouvement&action=index&id_prod=<?= $p['id_prod'] ?>"
                                    class="btn btn-secondary"
                                    style="padding: 5px 10px; font-size: 12px; background-color: #17a2b8; color: white; border: none; text-decoration: none; display: inline-block; margin-top: 4px;">Mouvements</a>

                                <a href="<?= BASE_URL ?>/index.php?controleur=produit&action=historiqueFournisseurs&id=<?= $p['id_prod'] ?>"
                                    class="btn btn-secondary"
                                    style="padding: 5px 10px; font-size: 12px; background-color: #ffc107; color: #333; border: none; text-decoration: none; display: inline-block; margin-top: 4px;">Fournisseurs</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>