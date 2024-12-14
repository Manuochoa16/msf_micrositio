import axios from "axios";

const API_URL = "http://localhost:8000/api.php?endpoint=saveInfo";

export const saveInfo = async (formData) => {
  try {
    const response = await axios.post(API_URL, formData, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    });
    return response.data;
  } catch (error) {
    console.error("Error al guardar la información:", error);
    throw error;
  }
};
