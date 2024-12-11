const Navbar = () => {
  return (
    <nav className="py-4 bg-white shadow-md">
      <ul className="flex justify-center pb-2 space-x-4 border-b-2">
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
    </nav>
  );
};

export default Navbar;
