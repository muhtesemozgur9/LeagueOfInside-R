import React from "react";
import PropTypes from "prop-types";
import styles from "./ChampionshipPredictions.module.css";

function ChampionshipPredictions({ predictions }) {
  return (
    <div className={styles.container}>
      <table className={styles.table}>
        <thead>
          <tr>
            <th>Championship Predictions</th>
            <th>%</th>
          </tr>
        </thead>
        <tbody>
          {predictions.map((item, index) => (
            <tr key={index}>
              <td>{item.team}</td>
              <td>{item.percentage}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}

ChampionshipPredictions.propTypes = {
  predictions: PropTypes.arrayOf(
    PropTypes.shape({
      team: PropTypes.string.isRequired,
      percentage: PropTypes.number.isRequired,
    })
  ).isRequired,
};

export default ChampionshipPredictions;
