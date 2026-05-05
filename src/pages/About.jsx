import React from 'react';
import { motion } from 'framer-motion';

const About = () => {
  return (
    <div className="max-w-7xl mx-auto py-20 px-4">
      <div className="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
        <motion.div
          initial={{ opacity: 0, x: -50 }}
          whileInView={{ opacity: 1, x: 0 }}
          transition={{ duration: 0.8 }}
        >
          <h1 className="text-5xl font-bold text-primary mb-8">Nossa História</h1>
          <p className="text-gray-600 text-lg mb-6 leading-relaxed">
            A <strong>Refeições Santa Helena</strong> nasceu do desejo de oferecer uma alimentação balanceada, saborosa e com o carinho da comida caseira para as famílias e empresas da nossa região.
          </p>
          <p className="text-gray-600 text-lg mb-6 leading-relaxed">
            Com anos de experiência no setor gastronômico, selecionamos cuidadosamente cada ingrediente para garantir que sua refeição não seja apenas nutritiva, mas uma verdadeira experiência de prazer.
          </p>
          <div className="bg-primary text-white p-8 rounded-2xl shadow-lg mt-10">
            <h3 className="text-2xl font-bold mb-4">Nossa Missão</h3>
            <p className="italic text-lg">
              "Proporcionar momentos de felicidade através de uma alimentação saudável, prática e de alta qualidade, respeitando sempre a tradição e o sabor."
            </p>
          </div>
        </motion.div>

        <div className="relative">
          <div className="bg-primary-light w-full h-[500px] rounded-3xl overflow-hidden shadow-2xl relative z-10">
            <div className="absolute inset-0 bg-white/10 backdrop-blur-sm flex items-center justify-center p-12 text-center border-8 border-white">
               <span className="text-white text-3xl font-bold italic">Espaço para Foto da Fachada ou Cozinha</span>
            </div>
          </div>
          <div className="absolute -bottom-10 -right-10 w-64 h-64 bg-primary opacity-20 rounded-full blur-3xl -z-10"></div>
        </div>
      </div>
    </div>
  );
};

export default About;
