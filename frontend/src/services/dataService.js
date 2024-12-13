import axios from "axios";

const API_URL = "http://localhost:8000/api.php";

// Obtener información
export const getInfo = async () => {
  try {
    const response = await axios.get(`${API_URL}?endpoint=getInfo`);
    return response.data;
  } catch (error) {
    console.error("Error al obtener la información:", error);
    throw error;
  }
};

// Guardar información
export const saveInfo = async (title, subtitle, description) => {
  try {
    const formData = new FormData();
    formData.append("title", title);
    formData.append("subtitle", subtitle);
    formData.append("description", description);

    const response = await axios.post(`${API_URL}?endpoint=saveInfo`, formData);
    return response.data;
  } catch (error) {
    console.error("Error al guardar la información:", error);
    throw error;
  }
};

// Actualizar información
export const updateInfo = async (id, title, subtitle, description) => {
  try {
    const formData = new FormData();
    formData.append("id", id);
    formData.append("title", title);
    formData.append("subtitle", subtitle);
    formData.append("description", description);

    const response = await axios.post(
      `${API_URL}?endpoint=updateInfo`,
      formData
    );
    return response.data;
  } catch (error) {
    console.error("Error al actualizar la información:", error);
    throw error;
  }
};
