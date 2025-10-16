/**
 * Copisteria - JavaScript Principal
 * Gestion de la configuration d'impression et upload de fichiers
 */

// Configuration object (starting with 5 copies like the image)

// Variables pour les options du spiral
let spiralOptions = {
    color: 'negro',
    frontCover: 'blanco',
    backCover: 'negro'
};
// Configuration object avec valeurs par défaut
let config = {
    copies: 1,
    colorMode: 'bw',
    paperSize: 'A4',
    paperWeight: '80g',
    sides: 'double',
    orientation: 'portrait',
    documentType: 'individual',    // ← AJOUTER
    finishing: 'none',            // ← MODIFIER (était 'individual')
    bindingSide: 'long',
    pagesPerSheet: 'normal',
    files: []
};
// Au début du fichier, après la déclaration de pricing, ajouter :
function initializeDefaultPricing() {
    // Prix par défaut si l'API ne répond pas
    if (!pricing['A4'] || !pricing['A4']['80g']) {
        pricing['A4'] = pricing['A4'] || {};
        pricing['A4']['80g'] = pricing['A4']['80g'] || {};
        pricing['A4']['80g']['bw'] = 0.05;
        pricing['A4']['80g']['color'] = 0.15;
    }
    calculatePrice();
}


// Pricing data (corresponds to your SQL table)
let pricing = {}; // Vide au début

let finishingCosts = {
    'individual': 0,
    'grouped': 0,
    'none': 0,
    'spiral': 1.5,
    'staple': 0.5,
    'laminated': 5,
    'perforated2': 1,
    'perforated4': 1.5
};

/**
 * Utility Functions
 */
function updateActiveButton(container, activeData, value) {
    const buttons = container.querySelectorAll('.option-btn');
    buttons.forEach(btn => {
        btn.classList.remove('active');
        if (btn.dataset[activeData] === value) {
            btn.classList.add('active');
        }
    });
}

function calculatePrice() {

      if (config.files.length === 0) {
        updatePriceDisplay(0);
        return;
    }
    
    console.log('=== DEBUG CALCUL PRIX ===');
    console.log('Config finishing:', config.finishing);
    console.log('FinishingCosts disponibles:', finishingCosts);
    
    let finishingCost = finishingCosts[config.finishing] || 0;
    console.log('Coût finition appliqué:', finishingCost);

    if (!pricing[config.paperSize]) {
        console.error('Pas de pricing pour', config.paperSize);
        updatePriceDisplay(0);
        return;
    }
    
    if (!pricing[config.paperSize][config.paperWeight]) {
        console.error('Pas de pricing pour', config.paperSize, config.paperWeight);
        updatePriceDisplay(0);
        return;
    }
    
    if (!pricing[config.paperSize][config.paperWeight][config.colorMode]) {
        console.error('Pas de pricing pour', config.paperSize, config.paperWeight, config.colorMode);
        updatePriceDisplay(0);
        return;
    }
    
    let totalPages = config.files.reduce((sum, file) => sum + (file.pages || 1), 0);
    let basePrice = pricing[config.paperSize][config.paperWeight][config.colorMode];
    let totalPrice = basePrice * totalPages * config.copies;
    
   

    totalPrice += finishingCost * config.copies;
    
    updatePriceDisplay(totalPrice);
}

function updatePriceDisplay(price) {
    // Vérifier que price est un nombre valide
    const validPrice = isNaN(price) || price < 0 ? 0 : price;
    
    const totalPriceElement = document.getElementById('total-price');
    const priceDisplayElement = document.getElementById('price-display');
    
    if (totalPriceElement) {
        totalPriceElement.textContent = validPrice.toFixed(2) + ' €';
    }
    if (priceDisplayElement) {
        priceDisplayElement.textContent = validPrice.toFixed(2);
    }
}

/**
 * Event Handlers
 */
function changeQuantity(delta) {
    config.copies = Math.max(1, config.copies + delta);
    const copiesCountElement = document.getElementById('copies-count');
    if (copiesCountElement) {
        copiesCountElement.textContent = config.copies;
    }
    calculatePrice();
    updateConfigBadges();
    saveConfiguration();
}

function selectColorMode(mode) {
    config.colorMode = mode;
    const container = document.querySelector('[data-color]').closest('.option-grid-2');
    updateActiveButton(container, 'color', mode);
    calculatePrice();
     updateConfigBadges();
    saveConfiguration();
}

function selectPaperSize(size) {
    config.paperSize = size;
    const container = document.querySelector('[data-size]').closest('.option-grid-3');
    updateActiveButton(container, 'size', size);
    calculatePrice();
     updateConfigBadges();
    saveConfiguration();
}

function selectPaperWeight(weight) {
    config.paperWeight = weight;
    const container = document.querySelector('[data-weight]').closest('.option-grid-3');
    updateActiveButton(container, 'weight', weight);
    calculatePrice();
     updateConfigBadges();
    saveConfiguration();
}

