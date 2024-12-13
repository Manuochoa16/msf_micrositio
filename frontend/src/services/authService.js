import api from "./api";

// Función para registrar usuario
export const registerUser = async (username, password) => {
  try {
    const response = await api.post("/api.php?endpoint=register", {
      username,
      password,
    });
    return response.data;
  } catch (error) {
    throw error.response.data || "Error en la solicitud";
  }
};

// Función para iniciar sesión
export const loginUser = async (username, password) => {
  try {
    const response = await api.post("/api.php?endpoint=login", {
      username,
      password,
    });
    return response.data;
  } catch (error) {
    throw error.response.data || "Error en la solicitud";
  }
};
