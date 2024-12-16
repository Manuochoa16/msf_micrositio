import React from "react";

const Navbar = ({ onSectionChange }) => {
  return (
    <nav className="py-4 bg-white">
      <div className="flex justify-center">
        <ul className="flex space-x-6">
          <li>
            <button
              onClick={() => onSectionChange("Estándares generales")}
              className="font-bold text-gray-800 hover:text-red-600"
            >
              Estándares generales
            </button>
          </li>
          <li>
            <button
              onClick={() => onSectionChange("Estilo y formato en RRSS")}
              className="font-bold text-gray-800 hover:text-red-600"
            >
              Estilo y formato en RRSS
            </button>
          </li>
          <li>
            <button
              onClick={() => onSectionChange("Anuncios")}
              className="font-bold text-gray-800 hover:text-red-600"
            >
              Anuncios
            </button>
          </li>
          <li>
            <button
              onClick={() => onSectionChange("Piezas gráficas")}
              className="font-bold text-gray-800 hover:text-red-600"
            >
              Piezas gráficas
            </button>
          </li>
          <li>
            <button
              onClick={() => onSectionChange("Archivos editables")}
              className="font-bold text-gray-800 hover:text-red-600"
            >
              Archivos editables
            </button>
          </li>
        </ul>
      </div>
    </nav>
  );
};

export default Navbar;