function selectSides(sides) {
    config.sides = sides;
    const container = document.querySelector('[data-sides]').closest('.option-grid-2');
    updateActiveButton(container, 'sides', sides);
    calculatePrice();
     updateConfigBadges();
    saveConfiguration();
}

function selectOrientation(orientation) {
    config.orientation = orientation;
    const container = document.querySelector('[data-orientation]').closest('.option-grid-2');
    updateActiveButton(container, 'orientation', orientation);
     updateConfigBadges();
    saveConfiguration();
}

function selectFinishing(finishing) {
    config.finishing = finishing;
     if (finishing === 'spiral') {
        showSpiralOptionsModal();
        return;
    }
    // Mettre à jour les boutons actifs
    const finishingButtons = document.querySelectorAll('[data-finishing]');
    finishingButtons.forEach(btn => {
        btn.classList.remove('active');
        if (btn.dataset.finishing === finishing) {
            btn.classList.add('active');
        }
    });
    
    calculatePrice();
    updateConfigBadges();
    saveConfiguration();
}


function showSpiralOptionsModal() {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-70 z-50 flex items-center justify-center p-4';
    modal.innerHTML = `
        <div class="bg-white rounded-3xl p-8 w-full max-w-lg shadow-2xl transform transition-all">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <svg width="36" height="36" viewBox="0 0 42 42" xmlns="http://www.w3.org/2000/svg">
                        <rect x="2" y="2" rx="3" ry="3" width="34" height="38" class="fill-white stroke-white" stroke-width="2"></rect>
                        <line x1="6" y1="4" x2="6" y2="37" class="stroke-white" style="stroke-width: 4px;"></line>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800">Configurar Encuadernado</h3>
                <p class="text-gray-500 text-sm mt-2">Personaliza los colores de tu encuadernación</p>
            </div>
            
            <!-- Color del Espiral -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                    <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                    Color del Espiral
                </h4>
                <div class="grid grid-cols-3 gap-3">
                    <button onclick="selectSpiralColor('negro')" class="spiral-color-btn p-3 border-2 border-gray-200 rounded-xl hover:shadow-md transition-all duration-200">
                        <div class="flex items-center space-x-2">
                            <div class="w-5 h-5 bg-black rounded-full border border-gray-300"></div>
                            <span class="text-sm font-medium">Negro</span>
                        </div>
                    </button>
                 
                </div>
            </div>
            
            <!-- Tapa Delantera -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                    <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                    Tapa Delantera
                </h4>
                <div class="grid grid-cols-3 gap-3">
                    <button onclick="selectFrontCover('negro')" class="cover-btn p-3 border-2 border-gray-200 rounded-xl hover:shadow-md transition-all duration-200">
                        <div class="flex items-center space-x-2">
                            <div class="w-5 h-5 bg-black rounded border border-gray-300"></div>
                            <span class="text-sm font-medium">Negro</span>
                        </div>
                    </button>
                    <button onclick="selectFrontCover('blanco')" class="cover-btn p-3 border-2 border-gray-200 rounded-xl hover:shadow-md transition-all duration-200">
                        <div class="flex items-center space-x-2">
                            <div class="w-5 h-5 bg-white rounded border-2 border-gray-400"></div>
                            <span class="text-sm font-medium">Blanco</span>
                        </div>
                    </button>
                    <button onclick="selectFrontCover('transparente')" class="cover-btn p-3 border-2 border-gray-200 rounded-xl hover:shadow-md transition-all duration-200">
                        <div class="flex items-center space-x-2">
                            <div class="w-5 h-5 bg-gradient-to-br from-blue-100 to-white rounded border border-gray-300 relative">
                                <div class="absolute inset-0 bg-white opacity-60 rounded"></div>
                            </div>
                            <span class="text-sm font-medium">Transparente</span>
                        </div>
                    </button>
                </div>
            </div>
            
            <!-- Tapa Trasera -->
            <div class="mb-8">
                <h4 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                    <div class="w-3 h-3 bg-purple-500 rounded-full mr-3"></div>
                    Tapa Trasera
                </h4>
                <div class="grid grid-cols-3 gap-3">
                    <button onclick="selectBackCover('negro')" class="back-cover-btn p-3 border-2 border-gray-200 rounded-xl hover:shadow-md transition-all duration-200">
                        <div class="flex items-center space-x-2">
                            <div class="w-5 h-5 bg-black rounded border border-gray-300"></div>
                            <span class="text-sm font-medium">Negro</span>
                        </div>
                    </button>
                    <button onclick="selectBackCover('blanco')" class="back-cover-btn p-3 border-2 border-gray-200 rounded-xl hover:shadow-md transition-all duration-200">
                        <div class="flex items-center space-x-2">
                            <div class="w-5 h-5 bg-white rounded border-2 border-gray-400"></div>
                            <span class="text-sm font-medium">Blanco</span>
                        </div>
                    </button>
                    <button onclick="selectBackCover('transparente')" class="back-cover-btn p-3 border-2 border-gray-200 rounded-xl hover:shadow-md transition-all duration-200">
                        <div class="flex items-center space-x-2">
                            <div class="w-5 h-5 bg-gradient-to-br from-blue-100 to-white rounded border border-gray-300 relative">
                                <div class="absolute inset-0 bg-white opacity-60 rounded"></div>
                            </div>
                            <span class="text-sm font-medium">Transparente</span>
                        </div>
                    </button>
                </div>
            </div>
            
            <!-- Buttons -->
            <div class="flex space-x-4">
                <button onclick="closeSpiralModal()" class="flex-1 px-6 py-3 border-2 border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors">
                    Cancelar
                </button>
                <button onclick="confirmSpiralOptions()" class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-medium rounded-xl hover:from-blue-600 hover:to-purple-700 transition-colors shadow-lg">
                    Confirmar
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    modal.id = 'spiral-modal';
    
    // Sélections par défaut
    setTimeout(() => {
        selectSpiralColor('negro');
        selectFrontCover('blanco');
        selectBackCover('negro');
    }, 100);
}

function selectSpiralColor(color) {
    spiralOptions.color = color;
    document.querySelectorAll('.spiral-color-btn').forEach(btn => {
        btn.classList.remove('border-blue-500', 'bg-blue-50');
        btn.classList.add('border-gray-200');
    });
    event.target.closest('button').classList.remove('border-gray-200');
    event.target.closest('button').classList.add('border-blue-500', 'bg-blue-50');
}

function selectFrontCover(color) {
    spiralOptions.frontCover = color;
    document.querySelectorAll('.cover-btn').forEach(btn => {
        btn.classList.remove('border-green-500', 'bg-green-50');
        btn.classList.add('border-gray-200');
    });
    event.target.closest('button').classList.remove('border-gray-200');
    event.target.closest('button').classList.add('border-green-500', 'bg-green-50');
}

function selectBackCover(color) {
    spiralOptions.backCover = color;
    document.querySelectorAll('.back-cover-btn').forEach(btn => {
        btn.classList.remove('border-purple-500', 'bg-purple-50');
        btn.classList.add('border-gray-200');
    });
    event.target.closest('button').classList.remove('border-gray-200');
    event.target.closest('button').classList.add('border-purple-500', 'bg-purple-50');
}

function confirmSpiralOptions() {
    config.finishing = 'spiral';
    config.spiralColor = spiralOptions.color;
    config.frontCover = spiralOptions.frontCover;
    config.backCover = spiralOptions.backCover;
    
    // Mettre à jour les boutons actifs
    const finishingButtons = document.querySelectorAll('[data-finishing]');
    finishingButtons.forEach(btn => {
        btn.classList.remove('active');
        if (btn.dataset.finishing === 'spiral') {
            btn.classList.add('active');
        }
    });
    
    calculatePrice();
    updateConfigBadges();
    saveConfiguration();
    closeSpiralModal();
    
    showNotification(`Encuadernado: Espiral ${spiralOptions.color}, Tapa delantera ${spiralOptions.frontCover}, Tapa trasera ${spiralOptions.backCover}`, 'success');
}

function closeSpiralModal() {
    const modal = document.getElementById('spiral-modal');
    if (modal) {
        modal.remove();
    }
}
/**
 * File Upload Handling
 */
function initializeFileUpload() {
    const uploadZone = document.getElementById('upload-zone');
    const fileInput = document.getElementById('file-input');
    const fileList = document.getElementById('file-list');
    const filesContainer = document.getElementById('files-container');

    if (!uploadZone || !fileInput) return;

    // Click to upload
    uploadZone.addEventListener('click', () => fileInput.click());

    // Drag and drop functionality
    uploadZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadZone.classList.add('border-blue-400', 'bg-blue-50');
    });

    uploadZone.addEventListener('dragleave', (e) => {
        e.preventDefault();
        uploadZone.classList.remove('border-blue-400', 'bg-blue-50');
    });

    uploadZone.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadZone.classList.remove('border-blue-400', 'bg-blue-50');
        handleFiles(e.dataTransfer.files);
    });

    // File input change
    fileInput.addEventListener('change', (e) => {
        handleFiles(e.target.files);
    });
}
async function handleFiles(files) {
    console.log('=== DEBUG UPLOAD ===');
    const fileArray = Array.from(files);
    
    // Vérifier connexion
    const isGuestMode = sessionStorage.getItem('terminal_mode') === 'guest';
    if (!isUserLoggedIn() && !isGuestMode) {
        showNotification('Debes iniciar sesión para subir archivos', 'error');
        openLoginModal();
        return;
    }
    
    // Afficher indicateur de chargement
    showUploadProgress(true);
    
    let successCount = 0;
    
    for (let file of fileArray) {
        try {
            // Validation
            if (!validateFile(file)) {
                continue;
            }
            
            // Upload vers serveur
            const uploadedFile = await uploadFileToServer(file);
            console.log('File uploaded successfully:', uploadedFile);
            
            if (uploadedFile) {
                // Ajouter à la configuration locale
                config.files.push(uploadedFile);
                
                // Afficher dans l'interface
                addFileToList(uploadedFile);
                
                successCount++;
                showNotification(`${file.name} subido correctamente`, 'success');
            }
            
        } catch (error) {
            console.error('Upload error:', error);
            showNotification(`Error al subir ${file.name}: ${error.message}`, 'error');
        }
    }
    
    // Masquer indicateur
    showUploadProgress(false);
    
    // Mettre à jour l'interface si au moins un fichier uploadé
    if (successCount > 0) {
        console.log('Updated config.files:', config.files);
        
        // Afficher la liste des fichiers
        const fileList = document.getElementById('file-list');
        if (fileList) {
            fileList.classList.remove('hidden');
        }
        
        // Recalculer prix et mettre à jour boutons
        calculatePrice();
        updateAddToCartButton();
        saveConfiguration();
        
        console.log('Interface updated successfully');
    }
}
// Validation fichier côté client
function validateFile(file) {
    // Types autorisés
    const allowedTypes = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'text/plain'
    ];
    
    const allowedExtensions = ['pdf', 'doc', 'docx', 'txt'];
    const maxSize = 50 * 1024 * 1024; // 50MB
    
    // Vérifier l'extension
    const extension = file.name.split('.').pop().toLowerCase();
    if (!allowedExtensions.includes(extension)) {
        showNotification(`Formato no permitido: ${file.name}. Solo PDF, DOC, DOCX, TXT`, 'error');
        return false;
    }
    
    // Vérifier le type MIME
    if (!allowedTypes.includes(file.type)) {
        showNotification(`Tipo de archivo no válido: ${file.name}`, 'error');
        return false;
    }
    
    // Vérifier la taille
    if (file.size > maxSize) {
        showNotification(`Archivo demasiado grande: ${file.name} (máx 50MB)`, 'error');
        return false;
    }
    
    return true;
}

// Upload vers le serveur

async function uploadFileToServer(file) {
    console.log('Uploading file:', file.name);
    
    const formData = new FormData();
    formData.append('files', file);
    
    try {
        const response = await fetch('api/upload.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        console.log('Upload result:', result);
        
        // Gérer le cas où il y a des erreurs mais aussi des succès
        if (result.files && result.files.length > 0) {
            // Il y a au moins un fichier uploadé/trouvé
            const uploadedFile = result.files[0];
            
            if (uploadedFile.is_duplicate) {
                showNotification(`${file.name} ya existe, usando archivo existente`, 'info');
            }
            
            return uploadedFile;
        }
        
        // Aucun fichier retourné
        if (result.errors && result.errors.length > 0) {
            // Afficher la première erreur
            throw new Error(result.errors[0]);
        }
        
        throw new Error(result.error || 'Error desconocido');
        
    } catch (error) {
        console.error('Fetch error:', error);
        throw error;
    }
}
// Version corrigée pour détecter la connexion
// Version debug pour identifier le problème
function isUserLoggedIn() {
    console.log('=== CONNECTION CHECK ===');
    
    // Tests spécifiques et précis
    const accountLink = document.querySelector('a[href="account.php"]');
    const logoutLink = document.querySelector('a[href="logout.php"]');
    
    console.log('Account link found:', !!accountLink);
    console.log('Logout link found:', !!logoutLink);
    
    // Si on a les liens de compte ET logout, c'est qu'on est connecté
    const connected = accountLink && logoutLink;
    
    console.log('Final connection status:', connected);
    return connected;
}

// Indicateur de progression
function showUploadProgress(show) {
    let progressDiv = document.getElementById('upload-progress');
    
    if (show) {
        if (!progressDiv) {
            progressDiv = document.createElement('div');
            progressDiv.id = 'upload-progress';
            progressDiv.className = 'fixed top-4 left-1/2 transform -translate-x-1/2 bg-blue-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            progressDiv.innerHTML = `
                <div class="flex items-center space-x-3">
                    <div class="animate-spin rounded-full h-5 w-5 border-2 border-white border-t-transparent"></div>
                    <span>Subiendo archivos...</span>
                </div>
            `;
            document.body.appendChild(progressDiv);
        }
        progressDiv.style.display = 'block';
    } else {
        if (progressDiv) {
            progressDiv.style.display = 'none';
        }
    }
}

function addFileToList(file) {
    const filesContainer = document.getElementById('files-container');
    if (!filesContainer) return;

    const fileDiv = document.createElement('div');
    fileDiv.className = 'file-item fade-in';
    
    fileDiv.innerHTML = `
        <div class="flex items-center space-x-3">
            <i class="fas fa-file-pdf file-icon"></i>
            <div class="file-info">
                <div class="file-name">${escapeHtml(file.name)}</div>
                <div class="file-details">${formatFileSize(file.size)} • ${file.pages} páginas</div>
            </div>
        </div>
        <div class="file-actions">
            <span class="text-sm text-gray-600">${file.pages} × ${config.copies} = ${file.pages * config.copies} páginas</span>
            <button class="delete-btn" onclick="removeFile('${escapeHtml(file.name)}')">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    
    filesContainer.appendChild(fileDiv);
}

