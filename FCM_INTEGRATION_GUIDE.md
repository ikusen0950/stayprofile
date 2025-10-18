# Firebase Cloud Messaging (FCM) Integration Guide for Capacitor Mobile App

## Overview
This guide explains how to integrate Firebase Cloud Messaging (FCM) with your Capacitor mobile app to receive push notifications from the Islanders Finolhu backend.

## Backend Setup ✅

The backend has been configured with:
1. **Device Token Storage**: `users.device_token` field (TEXT)
2. **API Endpoints**: For registering/removing device tokens
3. **Firebase Service**: For sending push notifications
4. **Helper Functions**: Easy-to-use notification functions

## API Endpoints

### 1. Register Device Token
**POST** `/api/device/register-token`

Register or update the FCM device token for the authenticated user.

**Headers:**
```
Content-Type: application/json
Authorization: Bearer {your-auth-token}
```

**Request Body:**
```json
{
  "device_token": "eXAMPLE_FCM_TOKEN_HERE...",
  "platform": "android"  // or "ios"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Device token registered successfully",
  "data": {
    "user_id": 123,
    "platform": "android",
    "registered_at": "2025-10-18 12:40:22"
  }
}
```

### 2. Remove Device Token
**POST** `/api/device/remove-token`

Remove the device token (e.g., on logout).

**Response:**
```json
{
  "success": true,
  "message": "Device token removed successfully"
}
```

### 3. Check Token Status
**GET** `/api/device/token-status`

Check if the current user has a registered device token.

**Response:**
```json
{
  "success": true,
  "data": {
    "has_token": true,
    "registered": true
  }
}
```

---

## Capacitor Mobile App Setup

### Step 1: Install Required Packages

```bash
npm install @capacitor/push-notifications
npm install firebase
npx cap sync
```

### Step 2: Configure Firebase in Your App

Create `src/firebase-config.ts`:

```typescript
import { initializeApp } from 'firebase/app';
import { getMessaging, getToken, onMessage } from 'firebase/messaging';

const firebaseConfig = {
  apiKey: "YOUR_API_KEY",
  authDomain: "islanders-app---finolhu.firebaseapp.com",
  projectId: "islanders-app---finolhu",
  storageBucket: "islanders-app---finolhu.appspot.com",
  messagingSenderId: "YOUR_SENDER_ID",
  appId: "YOUR_APP_ID"
};

const app = initializeApp(firebaseConfig);
export const messaging = getMessaging(app);
```

### Step 3: Create Push Notification Service

Create `src/services/push-notification.service.ts`:

