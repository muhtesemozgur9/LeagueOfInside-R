# League of Insider

League of Insider is a cutting-edge sports simulation platform built using a modern microfrontend and microservice architecture. The project integrates multiple React applications with a robust Laravel backend to deliver an interactive, real-time sports analytics experience.

## Table of Contents

- [Overview](#overview)
- [Architecture](#architecture)
- [Features](#features)
- [Installation & Setup](#installation--setup)
- [Configuration](#configuration)
- [Usage](#usage)
- [API Endpoints](#api-endpoints)
- [Makefile Commands](#makefile-commands)
- [Database Initialization](#database-initialization)
- [Development & Testing](#development--testing)

---

## Overview

League of Insider leverages a microfrontend approach for the client side, featuring independent React applications (e.g., **home-app** and **simulation-app**) served under a unified domain via a reverse proxy. The backend is powered by **Teams Service**, a Laravel microservice that handles team management, fixture generation, match simulation, standings, and championship probability calculations. This decoupled architecture ensures high scalability, maintainability, and rapid iteration.

---

## Architecture

- **Microfrontends**  
  - **home-app**: The main React application for live fixtures, standings, and analytics.  
  - **simulation-app**: A dedicated React application for simulation controls and leaderboards.

- **Backend Microservice – Teams Service**  
  - Built with Laravel, structured using the Repository Pattern, Service Layers, and DTOs.  
  - Integrates with MySQL for data persistence and Redis for caching.

- **Reverse Proxy**  
  - An Nginx container routes traffic based on URL paths (e.g., `/home-app`, `/simulation-app`, `/teams-service`).

---

## Features

- **Team Management**: Store team statistics (attack, defense, motivation).  
- **Fixture Generation & Match Simulation**: Generate fixtures, simulate match outcomes, and update standings.  
- **Championship Probability Calculation**: Compute each team’s chance to become the champion based on current and projected results.  
- **Dynamic Leaderboard**: Real-time updates for standings and championship predictions.  
- **RESTful API & Swagger**: Comprehensive endpoints with interactive API documentation.  
- **Dockerized Deployment**: Containerized with Docker Compose.  
- **Makefile Automation**: Simplified build and deployment using `make insider`.

---

## Installation & Setup

### Prerequisites

- Docker & Docker Compose  
- Git

### Steps

1. **Clone the Repository**  
   ```bash
   git clone https://github.com/yourusername/league-of-insider.git
   cd league-of-insider
Configure Environment Variables
Create a .env file in the project root (or copy from .env.example) and update the values:

env
Copy
# Teams Service (Laravel)
APP_ENV=local
APP_DEBUG=1
APP_KEY=base64:YOUR_APP_KEY_HERE

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=teams_service
DB_USERNAME=teams
DB_PASSWORD=secret

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

# Frontend (React)
REACT_APP_API_URL=http://dev.insider.com/teams-service/api
Build and Start Containers
Use the provided Makefile command:

bash
Copy
make insider
This command builds and starts all services defined in docker-compose.yml.

Configuration
The project is fully containerized with Docker Compose. The main services include:

home-app: React frontend on port 3000

simulation-app: React simulation frontend on port 3001

teams-service: Laravel backend on port 8080 (mapped from container port 8000)

db: MySQL service on port 3306

redis: Redis service on port 6379

reverse-proxy: Nginx container that routes requests based on URL paths

In the reverse proxy (nginx.conf), paths are typically mapped like so:

/teams-service/ → Teams Service backend

/home-app/ → Home App

/simulation-app/ → Simulation App

/ → Defaults to Home App

Usage
After starting the containers, access the services at:

Home App: http://dev.insider.com/home-app

Simulation App: http://dev.insider.com/simulation-app

Teams Service API: http://dev.insider.com/teams-service/api

Swagger-based API documentation is available at:

arduino
Copy
http://dev.insider.com/teams-service/api/documentation
API Endpoints
Teams
GET /api/teams
Returns a list of teams.

Fixture Generation
POST /api/fixture/generate
Generates fixtures for all teams.

Fixture Schedule
GET /api/fixtures/schedule
Returns the full fixture schedule with match results.

Latest Fixture Schedule
GET /api/fixtures/latest-schedule
Returns the schedule for the latest played week, or the first week if none have been played.

Match Simulation
POST /api/simulate
Simulates match results for a specified week (or all weeks).

Simulation Reset
POST /api/simulate/reset
Resets all simulation data (match results and standings).

Championship Probabilities
GET /api/championship-probabilities
Returns each team’s chance of winning the championship.

Makefile Commands
A Makefile is included to simplify the build and deployment process. The primary command is:

makefile
Copy
make insider
This command builds the Docker images and starts all services in docker-compose.yml.

Database Initialization
After running make insider, initialize team data by executing the following SQL (using your preferred MySQL client):

sql
Copy
INSERT INTO `teams` (`attack`, `created_at`, `defense`, `motivation`, `team_id`, `team_name`, `updated_at`) VALUES
(95, '2025-03-31 19:18:23', 89, 29, 1, 'Chelsea', '2025-03-31 19:18:23'),
(96, '2025-03-31 19:18:44', 49, 65, 2, 'Manchester City', '2025-03-31 19:18:44'),
(84, '2025-03-31 19:19:04', 45, 100, 3, 'Beşiktaş', '2025-03-31 19:19:36'),
(86, '2025-03-31 19:19:22', 43, 12, 4, 'Barcelona', '2025-03-31 19:19:22');
Development & Testing
Backend
Running Tests

bash
Copy
docker exec -it teams-service-app bash
php artisan test
Code Standards
Follow PSR standards and use tools like PHP CS Fixer and PHPStan to ensure high code quality.

Frontend
Local Development
Each React app (home-app, simulation-app) can be run locally using npm start if needed.

Testing
Use Jest and React Testing Library for unit and integration tests.

With this comprehensive setup, League of Insider offers a production-ready, modular, and scalable platform for sports simulation and analytics. Enjoy building and innovating with our robust microfrontend and microservice architecture!