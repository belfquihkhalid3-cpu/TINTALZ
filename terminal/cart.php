<?php
session_start();
// Récupérer token depuis session ou URL
if (isset($_GET['token'])) {
    $_SESSION['terminal_token'] = $_GET['token'];
}
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/user_functions.php';
require_once '../includes/security_headers.php';
// Détecter mode terminal
$is_terminal = false;
$terminal_info = null;

// Vérifier si vient d'un terminal
if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], '/terminal/') !== false) {
    $is_terminal = true;
    require_once 'config.php';
    $terminal_info = getTerminalInfo();
}

// Permettre les invités des terminaux
$is_guest_terminal = isset($_GET['guest']) || isset($_POST['guest']) || 
                     (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], '/terminal/') !== false);


if (!isLoggedIn() && $is_guest_terminal) {
    $user = [
        'first_name' => 'Cliente',
        'last_name' => 'Invitado',
        'email' => 'invitado@terminal.local'
    ];
} else {
    $user = getCurrentUser();
}
$user = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito - Tinta Expres LZ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
 <style>
@media (max-width: 768px) {
    /* Reset général */
    * {
        box-sizing: border-box !important;
    }
    
    body {
        overflow-x: hidden !important;
        width: 100% !important;
    }
    
    /* Header responsive */
    header {
        padding: 8px !important;
    }
    
    header .max-w-full {
        padding: 0 10px !important;
    }
    
    header .flex {
        flex-direction: column;
        gap: 10px;
        align-items: center;
    }
    
    /* Logo et titre */
    header img {
        height: 40px !important;
        width: 40px !important;
    }
    
    header h1 {
        font-size: 16px !important;
        text-align: center;
    }
    
    /* Masquer éléments header */
    header .space-x-4 {
        display: none !important;
    }
    
    /* Container principal */
    .container, .max-w-7xl {
        width: 100% !important;
        padding: 10px !important;
        margin: 0 !important;
    }
    
    /* Grid responsive */
    .grid {
        display: block !important;
    }
    
    .grid > div {
        width: 100% !important;
        margin-bottom: 20px;
    }
    
    /* Table responsive */
    .overflow-x-auto {
        overflow-x: scroll !important;
        -webkit-overflow-scrolling: touch;
        margin: 0 -10px;
    }
    
    table {
        min-width: 100%;
        font-size: 12px;
    }
    
    th, td {
        padding: 5px !important;
        white-space: nowrap;
    }
    
    /* Images produits */
    .w-24, .h-24 {
        width: 50px !important;
        height: 50px !important;
    }
    
    /* Cards */
    .bg-white {
        margin: 0 5px 15px 5px !important;
        border-radius: 8px !important;
    }
    
    .p-6 {
        padding: 15px !important;
    }
    
    /* Textes */
    .text-2xl {
        font-size: 18px !important;
    }
    
    .text-lg {
        font-size: 14px !important;
    }
    
    .text-sm {
        font-size: 11px !important;
    }
    
    /* Boutons */
    button, .btn {
        width: 100% !important;
        padding: 12px !important;
        margin: 5px 0 !important;
        font-size: 14px !important;
    }
    
    .flex.space-x-4 {
        flex-direction: column !important;
        space-x: 0 !important;
        gap: 10px;
    }
    
    /* Summary card en bas fixe */
    .sticky {
        position: fixed !important;
        bottom: 0 !important;
        left: 0 !important;
        right: 0 !important;
        top: auto !important;
        margin: 0 !important;
        border-radius: 20px 20px 0 0 !important;
        box-shadow: 0 -2px 15px rgba(0,0,0,0.1) !important;
        z-index: 40;
        max-height: 50vh;
        overflow-y: auto;
    }
    
    /* Padding pour éviter overlap */
    main {
        padding-bottom: 350px !important;
    }
    
    /* WhatsApp button position */
    .whatsapp-btn {
        bottom: 320px !important;
        right: 10px !important;
        width: 50px !important;
        height: 50px !important;
    }
}

/* Très petits écrans */
@media (max-width: 380px) {
    table {
        font-size: 10px !important;
    }
    
    .px-4 {
        padding-left: 5px !important;
        padding-right: 5px !important;
    }
    
    button {
        font-size: 12px !important;
        padding: 10px !important;
    }
}


