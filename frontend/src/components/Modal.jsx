import React, { useState, useEffect } from "react";

const Modal = ({ isOpen, onClose, children }) => {
  const [isVisible, setIsVisible] = useState(false);

  useEffect(() => {
    if (isOpen) {
      setIsVisible(true); // Mostrar modal inmediatamente al abrir
    } else {
      setTimeout(() => setIsVisible(false), 300); // Desmontar tras el fade-out
    }
  }, [isOpen]);

  const handleClose = () => {
    setIsVisible(false);
    setTimeout(() => {
      onClose();
    }, 2000);
  };

  if (!isOpen && !isVisible) return null;

  return (
    <div
      className={`fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300 ${
        isVisible ? "opacity-100" : "opacity-0"
      }`}
    >
      <div
        className={`relative p-6 bg-white rounded shadow-lg transform transition-transform duration-300 ${
          isVisible ? "scale-100" : "scale-90"
        }`}
      >
        <button
          onClick={handleClose}
          className="absolute text-gray-500 top-2 right-2 hover:text-gray-800"
        >
          ✕
        </button>
        {children ? children : <p>No hay contenido en el modal</p>}
      </div>
    </div>
  );
};

export default Modal;
