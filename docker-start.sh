#!/bin/bash

echo "Starting Pure PHP Market with Docker..."

# Build and start containers
docker-compose up --build -d

echo "Containers started!"
# Load environment variables
source .env 2>/dev/null || true

echo "Web application: http://localhost:${WEB_PORT:-8080}"
echo "Admin panel: http://localhost:${WEB_PORT:-8080}/admin"
echo "Database: localhost:${DB_PORT:-3306}"
echo ""
echo "Default admin credentials:"
echo "Email: test@test.com"
echo "Password: 222222"
echo ""
echo "To stop: docker-compose down"
echo "To view logs: docker-compose logs -f"