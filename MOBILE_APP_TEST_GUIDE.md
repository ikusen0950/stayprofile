# Quick Test Guide - Mobile App Notification Prompt

## 🎯 What Changed

The notification prompt now **works on both web and mobile Capacitor apps** by automatically detecting the platform and using the correct API.

---

## 📱 Testing on Your Capacitor Mobile App

### Step 1: Ensure Plugin is Installed

In your Capacitor project root:

```bash
# Check if plugin is installed
npm list @capacitor/push-notifications

# If not installed, install it:
npm install @capacitor/push-notifications

# Sync with native projects
npx cap sync
```

### Step 2: Add Firebase Configuration (if not already done)

**Android:**
- Place `google-services.json` in `android/app/` directory

**iOS:**
- Add `GoogleService-Info.plist` to Xcode project

### Step 3: Test User Setup

Clear device token for a test user:

```sql
-- In your database
UPDATE users 
SET device_token = NULL 
WHERE username = 'testuser';  -- Replace with your test username
```

### Step 4: Build and Run

```bash
# Build your web assets
npm run build

# Sync with Capacitor
npx cap sync

# Open in IDE
npx cap open android  # For Android
npx cap open ios      # For iOS

# Then run from Android Studio or Xcode
```

### Step 5: Test the Flow

1. **Open the app** on device/emulator
2. **Login** with the test user
3. **Dashboard loads**
4. **Wait 1 second** → Modal should popup! 🎉
5. **Click "Enable Notifications"**
6. **Native permission dialog appears** (Android/iOS system dialog)
7. **Grant permission**
8. **Check console logs:**
   ```
   Platform detected: android (or ios)
   Is Capacitor: true
   Handling Capacitor notifications...
   Requesting push notification permission...
   Push registration success, token: fK8x9p2mS_k:APA91b...
   Saving token to backend...
   Backend response: {success: true, ...}
   ```
9. **Success toast appears**
10. **Page reloads**
11. **Close and reopen app** → No popup! ✅

### Step 6: Verify Token Saved

Check database:

```sql
SELECT 
    id,
    username,
    LEFT(device_token, 50) as token_preview,
    CHAR_LENGTH(device_token) as token_length,
    CASE 
        WHEN device_token LIKE 'web_%' THEN '🌐 Web'
        ELSE '📱 Mobile (FCM)'
    END as token_type
FROM users 
WHERE username = 'testuser';
```

**Expected result:**
```
token_preview: fK8x9p2mS_k:APA91bHGn2Qf7...
token_length: 163 (or similar, FCM tokens are ~150-200 chars)
token_type: 📱 Mobile (FCM)
```

---

## 🌐 Testing on Web Browser (for comparison)

1. Open browser: `http://localhost/islanders_finolhu/`
2. Login with user (clear device_token first)
3. Modal appears
4. Click "Enable"
5. Browser permission dialog
6. Grant
7. Check database:
   ```
   token_preview: web_1729234567_abc123...
   token_length: 31
   token_type: 🌐 Web
   ```

---

## 🔍 Debugging Tips

### Check if Capacitor is Detected

Add to your mobile app's JavaScript console:

```javascript
console.log('Capacitor available:', window.Capacitor !== undefined);
console.log('Platform:', window.Capacitor ? window.Capacitor.getPlatform() : 'web');
console.log('PushNotifications plugin:', window.Capacitor?.Plugins?.PushNotifications ? 'Available' : 'Not available');
```

### Common Issues & Solutions

| Issue | Solution |
|-------|----------|
| Modal doesn't appear | Check: `device_token` is NULL in database |
| "Plugin not available" error | Install `@capacitor/push-notifications` and run `npx cap sync` |
| Permission not requested | Check platform-specific setup (AndroidManifest, Xcode capabilities) |
| Token not saved | Check network tab for API call, verify backend endpoint working |
| "Registration error" | Check Firebase configuration files are present |

### Enable Remote Debugging

**Android:**
1. Enable USB debugging on device
2. Connect via USB
3. Open Chrome: `chrome://inspect`
4. Click "inspect" on your app
5. See console logs in DevTools

**iOS:**
1. Enable Web Inspector on device: Settings → Safari → Advanced
2. Connect via USB
3. Open Safari → Develop → [Your Device] → [Your App]
4. See console logs in Web Inspector

---

## 📊 Expected Console Output (Mobile)

```javascript
// On page load
Show notification prompt: true
Platform detected: android
Is Capacitor: true
Notification permission modal shown

// After clicking "Enable"
Handling Capacitor notifications...
Requesting push notification permission...
Current permission status: {receive: "prompt"}
Permission after request: {receive: "granted"}
Registering for push notifications...
Push registration success, token: fK8x9p2mS_k:APA91bHGn2Qf7sQEKWYvH3bMfJ4nN...
Saving token to backend... {deviceToken: "fK8x9p2mS_k:...", platform: "android"}
Backend response: {success: true, message: "Device token registered successfully", ...}
```

---

## ✅ Success Checklist

- [ ] `@capacitor/push-notifications` installed
- [ ] Firebase config files added (google-services.json / GoogleService-Info.plist)
- [ ] App built and synced with `npx cap sync`
- [ ] Test user has NULL device_token
- [ ] App opens and modal appears
- [ ] Native permission dialog shows
- [ ] Permission granted
- [ ] FCM token received in console
- [ ] Token saved to backend
- [ ] Success message appears
- [ ] Database shows FCM token (not web_ token)
- [ ] Next app open: no popup

---

## 🎯 Quick Command Reference

```bash
# Check plugin
npm list @capacitor/push-notifications

# Install if missing
npm install @capacitor/push-notifications

# Build & sync
npm run build
npx cap sync

# Open in IDE
npx cap open android
npx cap open ios

# Check logs (Android)
npx cap run android -l

# Check logs (iOS)
npx cap run ios -l
```

---

## 📞 Still Not Working?

### 1. Verify Plugin Installation

In your Capacitor app, check `package.json`:

```json
{
  "dependencies": {
    "@capacitor/push-notifications": "^5.x.x",  // Should be present
    ...
  }
}
```

### 2. Check capacitor.config.ts

Ensure plugins are not excluded:

```typescript
const config: CapacitorConfig = {
  appId: 'your.app.id',
  appName: 'Your App',
  plugins: {
    PushNotifications: {
      presentationOptions: ["badge", "sound", "alert"]
    }
  }
};
```

### 3. Test Backend Endpoint Directly

```bash
curl -X POST http://localhost/islanders_finolhu/api/device/register-token \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_AUTH_TOKEN" \
  -d '{
    "device_token": "test_fcm_token_12345",
    "platform": "android"
  }'
```

Should return:
```json
{
  "success": true,
  "message": "Device token registered successfully"
}
```

---

## 🎉 Expected Result

**When everything works:**

1. ✅ User logs in → Modal appears automatically
2. ✅ User clicks "Enable" → Native dialog shows
3. ✅ User grants → FCM token generated
4. ✅ Token saved → Database updated
5. ✅ Success message → User notified
6. ✅ Next login → No popup (already enabled)

**You can now send push notifications to the user!** 🚀

---

**Guide Created:** October 18, 2025
**Works On:** Capacitor Android, Capacitor iOS, Web browsers
**Status:** ✅ Ready to test
