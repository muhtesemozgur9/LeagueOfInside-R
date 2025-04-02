import React from "react";
import Fixture from "../components/Fixture/Fixture";
import Button from "../components/common/Button";
import { useFixtures } from "../hooks/useFixtures";
import styles from "../components/Fixture/Fixture.module.css";

function FixturesPage() {
  const { fixtures, loading, error } = useFixtures();

  const handleStartSimulation = () => {
      window.location.href = "simulation-app"
  };

  if (loading) return <div>Loading fixtures...</div>;
  if (error) return <div>Error: {error.message}</div>;

  return (
    <div className={styles.container}>
      <h1 className={styles.pageTitle}>Generated Fixtures</h1>

      <div className={styles.weeksContainer}>
        {fixtures.map((weekObj) => (
          <div key={weekObj.week} className={styles.weekBlock}>
            <div className={styles.weekHeader}>Week {weekObj.week}</div>
            <div className={styles.matchesContainer}>
              {weekObj.matches.map((match, idx) => (
                <div key={idx} className={styles.matchRow}>
                  <Fixture 
                    home={match.home_team} 
                    away={match.away_team}
                    homeGoal={match.home_goals}
                    awayGoal={match.away_goals} 
                  />
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