function removeFile(fileName) {
    config.files = config.files.filter(file => file.name !== fileName);
    
    // Remove from DOM
    const filesContainer = document.getElementById('files-container');
    if (filesContainer) {
        const fileElements = filesContainer.children;
        for (let i = 0; i < fileElements.length; i++) {
            if (fileElements[i].innerHTML.includes(fileName)) {
                fileElements[i].remove();
                break;
            }
        }
    }

    const fileList = document.getElementById('file-list');
    if (config.files.length === 0 && fileList) {
        fileList.classList.add('hidden');
    }

    calculatePrice();
      updateAddToCartButton();
    saveConfiguration();
}

/**
 * Utility Functions
 */
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

/**
 * Configuration Persistence
 */
function saveConfiguration() {
    try {
        const configToSave = { ...config };
        configToSave.files = []; // Don't save files, only configuration
        localStorage.setItem('copisteria_config', JSON.stringify(configToSave));
    } catch (e) {
        console.warn('Could not save configuration to localStorage:', e);
    }
}

function loadConfiguration() {
    try {
        const saved = localStorage.getItem('copisteria_config');
        if (saved) {
            const savedConfig = JSON.parse(saved);
            // Merge saved config with defaults, excluding files
            Object.assign(config, savedConfig, { files: [] });
            
            // Update UI to reflect loaded config
            updateUIFromConfig();
        }
    } catch (e) {
        console.warn('Could not load configuration from localStorage:', e);
    }
}
loadConfiguration();

