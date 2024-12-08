import React, { useState } from "react";

const Header = () => {
  const [language, setLanguage] = useState("ES"); // Idioma inicial: Español

  return (
    <header className="flex items-center justify-between p-4 bg-white shadow">
      {/* Izquierda: Texto que cambia según el idioma */}
      <div className="text-left">
        <h1 className="text-xl font-bold">
          {language === "ES"
            ? "Médicos Sin Fronteras"
            : "Médicos Sin Fronteras"}
        </h1>
        <p className="text-sm text-gray-600">
          {language === "ES"
            ? "Manual de identidad visual"
            : "Visual Identity Manual"}
        </p>
      </div>

      {/* Centro: Logo */}
      <div className="flex items-center">
        <img src="/logomsf.png" alt="Logotipo MSF" className="h-16" />
      </div>

      {/* Derecha: Botón para cambiar idioma */}
      <div className="flex gap-2 text-sm">
        <button
          className={`cursor-pointer ${language === "ES" ? "font-bold" : ""}`}
          onClick={() => setLanguage("ES")} // Cambiar a español
        >
          ES
        </button>
        <button
          className={`cursor-pointer ${language === "EN" ? "font-bold" : ""}`}
          onClick={() => setLanguage("EN")} // Cambiar a inglés
        >
          EN
        </button>
      </div>
    </header>
  );
};

export default Header;
