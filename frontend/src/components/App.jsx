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

  return (
    <div className="flex flex-col min-h-screen">
      {/* Header con botones de inicio de sesión y registro */}
      <Header
        onLoginClick={() => setIsLoginOpen(true)}
        onRegisterClick={() => setIsRegisterOpen(true)}
      />

      {/* Navbar */}
      <Navbar />

      {/* Contenido principal con Sidebar */}
      <div className="flex flex-1">
        {/* Sidebar */}
        <Sidebar />
        {/* Main Content */}
        <MainContent />
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
