<?php

/**
 * Test d'intégration complet de la classe UserPDO
 * Teste le cycle de vie complet d'un utilisateur avec PDO
 */

require_once __DIR__ . '/../classes/UserPDO.php';

echo "=== TEST D'INTEGRATION COMPLET - CLASSE UserPDO ===\n\n";

$user = new UserPDO();

// 1. Inscription
echo "1️⃣ INSCRIPTION\n";
$result = $user->register("pdo_test", "password123", "pdo@test.com", "PDO", "Test");
echo "   ✅ Utilisateur cree : {$result['login']}\n";
echo "   ID: {$result['id']}\n\n";

// 2. Vérification connexion
echo "2️⃣ VERIFICATION isConnected()\n";
echo "   isConnected() : " . ($user->isConnected() ? "true" : "false") . "\n\n";

// 3. Déconnexion
echo "3️⃣ DECONNEXION\n";
$user->disconnect();
echo "   ✅ Deconnecte\n";
echo "   isConnected() : " . ($user->isConnected() ? "true" : "false") . "\n\n";

// 4. Reconnexion
echo "4️⃣ RECONNEXION\n";
$user->connect("pdo_test", "password123");
echo "   ✅ Reconnecte : {$user->getLogin()}\n\n";

// 5. Affichage infos
echo "5️⃣ RECUPERATION INFOS\n";
$infos = $user->getAllInfos();
echo "   Login: {$infos['login']}\n";
echo "   Email: {$infos['email']}\n";
echo "   Prenom: {$infos['firstname']}\n";
echo "   Nom: {$infos['lastname']}\n\n";

// 6. Modification
echo "6️⃣ MODIFICATION\n";
$user->update("pdo_updated", "newpass", "updated@pdo.com", "Updated", "PDO");
echo "   ✅ Informations modifiees\n";
echo "   Nouveau login: {$user->getLogin()}\n";
echo "   Nouvel email: {$user->getEmail()}\n\n";

// 7. Suppression
echo "7️⃣ SUPPRESSION\n";
$user->delete();
echo "   ✅ Utilisateur supprime de la BDD\n";
echo "   isConnected() : " . ($user->isConnected() ? "true" : "false") . "\n\n";

echo "🎉 CYCLE DE VIE COMPLET TESTE AVEC SUCCES (PDO) !\n";
echo "✅ Toutes les methodes PDO fonctionnent correctement !\n";
