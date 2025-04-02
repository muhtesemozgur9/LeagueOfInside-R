import { useState, useEffect } from 'react';
import axios from 'axios';

export const useChampionshipPredictions = (refreshKey) => {
  const [predictions, setPredictions] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    axios.get(`${process.env.REACT_APP_API_URL}/championship-probabilities`)
      .then((res) => {
         const mappedData = res.data.data.map(item => ({
           team: item.team_name,
           percentage: item.championship_probability,
         }));
         setPredictions(mappedData);
         setLoading(false);
      })
      .catch((err) => {
         setError(err);
         setLoading(false);
      });
  }, [refreshKey]);

  return { predictions, loading, error };
};