function updateUIFromConfig() {
    // Update copies counter
    const copiesCountElement = document.getElementById('copies-count');
    if (copiesCountElement) {
        copiesCountElement.textContent = config.copies;
    }
    
    // Update active buttons based on loaded config
    setTimeout(() => {
        const colorContainer = document.querySelector('[data-color]')?.closest('.option-grid-2');
        if (colorContainer) updateActiveButton(colorContainer, 'color', config.colorMode);
        
        const sizeContainer = document.querySelector('[data-size]')?.closest('.option-grid-3');
        if (sizeContainer) updateActiveButton(sizeContainer, 'size', config.paperSize);
        
        const weightContainer = document.querySelector('[data-weight]')?.closest('.option-grid-3');
        if (weightContainer) updateActiveButton(weightContainer, 'weight', config.paperWeight);
        
        const sidesContainer = document.querySelector('[data-sides]')?.closest('.option-grid-2');
        if (sidesContainer) updateActiveButton(sidesContainer, 'sides', config.sides);
        
        const orientationContainer = document.querySelector('[data-orientation]')?.closest('.option-grid-2');
        if (orientationContainer) updateActiveButton(orientationContainer, 'orientation', config.orientation);
        
        // Mise à jour bindingSide - CORRECTION ICI
        const bindingButtons = document.querySelectorAll('[data-binding]');
        bindingButtons.forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.binding === config.bindingSide) {
                btn.classList.add('active');
            }
        });
        
        // Mise à jour documentType
        const documentButtons = document.querySelectorAll('[data-document]');
        documentButtons.forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.document === config.documentType) {
                btn.classList.add('active');
            }
        });
        
        // Mise à jour finishing
        const finishingButtons = document.querySelectorAll('[data-finishing]');
        finishingButtons.forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.finishing === config.finishing) {
                btn.classList.add('active');
            }
        });
        
        // Mise à jour pagesPerSheet
        const pagesButtons = document.querySelectorAll('[data-pages]');
        pagesButtons.forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.pages === config.pagesPerSheet) {
                btn.classList.add('active');
            }
        });
        
        calculatePrice();
    }, 100);
}

