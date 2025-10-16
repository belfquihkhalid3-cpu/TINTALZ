<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';
require_once 'includes/security_headers.php';



// Vérifier si l'utilisateur est connecté
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tinta Express LZ</title>
    
    <!-- External CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
      <link rel="icon" href="assets/img/imprimerie.ico" type="image/x-icon">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">

</head>
<body class="bg-gray-100">
    <!-- Header -->
    <!-- Header -->
<header class="bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-full px-6 py-3">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
          <img src="assets/img/1.jpeg" alt="Copisteria Logo" class="h-20 w-20 object-contain">
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
            </div>
            
            
            <div class="flex items-center space-x-4">
                <!-- Bouton Imprimir -->
                <button onclick="openTrackingModal()" 
                class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-500 to-red-500 text-white font-medium rounded-xl hover:from-orange-600 hover:to-red-600 transform hover:scale-105 transition-all duration-300 shadow-lg">
            <i class="fas fa-search mr-3 text-lg"></i>
            Rastrear mi Pedido
        </button>
                
                <!-- Total carrito -->
             <!-- Remplacez cette section dans votre index.php : -->

<!-- Total carrito avec lien -->
<a href="cart.php" class="flex items-center space-x-2 hover:bg-gray-50 rounded-lg px-3 py-2 transition-colors">
    <i class="fas fa-shopping-cart text-blue-500"></i>
    <div class="text-center">
        <div class="text-sm text-gray-600">Total carrito</div>
        <div class="font-bold text-blue-600">
            <span class="bg-blue-500 text-white text-xs px-1 rounded" id="cart-count">0</span>
            <span id="total-price">0,00 €</span>
        </div>
        <div class="text-xs text-gray-500">(Envío incluido)</div>
    </div>
</a>
                
                <!-- Menu Utilisateur -->
             <!-- Menu Utilisateur -->
<div class="relative" id="user-menu">
    <button class="flex items-center space-x-2 px-4 py-2 border border-gray-300 rounded-full hover:bg-gray-50 transition-colors" onclick="toggleUserMenu()">
        <i class="fas fa-bars text-gray-600"></i>
        <i class="fas fa-user text-gray-600"></i>
    </button>
    
    <!-- Dropdown Menu -->
    <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-200 hidden" id="user-dropdown">
        <?php if ($user_id): ?>
            <a href="account.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Mi cuenta</a>
            <a href="orders.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Mis pedidos</a>
            <hr class="my-1">
            <a href="logout.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Cerrar sesión</a>
        <?php else: ?>
            <a href="#" onclick="openLoginModal()" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Iniciar sesión</a>
            <a href="#" onclick="openRegisterModal()" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Registrarte</a>
            <hr class="my-1">
            <a href="#" class="block px-4 py-2 text-blue-600 hover:bg-blue-50 font-medium">Consulta tu pedido</a>
        <?php endif; ?>
    </div>
</div>
            </div>
        </div>
    </div>
