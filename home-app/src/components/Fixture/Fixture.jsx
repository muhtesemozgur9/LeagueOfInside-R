import React from "react";
import PropTypes from "prop-types";
import styles from "./Fixture.module.css";

const Fixture = ({ home, away, homeGoal, awayGoal }) => {
  return (
    <div className={styles.fixture}>
      <div className={styles.teamLeft}>{home}</div>
      <div className={styles.hyphen}>{homeGoal ?? ""} - {awayGoal ?? ""}</div>
      <div className={styles.teamRight}>{away}</div>
      
    </div>
  );
};

Fixture.propTypes = {
  home: PropTypes.string.isRequired,
  away: PropTypes.string.isRequired,
};

export default Fixture;
