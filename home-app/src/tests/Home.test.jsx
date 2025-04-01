import React from 'react';
import { render, screen, waitFor } from '@testing-library/react';
import Home from '../pages/Home';
import axios from 'axios';

jest.mock('axios');

describe('Home Page', () => {
  test('renders loading state and then team names', async () => {
    const mockTeams = [
      { team_id: 1, team_name: 'Chelsea' },
      { team_id: 2, team_name: 'Manchester City' }
    ];
    axios.get.mockResolvedValueOnce({ data: { data: mockTeams } });

    render(<Home />);

    expect(screen.getByText(/Loading teams/i)).toBeInTheDocument();

    await waitFor(() => {
      expect(screen.getByText(/Chelsea/i)).toBeInTheDocument();
      expect(screen.getByText(/Manchester City/i)).toBeInTheDocument();
    });
  });

  test('renders error state', async () => {
    axios.get.mockRejectedValueOnce(new Error('Network Error'));
    render(<Home />);
    await waitFor(() => {
      expect(screen.getByText(/Error loading teams/i)).toBeInTheDocument();
    });
  });
});
