League of Insider
League of Insider is a state-of-the-art sports simulation platform built with a modern microfrontend and microservice architecture. The project is designed to deliver an interactive, real-time sports analytics experience by seamlessly integrating multiple React microfrontend applications with a robust Laravel backend service.

Table of Contents
Overview

Architecture

Features

Installation & Setup

Configuration

Running the Project

API Endpoints

Makefile Commands

Database Initialization

Development & Testing

Overview
League of Insider harnesses a microfrontend approach for the client-side with multiple independent React applications—such as home‑app and simulation‑app—working in tandem under a unified domain through a reverse proxy. The backend is powered by the Teams Service, a Laravel microservice that manages teams, fixture generation, match simulation, standings, and championship probability calculations. This decoupled architecture ensures high scalability, maintainability, and the ability to iterate rapidly on individual components of the system.

Architecture
Microfrontend Architecture:

home‑app: The primary React application that displays live data such as fixtures, standings, and detailed team analytics.

simulation‑app: A React application dedicated to simulation aspects, including match simulation controls and leaderboards.

Both microfrontends are built and deployed independently yet served under the same domain using a reverse proxy (Nginx).

Backend Microservice – Teams Service:

Built with Laravel, this service exposes a comprehensive RESTful API for managing teams, generating fixtures, simulating matches, updating standings, and computing championship probabilities.

Implements modern best practices using Repository Pattern, Service Layers, and Data Transfer Objects (DTOs).

Integrates with MySQL for data storage and Redis for caching.

Reverse Proxy:

An Nginx container routes traffic based on URL paths (e.g., /home-app, /simulation-app, /teams-service), ensuring a seamless integration of the microfrontends and backend service.

Features
Team Management:

Store and manage team statistics such as attack, defense, and motivation.

Fixture Generation & Match Simulation:

Automatically generate fixtures where each team plays every other team.

Simulate match outcomes using realistic scoring algorithms.

Update standings dynamically based on match results.

Championship Probability:

Calculate and display the likelihood of each team becoming the champion based on current and projected results.

Dynamic Leaderboard:

Real-time standings and predictions are integrated into the UI, allowing users to see updated leaderboards immediately after simulations.

RESTful API & Swagger Documentation:

Exposes endpoints for teams, fixtures, simulations, and championship predictions.

Interactive API documentation is generated automatically via Swagger (L5-Swagger).

Dockerized Deployment:

All components (React apps, Laravel backend, MySQL, Redis, and Nginx reverse proxy) are containerized and orchestrated using Docker Compose.

A Makefile streamlines the build and deployment process.

Installation & Setup
Prerequisites
Docker & Docker Compose

Git

Steps
Clone the Repository:

bash
Copy
git clone https://github.com/muhtesemozgur9/LeagueOfInsider.git
cd league-of-insider
Configure Environment Variables:

Create a .env file in the project root (or copy from the provided .env.example) and update the necessary values for the backend service (Teams Service) and React apps:

env
Copy
# Backend (Laravel)
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
Database Initialization:

After the containers are up, run the migrations and seed data in the Teams Service:

bash
Copy
docker exec -it teams-service-app bash
php artisan migrate --seed
Additionally, initialize team data by executing the provided SQL inserts.

Configuration
The project is fully containerized with Docker Compose. The primary services include:

home-app: React frontend served on port 3000

simulation-app: React simulation frontend served on port 3001

teams-service: Laravel backend served on port 8080 (mapped from container port 8000)

db: MySQL service on port 3306

redis: Redis service on port 6379

reverse-proxy: Nginx container routing requests based on URL paths (e.g., /home-app, /simulation-app, /teams-service)

Running the Project
To build and run all services, use the Makefile command:

bash
Copy
make insider
This command builds the Docker images and starts all containers defined in docker-compose.yml.

API Endpoints
Key endpoints include:

Teams:
GET /api/teams
Returns a list of teams.

Fixture Generation:
POST /api/fixture/generate
Generates fixtures for all teams.

Fixture Schedule:
GET /api/fixtures/schedule
Returns the full fixture schedule with match results.

Latest Fixture Schedule:
GET /api/fixtures/latest-schedule
Returns the schedule for the latest played week, or the first week if none have been played.

Match Simulation:
POST /api/simulate
Simulates match results for a specified week (or all weeks).

Simulation Reset:
POST /api/simulate/reset
Resets all simulation data (match results and standings).

Championship Probabilities:
GET /api/championship-probabilities
Returns the championship probability for each team.

Championship Predictions:
Same as above, used to populate the leaderboard.

Interactive API documentation is available at:

arduino
Copy
http://dev.insider.com/teams-service/api/documentation
Makefile Commands
A Makefile is provided to simplify the build and deployment process. The primary command is:

makefile
Copy
insider: all
Running:

bash
Copy
make insider
will build and start all services defined in docker-compose.yml.

Development & Testing
For backend development:

Running Tests:

bash
Copy
docker exec -it teams-service-app bash
php artisan test
Coding Standards:
Adhere to PSR standards. Use tools like PHP CS Fixer and PHPStan to maintain high code quality.

For frontend development:

Local Development:
React apps are built with Create React App. Use npm start for local development if not using Docker.

Testing:
Use Jest and React Testing Library to write unit tests for your components and hooks.