import React from "react";
import ReactDOM from "react-dom/client";
import App from "./components/App";
import "./index.css"; // Asegúrate de tener este archivo o cámbialo por el que uses

window.global = window;

ReactDOM.createRoot(document.getElementById("root")).render(
  <React.StrictMode>
    <App />
  </React.StrictMode>
);
