<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h3>Commandes Fournisseurs</h3>
    <a href="<?= BASE_URL ?>/index.php?controleur=commande&action=create" class="btn">Passer une Commande</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Numéro</th>
                    <th>Date</th>
                    <th>Produit</th>
                    <th>Fournisseur commandé</th>
                    <th>Quantité</th>
                    <th>Statut</th>
                    <th>Créé par</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($commandes)): ?>
                    <tr>
                        <td colspan="8" style="text-align: center;">Aucune commande trouvée.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($commandes as $c): ?>
                        <tr>
                            <td>#<?= htmlspecialchars($c['id_commande']) ?></td>
                            <td><?= htmlspecialchars((new DateTime($c['date_commande']))->format('d/m/Y H:i')) ?></td>
                            <td><?= htmlspecialchars($c['nom_prod']) ?></td>
                            <td><?= htmlspecialchars($c['nom_fourni'] ?? 'N/A') ?></td>
                            <td style="font-weight: bold;"><?= htmlspecialchars($c['quantite']) ?></td>
                            <td>
                                <?php if ($c['statut'] === 'En attente'): ?>
                                    <span style="color: #d97706; font-weight: bold;">En attente</span>
                                <?php elseif ($c['statut'] === 'Reçue'): ?>
                                    <span style="color: var(--success-bg); font-weight: bold;">Reçue</span>
                                <?php elseif ($c['statut'] === 'Annulée'): ?>
                                    <span style="color: var(--danger-text); font-weight: bold;">Annulée</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($c['nom_utilisateur'] ?? '') ?></td>
                            <td>
                                <?php if ($c['statut'] === 'En attente'): ?>
                                    <a href="<?= BASE_URL ?>/index.php?controleur=commande&action=recevoir&id=<?= $c['id_commande'] ?>"
                                        class="btn btn-secondary"
                                        style="padding: 5px 10px; font-size: 12px; background-color: #28a745; color: white; border: none; text-decoration: none; display: inline-block; margin-bottom: 5px;"
                                        onclick="return confirm('Confirmez-vous la réception de cette commande ? Le stock sera mis à jour.');">Marquer Reçue</a>

                                    <a href="<?= BASE_URL ?>/index.php?controleur=commande&action=annuler&id=<?= $c['id_commande'] ?>"
                                        class="btn btn-danger"
                                        style="padding: 5px 10px; font-size: 12px; border: none; text-decoration: none; display: inline-block;"
                                        onclick="return confirm('Voulez-vous annuler cette commande ?');">Annuler</a>
                                <?php else: ?>
                                    <span style="color: #888; font-style: italic;">—</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>