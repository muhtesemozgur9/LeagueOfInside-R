import React from "react";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import Home from "./pages/Home";
import FixturesPage from "./pages/FixturesPage";

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/fixtures" element={<FixturesPage />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;
