import React, { createContext, useState, useContext } from 'react';

const AuthContext = createContext();

// In a real production app, these would come from an API and passwords would never be hardcoded or stored in plain text.
const ADMIN_USERNAME = import.meta.env.VITE_ADMIN_USER || 'admin';
const ADMIN_PASSWORD = import.meta.env.VITE_ADMIN_PASSWORD || 'admin123';

export const AuthProvider = ({ children }) => {
  const [user, setUser] = useState(() => {
    const saved = localStorage.getItem('santa_helena_admin');
    return saved ? JSON.parse(saved) : null;
  });

  const login = (username, password) => {
    if (username === ADMIN_USERNAME && password === ADMIN_PASSWORD) {
      const userData = { username, role: 'admin' };
      setUser(userData);
      localStorage.setItem('santa_helena_admin', JSON.stringify(userData));
      return true;
    }
    return false;
  };

  const logout = () => {
    setUser(null);
    localStorage.removeItem('santa_helena_admin');
  };

  return (
    <AuthContext.Provider value={{ user, login, logout }}>
      {children}
    </AuthContext.Provider>
  );
};

export const useAuth = () => useContext(AuthContext);
