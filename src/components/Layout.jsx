import React from 'react';
import { Outlet } from 'react-router-dom';
import Navbar from './Navbar';

const Layout = () => {
  return (
    <div className="flex flex-col min-h-screen">
      <Navbar />
      <main className="flex-grow">
        <Outlet />
      </main>
      <footer className="bg-primary-dark text-white py-8">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <p className="text-lg font-bold mb-2">Refeições Santa Helena</p>
          <p className="text-sm opacity-75">© {new Date().getFullYear()} - Todos os direitos reservados.</p>
          <p className="mt-4 text-xs opacity-50 italic">Sabor e Qualidade em Cada Refeição</p>
        </div>
      </footer>
    </div>
  );
};

export default Layout;
