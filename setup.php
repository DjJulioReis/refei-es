<?php
session_start();

$config_file = 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs
    $host = preg_replace('/[^a-zA-Z0-9.-]/', '', $_POST['host']);
    $user = $_POST['user']; // Will be escaped in string
    $pass = $_POST['pass']; // Will be escaped in string
    $dbname = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['dbname']);

    try {
        $pdo = new PDO("mysql:host=$host", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Create database if not exists
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $pdo->exec("USE `$dbname`");

        // Create Tables
        $sql = "
        CREATE TABLE IF NOT EXISTS `products` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `title` VARCHAR(255) NOT NULL,
            `description` TEXT NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS `media` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `product_id` INT NOT NULL,
            `file_path` VARCHAR(255) NOT NULL,
            `file_type` ENUM('image', 'video') NOT NULL,
            FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
        );

        CREATE TABLE IF NOT EXISTS `admins` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `username` VARCHAR(50) NOT NULL UNIQUE,
            `password` VARCHAR(255) NOT NULL
        );
        ";

        $pdo->exec($sql);

        // Create default admin if not exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM admins");
        $stmt->execute();
        if ($stmt->fetchColumn() == 0) {
            $hashed_pass = password_hash('admin123', PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO admins (username, password) VALUES ('admin', ?)");
            $stmt->execute([$hashed_pass]);
        }

        // Save config with escaped values
        $config_content = "<?php\n"
            . "\$db_host = '" . addslashes($host) . "';\n"
            . "\$db_user = '" . addslashes($user) . "';\n"
            . "\$db_pass = '" . addslashes($pass) . "';\n"
            . "\$db_name = '" . addslashes($dbname) . "';\n\n"
            . "try {\n"
            . "    \$pdo = new PDO(\"mysql:host=\$db_host;dbname=\$db_name;charset=utf8mb4\", \$db_user, \$db_pass);\n"
            . "    \$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);\n"
            . "} catch (PDOException \$e) {\n"
            . "    die(\"Erro de conexão: \" . \$e->getMessage());\n"
            . "}\n";

        file_put_contents($config_file, $config_content);

        // Create uploads directory
        if (!file_exists('uploads')) {
            mkdir('uploads', 0755, true);
        }

        $success = "Configuração concluída com sucesso! Você já pode apagar este arquivo (setup.php) por segurança.";

    } catch (PDOException $e) {
        $error = "Erro: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuração do Banco de Dados - Santa Helena</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">
    <div class="bg-white p-8 rounded-xl shadow-2xl max-w-md w-full border-t-8 border-blue-600">
        <h1 class="text-2xl font-bold text-blue-800 mb-6 text-center">Configuração Inicial</h1>

        <?php if (isset($success)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <?php echo $success; ?>
                <br><br>
                <a href="index.php" class="font-bold underline text-blue-600">Ir para o Site</a>
            </div>
        <?php else: ?>
            <?php if (isset($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 text-sm">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Host do MySQL (Geralmente localhost)</label>
                    <input type="text" name="host" value="localhost" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Usuário do Banco</label>
                    <input type="text" name="user" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Senha do Banco</label>
                    <input type="password" name="pass" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nome do Banco de Dados</label>
                    <input type="text" name="dbname" value="santa_helena_db" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-md hover:bg-blue-700 transition">
                    Instalar e Configurar
                </button>
            </form>
            <p class="mt-4 text-xs text-gray-500 text-center">
                * Certifique-se de que o banco de dados já existe ou que o usuário tem permissão para criá-lo.
            </p>
        <?php endif; ?>
    </div>
</body>
</html>
