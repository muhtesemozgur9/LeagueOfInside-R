import axios from 'axios';

export const getTeams = async () => {
  const response = await axios.get('http://dev.insider.com/teams-service/api/teams');
  return response.data.data;
};
