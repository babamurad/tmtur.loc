#!/bin/bash

# Diagnostic script to check queue and email configuration
# Run this on the server to troubleshoot email issues

PROJECT_DIR="/home/u960938720/tmtourism.com"
cd "$PROJECT_DIR" || exit 1

echo "======================================"
echo "Queue & Email Diagnostic Report"
echo "======================================"
echo ""

echo "1. Queue Configuration:"
php artisan config:show queue.default
echo ""

echo "2. Jobs in Queue:"
php artisan tinker --execute="echo 'Pending jobs: ' . DB::table('jobs')->count(); echo PHP_EOL;"
echo ""

echo "3. Failed Jobs:"
php artisan queue:failed
echo ""

echo "4. Recent Laravel Logs (last 50 lines):"
tail -n 50 storage/logs/laravel.log
echo ""

echo "5. Lock File Status:"
if [ -f "storage/queue-worker.lock" ]; then
    echo "Lock file EXISTS"
    PID=$(cat storage/queue-worker.lock)
    echo "PID in lock file: $PID"
    if ps -p "$PID" > /dev/null 2>&1; then
        echo "Process is RUNNING"
    else
        echo "Process is NOT running (stale lock)"
    fi
else
    echo "Lock file does NOT exist"
fi
echo ""

echo "6. Check if queue:work is currently running:"
ps aux | grep "queue:work" | grep -v grep
echo ""

echo "======================================"
echo "Diagnostic Complete"
echo "======================================"