@media (max-width: 768px) {
    /* Container principal des dossiers */
    .cart-items, tbody {
        display: flex !important;
        flex-direction: column !important;
        gap: 10px !important;
        padding: 10px !important;
    }
    
    /* Chaque ligne/dossier */
    tr, .folder-row {
        display: flex !important;
        flex-direction: column !important;
        background: white !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 12px !important;
        padding: 12px !important;
        margin: 0 !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05) !important;
    }
    
    /* Header avec titre et prix */
    .folder-header {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        margin-bottom: 10px !important;
        padding-bottom: 10px !important;
        border-bottom: 1px solid #f3f4f6 !important;
    }
    
    /* Badges de couleur en grille */
    .color-badges {
        display: grid !important;
        grid-template-columns: repeat(6, 30px) !important;
        gap: 4px !important;
        margin-bottom: 10px !important;
    }
    
    .color-badges span {
        width: 30px !important;
        height: 30px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 11px !important;
        font-weight: bold !important;
        border-radius: 6px !important;
        color: white !important;
    }
    
    /* Contrôles quantité */
    .quantity-controls {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 10px !important;
        background: #f9fafb !important;
        padding: 8px !important;
        border-radius: 8px !important;
    }
    
    .quantity-controls button {
        width: 32px !important;
        height: 32px !important;
        min-width: 32px !important;
        border-radius: 50% !important;
        background: white !important;
        border: 1px solid #3b82f6 !important;
        color: #3b82f6 !important;
        font-size: 18px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    
    .quantity-controls input {
        width: 50px !important;
        height: 32px !important;
        text-align: center !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 6px !important;
        font-size: 16px !important;
        font-weight: 600 !important;
    }
    
    /* Info du dossier */
    .folder-info {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        font-size: 12px !important;
        color: #6b7280 !important;
    }
    
    /* Prix */
    .folder-price {
        font-size: 16px !important;
        font-weight: bold !important;
        color: #10b981 !important;
    }
    
    /* Nom du fichier */
    .file-name {
        font-size: 13px !important;
        color: #374151 !important;
        margin-bottom: 8px !important;
    }
    
    /* Masquer les colonnes inutiles */
    thead {
        display: none !important;
    }
    
    /* Actions (supprimer) */
    .delete-btn {
        position: absolute !important;
        top: 10px !important;
        right: 10px !important;
        color: #ef4444 !important;
        font-size: 18px !important;
    }
}


</style>
</head>
<body class="bg-gray-50">
    
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-full px-6 py-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <a href="index" target="_blank">
  <img src="../assets/img/1.jpeg" alt="Copisteria Logo" class="h-20 w-20 object-contain">
