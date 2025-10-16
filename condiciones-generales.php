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
    <title>Condiciones Generales - Tinta Expres</title>
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
        <h1 class="text-3xl font-bold mb-8 text-center">Condiciones Generales de Venta</h1>
        
        <!-- Índice -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h2 class="text-xl font-bold mb-4">Índice</h2>
            <ol class="space-y-2">
                <li><a href="#objeto" class="text-blue-600 hover:underline">1. Objeto</a></li>
                <li><a href="#identificacion" class="text-blue-600 hover:underline">2. Identificación</a></li>
                <li><a href="#servicios" class="text-blue-600 hover:underline">3. Servicios</a></li>
                <li><a href="#proceso" class="text-blue-600 hover:underline">4. Proceso de Compra</a></li>
                <li><a href="#precios" class="text-blue-600 hover:underline">5. Precios y Pagos</a></li>
                <li><a href="#entrega" class="text-blue-600 hover:underline">6. Entrega</a></li>
                <li><a href="#devoluciones" class="text-blue-600 hover:underline">7. Devoluciones</a></li>
                <li><a href="#responsabilidad" class="text-blue-600 hover:underline">8. Responsabilidad</a></li>
            </ol>
        </div>

        <!-- Secciones -->
        <div class="space-y-8">
            
            <!-- 1. Objeto -->
            <section id="objeto" class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-2xl font-bold mb-4">1. OBJETO</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    Las presentes Condiciones Generales regulan la adquisición de los servicios de impresión 
                    ofertados en el sitio web www.tintaexpreslz.com, del que es titular TINTA EXPRES LZ .
                </p>
                <p class="text-gray-700 leading-relaxed">
                    La adquisición de cualquiera de los servicios conlleva la aceptación plena y sin reservas 
                    de todas estas Condiciones Generales. Estas condiciones podrán ser modificadas sin notificación 
                    previa, por lo que es recomendable leer atentamente su contenido antes de proceder a la 
                    adquisición de cualquier servicio.
                </p>
            </section>

            <!-- 2. Identificación -->
            <section id="identificacion" class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-2xl font-bold mb-4">2. IDENTIFICACIÓN</h2>
                <div class="space-y-2">
                    <p><strong>Denominación social:</strong> TINTA EXPRES LZ .</p>
                    <p><strong>Nombre :</strong> BOUALI SAMIHA</p>
                    <p><strong>CIF:</strong> Y1082366T</p>
                    <p><strong>Domicilio social:</strong> C/ de les tres creus ,142, 08202,sabadell</p>
                    <p><strong>Email:</strong> infotintaexpreslz@gmail.com</p>
                    <p><strong>Teléfono/WhatsApp:</strong> + 34932520570 / +34 635589530</p>
                </div>
            </section>

            <!-- 3. Servicios -->
            <section id="servicios" class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-2xl font-bold mb-4">3. SERVICIOS</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    Los servicios ofertados por TINTA EXPRES LZ consisten en:
                </p>
                <ul class="list-disc list-inside space-y-2 text-gray-700">
                    <li>Impresión de documentos y archivos digitales</li>
                    <li>Fotocopias en blanco y negro y color</li>
                </ul>
            </section>

            <!-- 4. Proceso de Compra -->
            <section id="proceso" class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-2xl font-bold mb-4">4. PROCESO DE COMPRA</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    Para realizar un pedido:
                </p>
                <ol class="list-decimal list-inside space-y-2 text-gray-700">
                    <li>Regístrese o acceda a su cuenta</li>
                    <li>Suba sus archivos y configure las opciones de impresión</li>
                    <li>Añada los productos al carrito</li>
                    <li>Seleccione método de entrega</li>
                    <li>Realice el pago</li>
                </ol>
                <p class="text-gray-700 leading-relaxed mt-4">
                    Los pedidos pueden realizarse entre 24 y 48 horas duas laborales
                </p>
            </section>

            <!-- 5. Precios y Pagos -->
            <section id="precios" class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-2xl font-bold mb-4">5. PRECIOS Y PAGOS</h2>
                <div class="space-y-4">
                    <div>
                        <h3 class="font-bold mb-2">Precios:</h3>
                        <ul class="list-disc list-inside space-y-1 text-gray-700">
                            <li>Todos los precios incluyen IVA (21%)</li>
                          
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-bold mb-2">Formas de pago:</h3>
                        <ul class="list-disc list-inside space-y-1 text-gray-700">
                            <li>Tarjeta de crédito/débito (pago seguro SSL)</li>
                            <li>Bizum (+0,20€ de gestión)</li>
                            <li>PayPal</li>
                            <li>Transferencia bancaria</li>
                            <li>Contra reembolso (+2,50€)</li>
                            <li>Efectivo en tienda</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- 6. Entrega -->
            <section id="entrega" class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-2xl font-bold mb-4">6. ENTREGA</h2>
                <div class="space-y-4">
                    <div>
                        <h3 class="font-bold mb-2">En nuestras tiendas de tinta express LZ</h3>
                       
                    </div>
                   
            </section>

            <!-- 7. Devoluciones -->
            <section id="devoluciones" class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-2xl font-bold mb-4">7. POLÍTICA DE DEVOLUCIONES</h2>
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                    <p class="text-yellow-800">
                        <strong>Importante:</strong> Al tratarse de productos personalizados bajo las especificaciones 
                        del cliente, no se acepta el derecho de desistimiento según el art. 103.c del RDL 1/2007.
                    </p>
                </div>
                <div class="space-y-4">
                    <div>
                        <h3 class="font-bold mb-2">Anulación de pedidos:</h3>
                        <p class="text-gray-700">
                            Puede anular su pedido hasta 1 hora después de realizarlo, siempre que no haya 
                            comenzado la producción. Contacte por WhatsApp al +34 612 345 678.
                        </p>
                    </div>
                    <div>
                        <h3 class="font-bold mb-2">Incidencias:</h3>
                        <p class="text-gray-700">
                            Dispone de 15 días naturales desde la recepción para reportar cualquier incidencia. 
                            Conservamos los archivos durante 20 días para poder atender reclamaciones.
                        </p>
                    </div>
                </div>
            </section>

            <!-- 8. Responsabilidad -->
            <section id="responsabilidad" class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-2xl font-bold mb-4">8. RESPONSABILIDAD</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    El cliente se declara responsable de los contenidos de los documentos que encarga imprimir, 
                    declarando tener derecho para su reproducción, copia y distribución, salvaguardando los 
                    derechos de propiedad intelectual e industrial de terceros.
                </p>
                <p class="text-gray-700 leading-relaxed">
                    TINTA EXPRES se compromete a guardar confidencialidad y no divulgar los archivos/documentos 
                    del cliente, cumpliendo con la normativa vigente de protección de datos.
                </p>
                <p class="text-gray-700 leading-relaxed mt-4">
                    Nos reservamos el derecho a rechazar trabajos que puedan atentar contra derechos fundamentales, 
                    contengan material ilegal, pornográfico, violento o discriminatorio.
                </p>
            </section>

            <!-- Atención al cliente -->
            <section class="bg-blue-50 rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">ATENCIÓN AL CLIENTE</h2>
                <div class="space-y-2">
                    <p><i class="fas fa-phone mr-2"></i>WhatsApp: +34 635589530</p>
                    <p><i class="fas fa-envelope mr-2"></i>Email: infotintaexpreslz@gmail.com</p>
                    <p><i class="fas fa-clock mr-2"></i>Horario: L-V 09:00-19:00</p>
                </div>
            </section>

        </div>

        <!-- Footer -->
        <div class="mt-12 pt-8 border-t text-center text-gray-600 text-sm">
            <p>Última actualización: <?= date('d/m/Y') ?></p>
            <p class="mt-2">© <?= date('Y') ?> TINTA EXPRES LZ . - Todos los derechos reservados</p>
        </div>
    </div>

</body>
</html>