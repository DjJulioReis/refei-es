<?php
function render_header($title = "Refeições Santa Helena") {
    $is_admin = strpos($_SERVER['REQUEST_URI'], '/admin/') !== false;
    $base_path = $is_admin ? '../' : '';
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $title; ?></title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: {
                                light: '#3b82f6',
                                DEFAULT: '#1e40af',
                                dark: '#1e3a8a',
                            },
                            secondary: '#ffffff',
                        }
                    }
                }
            }
        </script>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
            body { font-family: 'Inter', sans-serif; }
        </style>
    </head>
    <body class="flex flex-col min-h-screen bg-gray-50">
        <nav class="bg-primary text-white shadow-lg sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <a href="<?php echo $base_path; ?>index.php" class="font-bold text-xl md:text-2xl tracking-wider">
                        REFEIÇÕES SANTA HELENA
                    </a>
                    <div class="hidden md:flex space-x-6 items-center">
                        <a href="<?php echo $base_path; ?>index.php" class="hover:text-gray-200">Início</a>
                        <a href="<?php echo $base_path; ?>about.php" class="hover:text-gray-200">Sobre</a>
                        <a href="<?php echo $base_path; ?>contact.php" class="hover:text-gray-200">Contato</a>
                        <?php if (isset($_SESSION['admin_id'])): ?>
                            <a href="<?php echo $base_path; ?>admin/index.php" class="bg-white text-primary px-4 py-2 rounded-lg font-bold">Painel</a>
                            <a href="<?php echo $base_path; ?>admin/logout.php" class="text-red-300">Sair</a>
                        <?php else: ?>
                            <a href="<?php echo $base_path; ?>admin/login.php" class="text-sm opacity-80 hover:opacity-100">Login Admin</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
        <main class="flex-grow">
    <?php
}

function render_footer() {
    ?>
        </main>
        <footer class="bg-primary-dark text-white py-12 mt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <p class="text-2xl font-bold mb-4">Refeições Santa Helena</p>
                <div class="flex justify-center space-x-6 mb-8 text-sm opacity-80">
                    <a href="index.php">Início</a>
                    <a href="about.php">Sobre</a>
                    <a href="contact.php">Contato</a>
                </div>
                <p class="text-sm opacity-60">© <?php echo date('Y'); ?> - Todos os direitos reservados.</p>
                <p class="mt-4 text-xs opacity-40 italic">Sabor e Qualidade em Cada Refeição</p>
            </div>
        </footer>
    </body>
    </html>
    <?php
}
?>