</a>
                <h1 class="text-2xl font-bold bg-gradient-to-r from-orange-500 via-orange-600 to-red-500 bg-clip-text text-transparent animate-pulse hover:animate-bounce transition-all duration-300" 
   style="
       background: linear-gradient(45deg, #ff6b35, #f7931e, #ff8c42, #ff6b35);
       background-size: 300% 300%;
       -webkit-background-clip: text;
       -webkit-text-fill-color: transparent;
       animation: gradientShift 3s ease-in-out infinite, textGlow 2s ease-in-out infinite alternate;
       text-shadow: 0 0 20px rgba(255, 107, 53, 0.3);
       font-family: 'Arial Black', sans-serif;
       letter-spacing: 1px;
   ">
   Tinta Expres LZ
</h1>
<style>
@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

@keyframes textGlow {
    0% { filter: drop-shadow(0 0 5px rgba(255, 107, 53, 0.4)); }
    100% { filter: drop-shadow(0 0 15px rgba(255, 107, 53, 0.8)); }
}

h1:hover {
    transform: scale(1.05);
    animation: gradientShift 1s ease-in-out infinite, textPulse 0.5s ease-in-out infinite;
}

@keyframes textPulse {
    0%, 100% { transform: scale(1.05); }
    50% { transform: scale(1.1); }
}
</style>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="flex items-center justify-center space-x-4">
        <i class="fas fa-desktop text-lg"></i>
        <span class="font-semibold">Terminal: <?= $terminal_info['name'] ?> - <?= $terminal_info['location'] ?></span>
        <span class="text-blue-200 text-sm">(ID: <?= $terminal_info['id'] ?>)</span>
    </div>
                    
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-shopping-cart text-blue-500"></i>
                        <div class="text-center">
                            <div class="text-sm text-gray-600">Total carrito</div>
                            <div class="font-bold text-blue-600">
                                <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded" id="cart-count">0</span>
                                <span id="cart-total">0,00 €</span>
                            </div>
                            <div class="text-xs text-gray-500">(Envío incluido)</div>
                        </div>
                    </div>
                    
                    <div class="relative">
                        <button class="flex items-center space-x-2 px-4 py-2 border border-gray-300 rounded-full hover:bg-gray-50 transition-colors">
                            <i class="fas fa-bars text-gray-600"></i>
                            <i class="fas fa-user text-gray-600"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="grid grid-cols-12 gap-6">
            
            <!-- Colonne gauche - Carpetas de impresión -->
            <div class="col-span-8" id="folders-container">
                
                <!-- Header section -->
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="bg-blue-100 p-3 rounded-lg">
                                <i class="fas fa-folder text-blue-500 text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-800">Carpetas de impresión</h2>
                                <p class="text-sm text-gray-600">
                                    <i class="fas fa-folder mr-1"></i>
                                    <span id="folder-count">0</span> carpetas para imprimir
                                </p>
                            </div>
                        </div>
                        <button onclick="createNewFolder()" class="flex items-center space-x-2 px-4 py-2 border border-green-500 text-green-600 rounded-lg hover:bg-green-50 transition-colors">
                            <i class="fas fa-plus"></i>
                            <span>Crear nueva carpeta</span>
                        </button>
                    </div>
                </div>

                <!-- Les dossiers seront ajoutés ici dynamiquement -->
                <div id="dynamic-folders"></div>

                <!-- Bouton crear nueva carpeta (sera ajouté dynamiquement) -->

            </div>

            <!-- Colonne droite - Información de pedido -->
            <div class="col-span-4 space-y-6">
                
                <!-- Forma de entrega -->
               
<!-- Forma de entrega -->
<div class="bg-white rounded-lg shadow-sm p-6">
    <h3 class="font-semibold text-gray-800 mb-4">Modo de entrega</h3>
    
    <div class="grid grid-cols-1 gap-3 mb-4">
        <button class="delivery-option active flex items-center justify-between p-4 border-2 border-blue-500 bg-blue-50 rounded-lg">
            <div class="flex items-center space-x-3">
                <i class="fas fa-store text-blue-500 text-xl"></i>
                <div class="text-left">
                    <div class="font-medium">Recoger en tienda</div>
                </div>
            </div>
            <div class="w-5 h-5 rounded-full border-2 border-blue-500 bg-blue-500 flex items-center justify-center">
                <i class="fas fa-check text-white text-xs"></i>
            </div>
        </button>
    </div>
    
    <!-- Información de la tienda -->
    <div class="bg-gray-50 rounded-lg p-4 space-y-3">
        <div class="flex items-start space-x-3">
            <i class="fas fa-map-marker-alt text-red-500 text-lg mt-1"></i>
            <div>
                <div class="font-medium text-gray-800">Tinta Expres LZ</div>
                <div class="text-gray-600 text-sm">Carrer de les Tres Creus, 142</div>
                <div class="text-gray-600 text-sm">08202 Sabadell, Barcelona, Spain</div>
            </div>
        </div>
        
        <div class="flex items-start space-x-3">
            <i class="fas fa-clock text-blue-500 text-lg mt-1"></i>
            <div>
                <div class="font-medium text-gray-800">Horarios</div>
                <div class="text-gray-600 text-sm">Lun-Vie: 8:30 - 20:30</div>
                <div class="text-gray-600 text-sm">Sáb: 08:00 - 15:00</div>
            </div>
        </div>
        
        <div class="flex items-start space-x-3">
            <i class="fas fa-phone text-green-500 text-lg mt-1"></i>
            <div>
                <div class="font-medium text-gray-800">Teléfono</div>
                <div class="text-gray-600 text-sm">+34 932 52 05 70</div>
            </div>
        </div>
    </div>
    
    <a href="https://maps.app.goo.gl/9y5Mey5Uw1PpVL3q6" target="_blank" class="w-full mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors text-sm flex items-center justify-center">
        <i class="fas fa-map-marker-alt mr-2"></i>
        Ver ubicación en Google Maps
    </a>
</div>
               

                <!-- Método de pago -->
               <!-- Método de pago -->
<!-- Section Método de pago -->
<!-- Datos del Cliente -->
<div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300">
    <div class="flex items-center mb-6">
        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
            <i class="fas fa-user text-white"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-800">Datos del Cliente</h3>
    </div>
    
    <div class="space-y-5">
        <!-- Nombre completo -->
        <div class="group">
            <label class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-blue-600 transition-colors">
                <i class="fas fa-user-circle mr-1"></i>Nombre completo *
            </label>
            <div class="relative">
                <input type="text" id="customer-name" required 
                       placeholder="Ej: Juan Pérez García"
                       class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 focus:bg-white">
                <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>
        
        <!-- Teléfono -->
        <div class="group">
            <label class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-blue-600 transition-colors">
                <i class="fas fa-phone mr-1"></i>Teléfono *
            </label>
            <div class="relative">
                <input type="tel" id="customer-phone" required 
                       placeholder="Ej: +34 600 123 456"
                       class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 focus:bg-white">
                <i class="fas fa-phone absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>
        
        <!-- Consentimiento -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4 border border-blue-200">
            <label class="flex items-start space-x-3 cursor-pointer group">
                <div class="relative">
                    <input type="checkbox" id="data-consent" required 
                           class="w-5 h-5 text-blue-600 border-2 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 transition-all duration-200">
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-20 bg-blue-500 rounded transition-opacity duration-200"></div>
                </div>
                <div class="text-sm">
                    <span class="text-gray-700 leading-relaxed">
                        <i class="fas fa-shield-alt text-blue-600 mr-1"></i>
                        Autorizo a <span class="font-semibold text-blue-800">Tinta Expres LZ</span> al tratamiento de mis datos personales
                    </span>
                    <div class="text-xs text-gray-500 mt-1">
                        Tus datos se utilizarán únicamente para gestionar tu pedido
                    </div>
                </div>
            </label>
        </div>
    </div>
</div>


   <div class="bg-white rounded-lg shadow-sm p-6">
    <h3 class="font-semibold text-gray-800 mb-4">Resumen del pedido</h3>
    
    <!-- Code promotionnel -->
    <div class="flex items-center justify-between mb-4">
        <span class="text-sm text-gray-700">¿Tienes un código promocional?</span>
        <button onclick="togglePromoCode()" class="text-blue-500 text-sm font-medium hover:text-blue-600">
            Añadir
        </button>
    </div>
    
    <!-- Input code promo (caché par défaut) -->
    <div id="promo-code-section" class="hidden mb-4">
        <div class="flex space-x-2">
            <input type="text" id="promo-code-input" placeholder="Código promocional" 
                   class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <button onclick="applyPromoCode()" class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600 transition-colors">
                Aplicar
            </button>
        </div>
        <div id="promo-message" class="hidden mt-2 text-sm"></div>
    </div>
    
    <!-- Détails prix -->
    <div class="space-y-3 py-4 border-t border-gray-200">
        
        <!-- Total -->
        <div class="flex justify-between items-center">
            <span class="text-gray-700">Subtotal</span>
            <span class="font-medium" id="order-subtotal">0,02 €</span>
        </div>
        
        <!-- Remise (si applicable) -->
        <div id="discount-line" class="flex justify-between items-center text-green-600 hidden">
            <span class="text-sm">Descuento (<span id="discount-code"></span>)</span>
            <span class="text-sm font-medium" id="discount-amount">-0,00 €</span>
        </div>
        
        <!-- Reconnu/Gratuit -->
        <div class="flex justify-between items-center">
            <span class="text-gray-700">Envío</span>
            <span class="font-medium text-gray-500">GRATIS</span>
        </div>
        
    </div>
    
    <!-- Total à payer -->
    <div class="border-t border-gray-200 pt-4">
        <div class="flex justify-between items-center mb-4">
            <div>
                <div class="font-semibold text-gray-800 text-lg">TOTAL A PAGAR</div>
                <div class="text-xs text-gray-500">(Impuestos incluidos)</div>
            </div>
            <div class="text-2xl font-bold text-green-600" id="final-total">0,02€</div>
        </div>
        
        <!-- Bouton Acheter -->
        <button onclick="processOrder()" class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-3 rounded-lg mb-3 transition-colors">
          Pasar por caja
        </button>
        
     
    </div>
</div>

</div>

            </div>

        </div>
    </div>
<!-- Modal Métodos de pago -->
<div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4">
        
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Métodos de pago</h2>
            <button onclick="closePaymentModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <!-- Modal Body -->
        <div class="p-4">
            <p class="text-gray-600 text-sm mb-6">Selecciona un método de pago</p>
            
            <!-- Payment options -->
            <div class="space-y-3">
                
               <!-- Pago con tarjeta -->
<div class="payment-option border-2 border-gray-300 rounded-lg p-4 opacity-50 cursor-not-allowed">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <i class="fas fa-credit-card text-gray-400 text-xl"></i>
            <div>
                <div class="font-medium text-gray-500">Pago con tarjeta</div>
                <div class="text-sm text-gray-400">Temporalmente no disponible</div>
            </div>
        </div>
        <div class="w-5 h-5 rounded-full border-2 border-gray-300"></div>
    </div>
</div>

<!-- Transferencia bancaria -->
<div class="payment-option border-2 border-gray-300 rounded-lg p-4 opacity-50 cursor-not-allowed">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <i class="fas fa-university text-gray-400 text-xl"></i>
            <div>
                <div class="font-medium text-gray-500">Transferencia bancaria</div>
                <div class="text-sm text-gray-400">No disponible en terminal</div>
            </div>
        </div>
        <div class="w-5 h-5 rounded-full border-2 border-gray-300"></div>
    </div>
</div>

<!-- Pago en tienda -->
<div class="payment-option border-2 border-blue-500 bg-blue-50 rounded-lg p-4 cursor-pointer" onclick="selectPaymentMethod('store', 'Pago en tienda', 'Pagar directamente en el mostrador')">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <i class="fas fa-store text-blue-600 text-xl"></i>
            <div>
                <div class="font-medium text-gray-800">Pago en tienda</div>
                <div class="text-sm text-gray-500">Pagar directamente en el mostrador</div>
            </div>
        </div>
        <div class="w-5 h-5 rounded-full border-2 border-blue-500 bg-blue-500 flex items-center justify-center">
            <i class="fas fa-check text-white text-xs"></i>
        </div>
    </div>
</div>
                
            </div>
        </div>

        
        
    </div>
    
</div>

    <script>
        // Variables globales
        let currentCartData = { folders: [] };
let customerName = '';
let customerPhone = '';

function saveCustomerData() {
    const nameInput = document.getElementById('customer-name');
    const phoneInput = document.getElementById('customer-phone');
    
    if (nameInput) {
        customerName = nameInput.value.trim();
    }
    if (phoneInput) {
        customerPhone = phoneInput.value.trim();
    }
    
    console.log('Customer data saved:', customerName, customerPhone);
}

// Ajouter les listeners pour capturer les données
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('customer-name');
    const phoneInput = document.getElementById('customer-phone');
    
    if (nameInput) {
        nameInput.addEventListener('input', saveCustomerData);
    }
    if (phoneInput) {
        phoneInput.addEventListener('input', saveCustomerData);
    }
});
        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            console.log('=== CART.PHP INITIALIZED ===');
            initializeCart();
        });

        function initializeCart() {
    // Vérifier les différentes sources de données
    const cartData = sessionStorage.getItem('cartData');
    const currentCart = sessionStorage.getItem('currentCart');
    
    console.log('cartData from sessionStorage:', cartData);
    console.log('currentCart from sessionStorage:', currentCart);
    
    if (currentCart) {
        // Utiliser currentCart (format multi-dossiers)
        currentCartData = JSON.parse(currentCart);
    } else if (cartData) {
        // Convertir cartData (format simple) en currentCart
        const parsedData = JSON.parse(cartData);
        currentCartData = {
            folders: [{
                id: 1,
                name: 'Carpeta sin título',
                files: parsedData.files || [],
                configuration: parsedData.configuration || {},
                copies: parsedData.configuration?.copies || 1,
                total: parsedData.total || 0,
                comments: parsedData.comments || ''
            }]
        };
        
        // Sauvegarder au nouveau format
        sessionStorage.setItem('currentCart', JSON.stringify(currentCartData));
        sessionStorage.removeItem('cartData'); // Nettoyer l'ancien
    } else {
        // Pas de données, retourner à index
        console.log('No cart data found, redirecting to index');
        window.location.href = 'index.php';
        return;
    }
    
    console.log('Final cart data:', currentCartData);
    
    // AJOUTER CES LIGNES MANQUANTES :
    if (currentCartData.folders && currentCartData.folders.length > 0) {
        displayFolders();
        updateCartSummary();
    }
}

        // Fonction pour observer les changements du prix du panier
