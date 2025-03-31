// src/pages/SimulationHome.jsx
import React from "react";
import TeamsTable from "../components/TeamsTable/TeamsTable";
import WeekCard from "../components/WeekCard/WeekCard";
import ChampionshipPredictions from "../components/ChampionshipPredictions/ChampionshipPredictions";
import SimulationButtons from "../components/SimulationButtons/SimulationButtons";
import SimulationLayout from "../components/SimulationLayout/SimulationLayout";

import { teamsData } from "../data/teamsData";
import { predictionsData } from "../data/predictionsData";

function SimulationHome() {
  // Örnek "Week 1" maçları
  const weekOneMatches = [
    { home: "Liverpool", away: "Arsenal" },
    { home: "Manchester City", away: "Chelsea" },
  ];

  return (
    <div>
      <SimulationLayout title="Simulation">
        <TeamsTable teams={teamsData} />
        <WeekCard weekNumber={1} matches={weekOneMatches} />
        <ChampionshipPredictions predictions={predictionsData} />
      </SimulationLayout>
      <SimulationButtons />
    </div>
  );
}

export default SimulationHome;
