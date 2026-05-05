import React from 'react';
import { Mail, Phone, MapPin } from 'lucide-react';
import { motion } from 'framer-motion';

const Contact = () => {
  return (
    <div className="max-w-7xl mx-auto py-20 px-4">
      <div className="text-center mb-16">
        <h1 className="text-5xl font-bold text-primary mb-4">Fale Conosco</h1>
        <p className="text-gray-500 text-xl">Dúvidas, sugestões ou encomendas? Estamos aqui para atender você.</p>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 gap-12">
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          className="bg-white p-10 rounded-3xl shadow-xl border border-gray-100"
        >
          <form className="space-y-6">
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-1">Nome Completo</label>
              <input type="text" className="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition" />
            </div>
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
              <input type="email" className="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition" />
            </div>
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-1">Mensagem</label>
              <textarea rows="5" className="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition"></textarea>
            </div>
            <button className="w-full bg-primary text-white py-4 rounded-xl font-bold text-lg hover:bg-primary-dark transition shadow-lg">
              Enviar Mensagem
            </button>
          </form>
        </motion.div>

        <div className="space-y-8 flex flex-col justify-center">
          <div className="flex items-start gap-6">
            <div className="bg-primary-light p-4 rounded-2xl text-white">
              <Phone size={28} />
            </div>
            <div>
              <h3 className="text-xl font-bold text-primary mb-1">Telefone / WhatsApp</h3>
              <p className="text-gray-600 text-lg">(00) 00000-0000</p>
            </div>
          </div>

          <div className="flex items-start gap-6">
            <div className="bg-primary-light p-4 rounded-2xl text-white">
              <Mail size={28} />
            </div>
            <div>
              <h3 className="text-xl font-bold text-primary mb-1">E-mail</h3>
              <p className="text-gray-600 text-lg">contato@santahelena.com.br</p>
            </div>
          </div>

          <div className="flex items-start gap-6">
            <div className="bg-primary-light p-4 rounded-2xl text-white">
              <MapPin size={28} />
            </div>
            <div>
              <h3 className="text-xl font-bold text-primary mb-1">Endereço</h3>
              <p className="text-gray-600 text-lg">Rua Exemplo, 123 - Centro<br/>Santa Helena, PR</p>
            </div>
          </div>

          <div className="pt-8 flex gap-4">
            <a href="#" className="bg-gray-100 p-4 rounded-full text-primary hover:bg-primary hover:text-white transition font-bold">
              IG
            </a>
            <a href="#" className="bg-gray-100 p-4 rounded-full text-primary hover:bg-primary hover:text-white transition font-bold">
              FB
            </a>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Contact;
