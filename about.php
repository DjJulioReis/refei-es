<?php
session_start();
require_once 'includes/db.php';
require_once 'includes/functions.php';

render_header("Nossa História - Santa Helena");
?>

<div class="max-w-7xl mx-auto py-24 px-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-20 items-center">
        <div>
            <h1 class="text-6xl font-extrabold text-primary mb-10 tracking-tight">Nossa História</h1>
            <div class="space-y-6 text-xl text-gray-600 leading-relaxed">
                <p>
                    A <strong>Refeições Santa Helena</strong> nasceu do desejo de oferecer uma alimentação balanceada, saborosa e com o carinho da comida caseira para as famílias e empresas da nossa região.
                </p>
                <p>
                    Com anos de experiência no setor gastronômico, selecionamos cuidadosamente cada ingrediente para garantir que sua refeição não seja apenas nutritiva, mas uma verdadeira experiência de prazer.
                </p>
            </div>

            <div class="bg-primary text-white p-10 rounded-3xl shadow-2xl mt-16 transform -rotate-1">
                <h3 class="text-3xl font-bold mb-6">Nossa Missão</h3>
                <p class="italic text-xl opacity-90">
                    "Proporcionar momentos de felicidade através de uma alimentação saudável, prática e de alta qualidade, respeitando sempre a tradição e o sabor."
                </p>
            </div>
        </div>

        <div class="relative">
            <div class="bg-primary-light w-full aspect-[4/5] rounded-[3rem] overflow-hidden shadow-2xl relative z-10 border-[12px] border-white">
                <div class="absolute inset-0 bg-blue-600/10 backdrop-blur-[2px] flex items-center justify-center p-12 text-center">
                    <span class="text-white text-4xl font-bold italic drop-shadow-lg text-primary">Sabor que une famílias</span>
                </div>
            </div>
            <div class="absolute -bottom-12 -right-12 w-80 h-80 bg-primary opacity-20 rounded-full blur-3xl -z-10"></div>
            <div class="absolute -top-12 -left-12 w-48 h-48 bg-blue-400 opacity-20 rounded-full blur-2xl -z-10"></div>
        </div>
    </div>
</div>

<?php render_footer(); ?>
