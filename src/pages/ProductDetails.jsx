import React from 'react';
import { useParams, Link } from 'react-router-dom';
import { useProducts } from '../context/ProductContext';
import { motion } from 'framer-motion';
import { ChevronLeft } from 'lucide-react';

const ProductDetails = () => {
  const { id } = useParams();
  const { products } = useProducts();
  const product = products.find(p => p.id === parseInt(id));

  if (!product) {
    return (
      <div className="max-w-7xl mx-auto py-20 px-4 text-center">
        <h2 className="text-2xl font-bold text-gray-800">Produto não encontrado</h2>
        <Link to="/" className="text-primary mt-4 inline-block">Voltar para o início</Link>
      </div>
    );
  }

  return (
    <div className="max-w-7xl mx-auto py-12 px-4">
      <Link to="/" className="flex items-center text-primary hover:underline mb-8">
        <ChevronLeft size={20} /> Voltar para o cardápio
      </Link>

      <div className="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <div className="space-y-6">
          <h1 className="text-4xl font-bold text-primary">{product.title}</h1>
          <div className="prose prose-blue text-gray-600 text-lg whitespace-pre-line">
            {product.description}
          </div>
        </div>

        <div className="grid grid-cols-1 gap-6">
          {product.media && product.media.length > 0 ? (
            product.media.map((item, index) => (
              <motion.div
                key={index}
                initial={{ opacity: 0, scale: 0.9 }}
                whileInView={{ opacity: 1, scale: 1 }}
                className="rounded-2xl overflow-hidden shadow-xl"
              >
                {item.type === 'video' ? (
                  <video controls className="w-full" src={item.url} />
                ) : (
                  <img src={item.url} alt={`${product.title} - ${index}`} className="w-full h-auto" />
                )}
              </motion.div>
            ))
          ) : (
            <div className="bg-gray-100 h-96 rounded-2xl flex items-center justify-center text-gray-400">
              Sem imagens disponíveis
            </div>
          )}
        </div>
      </div>
    </div>
  );
};

export default ProductDetails;
