# Flight Management API with Slim and Doctrine

[![CI Pipeline](https://github.com/Alizaher-info/slim-flights-management/actions/workflows/ci.yml/badge.svg)](https://github.com/Alizaher-info/slim-flights-management/actions/workflows/ci.yml)

This project implements a RESTful API for managing flights using Slim 4 Framework and Doctrine ORM.

## Technologies Used

- PHP 8.0+
- Slim Framework 4
- Doctrine ORM 3
- MySQL 8.0 (via Docker)
- Symfony Serializer Component

## Project Setup

### Prerequisites

- PHP 8.0 or higher
- Composer
- Docker and Docker Compose
- Git

### Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd flights
```

2. Install dependencies:
```bash
composer install
```

3. Start the Docker containers:
```bash
docker-compose up -d
```

4. Configure the database:
```bash
# Create database schema
composer migrations:migrate
```

5. Load sample data:
```bash
# Execute the SQL file with sample flights
docker-compose exec db mysql -uslim -pslim flights < db/insert_flights.sql
```

6. Start the development server:
```bash
composer start
```

## Database Configuration

The database connection is configured in two places:
- `app/settings.php`: For the application
- `migrations-db.php`: For Doctrine Migrations

Default database settings:
- Host: 127.0.0.1
- Port: 3307 (mapped from Docker's 3306)
- Database: flights
- User: slim
- Password: slim

## API Endpoints

### GET /flights
Retrieves all flights

Response format:
```json
[
    {
        "id": 1,
        "flightNumber": "LH1234",
        "departure": "Frankfurt",
        "arrival": "Berlin",
        "departureTime": "2025-09-14T10:00:00+02:00",
        "arrivalTime": "2025-09-14T11:15:00+02:00"
    }
]
```

## Development

### Available Commands

#### Database Migrations
```bash
# Generate a new migration
composer migrations:generate

# Create a migration from entity changes
composer migrations:diff

# Execute migrations
composer migrations:migrate

# Show migrations status
composer migrations:status
```

### Project Structure

```
.
├── app/
│   ├── dependencies.php    # DI container configuration
│   ├── middleware.php      # Application middleware
│   ├── routes.php         # Route definitions
│   └── settings.php       # Application settings
├── src/
│   ├── Controller/        # HTTP controllers
│   │   ├── ApiController.php
│   │   └── FlightController.php
│   └── Entity/            # Doctrine entities
│       └── Flight.php
├── migrations/            # Database migrations
├── public/               # Public directory
│   └── index.php         # Application entry point
└── docker-compose.yml    # Docker configuration
```

## Docker Environment

The project includes a Docker setup with:
- MySQL 8.0 database
- Port mapping: 3307:3306

## Contributing

1. Create a new branch for your feature
2. Write your changes
3. Ensure all tests pass locally:
   ```bash
   # Run all checks
   composer test         # Run PHPUnit tests
   vendor/bin/phpcs     # Check code style
   vendor/bin/phpstan   # Run static analysis
   ```
4. Create a pull request

## Continuous Integration & Deployment

This project uses GitHub Actions for CI/CD pipelines:

### CI Pipeline
- Runs on every push and pull request
- Tests on PHP 8.0, 8.1, and 8.2
- Validates composer.json
- Runs code style checks (PSR-12)
- Performs static analysis (PHPStan)
- Executes unit tests with coverage
- Sets up test database and runs migrations

### CD Pipeline
- Triggers on successful merge to main branch
- Performs production deployment:
  - Installs production dependencies
  - Runs database migrations
  - Updates application files
  - Restarts necessary services

## Troubleshooting

### Common Issues

1. Database Connection Issues
   - Check if Docker containers are running
   - Verify database credentials
   - Confirm port mapping (3307)

2. 405 Method Not Allowed
   - Verify HTTP method matches route configuration
   - Check route definitions in `app/routes.php`

3. Serialization Issues
   - DateTime objects are serialized using Symfony Serializer
   - Custom format configuration in dependencies.php

## License

MIT License. See LICENSE file for details.
