import React from "react";
import Login from "./Login";
import Register from "./Register";

const Auth = () => {
  return (
    <div className="flex items-center justify-center min-h-screen bg-gray-100">
      <div className="grid max-w-4xl grid-cols-1 gap-6 p-4 bg-white rounded-lg shadow-lg md:grid-cols-2">
        {/* Formulario de Iniciar Sesión */}
        <div className="p-4 border-r md:border-r-2 md:border-gray-200">
          <Login />
        </div>
        {/* Formulario de Registrarse */}
        <div className="p-4">
          <Register />
        </div>
      </div>
    </div>
  );
};

export default Auth;
