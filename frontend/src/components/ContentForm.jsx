import React, { useState } from "react";

const ContentForm = () => {
  const [showForm, setShowForm] = useState(false);

  return (
    <div>
      {/* Botón para desplegar el formulario */}
      <button
        onClick={() => setShowForm(!showForm)}
        style={{
          margin: "10px",
          padding: "8px 12px",
          background: "#007BFF",
          color: "white",
          border: "none",
          cursor: "pointer",
        }}
      >
        {showForm ? "Cerrar Formulario" : "Agregar Contenido"}
      </button>

      {/* Formulario oculto/visible */}
      {showForm && (
        <form
          style={{
            border: "1px solid #ddd",
            padding: "15px",
            borderRadius: "5px",
          }}
        >
          <div>
            <label>Título:</label>
            <input type="text" />
          </div>
          <div>
            <label>Subtítulo:</label>
            <input type="text" />
          </div>
          <div>
            <label>Descripción:</label>
            <textarea />
          </div>
          <div>
            <label>Imagen:</label>
            <input type="file" accept="image/*" />
          </div>
          <div>
            <label>Audio:</label>
            <input type="file" accept="audio/*" />
          </div>
          <div>
            <label>Video:</label>
            <input type="file" accept="video/*" />
          </div>
          <button
            type="submit"
            style={{
              marginTop: "10px",
              padding: "8px 12px",
              background: "#28A745",
              color: "white",
              border: "none",
            }}
          >
            Guardar
          </button>
        </form>
      )}
    </div>
  );
};

export default ContentForm;
