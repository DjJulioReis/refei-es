<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit; }
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Add user logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
    $new_user = $_POST['username'];
    $new_pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
        $stmt->execute([$new_user, $new_pass]);
        $msg = "Usuário adicionado com sucesso!";
    } catch (PDOException $e) {
        $error = "Erro ao adicionar usuário: " . $e->getMessage();
    }
}

// Delete user logic
if (isset($_GET['delete'])) {
    $uid = $_GET['delete'];
    // Prevent self-deletion if it's the only admin (optional but safe)
    $stmt = $pdo->query("SELECT COUNT(*) FROM admins");
    if ($stmt->fetchColumn() > 1) {
        $pdo->prepare("DELETE FROM admins WHERE id = ?")->execute([$uid]);
        header('Location: users.php?msg=Usuário removido');
        exit;
    } else {
        $error = "Não é possível remover o único administrador.";
    }
}

render_header("Gerenciar Usuários - Admin");
?>

<div class="max-w-4xl mx-auto py-12 px-4">
    <div class="mb-10 flex justify-between items-end">
        <div>
            <a href="index.php" class="text-primary font-bold flex items-center hover:-translate-x-1 transition-transform">
                ← Voltar ao painel
            </a>
            <h1 class="text-4xl font-bold text-primary mt-4">Usuários do Sistema</h1>
        </div>
    </div>

    <?php if (isset($msg) || isset($_GET['msg'])): ?>
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded-r-lg">
            <?php echo htmlspecialchars($msg ?? $_GET['msg']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-8 rounded-r-lg">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <!-- List Users -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="p-8 border-b border-gray-100 bg-gray-50">
                <h3 class="text-xl font-bold text-primary">Usuários Atuais</h3>
            </div>
            <ul class="divide-y divide-gray-100">
                <?php
                $stmt = $pdo->query("SELECT id, username FROM admins");
                while ($u = $stmt->fetch()):
                ?>
                    <li class="p-6 flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-bold text-gray-700"><?php echo htmlspecialchars($u['username']); ?></span>
                        <?php if ($u['id'] != $_SESSION['admin_id']): ?>
                            <a href="?delete=<?php echo $u['id']; ?>" class="text-red-500 hover:text-red-700 text-sm font-bold" onclick="return confirm('Excluir este acesso?')">Remover</a>
                        <?php else: ?>
                            <span class="text-xs text-gray-400 italic">Você</span>
                        <?php endif; ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>

        <!-- Add User Form -->
        <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100 h-fit">
            <h3 class="text-xl font-bold text-primary mb-6">Novo Administrador</h3>
            <form method="POST" class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Usuário</label>
                    <input type="text" name="username" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary outline-none transition">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Senha</label>
                    <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary outline-none transition">
                </div>
                <button type="submit" name="add_user" class="w-full bg-primary text-white py-4 rounded-xl font-bold hover:bg-primary-dark transition shadow-lg">
                    Adicionar Usuário
                </button>
            </form>
        </div>
    </div>
</div>

<?php render_footer(); ?>
