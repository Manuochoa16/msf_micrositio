import React from "react";
import Header from "./Header";
import Navbar from "./Navbar";
import MainContent from "./MainContent";
import Footer from "./Footer";
import Sidebar from "./Sidebar";

const App = () => {
  return (
    <div className="flex flex-col min-h-screen">
      {/* Header */}
      <Header />

      {/* Navbar horizontal */}
      <Navbar />

      {/* Contenido principal con Sidebar y MainContent */}
      <div className="flex flex-1 mt-4">
        {/* Sidebar */}
        <Sidebar />

        {/* Main Content */}
        <div className="flex-1 p-4">
          <MainContent />
        </div>
      </div>

      {/* Footer */}
      <Footer />
    </div>
  );
};

export default App;