function setupPriceSync() {
    const cartTotalElement = document.getElementById('cart-total');
    
    if (!cartTotalElement) return;
    
    // Observer les changements du texte du prix du panier
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList' || mutation.type === 'characterData') {
                // Le prix du panier a changé, synchroniser avec le résumé
                syncPriceToSummary();
            }
        });
    });
    
    // Observer le contenu du prix du panier
    observer.observe(cartTotalElement, {
        childList: true,
        subtree: true,
        characterData: true
    });
    
    console.log('✅ Synchronisation automatique prix activée');
}

// Fonction simple pour synchroniser le prix du panier avec le résumé
function syncPriceToSummary() {
    const cartTotalElement = document.getElementById('cart-total');
    const orderSubtotalElement = document.getElementById('order-subtotal');
    const finalTotalElement = document.getElementById('final-total');
    
    if (!cartTotalElement || !orderSubtotalElement || !finalTotalElement) return;
    
    const cartPrice = cartTotalElement.textContent; // Ex: "34,80 €"
    
    // Si pas de code promo appliqué, copier le prix directement
    if (document.getElementById('discount-line').classList.contains('hidden')) {
        orderSubtotalElement.textContent = cartPrice;
        finalTotalElement.textContent = cartPrice.replace(' €', '€');
    } else {
        // Si code promo appliqué, garder le subtotal original et recalculer le final
        const originalPrice = parseFloat(cartPrice.replace(',', '.').replace(' €', ''));
        const discountText = document.getElementById('discount-amount').textContent;
        const discountAmount = parseFloat(discountText.replace('-', '').replace(',', '.').replace(' €', ''));
        const finalPrice = originalPrice - discountAmount;
        
        orderSubtotalElement.textContent = cartPrice;
        finalTotalElement.textContent = finalPrice.toFixed(2).replace('.', ',') + '€';
    }
}

