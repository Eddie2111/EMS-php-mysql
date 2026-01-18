## v3

#!/bin/bash

echo "Starting Event Management System..."

# Check if Docker is installed
if ! command -v sudo docker &> /dev/null; then
    echo "Docker is not installed. Please install Docker and try again."
    exit 1
fi

# Check if Docker Compose is installed
if ! command -v sudo docker-compose &> /dev/null; then
    echo "Docker Compose is not installed. Please install Docker Compose and try again."
    exit 1
fi

# Build and start Docker containers
echo "Building and starting Docker containers..."
sudo docker-compose up --build -d

# Wait for MySQL to be fully ready
echo "Waiting for MySQL to start..."
until sudo docker exec mysql-db mysqladmin ping -h"localhost" --silent; do
    sleep 2
done

# Migrate the database
echo "Migrating database"
./migration.sh
echo "Event Management System is up and running at http://localhost:8080"

sleep 500