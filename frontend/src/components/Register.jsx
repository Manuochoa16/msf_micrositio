import React, { useState } from "react";
import axios from "axios";
import PasswordInput from "./PasswordInput";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faUser, faLock } from "@fortawesome/free-solid-svg-icons";

const Register = ({ onClose }) => {
  const [registerUsername, setRegisterUsername] = useState("");
  const [registerPassword, setRegisterPassword] = useState("");
  const [message, setMessage] = useState("");

  const handleRegister = async () => {
    try {
      const response = await axios.post(
        "http://localhost:8000/api.php?endpoint=register",
        {
          username: registerUsername,
          password: registerPassword,
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
      setMessage("Error al registrar usuario.");
    }
  };

  return (
    <div className="flex flex-col items-center p-6 bg-white rounded-lg shadow-lg">
      <h2 className="mb-4 text-2xl font-bold text-blue-600">Registrarse</h2>
      <form className="space-y-4">
        <div className="relative">
          <input
            type="text"
            placeholder="Nombre de usuario"
            value={registerUsername}
            onChange={(e) => setRegisterUsername(e.target.value)}
            className="w-full p-2 pl-10 border rounded"
          />
          <FontAwesomeIcon
            icon={faUser}
            className="absolute text-gray-500 transform -translate-y-1/2 left-3 top-1/2"
          />
        </div>
        <PasswordInput
          value={registerPassword}
          onChange={(e) => setRegisterPassword(e.target.value)}
          icon={<FontAwesomeIcon icon={faLock} className="text-gray-500" />}
        />
        <button
          type="button"
          onClick={handleRegister}
          className="w-full py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-600"
        >
          Registrarse
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

export default Register;
