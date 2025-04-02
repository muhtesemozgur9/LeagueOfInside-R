import { useState, useEffect } from 'react';
import axios from 'axios';

export const useFixtures = () => {
  const [fixtures, setFixtures] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchFixtures = async () => {
      try {
        await axios.post(`http://dev.insider.com/teams-service/api/fixture/generate`);
        
        const res = await axios.get(`http://dev.insider.com/teams-service/api/fixture/schedule`);
        
        setFixtures(res.data.data);
        setLoading(false);
      } catch (err) {
        setError(err);
        setLoading(false);
      }
    };

    fetchFixtures();
  }, []);

  return { fixtures, loading, error };
};
