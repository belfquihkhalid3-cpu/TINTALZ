<?php
session_start();
require_once 'auth.php';
requireAdmin();

// Générer un numéro de facture automatique
$invoice_number = 'FAC-' . date('Y') . date('m') . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
$pickup_code = strtoupper(substr(md5(uniqid()), 0, 6));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Factura - <?= $invoice_number ?></title>
    <style>
        @media print {
            @page {
                margin: 0;
                size: A4;
            }
            
            body { 
                margin: 0;
                padding: 0;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }
            
            .no-print { 
                display: none !important; 
            }
            
            .invoice-container { 
                box-shadow: none !important;
                margin: 0;
                padding: 0;
                page-break-inside: avoid;
                page-break-after: avoid;
            }
            
            .invoice-content {
                padding: 15px 40px !important;
            }
            
            .info-boxes {
                margin-bottom: 15px !important;
            }
            
            .items-table {
                margin: 10px 0 !important;
                font-size: 9px !important;
            }
            
            .items-table th,
            .items-table td {
                padding: 6px 4px !important;
            }
            
            .acabados-section {
                margin: 15px 0 !important;
                padding: 10px !important;
            }
            
            .acabados-table {
                margin-top: 10px !important;
                font-size: 9px !important;
            }
            
            .acabados-table th,
            .acabados-table td {
                padding: 6px 4px !important;
            }
            
            .notes-section {
                margin-top: 15px !important;
                padding: 10px !important;
            }
            
            .totals-section {
                margin-top: 10px !important;
            }
            
            input, textarea, select {
                border: none !important;
                background: transparent !important;
                padding: 2px 0 !important;
                font-family: inherit !important;
                color: inherit !important;
            }
            
            .editable-field {
                border: none !important;
                background: transparent !important;
            }
            
            select {
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
            }
            
            h3 {
                font-size: 12px !important;
                margin-bottom: 5px !important;
            }
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            background-color: #f5f5f5;
            padding: 20px;
        }
        
        .invoice-container {
            max-width: 210mm;
            margin: 0 auto;
            background: white;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        
        /* Header Orange */
        .invoice-header {
            background: linear-gradient(135deg, #EF7834, #d96a3f);
            color: white;
            padding: 30px 40px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        
        .company-section {
            display: flex;
            gap: 20px;
            align-items: flex-start;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 8px;
            padding: 8px;
            object-fit: contain;
        }
        
        .company-info h1 {
            font-size: 26px;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .company-info p {
            font-size: 11px;
            line-height: 1.4;
            opacity: 0.95;
        }
        
        .invoice-title-section {
            text-align: right;
        }
        
        .invoice-title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 8px;
        }
        
        .invoice-number-input {
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 14px;
            width: 180px;
        }
        
        .invoice-title-section p {
            font-size: 11px;
            margin: 3px 0;
        }
        
        .status-badge {
            display: inline-block;
            background: #28a745;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            margin-top: 8px;
        }
        
        /* Content Section */
        .invoice-content {
            padding: 30px 40px;
        }
        
        .info-boxes {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .info-box {
            border: 2px solid #EF7834;
            border-radius: 8px;
            padding: 20px;
            background: #fff;
        }
        
        .info-box h3 {
            color: #EF7834;
            font-size: 14px;
            margin-bottom: 15px;
            font-weight: bold;
        }
        
        .info-box .field-group {
            margin-bottom: 8px;
        }
        
        .info-box label {
            font-weight: bold;
            font-size: 12px;
            display: inline-block;
            width: 120px;
        }
        
        .editable-field {
            border: 1px dashed #ddd;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 12px;
            font-family: inherit;
            transition: all 0.2s;
        }
        
        .editable-field:focus {
            outline: none;
            border-color: #EF7834;
            background: #fffbf7;
        }
        
        .editable-field:hover {
            border-color: #EF7834;
        }
        
        input.editable-field {
            width: calc(100% - 130px);
        }
        
        textarea.editable-field {
            width: calc(100% - 130px);
            min-height: 50px;
            resize: vertical;
        }
        
        select.editable-field {
            width: calc(100% - 130px);
            cursor: pointer;
        }
        
        /* Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 11px;
        }
        
        .items-table thead {
            background: #EF7834;
            color: white;
        }
        
        .items-table th {
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }
        
        .items-table td {
            padding: 10px 8px;
            border-bottom: 1px solid #eee;
        }
        
        .items-table tbody tr:hover {
            background: #f9f9f9;
        }
        
        .items-table input,
        .items-table select {
            width: 100%;
            border: 1px dashed #ddd;
            padding: 4px;
            font-size: 11px;
        }
        
        .items-table input:focus,
        .items-table select:focus {
            border-color: #EF7834;
            outline: none;
        }
        
        .btn-delete {
            background: #dc3545;
            color: white;
            border: none;
            padding: 4px 8px;
            border-radius: 3px;
            cursor: pointer;
            font-size: 10px;
        }
        
        .btn-delete:hover {
            background: #c82333;
        }
        
        .btn-add {
            background: #17a2b8;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            margin: 10px 0;
        }
        
        .btn-add:hover {
            background: #138496;
        }
        
        /* Acabados Section */
        .acabados-section {
            margin: 30px 0;
            padding: 20px;
            background: #f8f9fa;
            border: 2px dashed #17a2b8;
            border-radius: 8px;
        }
        
        .acabados-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .acabados-header input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
        
        .acabados-header h3 {
            color: #17a2b8;
            font-size: 16px;
            margin: 0;
        }
        
        .acabados-table-container {
            display: none;
        }
        
        .acabados-table-container.active {
            display: block;
        }
        
        .acabados-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 11px;
            background: white;
        }
        
        .acabados-table thead {
            background: #17a2b8;
            color: white;
        }
        
        .acabados-table th {
            padding: 10px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }
        
        .acabados-table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        
        .acabados-table input[type="number"] {
            text-align: center;
            width: 100% !important;
            min-width: 50px;
        }
        
        .acabados-table .editable-field {
            width: 100%;
        }
        
        /* Totals */
        .totals-section {
            text-align: right;
            margin-top: 20px;
        }
        
        .totals-table {
            margin-left: auto;
            width: 350px;
            font-size: 14px;
        }
        
        .totals-table td {
            padding: 10px 15px;
        }
        
        .totals-table .total-row {
            background: #EF7834;
            color: white;
            font-weight: bold;
            font-size: 16px;
        }
        
        .totals-table .total-row td {
            white-space: nowrap;
        }
        
        /* Notes Section */
        .notes-section {
            margin-top: 25px;
            border: 1px solid #EF7834;
            border-radius: 8px;
            padding: 15px;
        }
        
        .notes-section h4 {
            color: #EF7834;
            font-size: 13px;
            margin-bottom: 10px;
        }
        
        .notes-section textarea {
            width: 100%;
            border: 1px dashed #ddd;
            padding: 8px;
            border-radius: 4px;
            min-height: 60px;
            font-family: inherit;
            font-size: 12px;
        }
        
        /* Footer */
        .invoice-footer {
            background: #f8f9fa;
            padding: 20px 40px;
            text-align: center;
            border-top: 2px solid #EF7834;
            font-size: 11px;
            color: #666;
        }
        
        .invoice-footer p {
            margin: 3px 0;
        }
        
        /* Action Buttons */
        .action-buttons {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
            z-index: 1000;
        }
        
        .btn {
            background: #EF7834;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            box-shadow: 0 4px 12px rgba(239, 120, 52, 0.3);
            font-size: 13px;
        }
        
        .btn:hover {
            background: #d96a3f;
            transform: translateY(-1px);
        }
        
        .btn-secondary {
            background: #6c757d;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
        }
        
        .edit-notice {
            background: linear-gradient(135deg, #17a2b8, #138496);
            color: white;
            padding: 12px 40px;
            text-align: center;
            font-weight: bold;
            font-size: 13px;
        }
    </style>
</head>
<body>

    <div class="action-buttons no-print">
        <button onclick="window.location.href='orders.php'" class="btn btn-secondary">
            ← Volver
        </button>
        <button onclick="window.print()" class="btn">
            🖨️ Imprimir
        </button>
    </div>

    <div class="invoice-container">
        
        <!-- Edit Notice -->
        <div class="edit-notice no-print">
            ✏️ MODO EDICIÓN - Complete los campos y presione Imprimir
        </div>
        
        <!-- Header -->
        <div class="invoice-header">
            <div class="company-section">
                <img src="../assets/img/1.jpeg" alt="Logo" class="logo">
                <div class="company-info">
                    <h1>Tinta Expres LZ</h1>
                    <p>Servicios de Impresión Profesional</p>
                    <p>Carrer de les Tres Creus, 142</p>
                    <p>08202 Sabadell, Barcelona, Spain</p>
                    <p>Tel: +34 932 52 05 70 | Email: infotintaexpres@gmail.com</p>
                    <p>CIF: Y1082366T</p>
                </div>
            </div>
            <div class="invoice-title-section">
                <div class="invoice-title">FACTURA </div>
                <input type="text" class="invoice-number-input editable-field" value="<?= $invoice_number ?>" style="color: white; background: rgba(255,255,255,0.2);">
                <p>Fecha: <input type="date" class="editable-field" value="<?= date('Y-m-d') ?>" style="width: 110px; color: white; background: rgba(255,255,255,0.2);"></p>
               
                <span class="status-badge">PAGADO</span>
            </div>
        </div>

        <!-- Content -->
        <div class="invoice-content">
            
            <!-- Info Boxes -->
            <div class="info-boxes">
                <div class="info-box">
                    <h3>FACTURAR A:</h3>
                    <div class="field-group">
                        <input type="text" class="editable-field" placeholder="Nombre completo" style="width: 100%; font-weight: bold;">
                    </div>
                    <div class="field-group">
                        <textarea class="editable-field" placeholder="Dirección completa" style="width: 100%;"></textarea>
                    </div>
                    <div class="field-group">
                        <label>Email:</label>
                        <input type="email" class="editable-field" placeholder="cliente@email.com">
                    </div>
                    <div class="field-group">
                        <label>Teléfono:</label>
                        <input type="tel" class="editable-field" placeholder="+34 XXX XX XX XX">
                    </div>
                </div>
                
                <div class="info-box">
                    <h3>DETALLES DEL PEDIDO:</h3>
                    <div class="field-group">
                        <label>Número de Pedido:</label>
                        <input type="text" class="editable-field" value="<?= $invoice_number ?>">
                    </div>
                    <div class="field-group">
                        <label>Código de Recogida:</label>
                        <input type="text" class="editable-field" value="<?= $pickup_code ?>">
                    </div>
                    <div class="field-group">
                        <label>Método de Pago:</label>
                        <select class="editable-field">
                            <option>Efectivo</option>
                            <option>Tarjeta</option>
                            <option>Transferencia</option>
                            <option>Pago en Tienda</option>
                        </select>
                    </div>
                    <div class="field-group">
                        <label>Estado:</label>
                        <select class="editable-field">
                            <option>PENDING</option>
                            <option>PROCESSING</option>
                            <option>READY</option>
                            <option selected>COMPLETED</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <h3 style="color: #EF7834; margin-bottom: 10px;">📄 Documentos de Impresión</h3>
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 25%;">Descripción</th>
                        <th style="width: 25%;">Configuración</th>
                        <th style="width: 15%;">Tipo Documento</th>
                        <th style="width: 10%;">Páginas</th>
                        <th style="width: 10%;">Copias</th>
                        <th style="width: 10%;">Precio Unit.</th>
                        <th style="width: 10%;">Total</th>
                        <th class="no-print" style="width: 5%;">✕</th>
                    </tr>
                </thead>
                <tbody id="itemsTableBody">
                    <tr data-index="0">
                        <td>
                            <input type="text" class="editable-field" placeholder="Nombre del documento">
                        </td>
                        <td>
                            <select class="editable-field">
                                <option>A4 - 80g - B/N - Una cara</option>
                                <option>A4 - 80g - Color - Una cara</option>
                                <option>A4 - 80g - B/N - Doble cara</option>
                                <option>A4 - 80g - Color - Doble cara</option>
                                <option>A3 - 80g - B/N - Una cara</option>
                                <option>A3 - 80g - Color - Una cara</option>
                                <option>A3 - 80g - B/N - Doble cara</option>
                                <option>A3 - 80g - Color - Doble cara</option>
                            </select>
                        </td>
                        <td>
                            <select class="editable-field">
                                <option>Individual - Cada documento</option>
                                <option>Agrupado - Todos en uno</option>
                            </select>
                        </td>
                        <td>
                            <input type="number" class="editable-field item-pages" data-index="0" value="1" min="1">
                        </td>
                        <td>
                            <input type="number" class="editable-field item-copies" data-index="0" value="1" min="1">
                        </td>
                        <td>
                            €<input type="number" step="0.01" class="editable-field item-unit-price" data-index="0" value="0.15" min="0" style="width: calc(100% - 12px);">
                        </td>
                        <td class="item-total" data-index="0" style="font-weight: bold;">
                            €0.15
                        </td>
                        <td class="no-print">
                            <button class="btn-delete" onclick="deleteRow(0)">🗑</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <button class="btn-add no-print" onclick="addNewRow()">➕ Agregar Documento</button>

            <!-- Acabados Section -->
            <div class="acabados-section">
                <div class="acabados-header">
                    <input type="checkbox" id="toggleAcabados" onchange="toggleAcabadosTable()">
                    <h3>✂️ Servicios de Acabado (Espiral, Grapado, Plastificado, etc.)</h3>
                </div>
                
                <div id="acabadosTableContainer" class="acabados-table-container">
                    <table class="acabados-table">
                        <thead>
                            <tr>
                                <th style="width: 40%;">Tipo de Acabado</th>
                                <th style="width: 20%;">Cantidad</th>
                                <th style="width: 20%;">Precio Unit.</th>
                                <th style="width: 15%;">Total</th>
                                <th class="no-print" style="width: 5%;">✕</th>
                            </tr>
                        </thead>
                        <tbody id="acabadosTableBody">
                            <tr data-acabado-index="0">
                                <td>
                                    <select class="editable-field acabado-type" data-acabado-index="0" onchange="updateAcabadoPrice(0)" style="width: 100%;">
                                        <option value="spiral">Encuadernado - En espiral</option>
                                        <option value="stapled">Grapado - En esquina</option>
                                        <option value="laminated">Plastificado - Ultraresistente</option>
                                        <option value="hole2">Perforado - 2 agujeros</option>
                                        <option value="hole4">Perforado - 4 agujeros</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="number" class="editable-field acabado-quantity" data-acabado-index="0" value="1" min="1" style="width: 100%; text-align: center;">
                                </td>
                                <td style="text-align: center;">
                                    <input type="number" step="0.01" class="editable-field acabado-unit-price" data-acabado-index="0" value="2.50" min="0" style="width: 60px; text-align: center;">
                                </td>
                                <td class="acabado-total-cell" data-acabado-index="0" style="font-weight: bold; text-align: center;">
                                    €2.50
                                </td>
                                <td class="no-print">
                                    <button class="btn-delete" onclick="deleteAcabadoRow(0)">🗑</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button class="btn-add no-print" onclick="addAcabadoRow()" style="margin-top: 10px;">➕ Agregar Acabado</button>
                </div>
            </div>

            <!-- Totals -->
            <div class="totals-section">
                <table class="totals-table">
                    <tr class="total-row">
                        <td colspan="2" style="text-align: right;"><strong>Total con IVA incluido : €<span id="total">0.18</span></strong></td>
                    </tr>
                </table>
            </div>

            <!-- Notes -->
            <div class="notes-section">
                <h4>Notas del Cliente:</h4>
                <textarea class="editable-field" placeholder="Agregar notas o instrucciones especiales..."></textarea>
            </div>

        </div>

        <!-- Footer -->
        <div class="invoice-footer">
            <p><strong>¡Gracias por confiar en Tinta Expres LZ!</strong></p>
            <p>Para cualquier consulta, contacte con nosotros en infotintaexpres@gmail.com o +34 932 52 05 70</p>
        </div>

    </div>

    <script>
    let itemIndex = 1;
    let acabadoIndex = 1;
    
    // Prix des acabados
    const acabadoPrices = {
        'spiral': 2.50,
        'stapled': 0.50,
        'laminated': 3.00,
        'hole2': 0.30,
        'hole4': 0.40
    };
    
    // Toggle Acabados Table
    function toggleAcabadosTable() {
        const checkbox = document.getElementById('toggleAcabados');
        const container = document.getElementById('acabadosTableContainer');
        
        if (checkbox.checked) {
            container.classList.add('active');
        } else {
            container.classList.remove('active');
        }
        
        calculateTotals();
    }
    
    // Update acabado price based on type
    function updateAcabadoPrice(index) {
        const typeSelect = document.querySelector(`.acabado-type[data-acabado-index="${index}"]`);
        const priceInput = document.querySelector(`.acabado-unit-price[data-acabado-index="${index}"]`);
        
        if (typeSelect && priceInput) {
            const selectedType = typeSelect.value;
            priceInput.value = acabadoPrices[selectedType].toFixed(2);
            calculateAcabadoTotal(index);
        }
    }
    
    // Calculate acabado total
    function calculateAcabadoTotal(index) {
        const quantityInput = document.querySelector(`.acabado-quantity[data-acabado-index="${index}"]`);
        const priceInput = document.querySelector(`.acabado-unit-price[data-acabado-index="${index}"]`);
        const totalCell = document.querySelector(`.acabado-total-cell[data-acabado-index="${index}"]`);
        
        if (quantityInput && priceInput && totalCell) {
            const quantity = parseFloat(quantityInput.value) || 0;
            const price = parseFloat(priceInput.value) || 0;
            const total = quantity * price;
            
            totalCell.textContent = '€' + total.toFixed(2);
            calculateTotals();
        }
    }
    
    // Add acabado row
    function addAcabadoRow() {
        const tbody = document.getElementById('acabadosTableBody');
        const newRow = document.createElement('tr');
        newRow.setAttribute('data-acabado-index', acabadoIndex);
        newRow.innerHTML = `
            <td>
                <select class="editable-field acabado-type" data-acabado-index="${acabadoIndex}" onchange="updateAcabadoPrice(${acabadoIndex})" style="width: 100%;">
                    <option value="spiral">Encuadernado - En espiral</option>
                    <option value="stapled">Grapado - En esquina</option>
                    <option value="laminated">Plastificado - Ultraresistente</option>
                    <option value="hole2">Perforado - 2 agujeros</option>
                    <option value="hole4">Perforado - 4 agujeros</option>
                </select>
            </td>
            <td>
                <input type="number" class="editable-field acabado-quantity" data-acabado-index="${acabadoIndex}" value="1" min="1" onchange="calculateAcabadoTotal(${acabadoIndex})" style="width: 100%; text-align: center;">
            </td>
            <td style="text-align: center;">
                €<input type="number" step="0.01" class="editable-field acabado-unit-price" data-acabado-index="${acabadoIndex}" value="2.50" min="0" style="width: 60px; text-align: center;" onchange="calculateAcabadoTotal(${acabadoIndex})">
            </td>
            <td class="acabado-total-cell" data-acabado-index="${acabadoIndex}" style="font-weight: bold; text-align: center;">
                €2.50
            </td>
            <td class="no-print">
                <button class="btn-delete" onclick="deleteAcabadoRow(${acabadoIndex})">🗑</button>
            </td>
        `;
        tbody.appendChild(newRow);
        acabadoIndex++;
        calculateTotals();
    }
    
    // Delete acabado row
    function deleteAcabadoRow(index) {
        const row = document.querySelector(`tr[data-acabado-index="${index}"]`);
        if (row) {
            row.remove();
            calculateTotals();
        }
    }
    
    // Add new document row
    function addNewRow() {
        const tbody = document.getElementById('itemsTableBody');
        const newRow = document.createElement('tr');
        newRow.setAttribute('data-index', itemIndex);
        newRow.innerHTML = `
            <td>
                <input type="text" class="editable-field" placeholder="Nombre del documento">
            </td>
            <td>
                <select class="editable-field">
                    <option>A4 - 80g - B/N - Una cara</option>
                    <option>A4 - 80g - Color - Una cara</option>
                    <option>A4 - 80g - B/N - Doble cara</option>
                    <option>A4 - 80g - Color - Doble cara</option>
                    <option>A3 - 80g - B/N - Una cara</option>
                    <option>A3 - 80g - Color - Una cara</option>
                    <option>A3 - 80g - B/N - Doble cara</option>
                    <option>A3 - 80g - Color - Doble cara</option>
                </select>
            </td>
            <td>
                <select class="editable-field">
                    <option>Individual - Cada documento</option>
                    <option>Agrupado - Todos en uno</option>
                </select>
            </td>
            <td>
                <input type="number" class="editable-field item-pages" data-index="${itemIndex}" value="1" min="1">
            </td>
            <td>
                <input type="number" class="editable-field item-copies" data-index="${itemIndex}" value="1" min="1">
            </td>
            <td>
                €<input type="number" step="0.01" class="editable-field item-unit-price" data-index="${itemIndex}" value="0.15" min="0" style="width: calc(100% - 12px);">
            </td>
            <td class="item-total" data-index="${itemIndex}" style="font-weight: bold;">
                €0.15
            </td>
            <td class="no-print">
                <button class="btn-delete" onclick="deleteRow(${itemIndex})">🗑</button>
            </td>
        `;
        tbody.appendChild(newRow);
        
        attachCalculateEvents(itemIndex);
        itemIndex++;
        calculateTotals();
    }
    
    // Delete document row
    function deleteRow(index) {
        const rows = document.querySelectorAll('#itemsTableBody tr');
        if (rows.length > 1) {
            const row = document.querySelector(`tr[data-index="${index}"]`);
            if (row) {
                row.remove();
                calculateTotals();
            }
        } else {
            alert('Debe haber al menos un artículo en la factura.');
        }
    }
    
    // Attach calculate events
    function attachCalculateEvents(index) {
        const pages = document.querySelector(`.item-pages[data-index="${index}"]`);
        const copies = document.querySelector(`.item-copies[data-index="${index}"]`);
        const unitPrice = document.querySelector(`.item-unit-price[data-index="${index}"]`);
        
        if (pages) pages.addEventListener('input', calculateTotals);
        if (copies) copies.addEventListener('input', calculateTotals);
        if (unitPrice) unitPrice.addEventListener('input', calculateTotals);
    }
    
    // Calculate totals
// Calculate totals
function calculateTotals() {
    let subtotal = 0;
    
    // Calculate document totals
    document.querySelectorAll('.item-pages').forEach(function(input) {
        const index = input.dataset.index;
        const pagesInput = document.querySelector(`.item-pages[data-index="${index}"]`);
        const copiesInput = document.querySelector(`.item-copies[data-index="${index}"]`);
        const unitPriceInput = document.querySelector(`.item-unit-price[data-index="${index}"]`);
        
        if (pagesInput && copiesInput && unitPriceInput) {
            const pages = parseFloat(pagesInput.value) || 0;
            const copies = parseFloat(copiesInput.value) || 0;
            const unitPrice = parseFloat(unitPriceInput.value) || 0;
            
            const itemTotal = pages * copies * unitPrice;
            const totalCell = document.querySelector(`.item-total[data-index="${index}"]`);
            if (totalCell) {
                totalCell.textContent = '€' + itemTotal.toFixed(2);
            }
            
            subtotal += itemTotal;
        }
    });
    
    // Add acabados totals if checkbox is checked
    const acabadosCheckbox = document.getElementById('toggleAcabados');
    if (acabadosCheckbox && acabadosCheckbox.checked) {
        document.querySelectorAll('.acabado-total-cell').forEach(function(cell) {
            const totalText = cell.textContent.replace('€', '');
            const total = parseFloat(totalText) || 0;
            subtotal += total;
        });
    }
    
    // SUPPRIMEZ CES 3 LIGNES :
    // const ivaRate = 21;
    // const iva = subtotal * (ivaRate / 100);
    // const total = subtotal + iva;
    
    // REMPLACEZ PAR :
    const total = subtotal;
    
    document.getElementById('total').textContent = total.toFixed(2);
}
    
    // Initialization
    document.addEventListener('DOMContentLoaded', function() {
        attachCalculateEvents(0);
        
        // Attach events to first acabado row
        const firstQuantity = document.querySelector('.acabado-quantity[data-acabado-index="0"]');
        const firstPrice = document.querySelector('.acabado-unit-price[data-acabado-index="0"]');
        if (firstQuantity) firstQuantity.addEventListener('input', function() { calculateAcabadoTotal(0); });
        if (firstPrice) firstPrice.addEventListener('input', function() { calculateAcabadoTotal(0); });
        
        calculateTotals();
    });
    </script>

</body>
</html>