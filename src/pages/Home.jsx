import React from 'react';
import { useProducts } from '../context/ProductContext';
import { Link } from 'react-router-dom';
import { motion } from 'framer-motion';

const Home = () => {
  const { products } = useProducts();

  return (
    <div>
      {/* Hero Section */}
      <section className="bg-primary text-white py-20 px-4">
        <div className="max-w-7xl mx-auto text-center">
          <motion.h1
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            className="text-4xl md:text-6xl font-extrabold mb-6"
          >
            Refeições Santa Helena
          </motion.h1>
          <motion.p
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            transition={{ delay: 0.2 }}
            className="text-xl md:text-2xl opacity-90 mb-10"
          >
            Tradição, sabor e qualidade no seu dia a dia.
          </motion.p>
          <Link to="/contato" className="bg-white text-primary px-8 py-3 rounded-full font-bold text-lg hover:bg-gray-100 transition shadow-xl">
            Peça agora
          </Link>
        </div>
      </section>

      {/* Products Grid */}
      <section className="max-w-7xl mx-auto py-16 px-4">
        <h2 className="text-3xl font-bold text-primary mb-10 border-b-2 border-primary w-fit pb-2">Nossas Refeições</h2>

        {products.length === 0 ? (
          <div className="text-center py-20 text-gray-500">
            <p className="text-xl">Nenhuma refeição cadastrada no momento.</p>
          </div>
        ) : (
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {products.map((product) => (
              <motion.div
                key={product.id}
                whileHover={{ scale: 1.02 }}
                className="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100"
              >
                <div className="h-64 bg-gray-200 relative">
                  {product.media && product.media.length > 0 ? (
                    product.media[0].type === 'video' ? (
                      <video src={product.media[0].url} className="w-full h-full object-cover" />
                    ) : (
                      <img src={product.media[0].url} alt={product.title} className="w-full h-full object-cover" />
                    )
                  ) : (
                    <div className="flex items-center justify-center h-full text-gray-400">Sem imagem</div>
                  )}
                </div>
                <div className="p-6">
                  <h3 className="text-xl font-bold text-primary mb-2">{product.title}</h3>
                  <p className="text-gray-600 line-clamp-3 mb-4">{product.description}</p>
                  <Link
                    to={`/produto/${product.id}`}
                    className="text-primary font-semibold hover:underline flex items-center"
                  >
                    Ver detalhes
                  </Link>
                </div>
              </motion.div>
            ))}
          </div>
        )}
      </section>
    </div>
  );
};

export default Home;
