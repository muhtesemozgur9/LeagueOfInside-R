// src/components/TeamsTable/TeamsTable.jsx
import React from "react";
import PropTypes from "prop-types";
import styles from "./TeamsTable.module.css";

function TeamsTable({ teams }) {
  return (
    <div className={styles.container}>
      <table className={styles.table}>
        <thead>
          <tr>
            <th>Team Name</th>
            <th>P</th>
            <th>W</th>
            <th>D</th>
            <th>L</th>
            <th>GD</th>
          </tr>
        </thead>
        <tbody>
          {teams.map((team, index) => (
            <tr key={index}>
              <td>{team.name}</td>
              <td>{team.played}</td>
              <td>{team.won}</td>
              <td>{team.drawn}</td>
              <td>{team.lost}</td>
              <td>{team.gd}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}

TeamsTable.propTypes = {
  teams: PropTypes.arrayOf(
    PropTypes.shape({
      name: PropTypes.string.isRequired,
      played: PropTypes.number.isRequired,
      won: PropTypes.number.isRequired,
      drawn: PropTypes.number.isRequired,
      lost: PropTypes.number.isRequired,
      gd: PropTypes.number.isRequired,
    })
  ).isRequired,
};

export default TeamsTable;