```typescript
import { PushNotifications, Token, ActionPerformed } from '@capacitor/push-notifications';
import { Capacitor } from '@capacitor/core';
import axios from 'axios';

const API_BASE_URL = 'https://your-api-domain.com';

export class PushNotificationService {
  
  async initialize() {
    if (Capacitor.getPlatform() === 'web') {
      console.log('Push notifications not available on web');
      return;
    }

    // Request permission
    let permStatus = await PushNotifications.checkPermissions();
    
    if (permStatus.receive === 'prompt') {
      permStatus = await PushNotifications.requestPermissions();
    }
    
    if (permStatus.receive !== 'granted') {
      throw new Error('User denied push notification permissions');
    }

    // Register with FCM
    await PushNotifications.register();

    // Listen for registration
    PushNotifications.addListener('registration', (token: Token) => {
      console.log('Push registration success, token: ' + token.value);
      this.registerTokenWithBackend(token.value);
    });

    // Listen for registration errors
    PushNotifications.addListener('registrationError', (error: any) => {
      console.error('Push registration error: ', error);
    });

    // Listen for push notifications received
    PushNotifications.addListener('pushNotificationReceived', (notification) => {
      console.log('Push notification received: ', notification);
      // Handle notification when app is in foreground
      this.handleNotification(notification);
    });

    // Listen for push notification actions
    PushNotifications.addListener('pushNotificationActionPerformed', (notification: ActionPerformed) => {
      console.log('Push notification action performed', notification);
      // Handle notification tap
      this.handleNotificationTap(notification);
    });
  }

  async registerTokenWithBackend(deviceToken: string) {
    try {
      const platform = Capacitor.getPlatform(); // 'ios' or 'android'
      
      const response = await axios.post(
        `${API_BASE_URL}/api/device/register-token`,
        {
          device_token: deviceToken,
          platform: platform
        },
        {
          headers: {
            'Authorization': `Bearer ${this.getAuthToken()}`,
            'Content-Type': 'application/json'
          }
        }
      );

      console.log('Device token registered with backend:', response.data);
      return response.data;
    } catch (error) {
      console.error('Failed to register device token:', error);
      throw error;
    }
  }

  async removeTokenFromBackend() {
    try {
      const response = await axios.post(
        `${API_BASE_URL}/api/device/remove-token`,
        {},
        {
          headers: {
            'Authorization': `Bearer ${this.getAuthToken()}`,
            'Content-Type': 'application/json'
          }
        }
      );

      console.log('Device token removed from backend:', response.data);
      return response.data;
    } catch (error) {
      console.error('Failed to remove device token:', error);
      throw error;
    }
  }

  private handleNotification(notification: any) {
    // Show in-app notification or update UI
    console.log('Handling notification:', notification);
    
    // You can show a toast or modal here
    // Example: show a toast notification
    // Toast.show({ text: notification.body });
  }

  private handleNotificationTap(notification: ActionPerformed) {
    // Navigate to specific screen based on notification data
    const data = notification.notification.data;
    
    if (data.url) {
      // Navigate to the URL specified in the notification
      console.log('Navigate to:', data.url);
      // Router.push(data.url);
    }
  }

  private getAuthToken(): string {
    // Retrieve your auth token from storage
    // Example: return localStorage.getItem('auth_token') || '';
    return localStorage.getItem('auth_token') || '';
  }

  async cleanup() {
    // Remove all listeners
    await PushNotifications.removeAllListeners();
  }
}

export const pushNotificationService = new PushNotificationService();
```

### Step 4: Initialize in Your App

In your main app file (e.g., `App.tsx` or `main.ts`):

```typescript
import { pushNotificationService } from './services/push-notification.service';

// After user logs in
async function onUserLogin() {
  try {
    await pushNotificationService.initialize();
    console.log('Push notifications initialized');
  } catch (error) {
    console.error('Failed to initialize push notifications:', error);
  }
}

// On user logout
async function onUserLogout() {
  try {
    await pushNotificationService.removeTokenFromBackend();
    await pushNotificationService.cleanup();
    console.log('Push notifications cleaned up');
  } catch (error) {
    console.error('Failed to cleanup push notifications:', error);
  }
}
```

### Step 5: Android Configuration

Edit `android/app/src/main/AndroidManifest.xml`:

```xml
<!-- Add these permissions -->
<uses-permission android:name="android.permission.POST_NOTIFICATIONS" />
<uses-permission android:name="android.permission.INTERNET" />

<application>
  <!-- ... existing configuration ... -->
  
  <!-- Add this meta-data inside <application> -->
  <meta-data
    android:name="com.google.firebase.messaging.default_notification_channel_id"
    android:value="default" />
</application>
```

Add `google-services.json` to `android/app/` directory (download from Firebase Console).

### Step 6: iOS Configuration

1. Add push notification capability in Xcode
2. Download `GoogleService-Info.plist` from Firebase Console
3. Add it to your iOS project in Xcode

Edit `ios/App/App/AppDelegate.swift`:

```swift
import UIKit
import Capacitor
import Firebase

@UIApplicationMain
class AppDelegate: UIResponder, UIApplicationDelegate {
  
  func application(_ application: UIApplication, didFinishLaunchingWithOptions launchOptions: [UIApplication.LaunchOptionsKey: Any]?) -> Bool {
    FirebaseApp.configure()
    return true
  }
  
  // ... rest of the code
}
```