function displayFolders() {
    const dynamicContainer = document.getElementById('dynamic-folders');
    if (!dynamicContainer) {
        console.error('Element dynamic-folders not found');
        return;
    }
    
    dynamicContainer.innerHTML = '';
    
    currentCartData.folders.forEach((folder, index) => {
        const folderElement = createFolderHTML(folder);
        dynamicContainer.appendChild(folderElement);
    });
    
    // Mettre à jour compteur avec vérification
    const folderCountElement = document.getElementById('folder-count');
    if (folderCountElement) {
        folderCountElement.textContent = currentCartData.folders.length;
    }
    
    addCreateFolderButton(dynamicContainer);
}

        function createFolderHTML(folder) {
            const folderDiv = document.createElement('div');
            folderDiv.className = 'bg-white rounded-lg shadow-sm p-6 mb-6';
            folderDiv.setAttribute('data-folder-id', folder.id);
            
            folderDiv.innerHTML = `
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="bg-blue-500 text-white w-8 h-8 rounded flex items-center justify-center font-semibold">
                            ${folder.id}
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">${folder.name}</h3>
                            <i class="fas fa-edit text-gray-400 text-sm cursor-pointer ml-2" onclick="editFolderName(${folder.id})"></i>
                        </div>
                        <div class="flex flex-wrap gap-1">
                            ${generateConfigBadges(folder.configuration)}
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="flex items-center space-x-2 bg-gray-50 rounded-lg px-3 py-2">
                            <i class="fas fa-copy text-blue-500"></i>
                            <span class="text-sm text-gray-600">Copias</span>
                            <button onclick="changeFolderQuantity(${folder.id}, -1)" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100">
                                <i class="fas fa-minus text-xs"></i>
                            </button>
                            <span class="font-semibold px-2" id="quantity-${folder.id}">${folder.copies}</span>
                            <button onclick="changeFolderQuantity(${folder.id}, 1)" class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center hover:bg-blue-600">
                                <i class="fas fa-plus text-xs"></i>
                            </button>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-gray-800" id="price-${folder.id}">${folder.total.toFixed(2)} €</div>
                            <div class="text-xs text-gray-500">(IVA incluido)</div>
                        </div>
                        <div class="flex space-x-2">
                            <button onclick="duplicateFolder(${folder.id})" class="p-2 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-copy"></i>
                            </button>
                            <button onclick="deleteFolder(${folder.id})" class="p-2 text-gray-400 hover:text-red-500">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pos.</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tamaño</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Páginas</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${generateFilesTable(folder.files)}
                        </tbody>
                    </table>
                </div>
            `;
            
            return folderDiv;
        }

       function generateConfigBadges(config) {
    if (!config) return '';
    
    return `
        <span class="badge badge-blue">${config.colorMode === 'bw' ? 'BN' : 'CO'}</span>
        <span class="badge badge-green">${config.paperSize || 'A4'}</span>
        <span class="badge badge-orange">${(config.paperWeight || '80g').replace('g', '')}</span>
        <span class="badge badge-purple">${config.sides === 'single' ? 'UC' : 'DC'}</span>
        <span class="badge badge-cyan">${config.orientation === 'portrait' ? 'VE' : 'HO'}</span>
        <span class="badge badge-pink">${config.copies || 1}</span>
    `;
}

        function generateFilesTable(files) {
            if (!files || files.length === 0) return '<tr><td colspan="4" class="text-center py-4 text-gray-500">Sin archivos</td></tr>';
            
            return files.map((file, index) => `
                <tr class="border-t border-gray-200">
                    <td class="px-4 py-3 text-sm text-gray-600">${index + 1}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-file-pdf text-red-500"></i>
                            <div>
                                <div class="font-medium text-gray-800">${file.name}</div>
                                <div class="text-xs text-blue-600 bg-blue-100 px-2 py-1 rounded-full inline-block">PDF</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">${formatFileSize(file.size)}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">${file.pages || 1}</td>
                </tr>
            `).join('');
        }

        function addCreateFolderButton(container) {
            const buttonDiv = document.createElement('div');
            buttonDiv.className = 'text-center mt-6';
            buttonDiv.innerHTML = `
                <button onclick="createNewFolder()" class="inline-flex items-center space-x-2 px-6 py-3 border-2 border-dashed border-blue-300 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors">
                    <i class="fas fa-plus"></i>
                    <span>Crear nueva carpeta para imprimir</span>
                </button>
            `;
            container.appendChild(buttonDiv);
        }

        // Actions sur les dossiers
        function changeFolderQuantity(folderId, delta) {
            const folder = currentCartData.folders.find(f => f.id === folderId);
            if (folder) {
                folder.copies = Math.max(1, folder.copies + delta);
                document.getElementById(`quantity-${folderId}`).textContent = folder.copies;
                
                // Recalculer prix (simulation)
                folder.total = folder.total / (folder.copies - delta) * folder.copies;
                document.getElementById(`price-${folderId}`).textContent = folder.total.toFixed(2) + ' €';
                
                sessionStorage.setItem('currentCart', JSON.stringify(currentCartData));
                updateCartSummary();
            }
        }

        function editFolderName(folderId) {
            const folder = currentCartData.folders.find(f => f.id === folderId);
            if (folder) {
                const newName = prompt('Nuevo nombre para la carpeta:', folder.name);
                if (newName && newName.trim()) {
                    folder.name = newName.trim();
                    sessionStorage.setItem('currentCart', JSON.stringify(currentCartData));
                    displayFolders();
                }
            }
        }

        function duplicateFolder(folderId) {
            const folder = currentCartData.folders.find(f => f.id === folderId);
            if (folder) {
                const newFolder = {
                    ...folder,
                    id: Math.max(...currentCartData.folders.map(f => f.id)) + 1,
                    name: folder.name + ' (copia)'
                };
                currentCartData.folders.push(newFolder);
                sessionStorage.setItem('currentCart', JSON.stringify(currentCartData));
                displayFolders();
                updateCartSummary();
                showNotification('Carpeta duplicada correctamente', 'success');
            }
        }

        function deleteFolder(folderId) {
            if (confirm('¿Eliminar esta carpeta?')) {
                currentCartData.folders = currentCartData.folders.filter(f => f.id !== folderId);
                if (currentCartData.folders.length === 0) {
                    sessionStorage.removeItem('currentCart');
                    window.location.href = 'index.php';
                } else {
                    sessionStorage.setItem('currentCart', JSON.stringify(currentCartData));
                    displayFolders();
                    updateCartSummary();
                }
            }
        }

        function createNewFolder() {
            sessionStorage.setItem('currentCart', JSON.stringify(currentCartData));
            window.location.href = 'index.php?from=cart';
        }

        function updateCartSummary() {
            const totalPrice = currentCartData.folders.reduce((sum, folder) => sum + folder.total, 0);
            const totalItems = currentCartData.folders.length;
            
            document.getElementById('cart-total').textContent = totalPrice.toFixed(2) + ' €';
            document.getElementById('cart-count').textContent = totalItems;
            document.getElementById('folder-count').textContent = totalItems;
        }

        // Fonctions utilitaires
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg bg-${type === 'success' ? 'green' : 'blue'}-500 text-white`;
            notification.innerHTML = `<span>${message}</span>`;
            document.body.appendChild(notification);
            setTimeout(() => notification.remove(), 3000);
        }
let currentPromoCode = null;
let discountAmount = 0;
        // Variables pour le paiement
let selectedPayment = {
     type: 'store',
    title: 'Pago en tienda',
    description: 'Pagar directamente en el mostrador'
};

function openPaymentModal() {
    document.getElementById('paymentModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closePaymentModal() {
    document.getElementById('paymentModal').classList.add('hidden');
    document.body.style.overflow = '';
}

function selectPaymentMethod(type, title, description) {
    // Actualizar la sélection
    selectedPayment = { type, title, description };
    
    // Mettre à jour l'affichage
    document.getElementById('selected-payment-method').textContent = title;
    
    // Mettre à jour les styles des options
    document.querySelectorAll('.payment-option').forEach(option => {
        option.classList.remove('border-blue-500', 'bg-blue-50');
        option.classList.add('border-gray-300');
        
        // Mettre à jour les cercles de sélection
        const circle = option.querySelector('.w-5.h-5');
        circle.classList.remove('border-blue-500', 'bg-blue-500');
        circle.classList.add('border-gray-300');
        circle.innerHTML = '';
    });
    
    // Styler l'option sélectionnée
    const selectedOption = event.currentTarget;
    selectedOption.classList.remove('border-gray-300');
    selectedOption.classList.add('border-blue-500', 'bg-blue-50');
    
    const selectedCircle = selectedOption.querySelector('.w-5.h-5');
    selectedCircle.classList.remove('border-gray-300');
    selectedCircle.classList.add('border-blue-500', 'bg-blue-500');
    selectedCircle.innerHTML = '<i class="fas fa-check text-white text-xs"></i>';
    
    // Fermer le modal après 500ms
    setTimeout(() => {
        closePaymentModal();
    }, 500);
}

// Fermer modal si clic sur overlay
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('paymentModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closePaymentModal();
            }
        });
    }
});

// Fermer avec Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closePaymentModal();
    }
});

async function processOrder() {
       try {
        // Récupérer les champs avec les BONS IDs
        const nameInput = document.getElementById('customer-name');
        const phoneInput = document.getElementById('customer-phone');
        const dataCheckbox = document.getElementById('data-consent');
        
        const customerName = nameInput?.value?.trim() || '';
        const customerPhone = phoneInput?.value?.trim() || '';
        const dataConsent = dataCheckbox?.checked || false;
        
        // VALIDATIONS OBLIGATOIRES
        if (!customerName) {
            showNotification('El nombre del cliente es obligatorio', 'error');
            nameInput?.focus();
            return;
        }
        
        if (!customerPhone) {
            showNotification('El teléfono del cliente es obligatorio', 'error');
            phoneInput?.focus();
            return;
        }
        
        if (!dataConsent) {
            showNotification('Debe autorizar el tratamiento de datos personales', 'error');
            dataCheckbox?.focus();
            return;
        }
        
        if (!currentCartData || !currentCartData.folders || currentCartData.folders.length === 0) {
            showNotification('No hay productos en el carrito', 'error');
            return;
        }
        
        const orderData = {
            folders: currentCartData.folders,
            paymentMethod: selectedPayment,
            comments: document.getElementById('order-comments')?.value || '',
            customerName: customerName,
            customerPhone: customerPhone,
            promoCode: currentPromoCode,
            discount: discountAmount,
            finalTotal: currentCartData.folders.reduce((sum, folder) => sum + folder.total, 0)
        };
        
        console.log('Données commande:', orderData);
        
        const response = await fetch('api/create-order.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(orderData)
        });

        const responseText = await response.text();
        console.log('Raw response:', responseText);

        const result = JSON.parse(responseText);
        
        if (result.success) {
                currentCartData = { folders: [] };
    localStorage.removeItem('terminalCart');
            sessionStorage.setItem('orderConfirmation', JSON.stringify(result));
            sessionStorage.setItem('orderCart', JSON.stringify(currentCartData));
            
            // Rediriger vers confirmation
            window.location.href = result.redirect_url || 'order-confirmation.php';
        } else {
            showNotification('Error: ' + result.error, 'error');
        }
        
    } catch (error) {  // ← Ce catch était manquant
        console.error('Erreur processOrder:', error);
        showNotification('Error al procesar el pedido: ' + error.message, 'error');
    }
}
// Version simple qui utilise les totaux déjà calculés
function calculateSubtotal() {
    if (!currentCartData || !currentCartData.folders) {
        return 0;
    }
    
    // Utiliser les totaux déjà stockés dans les dossiers
    const total = currentCartData.folders.reduce((sum, folder) => {
        return sum + (folder.total || 0);
    }, 0);
    
    console.log('Simple subtotal calculation:', total);
    return total;
}

function updateCartSummary() {
    const totalPrice = currentCartData.folders.reduce((sum, folder) => sum + folder.total, 0);
    const totalItems = currentCartData.folders.length;
    
    document.getElementById('cart-total').textContent = totalPrice.toFixed(2) + ' €';
    document.getElementById('cart-count').textContent = totalItems;
    document.getElementById('folder-count').textContent = totalItems;
    
    // AJOUTER CETTE LIGNE :
    updateOrderSummary();
}
function updateOrderSummary() {
    const subtotal = calculateSubtotal();
    
    document.getElementById('order-subtotal').textContent = subtotal.toFixed(2).replace('.', ',') + ' €';
    
    let finalTotal = subtotal;
    if (currentPromoCode && discountAmount > 0) {
        finalTotal = Math.max(0, subtotal - discountAmount);
    }
    
    document.getElementById('final-total').textContent = finalTotal.toFixed(2).replace('.', ',') + '€';
}
    </script>


<!-- Styles pour le bouton WhatsApp -->

<script>
// Ajuster hauteur mobile pour summary fixe
if (window.innerWidth < 768) {
    window.addEventListener('scroll', function() {
        const summary = document.querySelector('.sticky');
        if (summary) {
            if (window.scrollY > 100) {
                summary.style.boxShadow = '0 -4px 20px rgba(0,0,0,0.2)';
            } else {
                summary.style.boxShadow = '0 -4px 20px rgba(0,0,0,0.1)';
            }
        }
    });
}
</script>
</body>
</html>