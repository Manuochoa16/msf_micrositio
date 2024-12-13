import React, { useEffect, useState } from "react";
import { getInfo } from "../services/dataService";
import InfoList from "./InfoList";
import InfoForm from "./InfoForm";

const MainContent = () => {
  const [data, setData] = useState([]);
  const [selectedItem, setSelectedItem] = useState(null);

  // Obtener datos al montar el componente
  useEffect(() => {
    fetchData();
  }, []);

  const fetchData = async () => {
    try {
      const response = await getInfo();
      setData(response); // Guardar los datos en el estado
    } catch (error) {
      console.error("Error al obtener la información:", error);
    }
  };

  return (
    <main className="flex-1 p-6 bg-gray-200 rounded-xl">
      <h2 className="mb-4 text-3xl font-bold text-red-600">
        Manual de Identidad Visual
      </h2>
      <p className="mb-6 text-gray-700">
        Este manual contiene las directrices para el uso correcto de la marca.
      </p>

      {/* Formulario para guardar/actualizar información */}
      <InfoForm
        selectedItem={selectedItem}
        onFormSubmit={fetchData}
        onCancel={() => setSelectedItem(null)}
      />

      {/* Lista de datos */}
      <InfoList data={data} onEdit={(item) => setSelectedItem(item)} />
    </main>
  );
};

export default MainContent;
