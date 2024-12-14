import React, { useState } from "react";
import axios from "axios";

const InfoForm = ({ onSave }) => {
  const [title, setTitle] = useState("");
  const [subtitle, setSubtitle] = useState("");
  const [description, setDescription] = useState("");
  const [image, setImage] = useState(null);
  const [audio, setAudio] = useState(null);
  const [video, setVideo] = useState(null);
  const [error, setError] = useState("");

  const handleSubmit = async (e) => {
    e.preventDefault();

    const formData = new FormData();
    formData.append("title", title);
    formData.append("subtitle", subtitle);
    formData.append("description", description);
    if (image) formData.append("image", image);
    if (audio) formData.append("audio", audio);
    if (video) formData.append("video", video);

    try {
      const response = await axios.post(
        "http://localhost/api.php?endpoint=saveInfo",
        formData,
        {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        }
      );

      console.log("Respuesta del servidor:", response.data);

      // Limpiar los campos del formulario después del envío exitoso
      setTitle("");
      setSubtitle("");
      setDescription("");
      setImage(null);
      setAudio(null);
      setVideo(null);
      setError("");
    } catch (error) {
      console.error("Error al guardar la información:", error);
      setError(
        "No se pudo guardar la información. Por favor, intenta nuevamente."
      );
    }
  };

  return (
    <form onSubmit={handleSubmit}>
      <div>
        <label>Título:</label>
        <input
          type="text"
          value={title}
          onChange={(e) => setTitle(e.target.value)}
        />
      </div>
      <div>
        <label>Subtítulo:</label>
        <input
          type="text"
          value={subtitle}
          onChange={(e) => setSubtitle(e.target.value)}
        />
      </div>
      <div>
        <label>Descripción:</label>
        <textarea
          value={description}
          onChange={(e) => setDescription(e.target.value)}
        ></textarea>
      </div>
      <div>
        <label>Imagen:</label>
        <input
          type="file"
          accept="image/*"
          onChange={(e) => setImage(e.target.files[0])}
        />
      </div>
      <div>
        <label>Audio:</label>
        <input
          type="file"
          accept="audio/*"
          onChange={(e) => setAudio(e.target.files[0])}
        />
      </div>
      <div>
        <label>Video:</label>
        <input
          type="file"
          accept="video/*"
          onChange={(e) => setVideo(e.target.files[0])}
        />
      </div>
      {error && <p style={{ color: "red" }}>{error}</p>}
      <button type="submit">Guardar</button>
    </form>
  );
};

export default InfoForm;
