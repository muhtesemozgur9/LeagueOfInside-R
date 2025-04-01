import { useState, useEffect } from 'react';
import axios from 'axios';

export const useTeams = () => {
  const [teams, setTeams] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    axios.get('http://dev.insider.com/teams-service/api/teams')
      .then((response) => {
        setTeams(response.data.data);
        setLoading(false);
      })
      .catch((err) => {
        setError(err);
        setLoading(false);
      });
  }, []);

  return { teams, loading, error };
};
