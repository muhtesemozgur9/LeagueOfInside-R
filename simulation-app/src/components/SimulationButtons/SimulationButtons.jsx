import React from "react";
import axios from "axios";
import styles from "./SimulationButtons.module.css";

function SimulationButtons({ currentWeek, matches, onRefresh }) {
  const isCurrentWeekPlayed = () => {
    return matches.every(match => match.home_goals !== null && match.away_goals !== null);
  };

  const handlePlayAllWeeks = async () => {
    try {
      await axios.post(`${process.env.REACT_APP_API_URL}/simulate`);
      onRefresh();
    } catch (error) {
      console.error("Error simulating matches", error);
    }
  };

  const handleResetData = async () => {
    try {
      await axios.post(`${process.env.REACT_APP_API_URL}/simulate/reset`);
      onRefresh();
    } catch (error) {
      console.error("Error resetting data", error);
    }
  };

  const handlePlayNextWeek = async () => {
    try {
      const weekToSimulate = isCurrentWeekPlayed() ? currentWeek + 1 : currentWeek;
      await axios.post(`${process.env.REACT_APP_API_URL}/simulate`, null, {
        params: { week: weekToSimulate }
      });
      onRefresh();
    } catch (error) {
      console.error("Error simulating next week", error);
    }
  };

  return (
    <div className={styles.container}>
      <button className={styles.playAll} onClick={handlePlayAllWeeks}>
        Play All Weeks
      </button>
      <button className={styles.playNext} onClick={handlePlayNextWeek}>
        Play Next Week
      </button>
      <button className={styles.reset} onClick={handleResetData}>
        Reset Data
      </button>
    </div>
  );
}

export default SimulationButtons;
