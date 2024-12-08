const Navbar = () => {
  return (
    <nav className="py-4 bg-white shadow-md">
      <ul className="flex justify-center pb-2 space-x-4 border-b-2">
        <li>
          <a
            href="#introduccion"
            className="font-bold text-gray-800 hover:text-red-600"
          >
            Uso del logo
          </a>
        </li>
        <li>
          <a
            href="#logotipo"
            className="font-bold text-gray-800 hover:text-red-600"
          >
            Tipografía
          </a>
        </li>
        <li>
          <a
            href="#color"
            className="font-bold text-gray-800 hover:text-red-600"
          >
            Colores
          </a>
        </li>
        <li>
          <a
            href="#tipografia"
            className="font-bold text-gray-800 hover:text-red-600"
          >
            Uso de imágenes y videos
          </a>
        </li>
        <li>
          <a
            href="#iconografia"
            className="font-bold text-gray-800 hover:text-red-600"
          >
            Como filmarse / sacar fotos
          </a>
        </li>
      </ul>
    </nav>
  );
};

export default Navbar;