</header>

    <div class="flex h-screen">
        <!-- Sidebar de Configuration -->
  <aside class="w-100 bg-gray-50 border-r border-gray-200">
    <div class="sidebar-scroll p-6">
        
        <!-- Section Configuración -->
        <div class="collapsible-section">
            <div class="section-header bg-white rounded-lg border p-3 flex items-center justify-between hover:bg-gray-50 transition-colors" onclick="toggleCollapse('config')">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-cog text-blue-500"></i>
                    <div>
                        <div class="font-semibold text-gray-800">Configuración</div>
                        <div class="text-sm text-gray-500">Selecciona cómo lo imprimimos</div>
                    </div>
                </div>
                <i class="fas fa-chevron-down transition-transform" id="config-icon"></i>
            </div>
            
            <div class="section-content mt-3" id="config-section">
                <div class="space-y-4">
                    <!-- Copias -->
                    <div class="config-section bg-white rounded-lg p-4 border">
                        <h3 class="section-title">Copias</h3>
                        <div class="flex items-center justify-center space-x-6">
                            <button class="quantity-btn border-blue-200 text-blue-500 hover:bg-blue-50" onclick="changeQuantity(-1)">
                                <i class="fas fa-minus"></i>
                            </button>
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-copy text-blue-500 text-2xl"></i>
                                <span class="text-3xl font-bold text-gray-800" id="copies-count">1</span>
                                <i class="fas fa-plus text-blue-500 text-xl"></i>
                            </div>
                            <button class="quantity-btn bg-blue-500 text-white hover:bg-blue-600" onclick="changeQuantity(1)">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Color de la impresión -->
                    <div class="config-section bg-white rounded-lg p-4 border">
                        <h3 class="section-title">
                            Color de la impresión
                            <div class="tooltip">
                                <i class="fas fa-info-circle text-gray-400 text-sm cursor-help"></i>
                                <span class="tooltiptext">Selecciona el tipo de impresión</span>
                            </div>
                        </h3>
                        <p class="section-subtitle">Selecciona el tipo de impresión</p>
                        <div class="option-grid-2">
                            <button class="option-btn active" onclick="selectColorMode('bw')" data-color="bw">
                                <div class="font-semibold mb-1">B/N</div>
                                <div class="text-xs opacity-75">Escala de grises</div>
                            </button>
                            <button class="option-btn" onclick="selectColorMode('color')" data-color="color">
                                <div class="font-semibold mb-1">Color</div>
                                <div class="text-xs opacity-75">Formato CMYK</div>
                            </button>
                        </div>
                    </div>

                    <!-- Tamaño del papel -->
                    <div class="config-section bg-white rounded-lg p-4 border">
                        <h3 class="section-title">
                            Tamaño del papel
                            <div class="tooltip">
                                <i class="fas fa-info-circle text-gray-400 text-sm cursor-help"></i>
                                <span class="tooltiptext">Formato del papel</span>
                            </div>
                        </h3>
                        <div class="option-grid-3">
                            <button class="option-btn" onclick="selectPaperSize('A3')" data-size="A3">
                                <div class="font-semibold mb-1">A3</div>
                                <div class="text-xs opacity-75">420 x 297 mm</div>
                            </button>
                            <button class="option-btn active" onclick="selectPaperSize('A4')" data-size="A4">
                                <div class="font-semibold mb-1">A4</div>
                                <div class="text-xs opacity-75">297 x 210 mm</div>
                            </button>
                            <button class="option-btn" onclick="selectPaperSize('A5')" data-size="A5">
                                <div class="font-semibold mb-1">A5</div>
                                <div class="text-xs opacity-75">210 x 148 mm</div>
                            </button>
                        </div>
                    </div>

                    <!-- Grosor del papel -->
                    <div class="config-section bg-white rounded-lg p-4 border">
                        <h3 class="section-title">
                            Grosor del papel
                            <div class="tooltip">
                                <i class="fas fa-info-circle text-gray-400 text-sm cursor-help"></i>
                                <span class="tooltiptext">Peso del papel en gramos</span>
                            </div>
                        </h3>
                        <p class="section-subtitle">Peso del papel en gramos</p>
                        <div class="option-grid-3">
                            <button class="option-btn active" onclick="selectPaperWeight('80g')" data-weight="80g">
                                <div class="font-semibold mb-1">80 gr</div>
                                <div class="text-xs opacity-75">Estándar</div>
                            </button>
                            <button class="option-btn" onclick="selectPaperWeight('160g')" data-weight="160g">
                                <div class="font-semibold mb-1">160 gr</div>
                                <div class="text-xs opacity-75">Grueso alto</div>
                            </button>
                            <button class="option-btn" onclick="selectPaperWeight('280g')" data-weight="280g">
                                <div class="font-semibold mb-1">280 gr</div>
                                <div class="text-xs opacity-75">Tipo cartulina</div>
                            </button>
                        </div>
                    </div>

                    <!-- Forma de impresión -->
                    <div class="config-section bg-white rounded-lg p-4 border">
                        <h3 class="section-title">
                            Forma de impresión
                            <div class="tooltip">
                                <i class="fas fa-info-circle text-gray-400 text-sm cursor-help"></i>
                                <span class="tooltiptext">Una cara o ambas caras</span>
                            </div>
                        </h3>
                        <div class="option-grid-2">
                            <button class="option-btn" onclick="selectSides('single')" data-sides="single">
                                <div class="font-semibold mb-1">Una cara</div>
                                <div class="text-xs opacity-75">por una cara del papel</div>
                            </button>
                            <button class="option-btn active" onclick="selectSides('double')" data-sides="double">
                                <div class="font-semibold mb-1">Doble cara</div>
                                <div class="text-xs opacity-75">por ambas caras del papel</div>
                            </button>
                        </div>
                    </div>

                    <!-- Orientación -->
                    <div class="config-section bg-white rounded-lg p-4 border">
                        <h3 class="section-title">
                            Orientación
                            <div class="tooltip">
                                <i class="fas fa-info-circle text-gray-400 text-sm cursor-help"></i>
                                <span class="tooltiptext">Orientación del documento</span>
                            </div>
                        </h3>
                        <div class="option-grid-2">
                            <button class="option-btn active" onclick="selectOrientation('portrait')" data-orientation="portrait">
                                <div class="font-semibold">Vertical</div>
                            </button>
                            <button class="option-btn" onclick="selectOrientation('landscape')" data-orientation="landscape">
                                <div class="font-semibold">Horizontal</div>
                            </button>
                        </div>
                    </div>

                    <!-- Orientación de reliure -->
                    <div class="config-section bg-white rounded-lg p-4 border">
                        <h3 class="section-title">Orientación de reliure</h3>
                        <p class="section-subtitle">Selecciona el lado de encuadernación</p>
                        
                        <div class="option-grid-2">
                            <button class="option-btn relative" onclick="selectBindingSide('long')" data-binding="long">
                                <i class="fas fa-check-circle text-green-500 absolute top-2 right-2 text-lg hidden binding-check"></i>
                                <img src="assets/img/vell.svg" alt="Lado largo" class="w-12 h-12 mb-2 mx-auto">
                                <div class="font-semibold">Lado largo</div>
                            </button>
                            
                            <button class="option-btn relative" onclick="selectBindingSide('short')" data-binding="short">
                                <i class="fas fa-check-circle text-green-500 absolute top-2 right-2 text-lg hidden binding-check"></i>
                                <img src="assets/img/velc.svg" alt="Lado corto" class="w-12 h-12 mb-2 mx-auto">
                                <div class="font-semibold">Lado corto</div>
                            </button>
                        </div>
                    </div>

                    <!-- Pages par feuille -->
                    <div class="config-section bg-white rounded-lg p-4 border">
                        <h3 class="section-title">Páginas por hoja</h3>
                        <p class="section-subtitle">Selecciona la distribución</p>
                        
                        <div class="option-grid-2 mb-3">
                            <button class="option-btn" onclick="selectPagesPerSheet('normal')" data-pages="normal">
                                <svg width="28" height="28" viewBox="0 0 42 42" xmlns="http://www.w3.org/2000/svg" class="mb-2">
                                    <rect x="2" y="2" rx="2" ry="2" width="34" height="38" style="fill:white;stroke:#9e9e9e;stroke-width:1.5;opacity:1"></rect>
                                    <rect x="6" y="6" rx="1" ry="1" width="26" height="30" style="fill:#1976d2;stroke:#1976d2;stroke-width:1.5;opacity:.8"></rect>
                                </svg>
                                <div class="font-semibold mb-1">Normal</div>
                                <div class="text-xs opacity-75">1 página por cara</div>
                            </button>
                            
                            <button class="option-btn" onclick="selectPagesPerSheet('two-horizontal')" data-pages="two-horizontal">
                                <svg style="margin-top:1px;" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 42 42" class="mb-2">
                                    <rect x="2" y="2" rx="3" ry="3" width="38" height="34" style="fill:white;stroke:#1976d2;stroke-width:0.5;opacity:1"></rect>
                                    <rect x="6" y="6" rx="1" ry="1" width="14" height="26" style="fill:#1976d2;stroke:#1976d2;stroke-width:0.5;opacity:.8"></rect>
                                    <rect x="22" y="6" rx="1" ry="1" width="14" height="26" style="fill:#1976d2;stroke:#1976d2;stroke-width:0.5;opacity:.8"></rect>
                                </svg>
                                <div class="font-semibold mb-1">2 páginas</div>
                                <div class="text-xs opacity-75">Papel en horizontal</div>
                            </button>
                        </div>
                        
                        <div class="option-grid-2">
                            <button class="option-btn" onclick="selectPagesPerSheet('two-vertical')" data-pages="two-vertical">
                                <svg style="margin-top:1px;" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 42 42" class="mb-2">
                                    <rect x="2" y="2" rx="3" ry="3" width="34" height="38" style="fill:white;stroke:#1976d2;stroke-width:.5;opacity:1"></rect>
                                    <rect x="6" y="6" rx="1" ry="1" width="26" height="14" style="fill:#1976d2;stroke:#1976d2;stroke-width:0.5;opacity:.8"></rect>
                                    <rect x="6" y="22" rx="1" ry="1" width="26" height="14" style="fill:#1976d2;stroke:#1976d2;stroke-width:0.5;opacity:.8"></rect>
                                </svg>
                                <div class="font-semibold mb-1">2 diapositivas</div>
                                <div class="text-xs opacity-75">Orientación vertical</div>
                            </button>
                            
                            <button class="option-btn" onclick="selectPagesPerSheet('four')" data-pages="four">
                                <svg style="margin-top:1px;" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 42 42" class="mb-2">
                                    <rect x="2" y="2" rx="3" ry="3" width="38" height="34" style="fill:white;stroke:#1976d2;stroke-width:0.5;opacity:1"></rect>
                                    <rect x="6" y="6" rx="1" ry="1" width="14" height="12" style="fill:#1976d2;stroke:#1976d2;stroke-width:0.5;opacity:0.8"></rect>
                                    <rect x="22" y="6" rx="1" ry="1" width="14" height="12" style="fill:#1976d2;stroke:#1976d2;stroke-width:0.5;opacity:0.8"></rect>
                                    <rect x="6" y="20" rx="1" ry="1" width="14" height="12" style="fill:#1976d2;stroke:#1976d2;stroke-width:0.5;opacity:0.8"></rect>
                                    <rect x="22" y="20" rx="1" ry="1" width="14" height="12" style="fill:#1976d2;stroke:#1976d2;stroke-width:0.5;opacity:0.8"></rect>
                                </svg>
                                <div class="font-semibold mb-1">4 diapositivas</div>
                                <div class="text-xs opacity-75">por cara impresa</div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Acabado -->
        <div class="collapsible-section">
            <div class="section-header bg-white rounded-lg border p-3 flex items-center justify-between hover:bg-gray-50 transition-colors" onclick="toggleCollapse('acabado')">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-file-alt text-green-500"></i>
                    <div>
                        <div class="font-semibold text-gray-800">Acabado</div>
                        <div class="text-sm text-gray-500">Selecciona el tipo de acabado</div>
                    </div>
                </div>
                <i class="fas fa-chevron-down transition-transform" id="acabado-icon"></i>
            </div>
            
            <div class="section-content mt-3 collapsed" id="acabado-section">
                <div class="config-section bg-white rounded-lg p-4 border">
                    <h3 class="section-title">Acabado</h3>
                    <p class="section-subtitle">Selecciona el tipo de acabado</p>
                    
                    <!-- Section 1: Individual vs Agrupado -->
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Tipo de documento</h4>
                        <div class="finishing-grid">
                            <button class="option-btn flex items-center text-left p-3" onclick="selectDocumentType('individual')" data-document="individual">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 42 42" class="mr-3 flex-shrink-0">
                                    <rect x="2" y="2" rx="3" ry="3" width="29" height="33" style="fill: white; stroke: rgb(175, 175, 175); stroke-width: 1;"></rect>
                                    <line x1="6" y1="4" x2="6" y2="32" style="stroke: rgb(66, 133, 244); stroke-width: 1.5;"></line>
                                    <rect x="12" y="5" rx="3" ry="3" width="29" height="33" style="fill: white; stroke: rgb(175, 175, 175); stroke-width: 1;"></rect>
                                    <line x1="16" y1="7" x2="16" y2="36" style="stroke: rgb(66, 133, 244); stroke-width: 1.5;"></line>
                                </svg>
                                <div>
                                    <div class="font-semibold">Individual</div>
                                    <div class="text-xs opacity-75">Cada documento</div>
                                </div>
                            </button>
                            
                            <button class="option-btn flex items-center text-left p-3" onclick="selectDocumentType('grouped')" data-document="grouped">
                                <svg width="32" height="32" viewBox="0 0 42 42" xmlns="http://www.w3.org/2000/svg" class="mr-3 flex-shrink-0">
                                    <rect x="2" y="2" rx="3" ry="3" width="34" height="38" style="fill: white; stroke: rgb(191, 191, 191); stroke-width: 1.15px;"></rect>
                                    <line x1="6" y1="4" x2="6" y2="37" style="stroke-width: 3px; stroke: rgb(66, 133, 244);"></line>
                                </svg>
                                <div>
                                    <div class="font-semibold">Agrupado</div>
                                    <div class="text-xs opacity-75">Todos en uno</div>
                                </div>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Section 2: Types de finition -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Opciones de acabado</h4>
                        
                        <div class="finishing-grid mb-3">
                            <button class="option-btn flex items-center text-left p-3" onclick="selectFinishing('none')" data-finishing="none">
                                <img src="assets/img/SA.svg" alt="Sin acabado" class="w-8 h-8 mr-3 flex-shrink-0">
                                <div>
                                    <div class="font-semibold">Sin acabado</div>
                                    <div class="text-xs opacity-75">Solo impresión</div>
                                </div>
                            </button>
                            
                            <button class="option-btn flex items-center text-left p-3" onclick="selectFinishing('spiral')" data-finishing="spiral">
                                <svg width="32" height="32" viewBox="0 0 42 42" xmlns="http://www.w3.org/2000/svg" class="mr-3 flex-shrink-0">
                                    <rect x="2" y="2" rx="3" ry="3" width="34" height="38" class="fill-white stroke-gray-400"></rect>
                                    <line x1="6" y1="4" x2="6" y2="37" class="stroke-blue-500" style="stroke-width: 3px;"></line>
                                </svg>
                                <div>
                                    <div class="font-semibold">Encuadernado</div>
                                    <div class="text-xs opacity-75">En espiral</div>
                                </div>
                            </button>
                        </div>
                        
                        <div class="finishing-grid mb-3">
                            <button class="option-btn flex items-center text-left p-3" onclick="selectFinishing('staple')" data-finishing="staple">
                                <img src="assets/img/GR.svg" alt="Grapado" class="w-8 h-8 mr-3 flex-shrink-0">
                                <div>
                                    <div class="font-semibold">Grapado</div>
                                    <div class="text-xs opacity-75">En esquina</div>
                                </div>
                            </button>
                            
                            <button class="option-btn flex items-center text-left p-3" onclick="selectFinishing('laminated')" data-finishing="laminated">
                                <img src="assets/img/SA.svg" alt="Plastificado" class="w-8 h-8 mr-3 flex-shrink-0">
                                <div>
                                    <div class="font-semibold">Plastificado</div>
                                    <div class="text-xs opacity-75">Ultraresistente</div>
                                </div>
                            </button>
                        </div>
                        
                        <div class="finishing-grid">
                            <button class="option-btn flex items-center text-left p-3" onclick="selectFinishing('perforated2')" data-finishing="perforated2">
                                <img src="assets/img/2AG.svg" alt="Perforado 2" class="w-8 h-8 mr-3 flex-shrink-0">
                                <div>
                                    <div class="font-semibold">Perforado</div>
                                    <div class="text-xs opacity-75">2 agujeros</div>
                                </div>
                            </button>
                            
                            <button class="option-btn flex items-center text-left p-3" onclick="selectFinishing('perforated4')" data-finishing="perforated4">
                                <img src="assets/img/4AG.svg" alt="Perforado 4" class="w-8 h-8 mr-3 flex-shrink-0">
                                <div>
                                    <div class="font-semibold">Perforado</div>
                                    <div class="text-xs opacity-75">4 agujeros</div>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Comentario -->
        <div class="collapsible-section">
            <div class="section-header bg-white rounded-lg border p-3 flex items-center justify-between hover:bg-gray-50 transition-colors" onclick="toggleCollapse('comentario')">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-comment text-purple-500"></i>
                    <div>
                        <div class="font-semibold text-gray-800">Comentario</div>
                        <div class="text-sm text-gray-500">Comentario de la impresión</div>
                    </div>
                </div>
                <i class="fas fa-chevron-up transition-transform" id="comentario-icon"></i>
            </div>
            
            <div class="section-content mt-3" id="comentario-section">
                <div class="config-section bg-white rounded-lg p-4 border">
                    <h3 class="section-title">
                        Comentario
                        <i class="fas fa-comment text-gray-400"></i>
                    </h3>
                    <p class="section-subtitle">Comentario de la impresión</p>
                    <textarea 
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none text-sm"
                        placeholder="Comentario de impresión"
                        rows="3"
                        id="print-comments"
                        maxlength="400"
                        oninput="updateCharCount()"
                    ></textarea>
                    <div class="flex justify-end mt-2">
                        <span class="text-sm text-gray-500"><span id="char-count">0</span> / 400</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</aside>
        <!-- Zone principale -->
        <main class="flex-1 bg-white flex flex-col">
            <!-- Document Title Bar -->
            <div class="bg-gray-50 px-6 py-3 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-folder text-blue-500"></i>
                        <span class="font-medium text-gray-800">Carpeta sin título</span>
                        <i class="fas fa-edit text-gray-400 text-sm cursor-pointer"></i>
                        <div class="flex flex-wrap gap-1">
                <span class="badge badge-blue" id="color-badge">BN</span>
                <span class="badge badge-green" id="size-badge">A4</span>
                <span class="badge badge-orange" id="weight-badge">80</span>
                <span class="badge badge-purple" id="sides-badge">DC</span>
                <span class="badge badge-teal" id="finishing-badge">IN</span>
                <span class="badge badge-cyan" id="orientation-badge">VE</span>
                    <span class="badge badge-pink" id="copies-badge">5</span>
                </div>

                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold text-gray-800" id="price-display">0,00</div>
                        <div class="text-sm text-gray-600">EUR</div>
                        <button class="bg-green-500 hover:bg-green-600 text-white text-sm px-4 py-1 rounded-full mt-1 transition-colors">
                            Añadir al carro
                        </button>
                    </div>
                </div>
            </div>

            <!-- Upload Zone -->
             <div class="hidden p-6 border-t border-gray-200" id="file-list">
                <h4 class="font-medium text-gray-800 mb-4">Documentos subidos:</h4>
                <div id="files-container" class="space-y-2">
                    <!-- Files will be dynamically added here -->
                </div>
            </div>
            <div class="flex-1 flex items-center justify-center p-8">
                  <!-- File List (initially hidden) -->
            
                <div class="upload-zone w-full max-w-2xl h-96 border-2 border-dashed border-gray-300 rounded-xl flex flex-col items-center justify-center text-center bg-gradient-to-br from-gray-50 to-gray-100 hover:from-blue-50 hover:to-blue-100 hover:border-blue-300 transition-all duration-300 cursor-pointer" id="upload-zone">
                    <!-- Illustration -->
                    <div class="mb-6">
                        <svg width="120" height="120" viewBox="0 0 200 200" class="text-gray-400">
                            <!-- Laptop -->
                            <rect x="40" y="80" width="120" height="80" rx="8" fill="currentColor" opacity="0.3"/>
                            <rect x="50" y="90" width="100" height="60" rx="4" fill="white"/>
                            <!-- Documents floating -->
                            <rect x="70" y="40" width="30" height="40" rx="2" fill="currentColor" opacity="0.6" transform="rotate(-10 85 60)"/>
                            <rect x="90" y="30" width="30" height="40" rx="2" fill="currentColor" opacity="0.7" transform="rotate(5 105 50)"/>
                            <rect x="110" y="45" width="30" height="40" rx="2" fill="currentColor" opacity="0.8" transform="rotate(-5 125 65)"/>
                            <!-- Chart lines in documents -->
                            <path d="M75 55 L85 50 L95 58" stroke="white" stroke-width="1.5" fill="none"/>
                            <path d="M95 40 L105 35 L115 42" stroke="white" stroke-width="1.5" fill="none"/>
                            <!-- Floating elements -->
                            <circle cx="160" cy="50" r="3" fill="currentColor" opacity="0.4"/>
                            <circle cx="170" cy="70" r="2" fill="currentColor" opacity="0.3"/>
                            <circle cx="155" cy="80" r="2" fill="currentColor" opacity="0.5"/>
                        </svg>
                    </div>
                    
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Selecciona los documentos a imprimir</h3>
                    <p class="text-gray-600 mb-6">Sube tus documentos y empieza a imprimir con la mejor calidad al mejor precio</p>
                    
                    <button class="bg-blue-500 hover:bg-blue-600 text-white font-medium px-8 py-3 rounded-lg flex items-center space-x-2 transition-colors shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span>Subir documentos ( pdf )</span>
                    </button>
                    
                    <!-- Cloud service icons -->
                    <div class="flex items-center space-x-4 mt-6 opacity-70">
                        <i class="fab fa-google-drive text-2xl text-blue-500"></i>
                        <i class="fab fa-dropbox text-2xl text-blue-600"></i>
                        <i class="fab fa-microsoft text-2xl text-blue-700"></i>
                    </div>
                    
                    <input type="file" multiple accept=".pdf,.doc,.docx,.txt" class="hidden" id="file-input">
                </div>
            </div>

          
        </main>
    </div>

    <!-- Modal de Rastreo -->
