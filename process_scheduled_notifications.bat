@echo off
REM Scheduled Notification Processor for Islanders Finolhu
REM This script should be run every minute via Windows Task Scheduler

cd /d "C:\xampp\htdocs\islanders_finolhu"
php spark notifications:process-scheduled

REM Log the execution (optional)
echo %date% %time% - Scheduled notifications processed >> logs\scheduled_notifications.log