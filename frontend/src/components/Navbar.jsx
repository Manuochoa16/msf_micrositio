import React from "react";

const Navbar = () => {
  return (
    <nav className="py-4 bg-white">
      <div className="flex justify-center">
        <ul className="flex space-x-6">
          <li>
            <a
              href="#introduccion"
              className="font-bold text-gray-800 hover:text-red-600"
            >
              Estándares generales
            </a>
          </li>
          <li>
            <a
              href="#logotipo"
              className="font-bold text-gray-800 hover:text-red-600"
            >
              Estilo y formato en RRSS
            </a>
          </li>
          <li>
            <a
              href="#color"
              className="font-bold text-gray-800 hover:text-red-600"
            >
              Anuncios
            </a>
          </li>
          <li>
            <a
              href="#tipografia"
              className="font-bold text-gray-800 hover:text-red-600"
            >
              Piezas gráficas
            </a>
          </li>
          <li>
            <a
              href="#iconografia"
              className="font-bold text-gray-800 hover:text-red-600"
            >
              Archivos editables
            </a>
          </li>
        </ul>
      </div>
    </nav>
  );
};

export default Navbar;
