// src/components/WeekCard/WeekCard.jsx
import React from "react";
import PropTypes from "prop-types";
import styles from "./WeekCard.module.css";

function WeekCard({ weekNumber, matches, homeAppFixturesUrl }) {
  const handleWeekClick = () => {
    // Mikro frontend senaryosunda, harici bir link:
    window.location.href = `${homeAppFixturesUrl}?week=${weekNumber}`;
    // Örneğin: http://home-app-domain/fixtures?week=1
  };

  return (
    <div className={styles.container}>
      <div className={styles.header} onClick={handleWeekClick}>
        Week {weekNumber}
      </div>
      <div className={styles.matches}>
        {matches.map((match, index) => (
          <div key={index} className={styles.matchRow}>
            <div className={styles.teamLeft}>{match.home}</div>
            <div className={styles.hyphen}>-</div>
            <div className={styles.teamRight}>{match.away}</div>
          </div>
        ))}
      </div>
    </div>
  );
}

WeekCard.propTypes = {
  weekNumber: PropTypes.number.isRequired,
  matches: PropTypes.arrayOf(
    PropTypes.shape({
      home: PropTypes.string.isRequired,
      away: PropTypes.string.isRequired,
    })
  ).isRequired,
  homeAppFixturesUrl: PropTypes.string, // Örnek: "http://localhost:3000/fixtures"
};

WeekCard.defaultProps = {
  homeAppFixturesUrl: "http://localhost:3000/fixtures",
};

export default WeekCard;
