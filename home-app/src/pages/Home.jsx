import React from "react";
import TournamentTeams from "../components/TournamentTeams/TournamentTeams";
import { useTeams } from "../hooks/useTeams";

function Home() {
  const { teams, loading, error } = useTeams();

  if (loading) return <div>Loading teams...</div>;
  if (error) return <div>Error loading teams: {error.message}</div>;

  const teamNames = teams.map(team => team.team_name);

  return (
    <div>
      <TournamentTeams teams={teamNames} />
    </div>
  );
}

export default Home;
