<?php

/**
 * Test des méthodes isConnected(), getAllInfos() et getters
 */

require_once __DIR__ . '/../classes/User.php';

echo "=== TEST MÉTHODES GETTERS & isConnected() ===\n\n";

// Test 1 : isConnected() sans connexion
echo "--- Test 1 : isConnected() sans connexion ---\n";
$user1 = new User();

if ($user1->isConnected()) {
    echo "❌ ERREUR : isConnected() retourne true sans connexion !\n";
} else {
    echo "✅ isConnected() retourne false (normal)\n";
}

echo "\n";

// Test 2 : isConnected() après connexion
echo "--- Test 2 : isConnected() après connexion ---\n";
$user2 = new User();
$user2->connect("alice_updated", "nouveau_password");

if ($user2->isConnected()) {
    echo "✅ isConnected() retourne true après connexion\n";
} else {
    echo "❌ ERREUR : isConnected() retourne false alors qu'on est connecté !\n";
}

echo "\n";

// Test 3 : getAllInfos()
echo "--- Test 3 : getAllInfos() ---\n";
$infos = $user2->getAllInfos();

if ($infos !== null) {
    echo "✅ getAllInfos() retourne un tableau :\n";
    print_r($infos);
} else {
    echo "❌ ERREUR : getAllInfos() retourne null\n";
}

echo "\n";

// Test 4 : Tous les getters
echo "--- Test 4 : Getters individuels ---\n";
echo "getLogin() : " . $user2->getLogin() . "\n";
echo "getEmail() : " . $user2->getEmail() . "\n";
echo "getFirstname() : " . $user2->getFirstname() . "\n";
echo "getLastname() : " . $user2->getLastname() . "\n";

echo "\n";

// Test 5 : isConnected() après disconnect()
echo "--- Test 5 : isConnected() après disconnect() ---\n";
$user2->disconnect();

if ($user2->isConnected()) {
    echo "❌ ERREUR : isConnected() retourne true après disconnect() !\n";
} else {
    echo "✅ isConnected() retourne false après disconnect()\n";
}

echo "\n";

// Test 6 : getAllInfos() après disconnect()
echo "--- Test 6 : getAllInfos() après disconnect() ---\n";
$infos = $user2->getAllInfos();

if ($infos === null) {
    echo "✅ getAllInfos() retourne null après disconnect()\n";
} else {
    echo "❌ ERREUR : getAllInfos() retourne encore des données !\n";
}

echo "\n✅ Tous les tests terminés !\n";
