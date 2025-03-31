// src/components/SimulationButtons/SimulationButtons.jsx
import React from "react";
import styles from "./SimulationButtons.module.css";

function SimulationButtons() {
  return (
    <div className={styles.container}>
      <button className={styles.playAll}>Play All Weeks</button>
      <button className={styles.playNext}>Play Next Week</button>
      <button className={styles.reset}>Reset Data</button>
    </div>
  );
}

export default SimulationButtons;
