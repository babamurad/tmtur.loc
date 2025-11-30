#!/bin/bash

# Laravel Queue Worker Script for Hostinger Shared Hosting
# This script processes queued jobs and stops when the queue is empty

# Change to project directory
cd /home/u960938720/domains/tmtourism.com

# Run queue worker
/usr/bin/php artisan queue:work --stop-when-empty --tries=3 --timeout=50 --memory=128

# Exit
exit 0
