<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit; }
require_once '../includes/db.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $desc = $_POST['description'];

    $stmt = $pdo->prepare("INSERT INTO products (title, description) VALUES (?, ?)");
    $stmt->execute([$title, $desc]);
    $product_id = $pdo->lastInsertId();

    // Media Upload
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

                // Ensure uploads directory exists
                if (!file_exists('../uploads')) {
                    mkdir('../uploads', 0755, true);
                }

                if (move_uploaded_file($tmp_name, '../' . $destination)) {
                    $type = in_array($ext, $allowed_videos) ? 'video' : 'image';
                    $stmt = $pdo->prepare("INSERT INTO media (product_id, file_path, file_type) VALUES (?, ?, ?)");
                    $stmt->execute([$product_id, $destination, $type]);
                }
            }
        }
    }

    header('Location: index.php?msg=Produto adicionado com sucesso');
    exit;
}

render_header("Adicionar Produto - Admin");
?>

<div class="max-w-4xl mx-auto py-12 px-4">
    <div class="mb-10">
        <a href="index.php" class="text-primary font-bold flex items-center hover:-translate-x-1 transition-transform">
            ← Voltar ao painel
        </a>
        <h1 class="text-4xl font-bold text-primary mt-4">Novo Produto</h1>
    </div>

    <form method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl shadow-xl p-10 border border-gray-100 space-y-8">
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Título do Produto</label>
            <input type="text" name="title" required placeholder="Ex: Marmitex Especial de Domingo" class="w-full px-6 py-4 rounded-2xl border border-gray-200 focus:ring-2 focus:ring-primary outline-none transition text-lg">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Descrição Completa</label>
            <textarea name="description" rows="6" required placeholder="Descreva os ingredientes, acompanhamentos..." class="w-full px-6 py-4 rounded-2xl border border-gray-200 focus:ring-2 focus:ring-primary outline-none transition"></textarea>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Mídias (Fotos e Vídeos)</label>
            <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-2xl hover:border-primary transition">
                <div class="space-y-1 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="flex text-sm text-gray-600">
                        <label class="relative cursor-pointer bg-white rounded-md font-medium text-primary hover:text-primary-dark">
                            <span>Selecione os arquivos</span>
                            <input type="file" name="media[]" multiple class="sr-only" accept="image/*,video/*">
                        </label>
                    </div>
                    <p class="text-xs text-gray-500">Imagens (JPG, PNG, WEBP) ou Vídeos (MP4)</p>
                </div>
            </div>
        </div>

        <div class="pt-6">
            <button type="submit" class="w-full bg-primary text-white py-5 rounded-2xl font-bold text-xl hover:bg-primary-dark transition shadow-xl">
                Publicar no Cardápio
            </button>
        </div>
    </form>
</div>

<?php render_footer(); ?>
