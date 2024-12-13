import React from "react";

const Header = ({ onLoginClick, onRegisterClick }) => {
  return (
    <header className="flex items-center justify-between p-4 bg-white shadow">
      {/* Izquierda: Título y subtítulo */}
      <div className="text-left">
        <h1 className="text-xl font-bold">Médicos Sin Fronteras</h1>
        <p className="text-sm text-gray-600">Manual de identidad visual</p>
      </div>

      {/* Centro: Logo */}
      <div className="flex items-center">
        <img src="/logomsf.png" alt="Logotipo MSF" className="h-16" />
      </div>

      {/* Derecha: Botones de Iniciar Sesión y Registrarse */}
      <div className="flex gap-4">
        <button
          onClick={onLoginClick}
          className="px-4 py-2 text-sm font-bold text-white bg-green-500 rounded hover:bg-green-600"
        >
          Iniciar Sesión
        </button>
        <button
          onClick={onRegisterClick}
          className="px-4 py-2 text-sm font-bold text-white bg-blue-500 rounded hover:bg-blue-600"
        >
          Registrarse
        </button>
      </div>
    </header>
  );
};

export default Header;
