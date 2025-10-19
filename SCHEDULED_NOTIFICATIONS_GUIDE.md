# Scheduled Notifications Setup Guide

## Overview
The scheduled notification system allows you to schedule bulk notifications for future delivery. This document explains how to set up and use this feature.

## Features Added
- ✅ Database fields for scheduled notifications (`scheduled_at`, `sent_at`, `error_message`)
- ✅ Command to process scheduled notifications
- ✅ Proper status tracking (scheduled → sent/failed)
- ✅ Error handling and logging
- ✅ Windows Task Scheduler batch file

## Database Changes
The following fields were added to the `notifications` table:
- `scheduled_at` (DATETIME) - When the notification should be sent
- `sent_at` (DATETIME) - When the notification was actually sent
- `error_message` (TEXT) - Error details if sending failed

## Status Codes
- **Status 1**: Active (immediate notifications)
- **Status 27**: Scheduled (waiting to be sent)
- **Status 28**: Failed (could not be sent)
- **Status 29**: Sent (successfully delivered)

## How It Works

### 1. Scheduling Notifications
Users can schedule notifications through the bulk send modal:
1. Select "Schedule for Later" option
2. Choose date and time using datetime-local input
3. Submit the form

### 2. Processing Scheduled Notifications
Run this command to process scheduled notifications:
```bash
php spark notifications:process-scheduled
```

The command will:
1. Find all notifications with `status_id = 27` and `scheduled_at <= now()`
2. Attempt to send each notification via FCM
3. Update status based on success/failure
4. Log all activities

### 3. Automatic Processing (Recommended)
Set up a Windows Task Scheduler task to run every minute:

**Task Name**: Process Scheduled Notifications
**Action**: Start a program
**Program**: `C:\xampp\htdocs\islanders_finolhu\process_scheduled_notifications.bat`
**Schedule**: Every minute

## Manual Testing

### Test Scheduling
1. Go to Notifications → Send Bulk Notification
2. Enter title and message
3. Select "Schedule for Later"
4. Set time to 1-2 minutes in the future
5. Submit the form

### Test Processing
1. Wait for the scheduled time to pass
2. Run: `php spark notifications:process-scheduled`
3. Check the output for processing results
4. Verify notification status in database

## Troubleshooting

### Common Issues
1. **No notifications processed**: Check if `scheduled_at` is in the future
2. **FCM errors**: Verify users have valid device tokens
3. **Database errors**: Ensure all fields exist and have proper permissions

### Checking Logs
- Application logs: `writable/logs/`
- Scheduled processing log: `logs/scheduled_notifications.log`
- FCM logs: Check console output when running the command

### Database Queries
```sql
-- Check scheduled notifications
SELECT * FROM notifications WHERE status_id = 27;

-- Check sent notifications
SELECT * FROM notifications WHERE status_id = 29 AND sent_at IS NOT NULL;

-- Check failed notifications
SELECT * FROM notifications WHERE status_id = 28 AND error_message IS NOT NULL;
```

## Performance Notes
- The command processes all due notifications in one run
- FCM sending is done synchronously (consider async for large volumes)
- Database index on `scheduled_at` improves query performance
- Consider archiving old notifications periodically

## Security Considerations
- Only authorized users can schedule notifications
- All scheduling actions are logged
- Failed notifications include error details for debugging
- Processing command can be run safely multiple times

## Next Steps
1. Set up Windows Task Scheduler for automatic processing
2. Monitor the system for the first few scheduled notifications
3. Consider adding email alerts for processing failures
4. Add dashboard widgets to show scheduled notification statistics