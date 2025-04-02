import { useState, useEffect } from 'react';
import axios from 'axios';

export const useLatestSchedule = (refreshKey) => {
  const [latestSchedule, setLatestSchedule] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    axios.get(`${process.env.REACT_APP_API_URL}/fixture/schedule/latest`)
      .then((res) => {
        setLatestSchedule(res.data.data);
        setLoading(false);
      })
      .catch((err) => {
        setError(err);
        setLoading(false);
      });
  }, [refreshKey]);

  return { latestSchedule, loading, error };
};
