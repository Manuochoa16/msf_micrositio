import React from "react";

const Header = ({ onLoginClick, isAuthenticated, user, onLogout }) => {
  return (
    <header className="flex items-center justify-between p-4 bg-white shadow">
      <div className="text-left">
        <h1 className="text-xl font-bold">Médicos Sin Fronteras</h1>
        <p className="text-sm text-gray-600">Manual de identidad visual</p>
      </div>
      <div className="flex items-center">
        <img src="/logomsf.png" alt="Logotipo MSF" className="h-16" />
      </div>
      <div className="flex gap-4">
        {isAuthenticated ? (
          <>
            <span className="text-sm font-bold text-gray-700">
              Hola, {user}!
            </span>
            <button
              onClick={onLogout}
              className="px-4 py-2 text-sm font-bold text-white bg-red-500 rounded hover:bg-red-600"
            >
              Cerrar Sesión
            </button>
          </>
        ) : (
          <button
            onClick={onLoginClick}
            className="px-4 py-2 text-sm font-bold text-white bg-green-500 rounded hover:bg-green-600"
          >
            Iniciar Sesión
          </button>
        )}
      </div>
    </header>
  );
};

export default Header;
