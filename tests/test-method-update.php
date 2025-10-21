<?php

/**
 * Test de la méthode update()
 */

require_once __DIR__ . '/../classes/User.php';

echo "=== TEST MÉTHODE update() ===\n\n";

// Test 1 : Essayer de modifier SANS être connecté
echo "--- Test 1 : Modification sans connexion ---\n";
$user1 = new User();
$result = $user1->update("test", "pass", "test@mail.com", "Test", "User");

if ($result) {
    echo "❌ ERREUR : Modification réussie sans être connecté !\n";
} else {
    echo "✅ Modification refusée (normal, pas connecté)\n";
}

echo "\n";

// Test 2 : Connexion puis modification
echo "--- Test 2 : Connexion puis modification ---\n";
$user2 = new User();

// Connexion avec alice
echo "Connexion avec 'alice'...\n";
$user2->connect("alice", "motdepasse123");
echo "✅ Connecté\n";
echo "Avant modification :\n";
echo "  Login: {$user2->login}\n";
echo "  Email: {$user2->email}\n";
echo "  Prénom: {$user2->firstname}\n";
echo "  Nom: {$user2->lastname}\n\n";

// Modification
echo "Modification des informations...\n";
$result = $user2->update(
    "alice_updated",
    "nouveau_password",
    "alice.updated@mail.com",
    "Alice-Marie",
    "Dupont-Martin"
);

if ($result) {
    echo "✅ Modification réussie !\n";
    echo "Après modification :\n";
    echo "  Login: {$user2->login}\n";
    echo "  Email: {$user2->email}\n";
    echo "  Prénom: {$user2->firstname}\n";
    echo "  Nom: {$user2->lastname}\n";
} else {
    echo "❌ ERREUR : Modification échouée\n";
}

echo "\n";

// Test 3 : Vérifier en BDD avec le nouveau mot de passe
echo "--- Test 3 : Vérification du nouveau mot de passe ---\n";
$user3 = new User();

// Ancien mot de passe (doit échouer)
echo "Test avec ancien mot de passe...\n";
$result = $user3->connect("alice_updated", "motdepasse123");
if ($result) {
    echo "❌ ERREUR : Ancien mot de passe fonctionne encore !\n";
} else {
    echo "✅ Ancien mot de passe refusé (normal)\n";
}

// Nouveau mot de passe (doit réussir)
echo "Test avec nouveau mot de passe...\n";
$result = $user3->connect("alice_updated", "nouveau_password");
if ($result) {
    echo "✅ Nouveau mot de passe accepté !\n";
} else {
    echo "❌ ERREUR : Nouveau mot de passe refusé\n";
}

echo "\n✅ Tous les tests terminés !\n";
