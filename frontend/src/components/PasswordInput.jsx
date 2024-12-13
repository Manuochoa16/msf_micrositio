import React, { useState } from "react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faEye, faEyeSlash, faLock } from "@fortawesome/free-solid-svg-icons";

const PasswordInput = ({ value, onChange, placeholder = "Contraseña" }) => {
  const [isVisible, setIsVisible] = useState(false);

  const toggleVisibility = () => {
    setIsVisible(!isVisible);
  };

  return (
    <div className="relative">
      <input
        type={isVisible ? "text" : "password"}
        value={value}
        onChange={onChange}
        placeholder={placeholder}
        className="w-full p-2 pl-10 pr-10 border rounded"
      />
      {/* Icono del candado */}
      <FontAwesomeIcon
        icon={faLock}
        className="absolute text-gray-500 transform -translate-y-1/2 left-3 top-1/2"
      />
      {/* Botón de visibilidad */}
      <button
        type="button"
        onClick={toggleVisibility}
        className="absolute transform -translate-y-1/2 right-3 top-1/2 focus:outline-none"
      >
        <FontAwesomeIcon
          icon={isVisible ? faEyeSlash : faEye}
          className="text-gray-500 hover:text-gray-700"
        />
      </button>
    </div>
  );
};

export default PasswordInput;
