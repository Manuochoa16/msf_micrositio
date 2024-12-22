import React, { useEffect, useState } from "react";
import { getInfo, saveInfo } from "../services/dataService";
import InfoList from "./InfoList";
import InfoForm from "./InfoForm";

const MainContent = ({ currentSection, isAuthenticated }) => {
  const [data, setData] = useState([]);
  const [selectedItem, setSelectedItem] = useState(null);
  const [showForm, setShowForm] = useState(false);

  useEffect(() => {
    fetchData();
  }, [currentSection]);

  const fetchData = async () => {
    try {
      const response = await getInfo();
      setData(response);
    } catch (error) {
      console.error("Error al obtener la información:", error);
    }
  };

  const handleSave = async (formData) => {
    try {
      await saveInfo(formData);
      fetchData();
      setSelectedItem(null);
      setShowForm(false);
    } catch (error) {
      console.error("Error al guardar la información:", error);
    }
  };

  return (
    <main className="flex-1 p-6 bg-gray-200 rounded-xl">
      <div className="flex items-center justify-between mb-4">
        <h2 className="text-3xl font-bold text-red-600">{currentSection}</h2>
        {isAuthenticated && (
          <button
            onClick={() => setShowForm(!showForm)}
            className="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600"
          >
            {showForm ? "Cerrar Formulario" : "Agregar Contenido"}
          </button>
        )}
      </div>
      <p className="mb-6 text-gray-700">
        Aquí puedes agregar o gestionar contenido para la sección "
        {currentSection}".
      </p>
      {showForm && (
        <InfoForm
          selectedItem={selectedItem}
          onSave={handleSave}
          onCancel={() => {
            setSelectedItem(null);
            setShowForm(false);
          }}
        />
      )}
      <InfoList data={data} onEdit={(item) => setSelectedItem(item)} />
    </main>
  );
};

export default MainContent;
