# Capacitor Status Bar Setup Guide

## Problem
When using `viewport-fit=cover` in Capacitor apps, the web content extends under the mobile status bar (where signal strength and battery percentage are shown), causing the app header to be partially hidden.

## Solution Implemented

### 1. CSS Safe Area Handling
Added CSS in `app/Views/layout/header.php` to handle safe area insets:

```css
/* Handle iOS status bar safe area */
:root {
    --sat: env(safe-area-inset-top);
    --sar: env(safe-area-inset-right);
    --sab: env(safe-area-inset-bottom);
    --sal: env(safe-area-inset-left);
}

/* Apply safe area top padding to the app root */
#kt_app_root {
    padding-top: env(safe-area-inset-top);
}

/* Ensure header doesn't get covered by status bar */
#kt_app_header {
    padding-top: calc(env(safe-area-inset-top) * 0.5);
}
```

### 2. JavaScript Status Bar Configuration
Added JavaScript to configure the Capacitor Status Bar plugin:

```javascript
document.addEventListener('DOMContentLoaded', async function() {
    if (window.Capacitor && window.Capacitor.Plugins?.StatusBar) {
        const { StatusBar } = window.Capacitor.Plugins;
        
        try {
            await StatusBar.setStyle({ style: 'dark' }); // or 'light'
            await StatusBar.setBackgroundColor({ color: '#ffffff' });
            await StatusBar.show();
        } catch (error) {
            console.error('Status bar configuration failed:', error);
        }
    }
});
```

## Required Capacitor Plugin

Make sure you have the Status Bar plugin installed in your Capacitor project:

```bash
npm install @capacitor/status-bar
npx cap sync
```

## Alternative Approaches

### Option 1: Body Padding (Alternative CSS approach)
```css
body {
    padding-top: env(safe-area-inset-top);
    padding-left: env(safe-area-inset-left);
    padding-right: env(safe-area-inset-right);
    padding-bottom: env(safe-area-inset-bottom);
}
```

### Option 2: Different Status Bar Styles
```javascript
// Light content on dark status bar
await StatusBar.setStyle({ style: 'light' });

// Dark content on light status bar  
await StatusBar.setStyle({ style: 'dark' });

// Default system style
await StatusBar.setStyle({ style: 'default' });
```

### Option 3: Hide Status Bar (if needed)
```javascript
await StatusBar.hide();
```

## Testing
1. Build your Capacitor app: `npx cap build`
2. Sync changes: `npx cap sync`
3. Test on device or simulator
4. Verify that the header no longer appears under the status bar

## Troubleshooting

### Issue: CSS not working
- Ensure `viewport-fit=cover` is in the viewport meta tag
- Check that CSS custom properties (env()) are supported
- Test on actual device, not just browser

### Issue: Status Bar plugin not working
- Verify plugin is installed: `npm list @capacitor/status-bar`
- Check that Capacitor plugins are properly imported
- Ensure `npx cap sync` was run after installation

### Issue: Different behavior on iOS vs Android
- iOS uses safe area insets, Android may not
- Test both platforms separately
- Consider platform-specific CSS if needed

## Notes
- The `viewport-fit=cover` is required for full-screen apps on notched devices
- Safe area insets automatically handle different device types (notched, non-notched)
- Status bar color should match your app's theme for best user experience