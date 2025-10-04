<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Clientes - ColibriHub</title>
    <link href="./dist/output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* [Todos los estilos CSS anteriores se mantienen igual] */
        @keyframes float { 0% { transform: translateY(0px); } 50% { transform: translateY(-10px); } 100% { transform: translateY(0px); } }
        @keyframes pulse { 0% { transform: scale(1); } 50% { transform: scale(1.05); } 100% { transform: scale(1); } }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes slideIn { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-float { animation: float 3s ease-in-out infinite; }
        .animate-pulse { animation: pulse 2s ease-in-out infinite; }
        .animate-fadeIn { animation: fadeIn 0.8s ease-out forwards; }
        .animate-slideIn { animation: slideIn 0.5s ease-out forwards; }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
        .social-icon { transition: all 0.3s ease; }
        .social-icon:hover { transform: scale(1.2); }
        .alert-container { position: fixed; top: 20px; right: 20px; z-index: 1000; max-width: 400px; }
        .alert { padding: 16px; margin-bottom: 12px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); display: flex; align-items: center; animation: slideIn 0.5s ease-out; }
        .alert-error { background-color: #FEF2F2; border-left: 4px solid #DC2626; color: #DC2626; }
        .alert-success { background-color: #F0FDF4; border-left: 4px solid #16A34A; color: #16A34A; }
        .alert-warning { background-color: #FFFBEB; border-left: 4px solid #D97706; color: #D97706; }
        .alert-icon { margin-right: 12px; font-size: 20px; }
        .alert-close { margin-left: auto; cursor: pointer; background: none; border: none; font-size: 18px; opacity: 0.7; }
        .alert-close:hover { opacity: 1; }
        .telefono-input-container { position: relative; }
        .codigo-pais { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #6b7280; font-weight: 500; pointer-events: none; }
        .telefono-input { padding-left: 50px; }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <!-- Contenedor de alertas -->
    <div id="alertContainer" class="alert-container"></div>

    <!-- Header con desarrolladores -->
    <header class="gradient-bg text-white py-8 px-4">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold mb-2 animate-pulse">Sistema de Registro de Clientes</h1>
            <p class="text-xl mb-8">ColibriHub - Soluciones Tecnológicas</p>
        </div>
    </header>

    <!-- Formulario -->
    <main class="container mx-auto px-4 py-12 -mt-16">
        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-2xl overflow-hidden card-hover animate-fadeIn" style="animation-delay: 0.6s;">
            <!-- Encabezado del formulario -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-6 text-white">
                <h2 class="text-2xl font-bold">Formulario de Registro</h2>
                <p class="opacity-90">Complete la información del nuevo cliente</p>
            </div>
            
            <div class="p-8">
                <?php
                // Procesar el formulario cuando se envía
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $url = 'http://62.171.169.111:8090/api/clientes';
                    
                    // Recoger y sanitizar datos del formulario
                    $data = [
                        'nombre' => trim($_POST['nombre'] ?? ''),
                        'apellido' => trim($_POST['apellido'] ?? ''),
                        'email' => trim($_POST['email'] ?? ''),
                        'telefono' => "+503 ".trim($_POST['telefono'] ?? ''),
                        'direccion' => trim($_POST['direccion'] ?? ''),
                        'dui' => trim($_POST['dui'] ?? ''),
                        'nit' => trim($_POST['nit'] ?? ''),
                        'fechaRegistro' => $_POST['fechaRegistro'] ?? date('Y-m-d'),
                        'activo' => isset($_POST['activo']),
                        'genero' => $_POST['genero'] ?? '',
                        'estadoCivil' => $_POST['estadoCivil'] ?? '',
                        'ocupacion' => trim($_POST['ocupacion'] ?? ''),
                        'observaciones' => trim($_POST['observaciones'] ?? '')
                    ];
                    
                    // Validaciones adicionales del servidor
                    $errores = [];
                    if (empty($data['nombre'])) $errores[] = 'El nombre es obligatorio';
                    if (empty($data['apellido'])) $errores[] = 'El apellido es obligatorio';
                    if (empty($data['email'])) $errores[] = 'El email es obligatorio';
                    
                    if (!empty($errores)) {
                        echo '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">';
                        echo '<strong>Errores de validación:</strong><ul class="list-disc list-inside mt-2">';
                        foreach ($errores as $error) {
                            echo '<li>' . htmlspecialchars($error) . '</li>';
                        }
                        echo '</ul></div>';
                    } else {
                        // Configurar cURL
                        $ch = curl_init($url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                            'Content-Type: application/json',
                            'Accept: application/json'
                        ]);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                        
                        // Ejecutar la solicitud
                        $response = curl_exec($ch);
                        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                        $error = curl_error($ch);
                        curl_close($ch);
                        
                        // Mostrar resultado
                        if ($httpCode >= 200 && $httpCode < 300) {
                            echo '<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded animate-fadeIn">';
                            echo '<div class="flex items-center"><i class="fas fa-check-circle mr-2"></i> <strong>¡Éxito!</strong> Cliente registrado correctamente.</div>';
                            echo '</div>';
                            
                            // Opcional: limpiar el formulario después de éxito
                            echo '<script>setTimeout(function() { limpiarFormulario(); }, 1000);</script>';
                        } else {
                            // Decodificar la respuesta JSON de la API
                            $responseData = json_decode($response, true);
                            $errorMessage = 'Error desconocido al registrar el cliente.';
                            
                            // Detectar mensajes específicos de la API Spring Boot
                            if (isset($responseData['message'])) {
                                $errorMessage = $responseData['message'];
                                
                                // Mensajes específicos para DUI y NIT duplicados
                                if (strpos($responseData['message'], 'El DUI ya está registrado') !== false) {
                                    $errorMessage = 'El DUI ya está registrado en el sistema. Por favor, verifique el número.';
                                } elseif (strpos($responseData['message'], 'El NIT ya está registrado') !== false) {
                                    $errorMessage = 'El NIT ya está registrado en el sistema. Por favor, verifique el número.';
                                } elseif (strpos($responseData['message'], 'El email ya está registrado') !== false) {
                                    $errorMessage = 'El email ya está registrado en el sistema. Por favor, use otro email.';
                                }
                            } elseif ($error) {
                                $errorMessage = 'Error de conexión: ' . htmlspecialchars($error);
                            }
                            
                            echo '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded animate-fadeIn">';
                            echo '<div class="flex items-center"><i class="fas fa-exclamation-circle mr-2"></i> <strong>Error:</strong> ' . htmlspecialchars($errorMessage) . '</div>';
                            
                            // Mostrar detalles adicionales en modo desarrollo
                            if (isset($responseData) && $responseData !== null) {
                                echo '<details class="mt-2 text-sm">';
                                echo '<summary class="cursor-pointer">Ver detalles técnicos</summary>';
                                echo '<pre class="bg-red-200 p-2 rounded mt-2 overflow-auto max-h-40">';
                                echo 'Código HTTP: ' . $httpCode . "\n";
                                echo 'Respuesta: ' . htmlspecialchars($response);
                                echo '</pre>';
                                echo '</details>';
                            }
                            echo '</div>';
                        }
                    }
                }
                ?>
                
                <form method="POST" id="clienteForm" class="space-y-6">
                    <!-- [Todos los campos del formulario se mantienen igual] -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <label class="block text-blue-800 mb-2 font-medium"><i class="fas fa-user text-blue-600 mr-2"></i>Nombre *</label>
                            <input type="text" name="nombre" required 
                                   class="w-full px-4 py-2 border border-blue-200 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   value="<?= htmlspecialchars($_POST['nombre'] ?? ''); ?>">
                        </div>
                        
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <label class="block text-blue-800 mb-2 font-medium"><i class="fas fa-user text-blue-600 mr-2"></i>Apellido *</label>
                            <input type="text" name="apellido" required 
                                   class="w-full px-4 py-2 border border-blue-200 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   value="<?= htmlspecialchars($_POST['apellido'] ?? ''); ?>">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-green-50 p-4 rounded-lg">
                            <label class="block text-green-800 mb-2 font-medium"><i class="fas fa-envelope text-green-600 mr-2"></i>Email *</label>
                            <input type="email" name="email" required 
                                   class="w-full px-4 py-2 border border-green-200 rounded focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   value="<?= htmlspecialchars($_POST['email'] ?? ''); ?>">
                        </div>
                        
                        <div class="bg-green-50 p-4 rounded-lg">
                            <label class="block text-green-800 mb-2 font-medium"><i class="fas fa-phone text-green-600 mr-2"></i>Teléfono *</label>
                            <div class="telefono-input-container">
                                <span class="codigo-pais">+503</span>
                                <input type="text" name="telefono" id="telefono" required 
                                       class="w-full ms-2 px-4 py-2 border border-green-200 rounded focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent telefono-input"
                                       value="<?= htmlspecialchars($_POST['telefono'] ?? ''); ?>"
                                       placeholder="12345678" maxlength="8"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,8)">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Ingrese los 8 dígitos después del +503</p>
                        </div>
                    </div>
                    
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <label class="block text-purple-800 mb-2 font-medium"><i class="fas fa-map-marker-alt text-purple-600 mr-2"></i>Dirección</label>
                        <input type="text" name="direccion" 
                               class="w-full px-4 py-2 border border-purple-200 rounded focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               value="<?= htmlspecialchars($_POST['direccion'] ?? ''); ?>"
                               placeholder="Ej: Colonia Escalón, San Salvador">
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-red-50 p-4 rounded-lg">
                            <label class="block text-red-800 mb-2"><i class="fas fa-id-card text-red-600 mr-2"></i>DUI</label>
                            <input type="text" name="dui" id="dui" placeholder="00000000-0"
                                   class="w-full px-4 py-2 border border-red-200 rounded focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                   value="<?= htmlspecialchars($_POST['dui'] ?? ''); ?>"
                                   maxlength="10">
                        </div>
                        
                        <div class="bg-red-50 p-4 rounded-lg">
                            <label class="block text-red-800 mb-2"><i class="fas fa-id-card text-red-600 mr-2"></i>NIT</label>
                            <input type="text" name="nit" id="nit" placeholder="0000-000000-000-0"
                                   class="w-full px-4 py-2 border border-red-200 rounded focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                   value="<?= htmlspecialchars($_POST['nit'] ?? ''); ?>"
                                   maxlength="17">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <label class="block text-yellow-800 mb-2"><i class="fas fa-calendar-day text-yellow-600 mr-2"></i>Fecha de Registro</label>
                            <input type="date" name="fechaRegistro" 
                                   class="w-full px-4 py-2 border border-yellow-200 rounded focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                                   value="<?= $_POST['fechaRegistro'] ?? date('Y-m-d'); ?>">
                        </div>
                        
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <label class="block text-yellow-800 mb-2"><i class="fas fa-venus-mars text-yellow-600 mr-2"></i>Género</label>
                            <select name="genero" id="genero" class="w-full px-4 py-2 border border-yellow-200 rounded focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                                <option value="">Seleccionar</option>
                                <option value="Masculino" <?= (($_POST['genero'] ?? '') == 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
                                <option value="Femenino" <?= (($_POST['genero'] ?? '') == 'Femenino') ? 'selected' : ''; ?>>Femenino</option>
                                <option value="Otro" <?= (($_POST['genero'] ?? '') == 'Otro') ? 'selected' : ''; ?>>Otro</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-indigo-50 p-4 rounded-lg">
                            <label class="block text-indigo-800 mb-2"><i class="fas fa-heart text-indigo-600 mr-2"></i>Estado Civil</label>
                            <select name="estadoCivil" id="estadoCivil" class="w-full px-4 py-2 border border-indigo-200 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <option value="">Seleccionar</option>
                                <option value="Soltero" <?= (($_POST['estadoCivil'] ?? '') == 'Soltero') ? 'selected' : ''; ?>>Soltero</option>
                                <option value="Casado" <?= (($_POST['estadoCivil'] ?? '') == 'Casado') ? 'selected' : ''; ?>>Casado</option>
                                <option value="Divorciado" <?= (($_POST['estadoCivil'] ?? '') == 'Divorciado') ? 'selected' : ''; ?>>Divorciado</option>
                                <option value="Viudo" <?= (($_POST['estadoCivil'] ?? '') == 'Viudo') ? 'selected' : ''; ?>>Viudo</option>
                            </select>
                        </div>
                        
                        <div class="bg-indigo-50 p-4 rounded-lg">
                            <label class="block text-indigo-800 mb-2"><i class="fas fa-briefcase text-indigo-600 mr-2"></i>Ocupación</label>
                            <input type="text" name="ocupacion" id="ocupacion"
                                   class="w-full px-4 py-2 border border-indigo-200 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                   value="<?= htmlspecialchars($_POST['ocupacion'] ?? ''); ?>"
                                   placeholder="Ej: Ingeniero de Software">
                        </div>
                    </div>
                    
                    <div class="bg-pink-50 p-4 rounded-lg">
                        <label class="block text-pink-800 mb-2"><i class="fas fa-sticky-note text-pink-600 mr-2"></i>Observaciones</label>
                        <textarea name="observaciones" id="observaciones" rows="3"
                                  class="w-full px-4 py-2 border border-pink-200 rounded focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                                  placeholder="Notas adicionales sobre el cliente"><?= htmlspecialchars($_POST['observaciones'] ?? ''); ?></textarea>
                    </div>
                    
                    <div class="flex items-center bg-gray-50 p-4 rounded-lg">
                        <input type="checkbox" name="activo" id="activo" checked
                               class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="activo" class="ml-2 block text-gray-700 font-medium">Cliente activo</label>
                    </div>
                    
                    <div class="pt-4 flex flex-col md:flex-row gap-4">
                        <button type="submit" 
                                class="w-full md:w-3/4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition transform hover:scale-105 shadow-lg">
                            <i class="fas fa-user-plus mr-2"></i>Registrar Cliente
                        </button>
                        <button type="button" id="btnLimpiar"
                                class="w-full md:w-1/4 bg-gradient-to-r from-gray-500 to-gray-700 hover:from-gray-600 hover:to-gray-800 text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500 transition transform hover:scale-105 shadow-lg">
                            <i class="fas fa-broom mr-2"></i>Limpiar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-gray-800 to-gray-900 text-white py-12 mt-16">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <h3 class="text-2xl font-bold mb-2">ColibriHub</h3>
                    <p class="text-gray-400">Soluciones tecnológicas innovadoras</p>
                </div>
                
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white transition social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition social-icon"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition social-icon"><i class="fab fa-github"></i></a>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-400">© 2025 ColibriHub - Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
        // Función para mostrar alertas bonitas
        function showAlert(message, type = 'error') {
            const alertContainer = document.getElementById('alertContainer');
            
            const alert = document.createElement('div');
            alert.className = `alert alert-${type}`;
            
            let icon = 'exclamation-circle';
            if (type === 'success') icon = 'check-circle';
            if (type === 'warning') icon = 'exclamation-triangle';
            
            alert.innerHTML = `
                <div class="alert-icon">
                    <i class="fas fa-${icon}"></i>
                </div>
                <div class="alert-message">${message}</div>
                <button class="alert-close" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            alertContainer.appendChild(alert);
            
            // Auto-remove after 5 seconds
            setTimeout(() => {
                if (alert.parentElement) {
                    alert.remove();
                }
            }, 5000);
        }
        
        // Función para limpiar el formulario
        function limpiarFormulario() {
            // Limpiar todos los campos de texto
            document.querySelector('input[name="nombre"]').value = '';
            document.querySelector('input[name="apellido"]').value = '';
            document.querySelector('input[name="email"]').value = '';
            document.querySelector('input[name="telefono"]').value = '';
            document.querySelector('input[name="direccion"]').value = '';
            document.querySelector('input[name="dui"]').value = '';
            document.querySelector('input[name="nit"]').value = '';
            document.querySelector('input[name="ocupacion"]').value = '';
            document.querySelector('textarea[name="observaciones"]').value = '';
            
            // Restablecer selects a su valor por defecto
            document.getElementById('genero').selectedIndex = 0;
            document.getElementById('estadoCivil').selectedIndex = 0;
            
            // Restablecer checkbox a checked
            document.getElementById('activo').checked = true;
            
            // Restablecer la fecha al día actual
            const fechaInput = document.querySelector('input[name="fechaRegistro"]');
            const hoy = new Date();
            const fechaFormateada = hoy.toISOString().split('T')[0];
            fechaInput.value = fechaFormateada;
            
            showAlert('Formulario limpiado correctamente', 'success');
        }
        
        // Función para formatear DUI automáticamente (00000000-0)
        function formatDUI(input) {
            // Eliminar todos los caracteres que no sean números
            let value = input.value.replace(/\D/g, '');
            
            // Limitar a 9 caracteres (8 dígitos + 1 dígito verificador)
            if (value.length > 9) {
                value = value.substring(0, 9);
            }
            
            // Agregar el guión después de los primeros 8 dígitos
            if (value.length > 8) {
                value = value.substring(0, 8) + '-' + value.substring(8);
            }
            
            // Actualizar el valor del campo
            input.value = value;
        }
        
        // Función para formatear NIT automáticamente (0000-000000-000-0)
        function formatNIT(input) {
            // Eliminar todos los caracteres que no sean números
            let value = input.value.replace(/\D/g, '');
            
            // Limitar a 14 caracteres (4 + 6 + 3 + 1)
            if (value.length > 14) {
                value = value.substring(0, 14);
            }
            
            // Agregar guiones en las posiciones correctas para El Salvador
            if (value.length > 13) {
                value = value.substring(0, 13) + '-' + value.substring(13);
            }
            if (value.length > 10) {
                value = value.substring(0, 10) + '-' + value.substring(10);
            }
            if (value.length > 4) {
                value = value.substring(0, 4) + '-' + value.substring(4);
            }
            
            // Actualizar el valor del campo
            input.value = value;
        }
        
        // Validación del formulario
        document.getElementById('clienteForm').addEventListener('submit', function(e) {
            const email = this['email'].value;
            const dui = this['dui'].value;
            const nit = this['nit'].value;
            const telefono = this['telefono'].value;
            
            let isValid = true;
            let errorMessage = '';
            
            // Validar formato de email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                errorMessage = 'Por favor, ingrese un email válido.';
                isValid = false;
            }
            
            // Validar formato de DUI (00000000-0)
            else if (dui && !/^\d{8}-\d{1}$/.test(dui)) {
                errorMessage = 'El DUI debe tener el formato 00000000-0';
                isValid = false;
            }
            
            // Validar formato de NIT (0000-000000-000-0)
            else if (nit && !/^\d{4}-\d{6}-\d{3}-\d{1}$/.test(nit)) {
                errorMessage = 'El NIT debe tener el formato 0000-000000-000-0';
                isValid = false;
            }
            
            // Validar teléfono (8 dígitos exactos después del +503)
            else if (!/^\d{8}$/.test(telefono)) {
                errorMessage = 'El teléfono debe tener exactamente 8 dígitos después del +503.';
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
                showAlert(errorMessage, 'error');
            }
        });
        
        // Animación para elementos cuando están en viewport
        document.addEventListener('DOMContentLoaded', function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fadeIn');
                    }
                });
            }, { threshold: 0.1 });
            
            document.querySelectorAll('.bg-blue-50, .bg-green-50, .bg-purple-50, .bg-red-50, .bg-yellow-50, .bg-indigo-50, .bg-pink-50').forEach(el => {
                observer.observe(el);
            });
            
            // Agregar event listeners para el formateo automático de DUI y NIT
            const duiInput = document.getElementById('dui');
            const nitInput = document.getElementById('nit');
            
            if (duiInput) {
                duiInput.addEventListener('input', function() {
                    formatDUI(this);
                });
                
                // Aplicar formato si ya hay un valor al cargar la página
                if (duiInput.value) {
                    formatDUI(duiInput);
                }
            }
            
            if (nitInput) {
                nitInput.addEventListener('input', function() {
                    formatNIT(this);
                });
                
                // Aplicar formato si ya hay un valor al cargar la página
                if (nitInput.value) {
                    formatNIT(nitInput);
                }
            }
            
            // Agregar event listener al botón de limpiar
            document.getElementById('btnLimpiar').addEventListener('click', limpiarFormulario);
        });
    </script>
</body>
</html>"<!-- Test $(date) -->" 
