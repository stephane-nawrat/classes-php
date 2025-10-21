<?php

/**
 * Test de connexion MySQLi à la base de données
 * Vérifie que les credentials sont corrects et que la connexion fonctionne
 */

// Inclusion de la configuration
require_once __DIR__ . '/../config/database.php';

echo "=== TEST CONNEXION MySQL ===\n\n";
echo "Configuration chargée :\n";
echo "  Host: " . DB_HOST . "\n";
echo "  User: " . DB_USER . "\n";
echo "  Database: " . DB_NAME . "\n";
echo "  Port: " . DB_PORT . "\n\n";

// Tentative de connexion avec MySQLi
echo "Tentative de connexion...\n";
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

// Vérification de la connexion
if (!$conn) {
    die("❌ ERREUR de connexion : " . mysqli_connect_error() . "\n");
}

echo "✅ Connexion réussie !\n";
echo "Serveur MySQL version : " . mysqli_get_server_info($conn) . "\n\n";

// Test : Lister les tables de la base
$result = mysqli_query($conn, "SHOW TABLES");
echo "Tables dans la base '" . DB_NAME . "' :\n";

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        echo "  - " . $row[0] . "\n";
    }
} else {
    echo "  (Aucune table pour le moment)\n";
}

// Fermeture de la connexion
mysqli_close($conn);
echo "\n✅ Connexion fermée proprement.\n";
