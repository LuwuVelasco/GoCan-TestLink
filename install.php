<?php
/**
 * Script de instalación automática de TestLink
 * Accede a: https://testlink-gocan.onrender.com/install.php
 */

// Verificar si ya está instalado
$dbConfigFile = 'config_db.inc.php';
if (!file_exists($dbConfigFile)) {
    die("Error: config_db.inc.php no existe");
}

require_once($dbConfigFile);

// Intentar conexión
try {
    $dsn = 'pgsql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME;
    $pdo = new PDO($dsn, DB_USER, DB_PASSWD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

echo "<h1>TestLink Installation</h1>";

// Obtener SQL de instalación
$sqlDir = 'install/sql';
$sqlFiles = glob($sqlDir . '/*.sql');

if (empty($sqlFiles)) {
    die("No se encontraron archivos SQL de instalación");
}

// Buscar el archivo de creación de tablas para PostgreSQL
$pgSqlFile = null;
foreach ($sqlFiles as $file) {
    if (strpos($file, 'postgres') !== false || strpos($file, 'pgsql') !== false) {
        $pgSqlFile = $file;
        break;
    }
}

// Si no hay archivo específico de PostgreSQL, usar el genérico
if (!$pgSqlFile) {
    foreach ($sqlFiles as $file) {
        if (strpos($file, 'create_tables') !== false) {
            $pgSqlFile = $file;
            break;
        }
    }
}

if (!$pgSqlFile) {
    echo "<p>Archivos SQL encontrados:</p>";
    echo "<ul>";
    foreach ($sqlFiles as $file) {
        echo "<li>" . basename($file) . "</li>";
    }
    echo "</ul>";
    echo "<p><strong>Por favor, selecciona manualmente cuál archivo usar.</strong></p>";
    die();
}

echo "<p>Usando archivo de instalación: " . basename($pgSqlFile) . "</p>";

// Leer y ejecutar SQL
$sql = file_get_contents($pgSqlFile);

if (empty($sql)) {
    die("Error: archivo SQL vacío");
}

echo "<p>Leyendo esquema de BD...</p>";

// Dividir y ejecutar sentencias SQL
$statements = preg_split('/;[\r\n]+/', $sql);

$count = 0;
$errors = 0;

foreach ($statements as $statement) {
    $statement = trim($statement);
    
    if (empty($statement)) {
        continue;
    }
    
    try {
        $pdo->exec($statement);
        $count++;
    } catch (PDOException $e) {
        // Algunos errores pueden ser esperados (ej: tabla ya existe)
        echo "<p style='color: orange;'>Advertencia: " . htmlspecialchars($e->getMessage()) . "</p>";
        $errors++;
    }
}

echo "<p><strong>✓ Instalación completada</strong></p>";
echo "<p>Sentencias ejecutadas: $count</p>";
if ($errors > 0) {
    echo "<p>Advertencias: $errors (esto puede ser normal)</p>";
}

// Crear usuario admin
echo "<h2>Crear usuario administrador</h2>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $email = $_POST['email'] ?? '';
    
    if (!empty($username) && !empty($password) && !empty($email)) {
        // Hash de contraseña
        $passwordHash = md5($password);
        
        try {
            $stmt = $pdo->prepare("INSERT INTO tl_users (login, password, email, is_active) VALUES (?, ?, ?, 1)");
            $stmt->execute([$username, $passwordHash, $email]);
            
            echo "<p style='color: green;'><strong>✓ Usuario administrador creado exitosamente</strong></p>";
            echo "<p>Usuario: $username</p>";
            echo "<p>Puedes acceder a <a href='/login.php'>TestLink Login</a></p>";
        } catch (PDOException $e) {
            echo "<p style='color: red;'>Error al crear usuario: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    } else {
        echo "<p style='color: red;'>Error: Todos los campos son requeridos</p>";
    }
}

?>

<form method="POST" style="border: 1px solid #ccc; padding: 20px; margin-top: 20px; max-width: 400px;">
    <div>
        <label for="username">Usuario (username):</label><br>
        <input type="text" id="username" name="username" required value="admin">
    </div>
    
    <div style="margin-top: 10px;">
        <label for="password">Contraseña:</label><br>
        <input type="password" id="password" name="password" required value="admin123">
    </div>
    
    <div style="margin-top: 10px;">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required value="admin@testlink.local">
    </div>
    
    <div style="margin-top: 15px;">
        <button type="submit" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; cursor: pointer;">
            Crear Usuario Admin
        </button>
    </div>
</form>

<hr>
<p><small>Nota: Una vez creado el usuario, puedes acceder a <a href="/login.php">login.php</a></small></p>

<?php
$pdo = null;
?>
