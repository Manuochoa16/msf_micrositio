import React, { useState } from "react";
import Header from "./Header";
import Navbar from "./Navbar";
import Sidebar from "./Sidebar";
import MainContent from "./MainContent";
import Footer from "./Footer";
import Modal from "./Modal";
import Login from "./Login";
import Register from "./Register";

const App = () => {
  const [isLoginOpen, setIsLoginOpen] = useState(false);
  const [isRegisterOpen, setIsRegisterOpen] = useState(false);

  // Estado para manejar la sección activa
  const [currentSection, setCurrentSection] = useState("Estándares generales");

  return (
    <div className="flex flex-col min-h-screen">
      {/* Header con botones de inicio de sesión y registro */}
      <Header
        onLoginClick={() => setIsLoginOpen(true)}
        onRegisterClick={() => setIsRegisterOpen(true)}
      />

      {/* Navbar pasa la función para cambiar la sección */}
      <Navbar onSectionChange={setCurrentSection} />

      {/* Contenido principal con Sidebar */}
      <div className="flex flex-1">
        {/* Sidebar */}
        <Sidebar />

        {/* Main Content recibe la sección seleccionada */}
        <MainContent currentSection={currentSection} />
      </div>

      {/* Footer */}
      <Footer />

      {/* Modales */}
      {isLoginOpen && (
        <Modal isOpen={isLoginOpen} onClose={() => setIsLoginOpen(false)}>
          <Login onClose={() => setIsLoginOpen(false)} />
        </Modal>
      )}
      {isRegisterOpen && (
        <Modal isOpen={isRegisterOpen} onClose={() => setIsRegisterOpen(false)}>
          <Register onClose={() => setIsRegisterOpen(false)} />
        </Modal>
      )}
    </div>
  );
};

export default App;
