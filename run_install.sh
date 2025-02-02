#!/bin/bash

set -e  # Exit on failure

echo "Starting Event Management System..."

# Check if Docker is installed
if ! command -v docker &> /dev/null; then
    echo "Docker is not installed. Please install Docker and try again."
    exit 1
fi

# Check if Docker Compose is installed
if ! command -v docker-compose &> /dev/null; then
    echo "Docker Compose is not installed. Please install Docker Compose and try again."
    exit 1
fi

# Build and start Docker containers
echo "Building and starting Docker containers..."
docker-compose up --build -d

# Wait for MySQL to be fully ready
echo "Waiting for MySQL to start..."
until docker exec mysql-db mysqladmin ping -h"localhost" --silent; do
    sleep 2
done

# Copy migration SQL file to container
echo "Copying migration file..."
docker cp ./docs/migrate_schema.sql mysql-db:/migrate_schema.sql

# Run database migrations
echo "Initializing database..."
docker exec -i mysql-db mysql -u root -p mysql event_management < ./docs/migrate_schema.sql || { echo "Database migration failed"; sleep 500; }

echo "Event Management System is up and running at http://localhost:8080"
