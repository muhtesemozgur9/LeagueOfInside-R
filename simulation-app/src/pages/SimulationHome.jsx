import React, { useState } from "react";
import TeamsTable from "../components/TeamsTable/TeamsTable";
import WeekCard from "../components/WeekCard/WeekCard";
import ChampionshipPredictions from "../components/ChampionshipPredictions/ChampionshipPredictions";
import SimulationButtons from "../components/SimulationButtons/SimulationButtons";
import SimulationLayout from "../components/SimulationLayout/SimulationLayout";
import { useStandings } from "../hooks/useStandings";
import { useLatestSchedule } from "../hooks/useLatestSchedule";
import { useChampionshipPredictions } from "../hooks/useChampionshipPredictions";

function SimulationHome() {
  const [refreshKey, setRefreshKey] = useState(0);
  const { standings, loading: standingsLoading, error: standingsError } = useStandings(refreshKey);
  const { latestSchedule, loading: scheduleLoading, error: scheduleError } = useLatestSchedule(refreshKey);
  const { predictions, loading: predictionsLoading, error: predictionsError } = useChampionshipPredictions(refreshKey);

  const refreshData = () => {
    setRefreshKey(prev => prev + 1);
  };

  if (standingsLoading || scheduleLoading || predictionsLoading) {
    return <div>Loading...</div>;
  }
  if (standingsError) {
    return <div>Error loading standings: {standingsError.message}</div>;
  }
  if (scheduleError) {
    return <div>Error loading schedule: {scheduleError.message}</div>;
  }
  if (predictionsError) {
    return <div>Error loading predictions: {predictionsError.message}</div>;
  }

  const scheduleData = latestSchedule || { week: 1, matches: [] };

  return (
    <div>
      <SimulationLayout title="Simulation">
        <TeamsTable teams={standings} />
        <WeekCard weekNumber={scheduleData.week} matches={scheduleData.matches} />
        <ChampionshipPredictions predictions={predictions} />
      </SimulationLayout>
      <SimulationButtons 
        currentWeek={scheduleData.week} 
        matches={scheduleData.matches} 
        onRefresh={refreshData}
      />
    </div>
  );
}

export default SimulationHome;