/**
 * Cart Functionality
 */
function addToCart() {
    const errors = validateConfiguration();
    
    if (errors.length > 0) {
        showNotification('Errores de configuración:\n' + errors.join('\n'), 'error');
        return;
    }
    
    // Récupérer le panier existant
    const existingCart = JSON.parse(sessionStorage.getItem('currentCart') || '{"folders": []}');
    
    // Créer un nouveau dossier avec spiralColor inclus
    const newFolder = {
        id: existingCart.folders.length + 1,
        name: `Carpeta ${existingCart.folders.length + 1}`,
        files: config.files,
        configuration: {
            ...config,
            spiralColor: config.spiralColor || null // Inclure la couleur spiral
        },
        copies: config.copies,
        total: parseFloat(document.getElementById('price-display')?.textContent || 0),
        comments: document.getElementById('print-comments')?.value || ''
    };
    
    existingCart.folders.push(newFolder);
    
    // Sauvegarder et rediriger
    sessionStorage.setItem('currentCart', JSON.stringify(existingCart));
    window.location.href = 'cart.php';
}
function validateConfiguration() {
    const errors = [];
    
    if (config.files.length === 0) {
        errors.push('Debe subir al menos un archivo');
    }
    
    if (config.copies < 1) {
        errors.push('Debe seleccionar al menos 1 copia');
    }
    
    return errors;
}

