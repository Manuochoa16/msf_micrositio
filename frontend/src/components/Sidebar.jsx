const Sidebar = () => {
  return (
    <aside className="w-1/4 bg-white p-4 shadow-md">
      <ul className="space-y-2">
        <li>
          <a
            href="#introduccion"
            className="text-red-600 font-bold hover:underline"
          >
            Introducción
          </a>
        </li>
        <li>
          <a
            href="#logotipo"
            className="text-red-600 font-bold hover:underline"
          >
            Logotipo
          </a>
        </li>
        <li>
          <a href="#color" className="text-red-600 font-bold hover:underline">
            Color
          </a>
        </li>
        <li>
          <a href="#color" className="text-red-600 font-bold hover:underline">
            Iconografia
          </a>
        </li>
        <li>
          <a href="#color" className="text-red-600 font-bold hover:underline">
            Aplicaciones
          </a>
        </li>
      </ul>
      <button className="mt-4 w-full bg-red-600 text-white py-2 rounded hover:bg-red-700">
        Descargas
      </button>
    </aside>
  );
};

export default Sidebar;
