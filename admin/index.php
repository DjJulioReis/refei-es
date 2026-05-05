<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit; }
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Handle delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Get media files to delete them from folder
    $stmt = $pdo->prepare("SELECT file_path FROM media WHERE product_id = ?");
    $stmt->execute([$id]);
    $files = $stmt->fetchAll();
    foreach ($files as $file) {
        if (file_exists('../' . $file['file_path'])) {
            unlink('../' . $file['file_path']);
        }
    }

    $pdo->prepare("DELETE FROM products WHERE id = ?")->execute([$id]);
    header('Location: index.php?msg=Produto excluído');
    exit;
}

render_header("Painel Admin - Santa Helena");
?>

<div class="max-w-7xl mx-auto py-12 px-4">
    <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-6">
        <div>
            <h1 class="text-4xl font-bold text-primary">Gerenciar Cardápio</h1>
            <p class="text-gray-500 mt-1">Adicione ou remova itens do site principal</p>
        </div>
        <a href="add.php" class="bg-primary text-white px-8 py-3 rounded-xl flex items-center font-bold hover:bg-primary-dark transition shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Novo Produto
        </a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded-r-lg">
            <?php echo htmlspecialchars($_GET['msg']); ?>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-8 py-5 text-sm font-bold text-gray-700 uppercase">Produto</th>
                        <th class="px-8 py-5 text-sm font-bold text-gray-700 uppercase">Descrição</th>
                        <th class="px-8 py-5 text-sm font-bold text-gray-700 uppercase">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php
                    $stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
                    while ($row = $stmt->fetch()):
                    ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-8 py-6 font-bold text-primary"><?php echo $row['title']; ?></td>
                            <td class="px-8 py-6 text-gray-500 max-w-md">
                                <div class="truncate"><?php echo $row['description']; ?></div>
                            </td>
                            <td class="px-8 py-6 flex space-x-4">
                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="text-blue-600 hover:text-blue-800 font-bold">Editar</a>
                                <a href="?delete=<?php echo $row['id']; ?>" class="text-red-600 hover:text-red-800 font-bold" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    <?php if ($stmt->rowCount() == 0): ?>
                        <tr>
                            <td colspan="3" class="px-8 py-20 text-center text-gray-400 italic">Nenhum produto cadastrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php render_footer(); ?>
