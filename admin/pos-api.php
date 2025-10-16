<?php
// API backend pour la caisse
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$action = $input['action'] ?? '';

switch($action) {
    case 'quick_sale':
        // Traiter vente rapide
        $receipt_data = [
            'type' => 'sale',
            'items' => [['desc' => $input['description'], 'qty' => $input['quantity'], 'price' => $input['price']]],
            'total' => $input['total']
        ];
        echo json_encode(['success' => true, 'receipt_data' => $receipt_data]);
        break;
        
    case 'scanning':
        // Traiter scanner
        $receipt_data = [
            'type' => 'scan',
            'documents' => $input['documents'],
            'total' => $input['total']
        ];
        echo json_encode(['success' => true, 'receipt_data' => $receipt_data]);
        break;
        
    case 'customer_credit':
        // Traiter crédit client
        $receipt_data = [
            'type' => 'credit',
            'customer' => $input['customer_name'],
            'amount' => $input['amount'],
            'concept' => $input['concept']
        ];
        echo json_encode(['success' => true, 'receipt_data' => $receipt_data]);
        break;
        
    default:
        echo json_encode(['success' => false, 'error' => 'Action invalide']);
}
?>