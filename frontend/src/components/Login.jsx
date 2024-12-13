import React, { useState } from "react";
import axios from "axios";
import PasswordInput from "./PasswordInput";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faUser, faLock } from "@fortawesome/free-solid-svg-icons";

const Login = ({ onClose }) => {
  const [loginUsername, setLoginUsername] = useState("");
  const [loginPassword, setLoginPassword] = useState("");
  const [message, setMessage] = useState("");

  const handleLogin = async () => {
    try {
      const response = await axios.post(
        "http://localhost:8000/api.php?endpoint=login",
        {
          username: loginUsername,
          password: loginPassword,
        }
      );
      if (response.data.message) {
        setMessage(response.data.message);

        // Cerrar modal automáticamente después de 2 segundos
        setTimeout(() => {
          onClose();
        }, 2000);
      } else if (response.data.error) {
        setMessage(response.data.error);
      }
    } catch (error) {
      setMessage("Error al iniciar sesión.");
    }
  };

  return (
    <div className="flex flex-col items-center p-6 bg-white rounded-lg shadow-lg">
      <h2 className="mb-4 text-2xl font-bold text-green-600">Iniciar Sesión</h2>
      <form className="space-y-4">
        <div className="relative">
          <input
            type="text"
            placeholder="Nombre de usuario"
            value={loginUsername}
            onChange={(e) => setLoginUsername(e.target.value)}
            className="w-full p-2 pl-10 border rounded"
          />
          <FontAwesomeIcon
            icon={faUser}
            className="absolute text-gray-500 transform -translate-y-1/2 left-3 top-1/2"
          />
        </div>
        <PasswordInput
          value={loginPassword}
          onChange={(e) => setLoginPassword(e.target.value)}
          icon={<FontAwesomeIcon icon={faLock} className="text-gray-500" />}
        />
        <button
          type="button"
          onClick={handleLogin}
          className="w-full py-2 font-bold text-white bg-green-500 rounded hover:bg-green-600"
        >
          Iniciar Sesión
        </button>
        <button
          type="button"
          onClick={onClose}
          className="w-full py-2 mt-2 font-bold text-gray-500 bg-gray-200 rounded hover:bg-gray-300"
        >
          Cerrar ahora
        </button>
      </form>
      {message && (
        <p className="mt-4 text-sm text-center text-red-500">{message}</p>
      )}
    </div>
  );
};

export default Login;