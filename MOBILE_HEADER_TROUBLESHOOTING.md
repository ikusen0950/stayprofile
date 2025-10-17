# Mobile Header Troubleshooting Guide

## Issue Description
Header content (menu icon, logo, user section) is not visible on mobile devices, particularly in Capacitor apps on iOS and Android.

## Solution Implemented

### 1. CSS Changes
- **Status Bar Handling**: Added `env(safe-area-inset-top)` support for iOS notch/status bar
- **Fixed Positioning**: Header is now fixed with proper top positioning accounting for status bar
- **Mobile-First Approach**: CSS now applies to all screens ≤768px, not just detected mobile apps
- **Background Matching**: Status bar background matches header theme (white/dark)

### 2. Key CSS Features
```css
/* All mobile screens get status bar padding */
@media (max-width: 768px) {
    body {
        padding-top: var(--status-bar-height) !important;
    }
    
    #kt_app_header {
        top: var(--status-bar-height) !important;
        position: fixed !important;
    }
}
```

### 3. Testing Instructions

#### Test on Web Browser (Development)
1. Open browser dev tools (F12)
2. Switch to mobile view (responsive design mode)
3. Set width to 375px (iPhone) or 360px (Android)
4. Check if header is visible and properly positioned

#### Test on Capacitor App
1. Build and deploy to device
2. Check these elements are visible:
   - Menu icon (☰) or back arrow (←)
   - Logo in center
   - User profile section on right
3. Verify no overlap with status bar
4. Test both portrait and landscape modes

#### Debug Information
The JavaScript console will show:
- Mobile environment detection
- Safe area top value
- Screen size classification

### 4. Common Issues & Solutions

#### Issue: Header Still Hidden
**Solution**: Check browser console for safe area values
```javascript
// Run in browser console:
console.log('Safe area:', getComputedStyle(document.documentElement).getPropertyValue('--status-bar-height'));
```

#### Issue: Status Bar Background Doesn't Match
**Solution**: The CSS automatically matches your theme:
- Light theme: White background (`#ffffff`)
- Dark theme: Dark background (`#1e1e2d`)

#### Issue: Landscape Mode Problems
**Solution**: CSS includes landscape handling that reduces status bar height by 20%

### 5. Manual Testing Checklist

#### iOS Testing
- [ ] Header visible in portrait mode
- [ ] Header visible in landscape mode
- [ ] No overlap with notch/status bar
- [ ] Background color matches header
- [ ] All header elements clickable

#### Android Testing
- [ ] Header visible in portrait mode
- [ ] Header visible in landscape mode
- [ ] No overlap with status bar
- [ ] Background color matches header
- [ ] All header elements clickable

### 6. Capacitor Configuration

Ensure your `capacitor.config.json` includes:
```json
{
  "ios": {
    "contentInset": "automatic"
  },
  "android": {
    "allowMixedContent": true
  }
}
```

### 7. If Issues Persist

1. **Check Capacitor Version**: Ensure you're using Capacitor 5+
2. **Clear App Cache**: Uninstall and reinstall the app
3. **Test on Different Devices**: Some devices have unique status bar behaviors
4. **Enable Debug Mode**: Add `?debug=1` to URL to see additional console logs

### 8. Fallback Solution

If the automatic detection doesn't work, you can manually add classes:
```javascript
// Add to your app initialization
document.body.classList.add('capacitor-app');
```

## Expected Result
After implementing this solution:
- Header should be fully visible on all mobile devices
- Status bar area should have matching background color
- No overlap between header content and device status bar
- All header navigation elements should be accessible