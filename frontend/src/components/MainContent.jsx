const MainContent = () => {
  return (
    <main className="flex-1 p-6 bg-gray-200">
      <h2 className="mb-4 text-3xl font-bold text-red-600">
        Manual de Identidad Visual
      </h2>
      <p className="mb-6 text-gray-700">
        Este manual contiene las directrices para el uso correcto de la marca.
      </p>
      <div className="grid grid-cols-1 gap-6 md:grid-cols-2">
        <div className="p-4 bg-white rounded shadow">
          <h3 className="font-bold text-red-600">Estándares generales</h3>
          <ul className="mt-2 text-gray-700">
            <li>Uso del logotipo</li>
            <li>Tipografía</li>
            <li>Colores</li>
            <li>Iconografía</li>
            <li>Uso de imágenes y vídeos</li>
          </ul>
        </div>
        {/* Más tarjetas según sea necesario */}
      </div>
    </main>
  );
};

export default MainContent;
