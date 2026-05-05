import React, { createContext, useState, useEffect, useContext } from 'react';

const ProductContext = createContext();

export const ProductProvider = ({ children }) => {
  const [products, setProducts] = useState(() => {
    const saved = localStorage.getItem('santa_helena_products');
    if (saved) return JSON.parse(saved);

    // Initial sample data
    return [
      {
        id: 1,
        title: 'Marmitex Executiva',
        description: 'Deliciosa marmitex com arroz, feijão, uma opção de carne, guarnição e salada fresca.',
        media: [
          { url: 'https://images.unsplash.com/photo-1543339308-43e59d6b73a6?auto=format&fit=crop&q=80&w=800', type: 'image' }
        ]
      },
      {
        id: 2,
        title: 'Feijoada Completa',
        description: 'Nossa famosa feijoada servida às quartas e sábados, acompanhada de couve, farofa e laranja.',
        media: [
          { url: 'https://images.unsplash.com/photo-1594000199163-2479a489069a?auto=format&fit=crop&q=80&w=800', type: 'image' }
        ]
      }
    ];
  });

  useEffect(() => {
    localStorage.setItem('santa_helena_products', JSON.stringify(products));
  }, [products]);

  const addProduct = (product) => {
    setProducts([...products, { ...product, id: Date.now() }]);
  };

  const updateProduct = (updatedProduct) => {
    setProducts(products.map(p => p.id === updatedProduct.id ? updatedProduct : p));
  };

  const deleteProduct = (id) => {
    setProducts(products.filter(p => p.id !== id));
  };

  return (
    <ProductContext.Provider value={{ products, addProduct, updateProduct, deleteProduct }}>
      {children}
    </ProductContext.Provider>
  );
};

export const useProducts = () => useContext(ProductContext);
