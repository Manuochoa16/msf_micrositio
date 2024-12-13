import React, { useState, useEffect } from "react";
import { saveInfo, updateInfo } from "../services/dataService";

const InfoForm = ({ selectedItem, onFormSubmit, onCancel }) => {
  const [form, setForm] = useState({
    title: "",
    subtitle: "",
    description: "",
  });

  useEffect(() => {
    if (selectedItem) {
      setForm(selectedItem);
    } else {
      setForm({ title: "", subtitle: "", description: "" });
    }
  }, [selectedItem]);

  const handleSubmit = async () => {
    try {
      if (selectedItem) {
        await updateInfo(
          selectedItem.id,
          form.title,
          form.subtitle,
          form.description
        );
      } else {
        await saveInfo(form.title, form.subtitle, form.description);
      }
      onFormSubmit(); // Refrescar datos
    } catch (error) {
      console.error("Error al guardar/actualizar la información:", error);
    }
  };

  return (
    <div className="mb-6">
      <h3 className="text-xl font-bold">
        {selectedItem ? "Actualizar Información" : "Nueva Información"}
      </h3>
      <input
        type="text"
        placeholder="Título"
        value={form.title}
        onChange={(e) => setForm({ ...form, title: e.target.value })}
        className="w-full p-2 mt-2 border rounded"
      />
      <input
        type="text"
        placeholder="Subtítulo"
        value={form.subtitle}
        onChange={(e) => setForm({ ...form, subtitle: e.target.value })}
        className="w-full p-2 mt-2 border rounded"
      />
      <textarea
        placeholder="Descripción"
        value={form.description}
        onChange={(e) => setForm({ ...form, description: e.target.value })}
        className="w-full p-2 mt-2 border rounded"
      />
      <div className="flex gap-4 mt-2">
        <button
          onClick={handleSubmit}
          className="px-4 py-2 text-white bg-green-500 rounded"
        >
          {selectedItem ? "Actualizar" : "Guardar"}
        </button>
        {selectedItem && (
          <button
            onClick={onCancel}
            className="px-4 py-2 text-white bg-red-500 rounded"
          >
            Cancelar
          </button>
        )}
      </div>
    </div>
  );
};

export default InfoForm;
