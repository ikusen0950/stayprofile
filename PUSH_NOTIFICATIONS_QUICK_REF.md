# Push Notifications - Quick Reference Card

## 🚀 Quick Start

### Send a Notification (3 Ways)

```php
// Method 1: Simple helper (recommended)
helper('notification');
send_push_notification($userId, 'Title', 'Message', ['url' => '/page']);

// Method 2: Multiple users
send_push_notification_to_multiple([1,2,3], 'Title', 'Message');

// Method 3: Direct service
$firebase = new \App\Libraries\FirebaseNotificationService();
$firebase->sendToUser($userId, 'Title', 'Message', $data);
```

---

## 📱 API Endpoints

| Method | Endpoint | Purpose |
|--------|----------|---------|
| POST | `/api/device/register-token` | Register FCM token |
| POST | `/api/device/remove-token` | Remove token (logout) |
| GET | `/api/device/token-status` | Check token status |

### Register Token Request:
```json
{
  "device_token": "FCM_TOKEN_HERE",
  "platform": "android"
}
```

---

## 💻 CLI Commands

```bash
# Test notification
php spark notification:test

# Create notifications table
php spark db:create-notifications

# Check migration status
php spark migrate:status
```

---

## 📂 Key Files

| File | Purpose |
|------|---------|
| `app/Controllers/Api/DeviceController.php` | API endpoints |
| `app/Libraries/FirebaseNotificationService.php` | FCM service |
| `app/Helpers/notification_helper.php` | Helper functions |
| `app/Config/firebase_service_account.json` | Firebase config |
| `FCM_INTEGRATION_GUIDE.md` | Full integration guide |

---

## 🔍 Check Device Token

```sql
SELECT id, username, 
       CASE WHEN device_token IS NOT NULL 
       THEN 'Registered' 
       ELSE 'Not Registered' END as status
FROM users;
```

---

## 🎯 Common Use Cases

```php
// 1. Request assigned
send_push_notification($userId, 'New Request', 'Request #123 assigned', [
    'url' => '/requests/123'
]);

// 2. Status changed
send_push_notification($userId, 'Status Update', 'Request approved', [
    'type' => 'status_change',
    'url' => '/requests/123'
]);

// 3. Broadcast to team
$teamIds = [1, 2, 3, 4];
send_push_notification_to_multiple($teamIds, 'Meeting', 'Team meeting at 3 PM');

// 4. Reminder
send_push_notification($userId, 'Reminder', 'Submit report by EOD', [
    'type' => 'reminder'
]);
```

---

## ⚡ Mobile App Quick Setup

### 1. Install
```bash
npm install @capacitor/push-notifications firebase
npx cap sync
```

### 2. Register Token
```typescript
// On login success
const token = await PushNotifications.register();
await axios.post('/api/device/register-token', {
  device_token: token.value,
  platform: Capacitor.getPlatform()
});
```

### 3. Remove Token
```typescript
// On logout
await axios.post('/api/device/remove-token');
```

---

## 🐛 Troubleshooting

| Issue | Solution |
|-------|----------|
| "No device token" | User must log in to mobile app |
| "Access token failed" | Check firebase_service_account.json |
| "Not delivered" | Check Firebase Console logs |
| "Permission denied" | Check app notification settings |

---

## 📊 Test Checklist

- [ ] Register device token from mobile app
- [ ] Send test notification via CLI
- [ ] Verify notification received on device
- [ ] Test notification tap action
- [ ] Test background/foreground delivery
- [ ] Test token removal on logout
- [ ] Verify database updates

---

## 🔐 Security Notes

- ✅ All endpoints require authentication
- ✅ Tokens are user-specific
- ✅ Auto-cleanup on logout
- ✅ Service account JSON secured

---

## 📞 Quick Help

```bash
# Test send
php spark notification:test

# Check logs
tail -f writable/logs/log-*.log

# View routes
php spark routes | grep device
```

---

## 🎨 Notification Data Structure

```json
{
  "title": "String - Max 255 chars",
  "body": "String - Message text",
  "data": {
    "url": "Navigation path",
    "type": "Notification type",
    "id": "Related record ID",
    "...": "Any custom fields"
  }
}
```

---

**📚 Full Documentation:** See `FCM_INTEGRATION_GUIDE.md`
**📝 Examples:** See `app/Controllers/NotificationExampleController.php`
**✅ Status:** Backend Ready - Integrate with mobile app
