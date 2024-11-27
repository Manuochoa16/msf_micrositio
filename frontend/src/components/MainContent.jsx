const MainContent = () => {
  return (
    <main className="flex-1 p-6">
      <h2 className="text-3xl font-bold text-red-600 mb-4">
        Manual de Identidad Visual
      </h2>
      <p className="text-gray-700 mb-6">
        Este manual contiene las directrices para el uso correcto de la marca.
      </p>
      <div className="grid grid-cols-2 gap-6">
        <div className="p-4 bg-white shadow rounded">
          <h3 className="text-red-600 font-bold">Estándares generales</h3>
          <ul className="mt-2 text-gray-700">
            <li>Uso del logotipo</li>
            <li>Tipografía</li>
            <li>Colores</li>
            <li>Iconografía</li>
            <li>Uso de imágenes y vídeos</li>
          </ul>
        </div>
        {/* Más tarjetas */}
      </div>
    </main>
  );
};

export default MainContent;
