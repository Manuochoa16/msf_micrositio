import React from "react";

const InfoList = ({ data }) => {
  // Asegurarse de que data sea un array
  const validData = Array.isArray(data) ? data : [];

  return (
    <div>
      {validData.length > 0 ? (
        validData.map((item, index) => (
          <div key={index}>
            {/* Renderiza los datos */}
            <p>{item.title}</p>
          </div>
        ))
      ) : (
        <p>No hay información disponible.</p>
      )}
    </div>
  );
};

export default InfoList;
