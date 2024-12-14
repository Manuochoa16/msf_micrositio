import React from "react";

const InfoList = ({ data }) => {
  // Asegurarse de que data sea un array
  const validData = Array.isArray(data) ? data : [];

  return (
    <div>
      {validData.length > 0 ? (
        validData.map((item, index) => (
          <div key={index} className="info-item">
            {/* Renderiza el título */}
            <p className="text-lg font-bold">{item.title}</p>

            {/* Renderiza la imagen si existe */}
            {item.image && (
              <img
                src={`data:image/png;base64,${item.image}`}
                alt="Uploaded"
                className="mt-4 rounded shadow-lg"
                style={{ width: "300px", height: "auto" }}
              />
            )}

            {/* Puedes agregar otros elementos, como descripción */}
            {item.description && <p>{item.description}</p>}
          </div>
        ))
      ) : (
        <p>No hay información disponible.</p>
      )}
    </div>
  );
};

export default InfoList;
