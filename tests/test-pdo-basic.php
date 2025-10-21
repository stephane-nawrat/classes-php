<?php

/**
 * Test basique de la classe UserPDO
 */

require_once __DIR__ . '/../classes/UserPDO.php';

echo "=== TEST CLASSE UserPDO ===\n\n";

// Créer un objet UserPDO
echo "Creation d'un objet UserPDO...\n";
$user = new UserPDO();
echo "✅ Objet UserPDO cree !\n";
echo "✅ Connexion PDO etablie !\n\n";

// Modifier les attributs publics
$user->login = "test_pdo";
$user->email = "test@pdo.com";

echo "Test des attributs publics :\n";
echo "  Login: {$user->login}\n";
echo "  Email: {$user->email}\n\n";

echo "✅ Test termine !\n";
