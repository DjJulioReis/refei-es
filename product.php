<?php
session_start();
require_once 'includes/db.php';
require_once 'includes/functions.php';

$id = $_GET['id'] ?? null;
if (!$id) { header('Location: index.php'); exit; }

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) { header('Location: index.php'); exit; }

$stmt = $pdo->prepare("SELECT * FROM media WHERE product_id = ?");
$stmt->execute([$id]);
$media = $stmt->fetchAll();

render_header($product['title'] . " - Santa Helena");
?>

<div class="max-w-7xl mx-auto py-16 px-4">
    <a href="index.php" class="inline-flex items-center text-primary font-bold mb-10 hover:-translate-x-2 transition-transform">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Voltar para o cardápio
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
        <div>
            <h1 class="text-5xl font-extrabold text-primary mb-8"><?php echo htmlspecialchars($product['title']); ?></h1>
            <div class="prose prose-xl text-gray-600 leading-relaxed whitespace-pre-line">
                <?php echo nl2br(htmlspecialchars($product['description'])); ?>
            </div>

            <div class="mt-12 p-8 bg-blue-50 rounded-3xl border border-blue-100">
                <h3 class="text-xl font-bold text-primary mb-4">Gostou dessa opção?</h3>
                <p class="text-gray-600 mb-6">Entre em contato agora para fazer seu pedido ou tirar dúvidas.</p>
                <a href="contact.php" class="bg-primary text-white px-8 py-3 rounded-xl font-bold hover:bg-primary-dark transition shadow-lg inline-block">Falar com Atendente</a>
            </div>
        </div>

        <div class="space-y-8">
            <?php if (empty($media)): ?>
                <div class="bg-gray-100 aspect-video rounded-3xl flex items-center justify-center text-gray-400 border-2 border-dashed border-gray-200">
                    Nenhuma mídia disponível
                </div>
            <?php else: ?>
                <?php foreach ($media as $item): ?>
                    <div class="rounded-3xl overflow-hidden shadow-2xl bg-white group">
                        <?php if ($item['file_type'] == 'video'): ?>
                            <video controls class="w-full h-auto">
                                <source src="<?php echo htmlspecialchars($item['file_path']); ?>" type="video/mp4">
                                Seu navegador não suporta vídeos.
                            </video>
                        <?php else: ?>
                            <img src="<?php echo htmlspecialchars($item['file_path']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" class="w-full h-auto group-hover:scale-105 transition duration-700">
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php render_footer(); ?>