/**
 * Notification System
 */

function showNotification(message, type = 'info', duration = 5000) {
    // Supprimer notifications existantes
    document.querySelectorAll('.simple-notification').forEach(n => n.remove());
    
    const notification = document.createElement('div');
    notification.className = 'simple-notification';
    
    const bgColor = {
        'success': '#10b981',
        'error': '#ef4444', 
        'info': '#3b82f6',
        'warning': '#f59e0b'
    }[type] || '#3b82f6';
    
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: ${bgColor};
        color: white;
        padding: 16px 20px;
        border-radius: 8px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        z-index: 10000;
        font-size: 14px;
        font-weight: 500;
        max-width: 350px;
        word-wrap: break-word;
        opacity: 0;
        transform: translateX(100%);
        transition: all 0.3s ease;
    `;
    
    notification.innerHTML = `
        <div style="display: flex; align-items: flex-start; gap: 8px;">
            <span>${escapeHtml(message)}</span>
            <button onclick="this.parentElement.parentElement.remove()" 
                    style="background: none; border: none; color: white; cursor: pointer; font-size: 18px; padding: 0; margin-left: auto;">
                ×
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animation d'entrée
    setTimeout(() => {
        notification.style.opacity = '1';
        notification.style.transform = 'translateX(0)';
    }, 10);
    
    // Auto-fermeture
    setTimeout(() => {
        if (document.body.contains(notification)) {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(100%)';
            
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    notification.remove();
                }
            }, 300);
        }
    }, duration);
}
/**
 * Keyboard Shortcuts
 */
function initializeKeyboardShortcuts() {
    document.addEventListener('keydown', (e) => {
        if (e.ctrlKey || e.metaKey) {
            switch (e.key) {
                case 'u':
                    e.preventDefault();
                    document.getElementById('file-input')?.click();
                    break;
                case '+':
                case '=':
                    e.preventDefault();
                    changeQuantity(1);
                    break;
                case '-':
                    e.preventDefault();
                    changeQuantity(-1);
                    break;
            }
        }
    });
}

/**
 * Mobile Sidebar Toggle
 */
function initializeMobileToggle() {
    if (window.innerWidth < 1024) {
        const header = document.querySelector('header .flex');
        if (header) {
            const menuButton = document.createElement('button');
            menuButton.className = 'lg:hidden p-2 text-gray-600';
            menuButton.innerHTML = '<i class="fas fa-bars"></i>';
            menuButton.onclick = toggleSidebar;
            header.insertBefore(menuButton, header.firstChild);
        }
    }
}

function toggleSidebar() {
    const sidebar = document.querySelector('aside');
    if (sidebar) {
        sidebar.classList.toggle('hidden');
    }
}

/**
 * Real-time Updates
 */
function initializeRealTimeUpdates() {
    // Update price when typing in comments
    const commentsTextarea = document.getElementById('print-comments');
    if (commentsTextarea) {
        commentsTextarea.addEventListener('input', saveConfiguration);
    }
    
    // Auto-save configuration periodically
    setInterval(saveConfiguration, 30000); // Every 30 seconds
}
async function loadFinishingCosts() {
    try {
    console.log('=== DEBUT loadFinishingCosts ==='); // ← AJOUTER
        const response = await fetch('api/get-finishing.php');
        const data = await response.json();
        console.log('Données API reçues:', data.finishing_costs);
        if (data.success && data.finishing_costs) {
            // Mettre à jour les coûts de finition globaux
            finishingCosts = data.finishing_costs;
            calculatePrice(); // Recalculer le prix
        }
    } catch (error) {
        console.error('Erreur chargement coûts finition:', error);
    }
}
/**
 * Initialize Application
 */
function initializeApp() {
    // Load saved configuration FIRST
    loadConfiguration();
    
    // Initialize components
    initializeFileUpload();
    initializeKeyboardShortcuts();
    initializeMobileToggle();
    initializeRealTimeUpdates();
   
    
    
    // Setup add to cart button
    const addToCartBtn = document.querySelector('.bg-green-500');
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', addToCart);
    }
     const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('from') === 'cart') {
        showNotification('Agregue más documentos para crear una nueva carpeta', 'info');
    }
    // Load pricing AFTER everything is initialized
    loadPricingFromAPI();
     loadFinishingCosts();
       updateAddToCartButton();

}

// Charger les prix depuis l'API au démarrage
async function loadPricingFromAPI() {
    try {
        const response = await fetch('api/get-pricing.php');
        const data = await response.json();
        
        if (data.success && data.pricing) {
            pricing = {};
            
            for (let size in data.pricing) {
                pricing[size] = {};
                for (let weight in data.pricing[size]) {
                    pricing[size][weight] = {};
                    for (let color in data.pricing[size][weight]) {
                        const colorKey = color === 'BW' ? 'bw' : 'color';
                        pricing[size][weight][colorKey] = data.pricing[size][weight][color];
                    }
                }
            }
            
            calculatePrice(); // Recalculer après chargement
        }
    } catch (error) {
        console.error('Erreur chargement prix:', error);
        showNotification('Erreur chargement des prix', 'error');
    }
}
// Appeler au démarrage
loadPricingFromAPI();

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeApp);
} else {
    initializeApp();
}

