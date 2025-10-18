# Device Token Save Flow - Detailed Explanation

## 🔄 Complete Flow Diagram

```
┌─────────────────┐
│   Mobile App    │
│  (Capacitor)    │
└────────┬────────┘
         │
         │ 1. User logs in
         │
         ▼
┌─────────────────────────────────────┐
│  Request FCM Permission             │
│  PushNotifications.register()       │
└────────┬────────────────────────────┘
         │
         │ 2. FCM generates token
         │
         ▼
┌─────────────────────────────────────┐
│  FCM Returns Device Token           │
│  Example: "eXAMPLE123..."           │
└────────┬────────────────────────────┘
         │
         │ 3. Mobile app receives token
         │    via 'registration' listener
         │
         ▼
┌─────────────────────────────────────┐
│  POST /api/device/register-token    │
│  Headers:                           │
│    - Authorization: Bearer {token}  │
│  Body:                              │
│    - device_token: "eXAMPLE123..."  │
│    - platform: "android"            │
└────────┬────────────────────────────┘
         │
         │ 4. Backend receives request
         │
         ▼
┌─────────────────────────────────────┐
│  DeviceController::registerToken()  │
│  1. Get user_id from session        │
│  2. Validate device_token           │
│  3. Update database                 │
└────────┬────────────────────────────┘
         │
         │ 5. Execute SQL UPDATE
         │
         ▼
┌─────────────────────────────────────┐
│  Database UPDATE Query:             │
│                                     │
│  UPDATE users                       │
│  SET device_token = 'eXAMPLE123...'│
│      updated_at = NOW()             │
│  WHERE id = [user_id]               │
└────────┬────────────────────────────┘
         │
         │ 6. Token saved in database
         │
         ▼
┌─────────────────────────────────────┐
│  users table:                       │
│  ┌────┬──────────┬─────────────┐   │
│  │ id │ username │device_token │   │
│  ├────┼──────────┼─────────────┤   │
│  │ 1  │ john     │eXAMPLE123...│   │
│  └────┴──────────┴─────────────┘   │
└────────┬────────────────────────────┘
         │
         │ 7. Return success response
         │
         ▼
┌─────────────────────────────────────┐
│  Response to Mobile App:            │
│  {                                  │
│    "success": true,                 │
│    "message": "Token registered"    │
│  }                                  │
└─────────────────────────────────────┘
```

---

## 💾 Database Storage

### Table: `users`
The device token is stored in the existing `users` table:

```sql
-- Structure
CREATE TABLE users (
  id INT(11) PRIMARY KEY,
  username VARCHAR(255),
  email VARCHAR(255),
  ...
  device_token TEXT NULL,  -- ← FCM token stored here
  ...
);
```

### Example Data:
```sql
-- Before registration
| id | username | email           | device_token |
|----|----------|-----------------|--------------|
| 1  | john     | john@domain.com | NULL         |

-- After registration
| id | username | email           | device_token                                    |
|----|----------|-----------------|------------------------------------------------|
| 1  | john     | john@domain.com | eXAMPLE123FCM_TOKEN_VERY_LONG_STRING_HERE...  |
```

---

## 🔍 Detailed Backend Process

### Step 1: API Endpoint Receives Request

**URL:** `POST /api/device/register-token`

**Request Example:**
```json
{
  "device_token": "fK8x9p2mS_k:APA91bH...(long string)",
  "platform": "android"
}
```

### Step 2: DeviceController Processes Request

**File:** `app/Controllers/Api/DeviceController.php`

```php
public function registerToken()
{
    // 1. Get authenticated user ID
    $userId = user_id();  // e.g., returns 1
    
    if (!$userId) {
        return $this->failUnauthorized('User not authenticated');
    }

    // 2. Get device token from request
    $json = $this->request->getJSON();
    $deviceToken = $json->device_token;  // The FCM token
    $platform = $json->platform;         // "android" or "ios"

    // 3. Validate token is not empty
    if (empty($deviceToken)) {
        return $this->fail('Device token is required', 400);
    }

    // 4. Save to database using UserModel
    $updated = $this->userModel->update($userId, [
        'device_token' => $deviceToken,
        'updated_at' => date('Y-m-d H:i:s')
    ]);
    
    // 5. Return success response
    if ($updated) {
        return $this->respond([
            'success' => true,
            'message' => 'Device token registered successfully'
        ], 200);
    }
}
```

### Step 3: Database Update

The `$this->userModel->update()` method executes this SQL:

```sql
UPDATE users 
SET 
  device_token = 'fK8x9p2mS_k:APA91bH...(long string)',
  updated_at = '2025-10-18 12:50:00'
WHERE 
  id = 1;
```

---

## 📱 Mobile App Implementation Example