<div id="trackingModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="trackingModalContent">
        
        <!-- Header del Modal -->
        <div class="text-center mb-6">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-gradient-to-r from-orange-400 to-red-500 mb-4">
                <i class="fas fa-search text-white text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Rastrear Pedido</h3>
            <p class="text-gray-600">Ingresa tu email y número de pedido</p>
        </div>

        <!-- Formulario -->
      <!-- Formulario -->
        <form id="trackingForm" onsubmit="trackOrder(event)" class="space-y-6">
            
            <!-- Email Input -->
            <div class="relative">
                <label for="tracking-email" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-envelope mr-2 text-orange-500"></i>Email
                </label>
                <input type="email" 
                       id="tracking-email" 
                       name="email"
                       required
                       placeholder="tu@email.com"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all">
            </div>

            <!-- Order Number Input -->
            <div class="relative">
                <label for="tracking-order" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-hashtag mr-2 text-orange-500"></i>Número de Pedido
                </label>
                <input type="text" 
                       id="tracking-order" 
                       name="order_number"
                       required
                       placeholder="COP-2025-123456"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all">
            </div>

            <!-- Buttons -->
            <div class="flex space-x-4 pt-4">
                <button type="button" 
                        onclick="closeTrackingModal()"
                        class="flex-1 px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancelar
                </button>
                <button type="submit" 
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-lg hover:from-orange-600 hover:to-red-600 transition-all transform hover:scale-105">
                    <span id="track-btn-text">Buscar</span>
                    <i id="track-loading" class="fas fa-spinner fa-spin ml-2 hidden"></i>
                </button>
            </div>
        </form>

        <!-- Resultado del Rastreo -->
        <div id="trackingResult" class="hidden mt-6">
            <!-- El contenido se cargará dinámicamente -->
        </div>

    </div>
