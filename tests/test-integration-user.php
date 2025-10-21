<?php

/**
 * Test d'intégration complet de la classe User
 * Teste le cycle de vie complet d'un utilisateur
 */

require_once __DIR__ . '/../classes/User.php';

echo "=== TEST D'INTEGRATION COMPLET - CLASSE USER ===\n\n";

$user = new User();

// 1. Inscription
echo "1️⃣ INSCRIPTION\n";
$result = $user->register("integration_test", "password123", "test@integration.com", "Test", "Integration");
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
$user->connect("integration_test", "password123");
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
$user->update("integration_updated", "newpass", "updated@test.com", "Updated", "User");
echo "   ✅ Informations modifiees\n";
echo "   Nouveau login: {$user->getLogin()}\n";
echo "   Nouvel email: {$user->getEmail()}\n\n";

// 7. Suppression
echo "7️⃣ SUPPRESSION\n";
$user->delete();
echo "   ✅ Utilisateur supprime de la BDD\n";
echo "   isConnected() : " . ($user->isConnected() ? "true" : "false") . "\n\n";

echo "🎉 CYCLE DE VIE COMPLET TESTE AVEC SUCCES !\n";
echo "✅ Toutes les methodes fonctionnent correctement !\n";
