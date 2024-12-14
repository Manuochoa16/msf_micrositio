import React, { useEffect, useState } from "react";
import { getInfo, saveInfo } from "../services/dataService"; // Importar función saveInfo
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
      const response = await getInfo(); // Llama al servicio para obtener la info
      console.log(response); // Inspecciona que `image` esté presente en cada elemento
      setData(response);
    } catch (error) {
      console.error("Error al obtener la información:", error);
    }
  };

  // Manejar guardado de datos
  const handleSave = async (formData) => {
    try {
      await saveInfo(formData); // Llama al servicio para guardar la información
      fetchData(); // Recarga los datos después de guardar
      setSelectedItem(null); // Limpia el formulario
    } catch (error) {
      console.error("Error al guardar la información:", error);
      throw new Error("No se pudo guardar la información."); // Opcional: lanzar error para InfoForm
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
        onSave={handleSave} // Conectar la función de guardado
        onCancel={() => setSelectedItem(null)}
      />

      {/* Lista de datos */}
      <InfoList data={data} onEdit={(item) => setSelectedItem(item)} />
    </main>
  );
};

export default MainContent;