</div>
<div id="registerModal" class="fixed inset-0 modal-overlay z-50 flex items-center justify-center hidden">
    <div class="modal-content bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden">
        
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-6 border-b border-gray-100">
            <h2 class="text-xl font-semibold text-gray-800">Crea tu cuenta</h2>
            <button onclick="closeRegisterModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <!-- Modal Body -->
        <div class="p-6 space-y-4">
            <form id="registerForm" onsubmit="handleRegister(event)">
                
                <!-- Nombre y apellidos -->
                <div class="input-group">
                    <i class="fas fa-user input-icon"></i>
                    <input 
                        type="text" 
                        name="full_name"
                        class="input-field w-full py-4 pr-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all placeholder-gray-500"
                        placeholder="Nombre y apellidos"
                        required
                    >
                </div>
                
                <!-- Correo electrónico -->
                <div class="input-group">
                    <i class="fas fa-envelope input-icon"></i>
                    <input 
                        type="email" 
                        name="email"
                        class="input-field w-full py-4 pr-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all placeholder-gray-500"
                        placeholder="Correo electrónico"
                        required
                    >
                </div>
                <div class="input-group">
    <i class="fas fa-phone input-icon"></i>
    <input 
        type="tel" 
        name="phone"
        value="+34"
        class="input-field w-full py-4 pr-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all placeholder-gray-500"
        placeholder="Teléfono"
    >