// Fonction pour mettre à jour les badges avec codes courts
function updateConfigBadges() {
    // Couleur : BN (Blanc/Noir) ou CO (Couleur)
    document.getElementById('color-badge').textContent = config.colorMode === 'bw' ? 'BN' : 'CO';
    
    // Taille : A4, A3, A5
    document.getElementById('size-badge').textContent = config.paperSize;
    
    // Poids : 80, 160, 280
    document.getElementById('weight-badge').textContent = config.paperWeight.replace('g', '');
    
    // Faces : UC (Una Cara) ou DC (Doble Cara)
    document.getElementById('sides-badge').textContent = config.sides === 'single' ? 'UC' : 'DC';
    
    // Finition : codes courts
    const finishingCodes = {
        'individual': 'IN',
        'grouped': 'AG',
        'none': 'SA',
        'spiral': 'EN',
        'staple': 'GR',
        'laminated': 'PL',
        'perforated2': 'P2',
        'perforated4': 'P4'
    };
    document.getElementById('finishing-badge').textContent = finishingCodes[config.finishing];
    
    // Orientation : VE (Vertical) ou HO (Horizontal)  
    document.getElementById('orientation-badge').textContent = config.orientation === 'portrait' ? 'VE' : 'HO';
    
    // Copies : nombre
    document.getElementById('copies-badge').textContent = config.copies.toString();
}

// Fonction pour toggle le menu utilisateur
function toggleUserMenu() {
    const dropdown = document.getElementById('user-dropdown');
    dropdown.classList.toggle('hidden');
}

// Fermer le menu si on clique ailleurs
document.addEventListener('click', function(event) {
    const userMenu = document.getElementById('user-menu');
    const dropdown = document.getElementById('user-dropdown');
    
    if (!userMenu.contains(event.target)) {
        dropdown.classList.add('hidden');
    }
});

// Fonctions modal d'inscription
function openRegisterModal() {
    document.getElementById('registerModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeRegisterModal() {
    document.getElementById('registerModal').classList.add('hidden');
    document.body.style.overflow = '';
}

// Fermer modal si clic sur overlay
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('registerModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeRegisterModal();
            }
        });
    }
});

// Toggle password visibility
function togglePassword(inputId, icon) {
    const input = document.getElementById(inputId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    }
}

// Gérer l'inscription
function handleRegister(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const data = {
        full_name: formData.get('full_name'),
        email: formData.get('email'),
        password: formData.get('password')
    };
    
    // Appel AJAX vers votre API
    fetch('api/register.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            showNotification('Compte créé avec succès', 'success');
            closeRegisterModal();
        } else {
            showNotification(result.error || 'Erreur lors de l\'inscription', 'error');
        }
    })
    .catch(error => {
        showNotification('Erreur de connexion', 'error');
    });
}

// Fonctions modal login
function openLoginModal() {
    document.getElementById('loginModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    // Clear previous errors
    const errorDiv = document.getElementById('loginError');
    if (errorDiv) errorDiv.classList.add('hidden');
}

function closeLoginModal() {
    document.getElementById('loginModal').classList.add('hidden');
    document.body.style.overflow = '';
    // Reset form
    const form = document.getElementById('loginForm');
    if (form) form.reset();
    const errorDiv = document.getElementById('loginError');
    if (errorDiv) errorDiv.classList.add('hidden');
}

// Gérer la connexion
async function handleLogin(event) {
    event.preventDefault();
    
    const button = document.getElementById('loginButton');
    const originalText = button.textContent;
    
    // Disable button and show loading
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Conectando...';
    
    const formData = new FormData(event.target);
    const data = {
        email: formData.get('email'),
        password: formData.get('password'),
        remember_me: formData.get('remember_me') === 'on'
    };
    
    try {
        const response = await fetch('api/login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (result.success) {
            showNotification('Conexión exitosa', 'success');
            closeLoginModal();
            
            // Recharger la page pour mettre à jour le header
            setTimeout(() => {
                window.location.reload();
            }, 1000);
            
        } else {
            showLoginError(result.error || 'Error al iniciar sesión');
        }
        
    } catch (error) {
        console.error('Error login:', error);
        showLoginError('Error de conexión');
    } finally {
        // Restore button
        button.disabled = false;
        button.textContent = originalText;
    }
}

function showLoginError(message) {
    const errorDiv = document.getElementById('loginError');
    const errorMessage = document.getElementById('loginErrorMessage');
    
    if (errorDiv && errorMessage) {
        errorMessage.textContent = message;
        errorDiv.classList.remove('hidden');
        
        // Auto-hide after 5 seconds
        setTimeout(() => {
            errorDiv.classList.add('hidden');
        }, 5000);
    }
}

// Toggle menu utilisateur
function toggleUserMenu() {
    const dropdown = document.getElementById('user-dropdown');
    if (dropdown) {
        dropdown.classList.toggle('hidden');
    }
}

// Fermer menu si clic ailleurs
document.addEventListener('click', function(event) {
    const userMenu = document.getElementById('user-menu');
    const dropdown = document.getElementById('user-dropdown');
    
    if (userMenu && dropdown && !userMenu.contains(event.target)) {
        dropdown.classList.add('hidden');
    }
});

// Fermer modals avec Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeLoginModal();
        closeRegisterModal();
    }
});

