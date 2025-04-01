import React from "react";
import styles from "./TournamentTeams.module.css";
import PropTypes from "prop-types";
import { useNavigate } from "react-router-dom";
import Button from "../common/Button";

function TournamentTeams({ teams }) {
  const navigate = useNavigate();

  const handleGenerateFixtures = () => {
    navigate("/fixtures");
  };

  return (
    <div className={styles.container}>
      <h1 className={styles.title}>Tournament Teams</h1>
      <table className={styles.table}>
        <thead>
          <tr>
            <th className={styles.headerCell}>Team Name</th>
          </tr>
        </thead>
        <tbody>
          {teams.map((team, index) => (
            <tr key={index} className={styles.row}>
              <td className={styles.cell}>{team}</td>
            </tr>
          ))}
        </tbody>
      </table>
      <Button onClick={handleGenerateFixtures}>Generate Fixtures</Button>
    </div>
  );
}

TournamentTeams.propTypes = {
  teams: PropTypes.arrayOf(PropTypes.string).isRequired
};

export default TournamentTeams;
