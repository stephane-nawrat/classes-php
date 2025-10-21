<?php

/**
 * Test de la configuration database
 */

// Inclusion de la configuration
require_once __DIR__ . '/../config/database.php';

// Affichage des constantes
echo "=== TEST CONFIGURATION DATABASE ===\n\n";
echo "DB_HOST: " . DB_HOST . "\n";
echo "DB_USER: " . DB_USER . "\n";
echo "DB_PASS: " . (DB_PASS ? "[MASQUÉ]" : "[VIDE]") . "\n";
echo "DB_NAME: " . DB_NAME . "\n";
echo "DB_PORT: " . DB_PORT . "\n";
echo "DB_CHARSET: " . DB_CHARSET . "\n\n";
echo "✅ Configuration chargée avec succès !\n";
