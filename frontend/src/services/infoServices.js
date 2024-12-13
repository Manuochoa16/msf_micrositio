import axios from "axios";

const API_URL = "http://localhost:8000/api.php";

export const getInfo = async () => {
  try {
    const response = await axios.get(`${API_URL}?endpoint=getInfo`);
    return response.data;
  } catch (error) {
    console.error("Error al obtener la información:", error);
    throw error;
  }
};
