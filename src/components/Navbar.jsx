import React from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';
import { Menu, X, LogOut, User } from 'lucide-react';

const Navbar = () => {
  const { user, logout } = useAuth();
  const [isOpen, setIsOpen] = React.useState(false);
  const navigate = useNavigate();

  const handleLogout = () => {
    logout();
    navigate('/');
  };

  return (
    <nav className="bg-primary text-white shadow-lg sticky top-0 z-50">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex items-center justify-between h-20">
          <div className="flex items-center">
            <Link to="/" className="flex-shrink-0 font-bold text-2xl tracking-wider">
              REFEIÇÕES SANTA HELENA
            </Link>
          </div>
          <div className="hidden md:block">
            <div className="ml-10 flex items-baseline space-x-4">
              <Link to="/" className="hover:bg-primary-light px-3 py-2 rounded-md text-sm font-medium">Início</Link>
              <Link to="/sobre" className="hover:bg-primary-light px-3 py-2 rounded-md text-sm font-medium">Sobre</Link>
              <Link to="/contato" className="hover:bg-primary-light px-3 py-2 rounded-md text-sm font-medium">Contato</Link>
              {user ? (
                <>
                  <Link to="/admin" className="bg-white text-primary px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-100">Painel Admin</Link>
                  <button onClick={handleLogout} className="flex items-center space-x-1 hover:text-red-300">
                    <LogOut size={18} />
                    <span>Sair</span>
                  </button>
                </>
              ) : (
                <Link to="/login" className="flex items-center space-x-1 hover:text-gray-300">
                  <User size={18} />
                  <span>Login</span>
                </Link>
              )}
            </div>
          </div>
          <div className="md:hidden">
            <button onClick={() => setIsOpen(!isOpen)} className="p-2 rounded-md hover:bg-primary-light">
              {isOpen ? <X size={24} /> : <Menu size={24} />}
            </button>
          </div>
        </div>
      </div>

      {/* Mobile menu */}
      {isOpen && (
        <div className="md:hidden bg-primary-dark">
          <div className="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <Link to="/" className="block hover:bg-primary-light px-3 py-2 rounded-md text-base font-medium">Início</Link>
            <Link to="/sobre" className="block hover:bg-primary-light px-3 py-2 rounded-md text-base font-medium">Sobre</Link>
            <Link to="/contato" className="block hover:bg-primary-light px-3 py-2 rounded-md text-base font-medium">Contato</Link>
            {user ? (
              <>
                <Link to="/admin" className="block bg-white text-primary px-3 py-2 rounded-md text-base font-medium">Painel Admin</Link>
                <button onClick={handleLogout} className="w-full text-left flex items-center space-x-1 px-3 py-2 text-red-300">
                  <LogOut size={18} />
                  <span>Sair</span>
                </button>
              </>
            ) : (
              <Link to="/login" className="block px-3 py-2 rounded-md text-base font-medium">Login Admin</Link>
            )}
          </div>
        </div>
      )}
    </nav>
  );
};

export default Navbar;