</div>
                
                <!-- Contraseña -->
                <div class="input-group">
                    <i class="fas fa-key input-icon"></i>
                    <input 
                        type="password" 
                        name="password"
                        id="registerPassword"
                        class="input-field w-full py-4 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all placeholder-gray-500"
                        placeholder="Contraseña"
                        required
                        minlength="6"
                    >
                    <i class="fas fa-eye-slash password-toggle" onclick="togglePassword('registerPassword', this)"></i>
                </div>
                
                <!-- Términos y condiciones -->
                <div class="text-sm text-gray-600 leading-relaxed">
                    Al registrarte aceptas nuestros 
                    <a href="#" class="text-blue-600 hover:underline">Términos y Condiciones</a> 
                    y la 
                    <a href="#" class="text-blue-600 hover:underline">Política de Privacidad</a>.
                </div>
                
                <!-- Botón Crear cuenta -->
                <button 
                    type="submit" 
                    class="btn-primary w-full py-4 text-white font-semibold rounded-lg text-lg"
                >
                    Crear mi cuenta ahora
                </button>
                
                <!-- Separador -->
                <div class="flex items-center my-6">
                    <div class="flex-1 border-t border-gray-300"></div>
                    <span class="mx-4 text-gray-500 text-sm">O accede con:</span>
                    <div class="flex-1 border-t border-gray-300"></div>
                </div>
                
             <div class="flex space-x-3">
    <a href="auth/google.php?action=register" class="flex-1 flex items-center justify-center py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
        <i class="fab fa-google text-red-500 text-xl"></i>
    </a>
    <a href="auth/facebook.php?action=login" class="flex-1 flex items-center justify-center py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
        <i class="fab fa-facebook text-blue-600 text-xl"></i>
    </a>
    <button type="button" onclick="appleLogin()" class="flex-1 flex items-center justify-center py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
        <i class="fab fa-apple text-gray-800 text-xl"></i>
    </button>
