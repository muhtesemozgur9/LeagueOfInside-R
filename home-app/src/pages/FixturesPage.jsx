// src/pages/FixturesPage.jsx

import React from "react";
import { fixturesData } from "../data/fixturesData";
import Fixture from "../components/Fixture/Fixture";
import styles from "../components/Fixture/Fixture.module.css";
import Button from "../components/common/Button";


function FixturesPage() {
    const handleStartSimulation = () => {
        // Butona tıklandığında yapılacaklar
        console.log("Simulation started!");
      };

  return (
    <div className={styles.container}>
      <h1 className={styles.pageTitle}>Generated Fixtures</h1>

      <div className={styles.weeksContainer}>
        {fixturesData.map((weekObj) => (
          <div key={weekObj.week} className={styles.weekBlock}>
            <div className={styles.weekHeader}>Week {weekObj.week}</div>
            <div className={styles.matchesContainer}>
              {weekObj.matches.map((match, idx) => (
                <div key={idx} className={styles.matchRow}>
                  <Fixture home={match.home} away={match.away} />
                </div>
              ))}
            </div>
          </div>
        ))}
      </div>

      <Button onClick={handleStartSimulation}>Start Simulation</Button>
    </div>
  );
}

export default FixturesPage;
