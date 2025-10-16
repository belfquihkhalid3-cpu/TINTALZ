<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';
require_once 'includes/user_functions.php';
require_once 'includes/security_headers.php';

if (!isLoggedIn()) {
    header('Location: index.php');
    exit();
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
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-gray-50">
    
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-full px-6 py-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <a href="index" target="_blank">
  <img src="assets/img/1.jpeg" alt="Copisteria Logo" class="h-20 w-20 object-contain">
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
                    <button class="flex items-center space-x-2 px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors">
                        <i class="fas fa-print"></i>
                        <span>Imprimir</span>
                    </button>
                    
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
                    <div class="text-sm text-gray-500">Gratis : 24H - 48H</div>
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
                <div class="text-gray-600 text-sm">Sáb: 09:00 - 15:00</div>
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
                <!-- Datos de facturación -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                   <button onclick="openBillingModal()" class="w-full text-left py-2 px-3 text-blue-600 hover:bg-blue-50 rounded-lg">
    <i class="fas fa-receipt mr-2"></i>Datos de facturación
    <span id="billing-status" class="text-xs text-gray-500 block">Click para completar</span>
</button>
                </div>

                <!-- Método de pago -->
               <!-- Método de pago -->
<div class="bg-white rounded-lg shadow-sm p-6">
    <h3 class="font-semibold text-gray-800 mb-4">Método de pago</h3>
    <button onclick="openPaymentModal()" class="w-full flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
        <div class="flex items-center space-x-3">
            <i class="fas fa-credit-card text-gray-400 text-xl"></i>
            <div>
                <div class="font-medium" id="selected-payment-method">Pagar con tarjeta</div>
                <div class="text-sm text-gray-500">Pago seguro cifrado con certif...</div>
            </div>
        </div>
        <i class="fas fa-chevron-right text-gray-400"></i>
    </button>
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
            Comprar ahora
        </button>
        
        <!-- Sécurité -->
        <div class="flex items-center justify-center space-x-2 text-sm text-gray-600 mb-3">
            <i class="fas fa-lock text-green-500"></i>
            <span>Pago seguro en línea</span>
        </div>
        
        <!-- Conditions -->
        <div class="text-xs text-gray-500 text-center">
            Al hacer clic en « <strong>Comprar ahora</strong> », indica que acepta las 
            <a href="condiciones-generales.php" class="text-blue-500 hover:underline">condiciones generales de venta</a>.
        </div>
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
<div class="payment-option border-2 border-blue-500 bg-blue-50 rounded-lg p-4 cursor-pointer" onclick="selectPaymentMethod('transfer', 'Transferencia bancaria', 'Recibirás las instrucciones para realizar la transferencia')">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <i class="fas fa-university text-blue-600 text-xl"></i>
            <div>
                <div class="font-medium text-gray-800">Transferencia bancaria</div>
                <div class="text-sm text-gray-500">Recibirás las instrucciones para realizar la transferencia</div>
            </div>
        </div>
        <div class="w-5 h-5 rounded-full border-2 border-blue-500 bg-blue-500 flex items-center justify-center">
            <i class="fas fa-check text-white text-xs"></i>
        </div>
    </div>
</div>

<!-- Pago en tienda -->
<div class="payment-option border-2 border-gray-300 rounded-lg p-4 opacity-50 cursor-not-allowed">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <i class="fas fa-store text-gray-400 text-xl"></i>
            <div>
                <div class="font-medium text-gray-500">Pago en tienda</div>
                <div class="text-sm text-gray-400">Temporalmente no disponible</div>
            </div>
        </div>
        <div class="w-5 h-5 rounded-full border-2 border-gray-300"></div>
    </div>
</div>
                
            </div>
        </div>

        
        
    </div>
    
</div>
<!-- Modal Datos de Facturación -->
<div id="billingModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Datos de Facturación</h3>
            <button onclick="closeBillingModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="billingForm">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre completo *</label>
                    <input type="text" id="billing_name" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                    <input type="email" id="billing_email" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                    <input type="tel" id="billing_phone" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                    <input type="text" id="billing_address" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ciudad</label>
                        <input type="text" id="billing_city" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Código Postal</label>
                        <input type="text" id="billing_postal" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIF/CIF (para factura)</label>
                    <input type="text" id="billing_nif" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            
            <div class="flex space-x-3 mt-6">
                <button type="button" onclick="saveBillingData()" 
                        class="flex-1 bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">
                    Guardar
                </button>
                <button type="button" onclick="closeBillingModal()" 
                        class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-400">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>
    <script>
        // Variables globales
        let currentCartData = { folders: [] };

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
                document.getElementById('selected-payment-method').textContent = 'Transferencia bancaria';
            console.log('Final cart data:', currentCartData);
            
            if (currentCartData.folders && currentCartData.folders.length > 0) {
                displayFolders();
                updateCartSummary();
                 // Synchroniser le prix initial
        syncPriceToSummary();
        
        // Activer la synchronisation automatique
        setupPriceSync();
            } else {
                window.location.href = 'index.php';
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
            dynamicContainer.innerHTML = '';
            
            currentCartData.folders.forEach((folder, index) => {
                const folderElement = createFolderHTML(folder);
                dynamicContainer.appendChild(folderElement);
            });
            
            // Ajouter bouton "Crear nueva carpeta" à la fin
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
            
            const finishingCodes = {
                'individual': 'IN', 'grouped': 'AG', 'none': 'SA',
                'spiral': 'EN', 'staple': 'GR', 'laminated': 'PL',
                'perforated2': 'P2', 'perforated4': 'P4'
            };
            
            return `
                <span class="badge badge-blue">${config.colorMode === 'bw' ? 'BN' : 'CO'}</span>
                <span class="badge badge-green">${config.paperSize || 'A4'}</span>
                <span class="badge badge-orange">${(config.paperWeight || '80g').replace('g', '')}</span>
                <span class="badge badge-purple">${config.sides === 'single' ? 'UC' : 'DC'}</span>
                <span class="badge badge-teal">${finishingCodes[config.finishing] || 'IN'}</span>
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
                                <div class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded-full inline-block">Sin acabado</div>
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
    type: 'transfer',
    title: 'Transferencia bancaria',
    description: 'Recibirás las instrucciones para realizar la transferencia'
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
    console.log('=== PROCESSING ORDER ===');
    
    // Vérifier que tout est prêt
    if (!currentCartData || !currentCartData.folders || currentCartData.folders.length === 0) {
        showNotification('Tu carrito está vacío', 'error');
        return;
    }
    
    // Vérifier mode de paiement sélectionné
    if (selectedPayment.type !== 'transfer') {
        showNotification('Solo está disponible la transferencia bancaria actualmente', 'warning');
        return;
    }
    
    // Désactiver le bouton pendant le traitement
    const button = event.target;
    const originalText = button.textContent;
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Procesando...';
    
    try {
        // Préparer les données de commande
        const orderData = {
            folders: currentCartData.folders,
            paymentMethod: selectedPayment,
            promoCode: currentPromoCode,
            discount: discountAmount || 0,
            finalTotal: parseFloat(document.getElementById('final-total').textContent.replace('€', '').replace(',', '.')),
            subtotal: calculateSubtotal(),
            total: calculateSubtotal() - (discountAmount || 0),
            comments: document.getElementById('order-comments')?.value || '',
            orderDate: new Date().toISOString(),
            billingData: billingData || null // Ajouter les données de facturation
        };
        
        console.log('Sending order data:', orderData);
        
        // Envoyer à l'API
        const response = await fetch('api/create-order-online.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(orderData)
        });
        
        const result = await response.json();
        console.log('Order result:', result);
        
        if (result.success) {
            // Succès - nettoyer le panier et rediriger
            sessionStorage.removeItem('currentCart');
            sessionStorage.removeItem('cartData');
            
            // Sauvegarder info commande pour page confirmation
            sessionStorage.setItem('orderConfirmation', JSON.stringify(result));
            
            showNotification('¡Pedido creado correctamente!', 'success');
            
            // Rediriger vers page confirmation
            setTimeout(() => {
                window.location.href = 'order-confirmation.php';
            }, 2000);
            
        } else {
            throw new Error(result.error || 'Error desconocido');
        }
        
    } catch (error) {
        console.error('Order error:', error);
        showNotification('Error al procesar el pedido: ' + error.message, 'error');
    } finally {
        // Restaurer le bouton
        button.disabled = false;
        button.textContent = originalText;
    }
}
let billingData = {};

function openBillingModal() {
    document.getElementById('billingModal').classList.remove('hidden');
    
    // Prellenar con datos existentes
    if (billingData.name) {
        document.getElementById('billing_name').value = billingData.name || '';
        document.getElementById('billing_email').value = billingData.email || '';
        document.getElementById('billing_phone').value = billingData.phone || '';
        document.getElementById('billing_address').value = billingData.address || '';
        document.getElementById('billing_city').value = billingData.city || '';
        document.getElementById('billing_postal').value = billingData.postal || '';
        document.getElementById('billing_nif').value = billingData.nif || '';
    }
}

function closeBillingModal() {
    document.getElementById('billingModal').classList.add('hidden');
}

function saveBillingData() {
    const name = document.getElementById('billing_name').value;
    const email = document.getElementById('billing_email').value;
    
    if (!name || !email) {
        alert('Nombre y email son obligatorios');
        return;
    }
    
    // Guardar datos
    billingData = {
        name: name,
        email: email,
        phone: document.getElementById('billing_phone').value,
        address: document.getElementById('billing_address').value,
        city: document.getElementById('billing_city').value,
        postal: document.getElementById('billing_postal').value,
        nif: document.getElementById('billing_nif').value
    };
    
    // Actualizar estado en la UI
    const statusSpan = document.getElementById('billing-status');
    statusSpan.textContent = `${name} - ${email}`;
    statusSpan.className = 'text-xs text-green-600 block';
    
    closeBillingModal();
    
    showNotification('Datos de facturación guardados', 'success');
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

function updateOrderSummary() {
    const subtotal = calculateSubtotal();
    
    document.getElementById('order-subtotal').textContent = subtotal.toFixed(2).replace('.', ',') + ' €';
    
    let finalTotal = subtotal;
    if (currentPromoCode && discountAmount > 0) {
        finalTotal = Math.max(0, subtotal - discountAmount);
    }
    
    document.getElementById('final-total').textContent = finalTotal.toFixed(2).replace('.', ',') + '€';
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
    </script>
<div class="fixed bottom-6 right-6 z-50">
    <a href="https://wa.me/34932520570?text=Hola%2C%20necesito%20ayuda%20con%20mi%20pedido%20de%20impresi%C3%B3n" 
       target="_blank"
       class="whatsapp-btn group relative flex items-center justify-center w-16 h-16 bg-green-500 hover:bg-green-600 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110">
        
        <!-- Icono WhatsApp -->
        <i class="fab fa-whatsapp text-white text-2xl"></i>
        
        <!-- Efecto de ondas -->
        <div class="absolute inset-0 rounded-full bg-green-400 animate-ping opacity-20"></div>
        <div class="absolute inset-0 rounded-full bg-green-400 animate-ping opacity-20" style="animation-delay: 0.5s;"></div>
        
        <!-- Tooltip -->
        <div class="absolute right-full mr-4 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white text-sm px-3 py-2 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
            ¿Necesitas ayuda? ¡Escríbenos!
            <div class="absolute left-full top-1/2 transform -translate-y-1/2 border-4 border-transparent border-l-gray-800"></div>
        </div>
    </a>
</div>

<!-- Styles pour le bouton WhatsApp -->
<style>
.whatsapp-btn {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.whatsapp-btn:hover {
    animation: none;
}

/* Animation de pulsation */
@keyframes pulse-green {
    0%, 100% {
        box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
    }
    50% {
        box-shadow: 0 0 0 20px rgba(34, 197, 94, 0);
    }
}

.whatsapp-btn::before {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 50%;
    animation: pulse-green 2s infinite;
}

/* Version mobile responsive */
@media (max-width: 768px) {
    .whatsapp-btn {
        width: 56px;
        height: 56px;
    }
    
    .whatsapp-btn i {
        font-size: 1.5rem;
    }
    
    .whatsapp-btn .tooltip {
        display: none;
    }
}

/* Notification badge (optionnel) */
.whatsapp-btn::after {
    content: '!';
    position: absolute;
    top: -4px;
    right: -4px;
    width: 20px;
    height: 20px;
    background: #ef4444;
    color: white;
    border-radius: 50%;
    font-size: 12px;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid white;
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 20%, 53%, 80%, 100% {
        transform: translate3d(0, 0, 0);
    }
    40%, 43% {
        transform: translate3d(0, -8px, 0);
    }
    70% {
        transform: translate3d(0, -4px, 0);
    }
    90% {
        transform: translate3d(0, -2px, 0);
    }
}
</body>
</html>