</div>
                
                <!-- Link login -->
                <div class="text-center mt-6">
                    <span class="text-gray-600">¿Ya tienes cuenta? </span>
                    <a href="login.php" class="text-blue-600 hover:underline font-medium">Inicia sesión</a>
                </div>
                
            </form>
        </div>
    </div>
</div>
<div id="loginModal" class="fixed inset-0 modal-overlay z-50 flex items-center justify-center hidden">
    <div class="modal-content bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden">
        
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-6 border-b border-gray-100">
            <h2 class="text-xl font-semibold text-gray-800">Iniciar sesión</h2>
            <button onclick="closeLoginModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <!-- Modal Body -->
        <div class="p-6 space-y-4">
            <!-- Message d'erreur -->
            <div id="loginError" class="error hidden">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <span id="loginErrorMessage"></span>
            </div>
            
            <form id="loginForm" onsubmit="handleLogin(event)">
                
                <!-- Correo electrónico -->
                <div class="input-group">
                    <i class="fas fa-envelope input-icon"></i>
                    <input 
                        type="email" 
                        name="email"
                        id="loginEmail"
                        class="input-field w-full py-4 pr-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all placeholder-gray-500"
                        placeholder="Correo electrónico"
                        required
                    >
                </div>
                
                <!-- Contraseña -->
                <div class="input-group">
                    <i class="fas fa-key input-icon"></i>
                    <input 
                        type="password" 
                        name="password"
                        id="loginPassword"
                        class="input-field w-full py-4 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all placeholder-gray-500"
                        placeholder="Contraseña"
                        required
                    >
                    <i class="fas fa-eye-slash password-toggle" onclick="togglePassword('loginPassword', this)"></i>
                </div>
                
                <!-- Remember me y forgot password -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember_me" class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-gray-600">Recordarme</span>
                    </label>
                    <a href="#" class="text-blue-600 hover:underline">¿Olvidaste tu contraseña?</a>
                </div>
                
                <!-- Botón Iniciar sesión -->
                <button 
                    type="submit" 
                    class="btn-primary w-full py-4 text-white font-semibold rounded-lg text-lg"
                    id="loginButton"
                >
                    Iniciar sesión
                </button>
                
                <!-- Separador -->
                <div class="flex items-center my-6">
                    <div class="flex-1 border-t border-gray-300"></div>
                    <span class="mx-4 text-gray-500 text-sm">O inicia con:</span>
                    <div class="flex-1 border-t border-gray-300"></div>
                </div>
                
                <!-- Botones de redes sociales -->
               <div class="flex space-x-3">
    <a href="auth/google.php?action=login" class="flex-1 flex items-center justify-center py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
        <i class="fab fa-google text-red-500 text-xl"></i>
    </a>
    <a href="auth/facebook.php?action=login" class="flex-1 flex items-center justify-center py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
        <i class="fab fa-facebook text-blue-600 text-xl"></i>
    </a>
    <button type="button" onclick="appleLogin()" class="flex-1 flex items-center justify-center py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
        <i class="fab fa-apple text-gray-800 text-xl"></i>
    </button>