---

## Backend Usage Examples

### Send Notification to a Single User

```php
<?php
// Load helper
helper('notification');

// Send notification
$result = send_push_notification(
    123,  // user_id
    'New Request Assigned',
    'You have been assigned a new request #456',
    [
        'url' => '/requests/456',
        'request_id' => '456'
    ]
);

if ($result['success']) {
    echo 'Notification sent successfully!';
} else {
    echo 'Failed to send: ' . $result['error'];
}
```

### Send Notification to Multiple Users

```php
<?php
helper('notification');

$userIds = [123, 456, 789];

$result = send_push_notification_to_multiple(
    $userIds,
    'Team Meeting',
    'Team meeting scheduled for tomorrow at 10 AM',
    [
        'url' => '/calendar/meetings/123'
    ]
);

echo "Success: {$result['success']}, Failed: {$result['failed']}";
```

### Send Notification from Controller

```php
<?php
namespace App\Controllers;

use App\Libraries\FirebaseNotificationService;

class RequestController extends BaseController
{
    public function assignRequest($requestId)
    {
        // ... assign request logic ...
        
        $assignedUserId = $this->request->getPost('assigned_to');
        
        // Send push notification
        $firebase = new FirebaseNotificationService();
        $result = $firebase->sendToUser(
            $assignedUserId,
            'New Request Assigned',
            "Request #{$requestId} has been assigned to you",
            [
                'url' => "/requests/{$requestId}",
                'request_id' => $requestId,
                'type' => 'request_assigned'
            ]
        );
        
        if ($result['success']) {
            log_message('info', "Push notification sent for request {$requestId}");
        }
        
        // ... rest of the code ...
    }
}
```

---

## Testing

### Test from Backend

Create a test script `test_push_notification.php`:

```php
<?php
require_once 'vendor/autoload.php';

// Bootstrap CodeIgniter
$app = require_once ROOTPATH . 'app/Config/Boot.php';

// Load helper
helper('notification');

// Test user ID (replace with actual user ID that has a device token)
$userId = 1;

// Send test notification
$result = send_push_notification(
    $userId,
    'Test Notification',
    'This is a test push notification from Islanders Finolhu',
    [
        'test' => 'true',
        'timestamp' => date('Y-m-d H:i:s')
    ]
);

print_r($result);
```

Run: `php test_push_notification.php`

---

## Troubleshooting

### Device Token Not Saving
- Check if user is authenticated when calling the API
- Verify the token is being sent in the request
- Check server logs for errors

### Notifications Not Received
- Verify the device token is correctly saved in the database
- Check Firebase Console for delivery status
- Ensure the app has notification permissions
- Check if the app is in foreground/background

### iOS Not Working
- Verify APNs certificates are configured in Firebase Console
- Check if push notification capability is enabled in Xcode
- Ensure the app is not in debug mode for production notifications

### Android Not Working
- Verify `google-services.json` is in the correct location
- Check if Google Play Services are installed on the device
- Ensure the app has POST_NOTIFICATIONS permission (Android 13+)

---

## Security Notes

1. **Protect API Endpoints**: All device token endpoints require authentication
2. **Secure Firebase Config**: Keep your Firebase service account JSON secure
3. **Token Validation**: The backend validates tokens before saving
4. **Remove on Logout**: Always remove device tokens when users log out

---

## Next Steps

1. Set up Firebase project if not already done
2. Download configuration files (google-services.json, GoogleService-Info.plist)
3. Implement the Capacitor service in your mobile app
4. Test notification delivery
5. Integrate with your app's business logic

---

## Support Files Created

- ✅ `app/Controllers/Api/DeviceController.php` - API endpoints
- ✅ `app/Libraries/FirebaseNotificationService.php` - FCM service
- ✅ `app/Helpers/notification_helper.php` - Helper functions
- ✅ `app/Config/Routes.php` - Updated with API routes
- ✅ Database: `users.device_token` field already exists

**Ready to use!** 🚀
