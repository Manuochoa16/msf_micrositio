// InfoForm.jsx
import React, { useState } from "react";
import axios from "axios";
import { Editor, EditorState, RichUtils, convertToRaw } from "draft-js";
import "draft-js/dist/Draft.css";

const customStyleMap = {
  RED: { color: "red" },
  GREEN: { color: "green" },
  BLUE: { color: "blue" },
};

const InfoForm = ({ onSave }) => {
  const [blocks, setBlocks] = useState([]); // Maneja múltiples bloques dinámicos
  const [title, setTitle] = useState("");
  const [subtitle, setSubtitle] = useState("");

  const addBlock = (type) => {
    setBlocks([...blocks, { type, content: "", file: null }]);
  };

  const handleBlockChange = (index, field, value) => {
    const updatedBlocks = [...blocks];
    updatedBlocks[index][field] = value;
    setBlocks(updatedBlocks);
  };

  const handleFileUpload = (index, file) => {
    const updatedBlocks = [...blocks];
    updatedBlocks[index].file = file;
    setBlocks(updatedBlocks);
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    const formData = new FormData();
    formData.append("title", title);
    formData.append("subtitle", subtitle);
    formData.append("blocks", JSON.stringify(blocks));

    blocks.forEach((block, index) => {
      if (block.file) {
        formData.append(`file_${index}`, block.file);
      }
    });

    try {
      const response = await axios.post(
        "https://msf-micrositio.onrender.com/api.php?endpoint=saveInfo",
        formData,
        { headers: { "Content-Type": "multipart/form-data" } }
      );
      console.log("Respuesta del servidor:", response.data);
    } catch (error) {
      console.error("Error al guardar la información:", error);
    }
  };

  return (
    <form
      onSubmit={handleSubmit}
      className="p-4 space-y-4 bg-white rounded shadow"
    >
      <div>
        <label className="block font-bold">Título:</label>
        <input
          type="text"
          value={title}
          onChange={(e) => setTitle(e.target.value)}
          className="w-full p-2 border rounded"
        />
      </div>

      <div>
        <label className="block font-bold">Subtítulo:</label>
        <input
          type="text"
          value={subtitle}
          onChange={(e) => setSubtitle(e.target.value)}
          className="w-full p-2 border rounded"
        />
      </div>

      <div>
        <h3 className="font-bold">Bloques de Contenido:</h3>
        {blocks.map((block, index) => (
          <div key={index} className="pb-2 mb-4 border-b">
            <label className="block font-bold">
              Tipo de bloque: {block.type}
            </label>

            {block.type === "text" && (
              <textarea
                className="w-full p-2 border rounded"
                value={block.content}
                onChange={(e) =>
                  handleBlockChange(index, "content", e.target.value)
                }
              ></textarea>
            )}

            {(block.type === "image" ||
              block.type === "video" ||
              block.type === "audio") && (
              <input
                type="file"
                accept={block.type + "/*"}
                onChange={(e) => handleFileUpload(index, e.target.files[0])}
              />
            )}
          </div>
        ))}

        <div className="flex space-x-2">
          <button
            type="button"
            onClick={() => addBlock("text")}
            className="px-4 py-2 text-white bg-blue-500 rounded"
          >
            Agregar Texto
          </button>
          <button
            type="button"
            onClick={() => addBlock("image")}
            className="px-4 py-2 text-white bg-green-500 rounded"
          >
            Agregar Imagen
          </button>
          <button
            type="button"
            onClick={() => addBlock("video")}
            className="px-4 py-2 text-white bg-red-500 rounded"
          >
            Agregar Video
          </button>
          <button
            type="button"
            onClick={() => addBlock("audio")}
            className="px-4 py-2 text-white bg-yellow-500 rounded"
          >
            Agregar Audio
          </button>
        </div>
      </div>

      <div className="flex justify-end space-x-2">
        <button
          type="submit"
          className="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600"
        >
          Guardar
        </button>
      </div>
    </form>
  );
};

export default InfoForm;