</div>
                
                <!-- Link register -->
                <div class="text-center mt-6">
                    <span class="text-gray-600">¿No tienes cuenta? </span>
                    <a href="#" onclick="openRegisterModal(); closeLoginModal();" class="text-blue-600 hover:underline font-medium">Regístrate</a>
                </div>
                
            </form>
        </div>
    </div>
</div>
<!-- Checkbox de aceptación antes del botón de pago -->
<div class="bg-gray-50 rounded-lg p-6 mb-4 text-center">
    <p class="text-sm text-gray-700 mb-2">
        He leído y acepto las 
        <a href="condiciones-generales.php" target="_blank" class="text-blue-600 hover:underline">
            Condiciones Generales de Venta
        </a> y la 
        <a href="politica-privacidad.php" target="_blank" class="text-blue-600 hover:underline">
            Política de Privacidad
        </a>.
    </p>
</div>

    <!-- JavaScript -->
    <script src="assets/js/mainn.js?v=<?= time() ?>"></script>
   
    <script>
function openTrackingModal() {
    const modal = document.getElementById('trackingModal');
    const content = document.getElementById('trackingModalContent');
    
    modal.classList.remove('hidden');
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeTrackingModal() {
    const modal = document.getElementById('trackingModal');
    const content = document.getElementById('trackingModalContent');
    
    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        document.getElementById('trackingForm').reset();
        document.getElementById('trackingResult').classList.add('hidden');
    }, 300);
}

async function trackOrder(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    const trackBtn = document.getElementById('track-btn-text');
    const trackLoading = document.getElementById('track-loading');
    
    // Mostrar loading
    trackBtn.textContent = 'Buscando...';
    trackLoading.classList.remove('hidden');
    
    try {
        const response = await fetch('api/track-order.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            displayTrackingResult(result.order, result.timeline);
        } else {
            showTrackingError(result.error);
        }
        
    } catch (error) {
        showTrackingError('Error de conexión. Inténtalo de nuevo.');
    } finally {
        // Restaurar botón
        trackBtn.textContent = 'Buscar';
        trackLoading.classList.add('hidden');
    }
}

function toggleCollapse(sectionName) {
    const section = document.getElementById(sectionName + '-section');
    const icon = document.getElementById(sectionName + '-icon');
    
    if (section && icon) {
        if (section.classList.contains('collapsed')) {
            section.classList.remove('collapsed');
            icon.classList.add('rotate-180');
        } else {
            section.classList.add('collapsed');
            icon.classList.remove('rotate-180');
        }
    }
}

