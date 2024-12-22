import React, { useState } from "react";
import Header from "./Header";
import Navbar from "./Navbar";
import Sidebar from "./Sidebar";
import MainContent from "./MainContent";
import Footer from "./Footer";
import Modal from "./Modal";
import Login from "./Login";

const App = () => {
  const [isLoginOpen, setIsLoginOpen] = useState(false);
  const [isAuthenticated, setIsAuthenticated] = useState(false); // Nuevo estado
  const [user, setUser] = useState(null); // Almacena el nombre del usuario

  const handleLogin = (username) => {
    setIsAuthenticated(true);
    setUser(username); // Establecer el nombre del usuario
    setIsLoginOpen(false);
  };

  const handleLogout = () => {
    setIsAuthenticated(false);
    setUser(null); // Limpiar usuario
  };

  const [currentSection, setCurrentSection] = useState("Estándares generales");

  return (
    <div className="flex flex-col min-h-screen">
      <Header
        onLoginClick={() => setIsLoginOpen(true)}
        isAuthenticated={isAuthenticated}
        user={user}
        onLogout={handleLogout}
      />
      <Navbar onSectionChange={setCurrentSection} />
      <div className="flex flex-1">
        <Sidebar />
        <MainContent
          currentSection={currentSection}
          isAuthenticated={isAuthenticated}
        />
      </div>
      <Footer />
      {isLoginOpen && (
        <Modal isOpen={isLoginOpen} onClose={() => setIsLoginOpen(false)}>
          <Login
            onLogin={(username) => handleLogin(username)}
            onClose={() => setIsLoginOpen(false)}
          />
        </Modal>
      )}
    </div>
  );
};

export default App;
