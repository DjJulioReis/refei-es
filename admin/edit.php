<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit; }
require_once '../includes/db.php';
require_once '../includes/functions.php';

$id = $_GET['id'] ?? null;
if (!$id) { header('Location: index.php'); exit; }

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) { header('Location: index.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $desc = $_POST['description'];

    // Update basic info
    $stmt = $pdo->prepare("UPDATE products SET title = ?, description = ? WHERE id = ?");
    $stmt->execute([$title, $desc, $id]);

    // Handle new media uploads
    if (!empty($_FILES['media']['name'][0])) {
        $allowed_images = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $allowed_videos = ['mp4', 'webm', 'mov'];
        $allowed_extensions = array_merge($allowed_images, $allowed_videos);

        foreach ($_FILES['media']['tmp_name'] as $key => $tmp_name) {
            $name = $_FILES['media']['name'][$key];
            if (empty($name)) continue;

            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

            if (in_array($ext, $allowed_extensions)) {
                $new_name = uniqid() . '.' . $ext;
                $destination = 'uploads/' . $new_name;

                if (!file_exists('../uploads')) {
                    mkdir('../uploads', 0755, true);
                }

                if (move_uploaded_file($tmp_name, '../' . $destination)) {
                    $type = in_array($ext, $allowed_videos) ? 'video' : 'image';
                    $stmt = $pdo->prepare("INSERT INTO media (product_id, file_path, file_type) VALUES (?, ?, ?)");
                    $stmt->execute([$id, $destination, $type]);
                }
            }
        }
    }

    header('Location: index.php?msg=Produto atualizado');
    exit;
}

// Delete media
if (isset($_GET['delete_media'])) {
    $mid = $_GET['delete_media'];
    $stmt = $pdo->prepare("SELECT file_path FROM media WHERE id = ? AND product_id = ?");
    $stmt->execute([$mid, $id]);
    $file = $stmt->fetch();
    if ($file) {
        if (file_exists('../' . $file['file_path'])) unlink('../' . $file['file_path']);
        $pdo->prepare("DELETE FROM media WHERE id = ?")->execute([$mid]);
    }
    header("Location: edit.php?id=$id&msg=Arquivo removido");
    exit;
}

render_header("Editar Produto - Admin");
?>

<div class="max-w-4xl mx-auto py-12 px-4">
    <div class="mb-10">
        <a href="index.php" class="text-primary font-bold flex items-center hover:-translate-x-1 transition-transform">
            ← Voltar ao painel
        </a>
        <h1 class="text-4xl font-bold text-primary mt-4">Editar Produto</h1>
    </div>

    <form method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl shadow-xl p-10 border border-gray-100 space-y-8 mb-12">
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Título do Produto</label>
            <input type="text" name="title" required value="<?php echo htmlspecialchars($product['title']); ?>" class="w-full px-6 py-4 rounded-2xl border border-gray-200 focus:ring-2 focus:ring-primary outline-none transition text-lg">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Descrição Completa</label>
            <textarea name="description" rows="6" required class="w-full px-6 py-4 rounded-2xl border border-gray-200 focus:ring-2 focus:ring-primary outline-none transition"><?php echo htmlspecialchars($product['description']); ?></textarea>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Adicionar Novas Mídias</label>
            <input type="file" name="media[]" multiple accept="image/*,video/*" class="w-full">
        </div>

        <button type="submit" class="w-full bg-primary text-white py-5 rounded-2xl font-bold text-xl hover:bg-primary-dark transition shadow-xl">
            Salvar Alterações
        </button>
    </form>

    <h3 class="text-2xl font-bold text-primary mb-6">Mídias Atuais</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <?php
        $stmt = $pdo->prepare("SELECT * FROM media WHERE product_id = ?");
        $stmt->execute([$id]);
        while ($item = $stmt->fetch()):
        ?>
            <div class="relative group bg-white rounded-2xl overflow-hidden shadow-md border border-gray-100">
                <?php if ($item['file_type'] == 'video'): ?>
                    <div class="aspect-square flex items-center justify-center bg-gray-100 text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                <?php else: ?>
                    <img src="../<?php echo $item['file_path']; ?>" class="aspect-square object-cover">
                <?php endif; ?>
                <a href="?id=<?php echo $id; ?>&delete_media=<?php echo $item['id']; ?>"
                   class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition shadow-lg"
                   onclick="return confirm('Excluir este arquivo?')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php render_footer(); ?>