function updateCharCount() {
    const textarea = document.getElementById('print-comments');
    const counter = document.getElementById('char-count');
    if (textarea && counter) {
        counter.textContent = textarea.value.length;
    }
}

// Initialiser la section commentarios comme ouverte
document.addEventListener('DOMContentLoaded', function() {
    const comentarioIcon = document.getElementById('comentario-icon');
    if (comentarioIcon) {
        comentarioIcon.classList.add('rotate-180');
    }
});

function displayTrackingResult(order, timeline) {
    const resultDiv = document.getElementById('trackingResult');
    
    resultDiv.innerHTML = `
        <div class="border-t border-gray-200 pt-6">
            <!-- Información del Pedido -->
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-4 mb-6">
                <div class="flex items-center justify-center mb-3">
                    <i class="fas fa-check-circle text-green-500 text-2xl mr-2"></i>
                    <h4 class="text-lg font-semibold text-green-800">¡Pedido Encontrado!</h4>
                </div>
                
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-medium text-gray-600">Cliente:</span>
                        <div class="font-semibold">${order.customer_name}</div>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">Total:</span>
                        <div class="font-semibold">€${parseFloat(order.total_price).toFixed(2)}</div>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">Archivos:</span>
                        <div class="font-semibold">${order.total_files}</div>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">Páginas:</span>
                        <div class="font-semibold">${order.total_pages}</div>
                    </div>
                </div>
                
                ${order.pickup_code ? `
                    <div class="mt-4 text-center bg-white rounded-lg p-3">
                        <span class="font-medium text-gray-600">Código de Recogida:</span>
                        <div class="text-xl font-bold text-blue-600 font-mono">${order.pickup_code}</div>
                    </div>
                ` : ''}
            </div>

            <!-- Estado Actual -->
            <div class="text-center mb-6">
                <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-${order.status_info.color}-100 text-${order.status_info.color}-800">
                    <i class="fas fa-${order.status_info.icon} mr-2"></i>
                    ${order.status_info.label}
                </div>
            </div>

            <!-- Timeline -->
            <div class="space-y-4">
                <h5 class="font-semibold text-gray-800 text-center mb-4">Progreso del Pedido</h5>
                <div class="relative">
                    ${generateTimeline(order.current_step, timeline)}
                </div>
            </div>

            <!-- Botón Cerrar -->
            <div class="mt-6 text-center">
                <button onclick="closeTrackingModal()" 
                        class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                    Cerrar
                </button>
            </div>
        </div>
    `;
    
    resultDiv.classList.remove('hidden');
}

function generateTimeline(currentStep, timeline) {
    const steps = [
        { step: 1, title: 'Pedido Recibido', icon: 'shopping-cart' },
        { step: 2, title: 'Pago Confirmado', icon: 'credit-card' },
        { step: 3, title: 'En Preparación', icon: 'cog' },
        { step: 4, title: 'Imprimiendo', icon: 'print' },
        { step: 5, title: 'Listo para Recoger', icon: 'box' },
        { step: 6, title: 'Entregado', icon: 'check-double' }
    ];
    
    return steps.map((step, index) => {
        const isCompleted = step.step <= currentStep;
        const isCurrent = step.step === currentStep;
        const isLast = index === steps.length - 1;
        
        return `
            <div class="flex items-center ${isLast ? '' : 'mb-4'}">
                <div class="flex items-center justify-center w-10 h-10 rounded-full border-2 ${
                    isCompleted 
                        ? 'bg-green-500 border-green-500 text-white' 
                        : 'bg-gray-200 border-gray-300 text-gray-400'
                }">
                    <i class="fas fa-${step.icon} text-sm"></i>
                </div>
                <div class="ml-4 flex-1">
                    <div class="font-medium ${isCompleted ? 'text-green-600' : 'text-gray-400'}">${step.title}</div>
                    ${isCurrent ? '<div class="text-xs text-blue-600 font-medium">Estado actual</div>' : ''}
                </div>
                ${!isLast ? `
                    <div class="absolute left-5 w-0.5 h-8 ${isCompleted ? 'bg-green-500' : 'bg-gray-300'}" style="top: ${(index * 64) + 40}px;"></div>
                ` : ''}
            </div>
        `;
    }).join('');
}

function showTrackingError(message) {
    const resultDiv = document.getElementById('trackingResult');
    
    resultDiv.innerHTML = `
        <div class="border-t border-gray-200 pt-6">
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                <i class="fas fa-exclamation-triangle text-red-500 text-2xl mb-2"></i>
                <h4 class="font-semibold text-red-800 mb-2">Error</h4>
                <p class="text-red-700">${message}</p>
                <button onclick="document.getElementById('trackingResult').classList.add('hidden')" 
                        class="mt-3 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                    Intentar de Nuevo
                </button>
            </div>
        </div>
    `;
    
    resultDiv.classList.remove('hidden');
}

// Cerrar modal al hacer clic fuera
document.getElementById('trackingModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeTrackingModal();
    }
});
</script>
<!-- Bouton WhatsApp Flottant -->
<div class="fixed bottom-6 right-6 z-50">
    <a href="https://wa.me/34635589530?text=Hola%2C%20necesito%20ayuda%20con%20mi%20pedido%20de%20impresi%C3%B3n" 
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
</style>
</body>
</html>