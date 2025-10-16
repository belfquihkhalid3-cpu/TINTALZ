<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Política de Privacidad - Tinta Expres</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <a href="index.php" class="flex items-center space-x-3">
                    <img src="assets/img/1.jpeg" alt="Logo" class="h-12">
                    <h1 class="text-xl font-bold">Tinta Expres LZ</h1>
                </a>
                <a href="index.php" class="text-blue-600 hover:underline">
                    <i class="fas fa-arrow-left mr-2"></i>Volver
                </a>
            </div>
        </div>
    </header>

    <!-- Contenido -->
    <div class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8 text-center">Política de Privacidad</h1>
        
        <!-- Información principal -->
        <div class="bg-blue-50 rounded-lg p-6 mb-8">
            <p class="text-blue-900">
                En TINTA EXPRES nos tomamos muy en serio la protección de sus datos personales. 
                Esta política describe cómo recopilamos, usamos y protegemos su información.
            </p>
        </div>

        <div class="space-y-8">
            
            <!-- 1. Responsable -->
            <section class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-2xl font-bold mb-4">1. RESPONSABLE DEL TRATAMIENTO</h2>
                <div class="space-y-2 text-gray-700">
                    <p><strong>Identidad:</strong> TINTA EXPRES LZ </p>
                    <p><strong>CIF:</strong> Y1082366T</p>
                    <p><strong>Dirección:</strong> C/ de les tres creus ,142, 08202,sabadell</p>
                    <p><strong>Email:</strong> infotintaexpres@gmail.com</p>
                    <p><strong>Teléfono:</strong> + 34932520570 / +34 635589530</p>
                </div>
            </section>

            <!-- 2. Datos que recopilamos -->
            <section class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-2xl font-bold mb-4">2. DATOS QUE RECOPILAMOS</h2>
                <div class="space-y-4">
                    <div>
                        <h3 class="font-semibold mb-2">Datos de identificación:</h3>
                        <ul class="list-disc list-inside text-gray-700 space-y-1">
                            <li>Nombre y apellidos</li>
                            <li>DNI/NIF</li>
                            <li>Dirección postal</li>
                            <li>Teléfono</li>
                            <li>Email</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-2">Datos de transacciones:</h3>
                        <ul class="list-disc list-inside text-gray-700 space-y-1">
                            <li>Historial de pedidos</li>
                            <li>Productos adquiridos</li>
                            <li>Forma de pago (sin datos bancarios completos)</li>
                            <li>Dirección de entrega</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-2">Datos de navegación:</h3>
                        <ul class="list-disc list-inside text-gray-700 space-y-1">
                            <li>Dirección IP</li>
                            <li>Tipo de navegador</li>
                            <li>Páginas visitadas</li>
                            <li>Fecha y hora de acceso</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- 3. Finalidad -->
            <section class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-2xl font-bold mb-4">3. FINALIDAD DEL TRATAMIENTO</h2>
                <p class="text-gray-700 mb-4">Tratamos sus datos personales con las siguientes finalidades:</p>
                <ul class="list-disc list-inside text-gray-700 space-y-2">
                    <li><strong>Gestión de pedidos:</strong> Procesar y entregar sus pedidos</li>
                    <li><strong>Facturación:</strong> Emitir facturas y gestionar pagos</li>
                    <li><strong>Comunicación:</strong> Informarle sobre el estado de sus pedidos</li>
                    <li><strong>Atención al cliente:</strong> Resolver dudas e incidencias</li>
                    
                    <li><strong>Mejora del servicio:</strong> Analizar el uso de nuestra web</li>
                    <li><strong>Cumplimiento legal:</strong> Cumplir con obligaciones legales y fiscales</li>
                </ul>
            </section>

            <!-- 4. Base legal -->
            <section class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-2xl font-bold mb-4">4. BASE LEGAL</h2>
                <div class="space-y-3 text-gray-700">
                    <p>El tratamiento de sus datos se basa en:</p>
                    <ul class="list-disc list-inside space-y-2">
                        <li><strong>Ejecución de contrato:</strong> Para gestionar sus pedidos</li>
                        <li><strong>Consentimiento:</strong> Para envío de comunicaciones comerciales</li>
                        <li><strong>Interés legítimo:</strong> Para mejorar nuestros servicios</li>
                        <li><strong>Obligación legal:</strong> Para cumplir con normativas fiscales</li>
                    </ul>
                </div>
            </section>

            <!-- 5. Conservación -->
            <section class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-2xl font-bold mb-4">5. CONSERVACIÓN DE DATOS</h2>
                <div class="space-y-3 text-gray-700">
                    <p>Sus datos se conservarán durante:</p>
                    <ul class="list-disc list-inside space-y-2">
                        <li><strong>Datos de clientes:</strong> Durante la relación comercial y 6 años posteriores (obligaciones fiscales)</li>
                        <li><strong>Datos de facturación:</strong> 6 años (normativa fiscal)</li>
                        <li><strong>Archivos de impresión:</strong> 20 días desde el pedido</li>
                        <li><strong>Datos de navegación:</strong> 2 años máximo</li>
                        <li><strong>Comunicaciones comerciales:</strong> Hasta que retire su consentimiento</li>
                    </ul>
                </div>
            </section>

            <!-- 6. Destinatarios -->
            <section class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-2xl font-bold mb-4">6. DESTINATARIOS</h2>
                <p class="text-gray-700 mb-4">Sus datos podrán ser comunicados a:</p>
                <ul class="list-disc list-inside text-gray-700 space-y-2">
                    <li><strong>Empresas de transporte:</strong> Para la entrega de pedidos</li>
                    <li><strong>Entidades bancarias:</strong> Para gestionar pagos</li>
                    <li><strong>Administración pública:</strong> Por obligación legal</li>
                    <li><strong>Proveedores de servicios:</strong> Hosting, email marketing (con contratos de confidencialidad)</li>
                </ul>
                <div class="bg-yellow-50 p-4 rounded mt-4">
                    <p class="text-yellow-800">
                        <i class="fas fa-info-circle mr-2"></i>
                        No vendemos, alquilamos ni compartimos sus datos personales con terceros para fines comerciales.
                    </p>
                </div>
            </section>

     

            <!-- 8. Seguridad -->
            <section class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-2xl font-bold mb-4">7. MEDIDAS DE SEGURIDAD</h2>
                <p class="text-gray-700 mb-4">
                    Implementamos medidas técnicas y organizativas para proteger sus datos:
                </p>
                <ul class="list-disc list-inside text-gray-700 space-y-2">
                    <li>Encriptación SSL en todas las comunicaciones</li>
                    <li>Servidores seguros con copias de seguridad</li>
                    <li>Acceso restringido a datos personales</li>
                    <li>Contratos de confidencialidad con empleados</li>
                    <li>Auditorías de seguridad periódicas</li>
                    <li>Cumplimiento con RGPD y LOPD</li>
                </ul>
            </section>

            <!-- 9. Cookies -->
            <section class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-2xl font-bold mb-4">8. COOKIES</h2>
                <p class="text-gray-700 mb-4">
                    Utilizamos cookies para mejorar su experiencia:
                </p>
                <ul class="list-disc list-inside text-gray-700 space-y-2">
                    <li><strong>Cookies técnicas:</strong> Necesarias para el funcionamiento</li>
                    <li><strong>Cookies de análisis:</strong> Para mejorar nuestros servicios</li>
                    <li><strong>Cookies de personalización:</strong> Para recordar sus preferencias</li>
                </ul>
                <p class="text-gray-700 mt-4">
                    Puede configurar su navegador para rechazar cookies, aunque esto podría afectar 
                    a algunas funcionalidades.
                </p>
            </section>

            <!-- 10. Menores -->
            <section class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-2xl font-bold mb-4">9. MENORES DE EDAD</h2>
                <p class="text-gray-700">
                    Nuestros servicios no están dirigidos a menores de 18 años. No recopilamos 
                    conscientemente datos de menores sin autorización de padres o tutores.
                </p>
            </section>

            <!-- Contacto -->
            <section class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">CONTACTO</h2>
                <p class="text-gray-700 mb-4">
                    Para cualquier consulta sobre esta política de privacidad:
                </p>
                <div class="space-y-2">
                    <p><i class="fas fa-envelope mr-2"></i>infotintaexpres@gmail.com</p>
                    <p><i class="fas fa-phone mr-2"></i>+ 34932520570 / +34 635589530</p>
                    <p><i class="fas fa-map-marker-alt mr-2"></i>C/ de les tres creus ,142, 08202,sabadell</p>
                </div>
            </section>

        </div>

        <!-- Footer -->
        <div class="mt-12 pt-8 border-t text-center text-gray-600 text-sm">
            <p>Última actualización: <?= date('d/m/Y') ?></p>
            <p class="mt-2">© <?= date('Y') ?> TINTA EXPRES LZ . - Todos los derechos reservados</p>
            <p class="mt-4">
                <a href="condiciones-generales.php" class="text-blue-600 hover:underline mr-4">
                    Condiciones Generales
                </a>
                <a href="cookies.php" class="text-blue-600 hover:underline">
                    Política de Cookies
                </a>
            </p>
        </div>
    </div>

</body>
</html>