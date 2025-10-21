<?php

/**
 * Test de la méthode disconnect()
 */

require_once __DIR__ . '/../classes/User.php';

echo "=== TEST MÉTHODE disconnect() ===\n\n";

// 1. Créer et connecter un utilisateur
echo "--- Étape 1 : Connexion ---\n";
$user = new User();
$user->connect("alice", "motdepasse123");

echo "✅ Utilisateur connecté\n";
echo "  Login: {$user->login}\n";
echo "  Email: {$user->email}\n";
echo "  Prénom: {$user->firstname}\n";
echo "  Nom: {$user->lastname}\n\n";

// 2. Déconnecter
echo "--- Étape 2 : Déconnexion ---\n";
$user->disconnect();

echo "✅ Méthode disconnect() appelée\n\n";

// 3. Vérifier que les attributs sont vides
echo "--- Étape 3 : Vérification ---\n";
echo "  Login: " . ($user->login ?? "[NULL]") . "\n";
echo "  Email: " . ($user->email ?? "[NULL]") . "\n";
echo "  Prénom: " . ($user->firstname ?? "[NULL]") . "\n";
echo "  Nom: " . ($user->lastname ?? "[NULL]") . "\n\n";

// 4. Vérifier qu'on ne peut plus accéder aux infos
if ($user->login === null && $user->email === null) {
    echo "✅ Utilisateur correctement déconnecté !\n";
} else {
    echo "❌ ERREUR : Des attributs ne sont pas null\n";
}

echo "\n✅ Test terminé !\n";
