<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h3>Historique des Mouvements</h3>
    <a href="<?= BASE_URL ?>/index.php?controleur=mouvement&action=create" class="btn">Nouveau Mouvement</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Produit</th>
                    <th>Type</th>
                    <th>Quantité</th>
                    <th>Utilisateur</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($mouvements)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Aucun mouvement trouvé.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($mouvements as $m): ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars(date('d/m/Y H:i', strtotime($m['date_mouv']))) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($m['nom_prod']) ?>
                            </td>
                            <td>
                                <?php if ($m['libelle_type_mouvement'] == 'Entrée'): ?>
                                    <span style="color: #059669; font-weight: bold;">Entrée</span>
                                <?php else: ?>
                                    <span style="color: #dc2626; font-weight: bold;">Sortie</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($m['qte_mouv']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($m['nom_utilisateur'] ?? 'Inconnu') ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>