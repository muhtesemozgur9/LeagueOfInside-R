import React from "react";
import PropTypes from "prop-types";
import styles from "./SimulationLayout.module.css";

const SimulationLayout = ({ title, children }) => {
  return (
    <div className={styles.container}>
      {title && <h1 className={styles.title}>{title}</h1>}
      <div className={styles.topRow}>{children}</div>
    </div>
  );
};

SimulationLayout.propTypes = {
  title: PropTypes.string,
  children: PropTypes.node.isRequired,
};

export default SimulationLayout;
