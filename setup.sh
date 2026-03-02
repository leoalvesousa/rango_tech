#!/bin/bash
cp -n .env.example .env

docker-compose up -d

echo "Database up and running."