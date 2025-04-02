import { useState, useEffect } from 'react';
import axios from 'axios';

export const useStandings = (refreshKey) => {
  const [standings, setStandings] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    axios
      .get(`${process.env.REACT_APP_API_URL}/standings`)
      .then((res) => {
        const mappedData = res.data.data.map((row) => ({
          name: row.team_name,
          played: row.played,
          won: row.wins,
          drawn: row.draws,
          lost: row.losses,
          gd: row.goal_difference,
        }));
        setStandings(mappedData);
        setLoading(false);
      })
      .catch((err) => {
        setError(err);
        setLoading(false);
      });
  }, [refreshKey]);

  return { standings, loading, error };
};
