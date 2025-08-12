<?php
header('Content-Type: application/json');
require_once '../includes/functions.php';

try {
    $category = $_GET['category'] ?? 'crypto_tl';
    $limit = (int)($_GET['limit'] ?? 50);
    
    // Validate category
    $valid_categories = ['crypto_tl', 'crypto_usd', 'forex'];
    if (!in_array($category, $valid_categories)) {
        $category = 'crypto_tl';
    }
    
    // Get market data
    $markets = getMarketData($category, $limit);
    
    echo json_encode([
        'success' => true,
        'markets' => $markets,
        'count' => count($markets),
        'category' => $category,
        'timestamp' => time()
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
