<?php
session_start();
require_once 'includes/db.php';
require_once 'includes/functions.php';

render_header("Fale Conosco - Santa Helena");
?>

<div class="max-w-7xl mx-auto py-24 px-4">
    <div class="text-center mb-20">
        <h1 class="text-6xl font-extrabold text-primary mb-6 tracking-tight">Fale Conosco</h1>
        <p class="text-gray-500 text-2xl max-w-2xl mx-auto leading-relaxed">Dúvidas, sugestões ou encomendas? Estamos prontos para atender você.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-20">
        <div class="bg-white p-12 rounded-[2.5rem] shadow-2xl border border-gray-50 relative overflow-hidden">
            <form class="space-y-8 relative z-10">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nome Completo</label>
                    <input type="text" placeholder="Como deseja ser chamado?" class="w-full px-6 py-4 rounded-2xl border border-gray-200 focus:ring-2 focus:ring-primary outline-none transition text-lg bg-gray-50">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Seu Melhor E-mail</label>
                    <input type="email" placeholder="exemplo@email.com" class="w-full px-6 py-4 rounded-2xl border border-gray-200 focus:ring-2 focus:ring-primary outline-none transition text-lg bg-gray-50">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Mensagem</label>
                    <textarea rows="5" placeholder="Em que podemos ajudar hoje?" class="w-full px-6 py-4 rounded-2xl border border-gray-200 focus:ring-2 focus:ring-primary outline-none transition text-lg bg-gray-50"></textarea>
                </div>
                <button type="button" onclick="alert('Funcionalidade de demonstração. Em produção, os dados seriam enviados por e-mail.')" class="w-full bg-primary text-white py-5 rounded-2xl font-bold text-xl hover:bg-primary-dark transition shadow-xl hover:-translate-y-1">
                    Enviar Mensagem
                </button>
            </form>
            <div class="absolute top-0 right-0 w-32 h-32 bg-primary opacity-[0.03] rounded-bl-full"></div>
        </div>

        <div class="flex flex-col justify-center space-y-12">
            <div class="group flex items-start gap-8 p-8 rounded-3xl hover:bg-white hover:shadow-xl transition duration-500">
                <div class="bg-primary-light p-5 rounded-2xl text-white shadow-lg group-hover:scale-110 transition duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-primary mb-2">WhatsApp</h3>
                    <p class="text-gray-600 text-xl font-medium">(00) 00000-0000</p>
                </div>
            </div>

            <div class="group flex items-start gap-8 p-8 rounded-3xl hover:bg-white hover:shadow-xl transition duration-500">
                <div class="bg-primary-light p-5 rounded-2xl text-white shadow-lg group-hover:scale-110 transition duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-primary mb-2">E-mail</h3>
                    <p class="text-gray-600 text-xl font-medium">contato@santahelena.com.br</p>
                </div>
            </div>

            <div class="group flex items-start gap-8 p-8 rounded-3xl hover:bg-white hover:shadow-xl transition duration-500">
                <div class="bg-primary-light p-5 rounded-2xl text-white shadow-lg group-hover:scale-110 transition duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-primary mb-2">Endereço</h3>
                    <p class="text-gray-600 text-xl leading-relaxed font-medium">Rua Exemplo, 123 - Centro<br>Santa Helena, PR</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php render_footer(); ?>