// Fermer modals si clic sur overlay
document.addEventListener('DOMContentLoaded', function() {
    // Modal login
    const loginModal = document.getElementById('loginModal');
    if (loginModal) {
        loginModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeLoginModal();
            }
        });
    }
    
    // Modal register
    const registerModal = document.getElementById('registerModal');
    if (registerModal) {
        registerModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeRegisterModal();
            }
        });
    }
});

function updateAddToCartButton() {
    const addToCartBtn = document.querySelector('.bg-green-500');
    if (!addToCartBtn) return;
    
    if (config.files.length > 0) {
        // Activer le bouton
        addToCartBtn.disabled = false;
        addToCartBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        addToCartBtn.classList.add('hover:bg-green-600');
        addToCartBtn.textContent = 'Añadir al carro';
    } else {
        // Désactiver le bouton
        addToCartBtn.disabled = true;
        addToCartBtn.classList.add('opacity-50', 'cursor-not-allowed');
        addToCartBtn.classList.remove('hover:bg-green-600');
        addToCartBtn.textContent = 'Subir archivos primero';
    }
}

// Ajouter après les autres fonctions

// Apple Sign In (simulation)
function appleLogin() {
    showNotification('Apple Sign In estará disponible próximamente', 'info');
}

// Gérer les retours de connexion sociale
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    
    if (urlParams.get('social_login') === 'success') {
        showNotification('¡Conectado con éxito!', 'success');
        // Nettoyer URL
        window.history.replaceState({}, '', window.location.pathname);
    }
    
    if (urlParams.get('social_register') === 'success') {
        showNotification('¡Cuenta creada con éxito!', 'success');
        window.history.replaceState({}, '', window.location.pathname);
    }
    
    if (urlParams.get('social_error')) {
        showNotification('Error: ' + urlParams.get('social_error'), 'error');
        window.history.replaceState({}, '', window.location.pathname);
    }
});

// Améliorer les modals avec loading states
function socialLogin(provider) {
    // Afficher loading
    const buttons = document.querySelectorAll('.fab.fa-' + provider);
    buttons.forEach(btn => {
        const parent = btn.parentElement;
        parent.classList.add('opacity-50', 'pointer-events-none');
        btn.className = 'fas fa-spinner fa-spin text-xl';
    });
    
    // Message de redirection
    showNotification(`Redirigiendo a ${provider.charAt(0).toUpperCase() + provider.slice(1)}...`, 'info');
}

// Variable pour stocker l'orientation de reliure
config.bindingSide = 'long'; // par défaut

function selectBindingSide(side) {
    config.bindingSide = side;
    
    // Mettre à jour les boutons actifs
    const bindingButtons = document.querySelectorAll('[data-binding]');
    bindingButtons.forEach(btn => {
        const checkIcon = btn.querySelector('.binding-check');
        btn.classList.remove('active');
        checkIcon.classList.add('hidden');
        
        if (btn.dataset.binding === side) {
            btn.classList.add('active');
            checkIcon.classList.remove('hidden');
        }
    });
    
    calculatePrice();
    updateConfigBadges();
    saveConfiguration();
}

// Variable pour stocker les pages par feuille
config.pagesPerSheet = 'normal'; // par défaut

function selectPagesPerSheet(type) {
    config.pagesPerSheet = type;
    
    // Mettre à jour les boutons actifs
    const pagesButtons = document.querySelectorAll('[data-pages]');
    pagesButtons.forEach(btn => {
        btn.classList.remove('active');
        if (btn.dataset.pages === type) {
            btn.classList.add('active');
        }
    });
    
    calculatePrice();
    updateConfigBadges();
    saveConfiguration();
}



function toggleSection(sectionName) {
    const content = document.getElementById(sectionName + '-content');
    const arrow = document.getElementById(sectionName + '-arrow');
    const header = content.previousElementSibling;
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        header.classList.add('active');
        arrow.classList.remove('fa-chevron-down');
        arrow.classList.add('fa-chevron-up');
    } else {
        content.classList.add('hidden');
        header.classList.remove('active');
        arrow.classList.remove('fa-chevron-up');
        arrow.classList.add('fa-chevron-down');
    }
}

function updateCharCount() {
    const textarea = document.getElementById('print-comments');
    const counter = document.getElementById('char-count');
    if (textarea && counter) {
        counter.textContent = textarea.value.length;
    }
}


// Charger les coûts de finition depuis l'API






