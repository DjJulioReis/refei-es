<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$user]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($pass, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        header('Location: index.php');
        exit;
    } else {
        $error = "Usuário ou senha incorretos.";
    }
}

render_header("Login Administrativo");
?>

<div class="min-h-[70vh] flex items-center justify-center px-4">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-2xl p-10 border border-gray-100">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-primary">Acesso Restrito</h2>
            <p class="text-gray-500 mt-2">Painel de gerenciamento de cardápio</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-8 text-sm">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Usuário</label>
                <input type="text" name="username" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Senha</label>
                <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary outline-none transition">
            </div>
            <button type="submit" class="w-full bg-primary text-white py-4 rounded-xl font-bold text-lg hover:bg-primary-dark transition shadow-lg">
                Entrar no Painel
            </button>
        </form>

        <p class="mt-8 text-center text-xs text-gray-400">
            Em caso de perda de senha, consulte o administrador do banco de dados.
        </p>
    </div>
</div>

<?php render_footer(); ?>
