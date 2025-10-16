<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caisse - Tinta Expres LZ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    
    <!-- Header -->
    <header class="bg-blue-600 text-white p-4">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">Tinta Expres LZ - Caisse</h1>
            <div class="text-right">
                <div class="text-sm">Usuario: Admin</div>
                <div class="text-sm" id="current-time"></div>
            </div>
        </div>
    </header>

    <!-- Main Interface -->
    <div class="max-w-6xl mx-auto p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- 1. Ouvrir Caisse -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-cash-register text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-4">Abrir Caja</h3>
                    <button onclick="openCashDrawer()" class="w-full bg-green-500 hover:bg-green-600 text-white py-3 px-4 rounded-lg transition-colors">
                        <i class="fas fa-unlock mr-2"></i>
                        Abrir Caja
                    </button>
                </div>
            </div>

            <!-- 2. Venta Rápida -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-calculator text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-4">Venta Rápida</h3>
                    <button onclick="openQuickSale()" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-3 px-4 rounded-lg transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Nueva Venta
                    </button>
                </div>
            </div>

            <!-- 3. Scanner -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-qrcode text-orange-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-4">Scanner</h3>
                    <button onclick="openScanner()" class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 px-4 rounded-lg transition-colors">
                        <i class="fas fa-scan mr-2"></i>
                        Escanear
                    </button>
                </div>
            </div>

            <!-- 4. Crédito Cliente -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-credit-card text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-4">Crédito Cliente</h3>
                    <button onclick="openCredit()" class="w-full bg-purple-500 hover:bg-purple-600 text-white py-3 px-4 rounded-lg transition-colors">
                        <i class="fas fa-wallet mr-2"></i>
                        Gestionar Crédito
                    </button>
                </div>
            </div>
        </div>

        <!-- Resumen de Caja -->
        <div class="mt-6 bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-semibold mb-4">Resumen de Caja</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-green-50 p-4 rounded-lg">
                    <div class="text-green-600 text-sm font-medium">Ventas de Hoy</div>
                    <div class="text-2xl font-bold text-green-800" id="daily-sales">€0.00</div>
                </div>
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="text-blue-600 text-sm font-medium">Efectivo en Caja</div>
                    <div class="text-2xl font-bold text-blue-800" id="cash-amount">€0.00</div>
                </div>
                <div class="bg-orange-50 p-4 rounded-lg">
                    <div class="text-orange-600 text-sm font-medium">Créditos Pendientes</div>
                    <div class="text-2xl font-bold text-orange-800" id="pending-credits">€0.00</div>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg">
                    <div class="text-purple-600 text-sm font-medium">Transacciones</div>
                    <div class="text-2xl font-bold text-purple-800" id="transaction-count">0</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Venta Rápida -->
    <div id="quickSaleModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-md w-full p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold">Venta Rápida</h3>
                    <button onclick="closeModal('quickSaleModal')" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cantidad</label>
                        <input type="number" id="quickSale-quantity" min="1" value="1" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Precio (€)</label>
                        <input type="number" id="quickSale-price" step="0.01" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <input type="text" id="quickSale-description" placeholder="Ej: Impresión, Fotocopia..." class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                    
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="flex justify-between">
                            <span>Total:</span>
                            <span class="font-bold" id="quickSale-total">€0.00</span>
                        </div>
                    </div>
                    
                    <div class="flex space-x-3">
                        <button onclick="processQuickSale()" class="flex-1 bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg">
                            Procesar Venta
                        </button>
                        <button onclick="closeModal('quickSaleModal')" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Scanner -->
    <div id="scannerModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-md w-full p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold">Scanner de Documentos</h3>
                    <button onclick="closeModal('scannerModal')" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Número de Documentos</label>
                        <input type="number" id="scanner-docs" min="1" value="1" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Precio por Documento (€)</label>
                        <input type="number" id="scanner-price" step="0.01" value="0.50" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                    
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="flex justify-between">
                            <span>Total:</span>
                            <span class="font-bold" id="scanner-total">€0.50</span>
                        </div>
                    </div>
                    
                    <div class="flex space-x-3">
                        <button onclick="processScanning()" class="flex-1 bg-orange-500 hover:bg-orange-600 text-white py-2 px-4 rounded-lg">
                            Procesar Scanner
                        </button>
                        <button onclick="closeModal('scannerModal')" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Crédito Cliente -->
    <div id="creditModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-lg w-full p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold">Gestión de Crédito Cliente</h3>
                    <button onclick="closeModal('creditModal')" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del Cliente</label>
                        <input type="text" id="credit-customer" placeholder="Nombre del cliente" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cantidad Pagada (€)</label>
                        <input type="number" id="credit-amount" step="0.01" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Concepto</label>
                        <input type="text" id="credit-concept" placeholder="Ej: Adelanto para impresiones" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                    
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-blue-800 mb-2">Información</h4>
                        <p class="text-sm text-blue-700">
                            El cliente pagará la cantidad indicada y recibirá un recibo como comprobante. 
                            El crédito se guardará en el sistema para futuras compras.
                        </p>
                    </div>
                    
                    <div class="flex space-x-3">
                        <button onclick="processCredit()" class="flex-1 bg-purple-500 hover:bg-purple-600 text-white py-2 px-4 rounded-lg">
                            Generar Crédito
                        </button>
                        <button onclick="closeModal('creditModal')" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notifications -->
    <div id="toast-container" class="fixed top-4 right-4 z-50"></div>

    <script>
        // Variables globales
        let dailySales = 0;
        let cashAmount = 0;
        let pendingCredits = 0;
        let transactionCount = 0;

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            updateTime();
            setInterval(updateTime, 1000);
            loadDashboardData();
            
            // Event listeners pour calculs automatiques
            document.getElementById('quickSale-quantity').addEventListener('input', calculateQuickSaleTotal);
            document.getElementById('quickSale-price').addEventListener('input', calculateQuickSaleTotal);
            document.getElementById('scanner-docs').addEventListener('input', calculateScannerTotal);
            document.getElementById('scanner-price').addEventListener('input', calculateScannerTotal);
        });

        // Mise à jour de l'heure
        function updateTime() {
            const now = new Date();
            document.getElementById('current-time').textContent = now.toLocaleTimeString('es-ES');
        }

        // Charger les données du tableau de bord
        function loadDashboardData() {
            // Simulation - remplacer par appels API
            updateDashboard();
        }

        // Ouvrir tiroir-caisse
        async function openCashDrawer() {
            try {
                const response = await fetch('ticket-printer.php?action=open-drawer', {
                    method: 'POST'
                });
                
                if (response.ok) {
                    showToast('Caja abierta correctamente', 'success');
                } else {
                    showToast('Error al abrir la caja', 'error');
                }
            } catch (error) {
                showToast('Error de conexión', 'error');
                console.error('Error:', error);
            }
        }

        // Modals
        function openQuickSale() {
            document.getElementById('quickSaleModal').classList.remove('hidden');
        }

        function openScanner() {
            document.getElementById('scannerModal').classList.remove('hidden');
        }

        function openCredit() {
            document.getElementById('creditModal').classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        // Calculs
        function calculateQuickSaleTotal() {
            const quantity = parseFloat(document.getElementById('quickSale-quantity').value) || 0;
            const price = parseFloat(document.getElementById('quickSale-price').value) || 0;
            const total = quantity * price;
            document.getElementById('quickSale-total').textContent = '€' + total.toFixed(2);
        }

        function calculateScannerTotal() {
            const docs = parseFloat(document.getElementById('scanner-docs').value) || 0;
            const price = parseFloat(document.getElementById('scanner-price').value) || 0;
            const total = docs * price;
            document.getElementById('scanner-total').textContent = '€' + total.toFixed(2);
        }

        // Traitement des ventes
        async function processQuickSale() {
            const quantity = document.getElementById('quickSale-quantity').value;
            const price = document.getElementById('quickSale-price').value;
            const description = document.getElementById('quickSale-description').value;
            
            if (!quantity || !price || !description) {
                showToast('Veuillez remplir tous les champs', 'error');
                return;
            }

            const total = parseFloat(quantity) * parseFloat(price);
            
            try {
                const response = await fetch('pos-api.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({
                        action: 'quick_sale',
                        quantity: quantity,
                        price: price,
                        description: description,
                        total: total
                    })
                });

                const result = await response.json();
                
                if (result.success) {
                    showToast(`Venta procesada: €${total.toFixed(2)}`, 'success');
                    closeModal('quickSaleModal');
                    clearQuickSaleForm();
                    updateSalesData(total);
                    printReceipt(result.receipt_data);
                } else {
                    showToast('Error: ' + result.error, 'error');
                }
            } catch (error) {
                showToast('Error al procesar la venta', 'error');
                console.error('Error:', error);
            }
        }

        async function processScanning() {
            const docs = document.getElementById('scanner-docs').value;
            const price = document.getElementById('scanner-price').value;
            
            if (!docs || !price) {
                showToast('Veuillez remplir tous les champs', 'error');
                return;
            }

            const total = parseFloat(docs) * parseFloat(price);
            
            try {
                const response = await fetch('pos-api.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({
                        action: 'scanning',
                        documents: docs,
                        price_per_doc: price,
                        total: total
                    })
                });

                const result = await response.json();
                
                if (result.success) {
                    showToast(`Scanner procesado: €${total.toFixed(2)}`, 'success');
                    closeModal('scannerModal');
                    updateSalesData(total);
                    printReceipt(result.receipt_data);
                } else {
                    showToast('Error: ' + result.error, 'error');
                }
            } catch (error) {
                showToast('Error al procesar el scanner', 'error');
                console.error('Error:', error);
            }
        }

        async function processCredit() {
            const customer = document.getElementById('credit-customer').value;
            const amount = document.getElementById('credit-amount').value;
            const concept = document.getElementById('credit-concept').value;
            
            if (!customer || !amount || !concept) {
                showToast('Veuillez remplir tous les champs', 'error');
                return;
            }

            try {
                const response = await fetch('pos-api.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({
                        action: 'customer_credit',
                        customer_name: customer,
                        amount: amount,
                        concept: concept
                    })
                });

                const result = await response.json();
                
                if (result.success) {
                    showToast(`Crédito generado: €${parseFloat(amount).toFixed(2)}`, 'success');
                    closeModal('creditModal');
                    clearCreditForm();
                    updateCreditData(parseFloat(amount));
                    printCreditReceipt(result.receipt_data);
                } else {
                    showToast('Error: ' + result.error, 'error');
                }
            } catch (error) {
                showToast('Error al generar el crédito', 'error');
                console.error('Error:', error);
            }
        }

        // Fonctions utilitaires
        function clearQuickSaleForm() {
            document.getElementById('quickSale-quantity').value = '1';
            document.getElementById('quickSale-price').value = '';
            document.getElementById('quickSale-description').value = '';
            document.getElementById('quickSale-total').textContent = '€0.00';
        }

        function clearCreditForm() {
            document.getElementById('credit-customer').value = '';
            document.getElementById('credit-amount').value = '';
            document.getElementById('credit-concept').value = '';
        }

        function updateSalesData(amount) {
            dailySales += amount;
            cashAmount += amount;
            transactionCount++;
            updateDashboard();
        }

        function updateCreditData(amount) {
            pendingCredits += amount;
            cashAmount += amount;
            transactionCount++;
            updateDashboard();
        }

        function updateDashboard() {
            document.getElementById('daily-sales').textContent = '€' + dailySales.toFixed(2);
            document.getElementById('cash-amount').textContent = '€' + cashAmount.toFixed(2);
            document.getElementById('pending-credits').textContent = '€' + pendingCredits.toFixed(2);
            document.getElementById('transaction-count').textContent = transactionCount;
        }

        async function printReceipt(receiptData) {
            try {
                await fetch('ticket-printer.php?action=print-receipt', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(receiptData)
                });
            } catch (error) {
                console.error('Error printing receipt:', error);
            }
        }

        async function printCreditReceipt(receiptData) {
            try {
                await fetch('ticket-printer.php?action=print-credit', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(receiptData)
                });
            } catch (error) {
                console.error('Error printing credit receipt:', error);
            }
        }

        function showToast(message, type) {
            const toast = document.createElement('div');
            toast.className = `mb-4 p-4 rounded-lg shadow-lg text-white ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            }`;
            toast.textContent = message;
            
            document.getElementById('toast-container').appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }
    </script>
</body>
</html>