import api from "./api";

// Guardar información con archivos
export const saveInfo = async (formData) => {
  try {
    const response = await api.post("/api.php?endpoint=saveFile", formData, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    });
    return response.data;
  } catch (error) {
    throw error.response.data || "Error en la solicitud";
  }
};

// Obtener información
export const getInfo = async () => {
  try {
    const response = await api.get("/api.php?endpoint=getFiles");
    return response.data;
  } catch (error) {
    throw error.response.data || "Error en la solicitud";
  }
};
