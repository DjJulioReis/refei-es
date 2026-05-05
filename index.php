<?php
session_start();
require_once 'includes/db.php';
require_once 'includes/functions.php';

render_header();

// Fetch products
$stmt = $pdo->query("
    SELECT p.*, (SELECT file_path FROM media WHERE product_id = p.id LIMIT 1) as cover
    FROM products p
    ORDER BY created_at DESC
");
$products = $stmt->fetchAll();
?>

<!-- Hero -->
<section class="bg-primary text-white py-24 px-4 relative overflow-hidden">
    <div class="max-w-7xl mx-auto text-center relative z-10">
        <h1 class="text-5xl md:text-7xl font-extrabold mb-6 tracking-tight">Refeições Santa Helena</h1>
        <p class="text-xl md:text-3xl opacity-90 mb-12 max-w-3xl mx-auto">Sabor caseiro e qualidade premium entregues diretamente para você.</p>
        <a href="contact.php" class="bg-white text-primary px-10 py-4 rounded-full font-bold text-xl hover:bg-gray-100 transition shadow-2xl inline-block">Peça agora</a>
    </div>
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-white opacity-5 rounded-full blur-3xl"></div>
</section>

<!-- Menu Grid -->
<section class="max-w-7xl mx-auto py-20 px-4">
    <div class="flex items-center justify-between mb-12">
        <h2 class="text-4xl font-bold text-primary">Nosso Cardápio</h2>
        <div class="h-1 flex-grow ml-8 bg-gray-100"></div>
    </div>

    <?php if (empty($products)): ?>
        <div class="text-center py-32 bg-white rounded-3xl shadow-inner border-2 border-dashed border-gray-200">
            <p class="text-2xl text-gray-400">Em breve novidades deliciosas!</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            <?php foreach ($products as $product): ?>
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 hover:shadow-2xl transition duration-300 group">
                    <div class="h-72 bg-gray-200 relative overflow-hidden">
                        <?php if ($product['cover']): ?>
                            <img src="<?php echo htmlspecialchars($product['cover']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <?php else: ?>
                            <div class="flex items-center justify-center h-full text-gray-400">Sem imagem</div>
                        <?php endif; ?>
                    </div>
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-primary mb-3"><?php echo htmlspecialchars($product['title']); ?></h3>
                        <p class="text-gray-600 line-clamp-2 mb-6 leading-relaxed"><?php echo htmlspecialchars($product['description']); ?></p>
                        <a href="product.php?id=<?php echo $product['id']; ?>" class="inline-flex items-center text-primary font-bold hover:gap-3 transition-all">
                            Ver detalhes
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php render_footer(); ?>
