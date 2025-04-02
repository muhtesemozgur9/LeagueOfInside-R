import React from "react";
import PropTypes from "prop-types";
import styles from "./WeekCard.module.css";

function WeekCard({ weekNumber, matches, homeAppFixturesUrl }) {
  const handleWeekClick = () => {
    window.location.href = `${homeAppFixturesUrl}?week=${weekNumber}`;
  };

  return (
    <div className={styles.container}>
      <div className={styles.header} onClick={handleWeekClick}>
        Week {weekNumber}
      </div>
      <div className={styles.matches}>
        {matches.map((match, index) => (
          <div key={index} className={styles.matchRow}>
            <div className={styles.teamLeft}>{match.home_team}</div>
            <div className={styles.hyphen}>{match.home_goals ?? ""}-{match.away_goals ?? ""}</div>
            <div className={styles.teamRight}>{match.away_team}</div>
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
  homeAppFixturesUrl: PropTypes.string, 
};

WeekCard.defaultProps = {
  homeAppFixturesUrl: "http://localhost:3000/fixtures",
};

export default WeekCard;
