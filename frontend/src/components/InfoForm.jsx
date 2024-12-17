import React, { useState } from "react";
import axios from "axios";
import { Editor, EditorState, RichUtils, convertToRaw } from "draft-js";
import "draft-js/dist/Draft.css";

// Definir estilos personalizados para colores
const customStyleMap = {
  RED: { color: "red" },
  GREEN: { color: "green" },
  BLUE: { color: "blue" },
};

const InfoForm = ({ onSave }) => {
  const [title, setTitle] = useState("");
  const [subtitle, setSubtitle] = useState("");
  const [editorState, setEditorState] = useState(EditorState.createEmpty());
  const [image, setImage] = useState(null);
  const [audio, setAudio] = useState(null);
  const [video, setVideo] = useState(null);
  const [error, setError] = useState("");

  const currentStyle = editorState.getCurrentInlineStyle();

  const handleEditorChange = (newState) => {
    setEditorState(newState);
  };

  const handleInlineStyle = (style) => {
    setEditorState(RichUtils.toggleInlineStyle(editorState, style));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    const rawContent = JSON.stringify(
      convertToRaw(editorState.getCurrentContent())
    );

    const formData = new FormData();
    formData.append("title", title);
    formData.append("subtitle", subtitle);
    formData.append("description", rawContent);
    if (image) formData.append("image", image);
    if (audio) formData.append("audio", audio);
    if (video) formData.append("video", video);

    try {
      const response = await axios.post(
        "http://localhost/api.php?endpoint=saveInfo",
        formData,
        { headers: { "Content-Type": "multipart/form-data" } }
      );
      console.log("Respuesta del servidor:", response.data);

      // Limpiar campos
      setTitle("");
      setSubtitle("");
      setEditorState(EditorState.createEmpty());
      setImage(null);
      setAudio(null);
      setVideo(null);
      setError("");
    } catch (error) {
      console.error("Error al guardar la información:", error);
      setError(
        "No se pudo guardar la información. Por favor, intenta nuevamente."
      );
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
        <label className="block mb-2 font-bold">Descripción:</label>

        {/* Botones de estilo */}
        <div className="flex mb-2 space-x-2">
          <button
            type="button"
            onMouseDown={(e) => {
              e.preventDefault();
              handleInlineStyle("BOLD");
            }}
            className={`px-2 py-1 rounded hover:bg-gray-400 ${
              currentStyle.has("BOLD")
                ? "bg-gray-600 text-white font-bold"
                : "bg-gray-300"
            }`}
          >
            B
          </button>
          <button
            type="button"
            onMouseDown={(e) => {
              e.preventDefault();
              handleInlineStyle("ITALIC");
            }}
            className={`px-2 py-1 rounded hover:bg-gray-400 ${
              currentStyle.has("ITALIC")
                ? "bg-gray-600 text-white italic"
                : "bg-gray-300"
            }`}
          >
            I
          </button>
          <button
            type="button"
            onMouseDown={(e) => {
              e.preventDefault();
              handleInlineStyle("UNDERLINE");
            }}
            className={`px-2 py-1 rounded hover:bg-gray-400 ${
              currentStyle.has("UNDERLINE")
                ? "bg-gray-600 text-white underline"
                : "bg-gray-300"
            }`}
          >
            U
          </button>

          {/* Botones de colores */}
          <button
            type="button"
            onMouseDown={(e) => {
              e.preventDefault();
              handleInlineStyle("RED");
            }}
            className={`px-2 py-1 text-white rounded bg-red-500 hover:bg-red-600`}
          >
            Rojo
          </button>
          <button
            type="button"
            onMouseDown={(e) => {
              e.preventDefault();
              handleInlineStyle("GREEN");
            }}
            className={`px-2 py-1 text-white rounded bg-green-500 hover:bg-green-600`}
          >
            Verde
          </button>
          <button
            type="button"
            onMouseDown={(e) => {
              e.preventDefault();
              handleInlineStyle("BLUE");
            }}
            className={`px-2 py-1 text-white rounded bg-blue-500 hover:bg-blue-600`}
          >
            Azul
          </button>
        </div>

        {/* Editor */}
        <div className="p-2 bg-gray-100 border rounded">
          <Editor
            editorState={editorState}
            onChange={handleEditorChange}
            customStyleMap={customStyleMap} // Agregar estilos personalizados
          />
        </div>
      </div>

      {/* Campos de archivos */}
      <div>
        <label className="block font-bold">Imagen:</label>
        <input
          type="file"
          accept="image/*"
          onChange={(e) => setImage(e.target.files[0])}
          className="w-full"
        />
      </div>

      <div>
        <label className="block font-bold">Audio:</label>
        <input
          type="file"
          accept="audio/*"
          onChange={(e) => setAudio(e.target.files[0])}
          className="w-full"
        />
      </div>

      <div>
        <label className="block font-bold">Video:</label>
        <input
          type="file"
          accept="video/*"
          onChange={(e) => setVideo(e.target.files[0])}
          className="w-full"
        />
      </div>

      {error && <p className="text-red-500">{error}</p>}

      <div className="flex justify-end space-x-2">
        <button
          type="submit"
          className="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600"
        >
          Guardar
        </button>
        <button
          type="button"
          onClick={() => {
            setTitle("");
            setSubtitle("");
            setEditorState(EditorState.createEmpty());
            setImage(null);
            setAudio(null);
            setVideo(null);
          }}
          className="px-4 py-2 text-white bg-gray-400 rounded hover:bg-gray-500"
        >
          Cancelar
        </button>
      </div>
    </form>
  );
};

export default InfoForm;
