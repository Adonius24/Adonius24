run:
php -S localhost:8000 -t tracker/public

watch-notifications:
tail -f tracker/storage/logs/notifications.log
