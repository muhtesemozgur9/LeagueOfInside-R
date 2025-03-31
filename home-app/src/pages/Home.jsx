import React from "react";
import TournamentTeams from "../components/TournamentTeams/TournamentTeams";
import { teamsData } from "../data/teamsData";

function Home() {
  return (
    <div>
      <TournamentTeams teams={teamsData} />
    </div>
  );
}

export default Home;
