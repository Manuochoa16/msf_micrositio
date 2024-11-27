import React from "react";
import "./ContentGrid.css";

const ContentGrid = () => {
  const sections = [
    {
      title: "Estándares Generales",
      items: [
        "Uso del logo",
        "Tipografía",
        "Colores",
        "Iconografía",
        "Uso de imágenes y videos",
        "Cómo filmarse/sacar fotos",
      ],
    },
    {
      title: "Estilo y formato en RRSS",
      items: [
        "Instagram",
        "Facebook",
        "Twitter",
        "LinkedIn",
        "YouTube",
        "TikTok",
        "Canal de WhatsApp",
      ],
    },
    {
      title: "Anuncios",
      items: ["Meta", "LinkedIn", "YouTube", "TikTok", "Google"],
    },
    {
      title: "Piezas Gráficas",
      items: ["Banners", "Flyers", "Folletos", "Presentaciones", "Uso de QR"],
    },
    {
      title: "Archivos Editables",
      items: [
        "Cómo compartir archivos editables",
        "Empaquetado en Photoshop",
        "Empaquetado en Illustrator",
        "Empaquetado en Premiere Pro",
        "Empaquetado en After Effects",
        "Empaquetado en InDesign",
        "Empaquetado en Audition",
        "Empaquetado en Acrobat",
        "Editable en Canva",
      ],
    },
  ];

  return (
    <div className="content-grid">
      {sections.map((section, index) => (
        <div key={index} className="grid-section">
          <h2>{section.title}</h2>
          <ul>
            {section.items.map((item, idx) => (
              <li key={idx}>{item}</li>
            ))}
          </ul>
        </div>
      ))}
    </div>
  );
};

export default ContentGrid;
