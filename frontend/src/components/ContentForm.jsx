import React, { useState } from "react";

const ContentForm = () => {
  const [showForm, setShowForm] = useState(false);

  return (
    <div>
      {/* Botón para desplegar el formulario */}
      <button
        onClick={() => setShowForm(!showForm)}
        style={{
          margin: "10px",
          padding: "8px 12px",
          background: "#007BFF",
          color: "white",
          border: "none",
          cursor: "pointer",
        }}
      >
        {showForm ? "Cerrar Formulario" : "Agregar Contenido"}
      </button>

      {/* Formulario oculto/visible */}
      {showForm && (
        <form
          style={{
            border: "1px solid #ddd",
            padding: "15px",
            borderRadius: "5px",
          }}
        >
          <div>
            <label>Título:</label>
            <input type="text" />
          </div>
          <div>
            <label>Subtítulo:</label>
            <input type="text" />
          </div>
          <div>
            <label>Descripción:</label>
            <textarea />
          </div>
          <div>
            <label>Imagen:</label>
            <input type="file" accept="image/*" />
          </div>
          <div>
            <label>Audio:</label>
            <input type="file" accept="audio/*" />
          </div>
          <div>
            <label>Video:</label>
            <input type="file" accept="video/*" />
          </div>
          <button
            type="submit"
            style={{
              marginTop: "10px",
              padding: "8px 12px",
              background: "#28A745",
              color: "white",
              border: "none",
            }}
          >
            Guardar
          </button>
        </form>
      )}
    </div>
  );
};

export default ContentForm;

// Para agregar viñetas
// npm install draft-js

// import React, { useState } from "react";
// import { Editor, EditorState, RichUtils } from "draft-js";
// import "draft-js/dist/Draft.css";

// const ContentForm = () => {
//   const [showForm, setShowForm] = useState(false);
//   const [editorState, setEditorState] = useState(EditorState.createEmpty());

//   const currentStyle = editorState.getCurrentInlineStyle();

//   const handleEditorChange = (newState) => {
//     setEditorState(newState);
//   };

//   const handleInlineStyle = (style) => {
//     setEditorState(RichUtils.toggleInlineStyle(editorState, style));
//   };

//   const handleBlockType = (blockType) => {
//     setEditorState(RichUtils.toggleBlockType(editorState, blockType));
//   };

//   return (
//     <div>
//       {/* Botón para desplegar el formulario */}
//       <button
//         onClick={() => setShowForm(!showForm)}
//         style={{
//           margin: "10px",
//           padding: "8px 12px",
//           background: "#007BFF",
//           color: "white",
//           border: "none",
//           cursor: "pointer",
//         }}
//       >
//         {showForm ? "Cerrar Formulario" : "Agregar Contenido"}
//       </button>

//       {/* Formulario oculto/visible */}
//       {showForm && (
//         <form
//           style={{
//             border: "1px solid #ddd",
//             padding: "15px",
//             borderRadius: "5px",
//           }}
//         >
//           <div>
//             <label>Título:</label>
//             <input type="text" />
//           </div>
//           <div>
//             <label>Subtítulo:</label>
//             <input type="text" />
//           </div>
//           <div>
//             <label>Descripción:</label>
//             {/* Botones para estilos */}
//             <div style={{ marginBottom: "10px" }}>
//               <button
//                 type="button"
//                 onMouseDown={(e) => {
//                   e.preventDefault();
//                   handleInlineStyle("BOLD");
//                 }}
//                 style={{
//                   background: currentStyle.has("BOLD")
//                     ? "#555"
//                     : "#ddd",
//                   color: currentStyle.has("BOLD") ? "white" : "black",
//                   padding: "5px",
//                   marginRight: "5px",
//                 }}
//               >
//                 B
//               </button>
//               <button
//                 type="button"
//                 onMouseDown={(e) => {
//                   e.preventDefault();
//                   handleInlineStyle("ITALIC");
//                 }}
//                 style={{
//                   background: currentStyle.has("ITALIC")
//                     ? "#555"
//                     : "#ddd",
//                   color: currentStyle.has("ITALIC") ? "white" : "black",
//                   padding: "5px",
//                   marginRight: "5px",
//                 }}
//               >
//                 I
//               </button>
//               <button
//                 type="button"
//                 onMouseDown={(e) => {
//                   e.preventDefault();
//                   handleInlineStyle("UNDERLINE");
//                 }}
//                 style={{
//                   background: currentStyle.has("UNDERLINE")
//                     ? "#555"
//                     : "#ddd",
//                   color: currentStyle.has("UNDERLINE") ? "white" : "black",
//                   padding: "5px",
//                   marginRight: "5px",
//                 }}
//               >
//                 U
//               </button>
//               <button
//                 type="button"
//                 onMouseDown={(e) => {
//                   e.preventDefault();
//                   handleBlockType("unordered-list-item");
//                 }}
//                 style={{
//                   padding: "5px",
//                   marginRight: "5px",
//                 }}
//               >
//                 Viñetas
//               </button>
//               <button
//                 type="button"
//                 onMouseDown={(e) => {
//                   e.preventDefault();
//                   handleBlockType("ordered-list-item");
//                 }}
//                 style={{
//                   padding: "5px",
//                   marginRight: "5px",
//                 }}
//               >
//                 Numeración
//               </button>
//             </div>

//             {/* Editor */}
//             <div
//               style={{
//                 border: "1px solid #ddd",
//                 padding: "10px",
//                 borderRadius: "5px",
//               }}
//             >
//               <Editor
//                 editorState={editorState}
//                 onChange={handleEditorChange}
//               />
//             </div>
//           </div>
//           <div>
//             <label>Imagen:</label>
//             <input type="file" accept="image/*" />
//           </div>
//           <div>
//             <label>Audio:</label>
//             <input type="file" accept="audio/*" />
//           </div>
//           <div>
//             <label>Video:</label>
//             <input type="file" accept="video/*" />
//           </div>
//           <button
//             type="submit"
//             style={{
//               marginTop: "10px",
//               padding: "8px 12px",
//               background: "#28A745",
//               color: "white",
//               border: "none",
//             }}
//           >
//             Guardar
//           </button>
//         </form>
//       )}
//     </div>
//   );
// };

// export default ContentForm;