### Complete TypeScript Service:

```typescript
// push-notification.service.ts
import { PushNotifications, Token } from '@capacitor/push-notifications';
import axios from 'axios';

export class PushNotificationService {
  
  async initialize() {
    // Request permission
    const permission = await PushNotifications.requestPermissions();
    
    if (permission.receive !== 'granted') {
      throw new Error('Permission denied');
    }

    // Register with FCM
    await PushNotifications.register();

    // Listen for token
    PushNotifications.addListener('registration', async (token: Token) => {
      console.log('📱 FCM Token received:', token.value);
      
      // Send token to backend
      await this.saveTokenToBackend(token.value);
    });
  }

  private async saveTokenToBackend(deviceToken: string) {
    try {
      const authToken = localStorage.getItem('auth_token');
      const platform = Capacitor.getPlatform(); // 'android' or 'ios'
      
      // Call your backend API
      const response = await axios.post(
        'https://your-domain.com/api/device/register-token',
        {
          device_token: deviceToken,
          platform: platform
        },
        {
          headers: {
            'Authorization': `Bearer ${authToken}`,
            'Content-Type': 'application/json'
          }
        }
      );

      console.log('✅ Token saved to backend:', response.data);
      
    } catch (error) {
      console.error('❌ Failed to save token:', error);
    }
  }
}

// Usage in your app:
const pushService = new PushNotificationService();

// After user logs in successfully:
await pushService.initialize();
```

---

## 🔐 Security & Authentication

### How the Backend Knows Which User:

1. **User logs in** → Backend returns JWT token or session
2. **Mobile app stores** this auth token
3. **Every API request includes** `Authorization: Bearer {token}` header
4. **Backend validates** the token and gets user ID
5. **Device token is saved** to that specific user's record

```php
// In DeviceController
$userId = user_id();  // This function reads from session/JWT
// Returns: 1 (the logged-in user's ID)

// Update ONLY this user's record
$this->userModel->update($userId, ['device_token' => $token]);
```

---

## 🎯 Real-World Example

Let's say user "Sarah" logs into the mobile app:

1. **Login successful**
   - Sarah's user_id = 5
   - Auth token = "abc123xyz..."

2. **App requests FCM token**
   - Firebase returns: "fK8x9p2mS_k:APA91bH..."

3. **App calls backend API**
   ```
   POST /api/device/register-token
   Authorization: Bearer abc123xyz...
   {
     "device_token": "fK8x9p2mS_k:APA91bH...",
     "platform": "ios"
   }
   ```

4. **Backend processes**
   - Validates "abc123xyz..." → user_id = 5
   - Executes: `UPDATE users SET device_token='fK8x9p2mS_k:APA91bH...' WHERE id=5`

5. **Database updated**
   ```
   | id | username | device_token              |
   |----|----------|---------------------------|
   | 5  | sarah    | fK8x9p2mS_k:APA91bH...   |
   ```

6. **Now you can send notifications to Sarah**
   ```php
   send_push_notification(5, 'Hello Sarah!', 'Your request was approved');
   ```

---

## 🧪 Test the Flow

### 1. Check if token is saved:
```sql
SELECT id, username, 
       SUBSTRING(device_token, 1, 50) as token_preview,
       CASE WHEN device_token IS NOT NULL THEN 'Yes' ELSE 'No' END as has_token
FROM users
WHERE id = 1;
```

### 2. Manually test the API:
```bash
# Using curl
curl -X POST https://your-domain.com/api/device/register-token \
  -H "Authorization: Bearer YOUR_AUTH_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "device_token": "test_token_12345",
    "platform": "android"
  }'
```

### 3. Verify in database:
```sql
SELECT * FROM users WHERE device_token IS NOT NULL;
```

---

## 🔄 Token Updates

### What if user logs in on multiple devices?

**Current behavior:** The token is **overwritten**
- User logs in on iPhone → iOS token saved
- User logs in on Android → Android token **replaces** iOS token

### Want to support multiple devices per user?

You would need to create a separate table:

```sql
CREATE TABLE user_devices (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT,
  device_token TEXT,
  platform VARCHAR(20),
  created_at DATETIME,
  FOREIGN KEY (user_id) REFERENCES users(id)
);
```

---

## ✨ Summary

**The device token is saved through this simple flow:**

1. 📱 Mobile app gets FCM token from Firebase
2. 🌐 Mobile app sends token to backend API (`/api/device/register-token`)
3. 🔐 Backend authenticates user from session/JWT
4. 💾 Backend saves token to `users.device_token` field
5. ✅ Token is now stored and ready for sending notifications!

**Key Point:** The token is tied to the authenticated user making the API request, so each user's token is stored in their own record.
