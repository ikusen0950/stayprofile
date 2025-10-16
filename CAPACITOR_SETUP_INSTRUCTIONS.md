# Capacitor Mobile App Setup Instructions

## Status Bar Configuration

To properly handle the status bar in your Capacitor mobile app, follow these steps:

### 1. Install the Status Bar Plugin

```bash
npm install @capacitor/status-bar
npx cap sync
```

### 2. Configure Status Bar in your Capacitor App

Add this code to your Capacitor app's main entry point (usually `src/main.ts` or `src/index.ts`):

```typescript
import { StatusBar, Style } from '@capacitor/status-bar';
import { Capacitor } from '@capacitor/core';

// Configure status bar when app loads
const configureStatusBar = async () => {
  if (Capacitor.isNativePlatform()) {
    // Set status bar style (Light or Dark)
    await StatusBar.setStyle({ style: Style.Light });
    
    // Set status bar background color (match your app's header color)
    await StatusBar.setBackgroundColor({ color: '#ffffff' });
    
    // Show the status bar
    await StatusBar.show();
  }
};

// Call the configuration function
configureStatusBar();
```

### 3. Handle Theme Changes

If your app supports dark/light themes, add this to handle theme changes:

```typescript
// Function to update status bar based on theme
const updateStatusBarForTheme = async (isDark: boolean) => {
  if (Capacitor.isNativePlatform()) {
    await StatusBar.setStyle({ 
      style: isDark ? Style.Dark : Style.Light 
    });
    
    await StatusBar.setBackgroundColor({ 
      color: isDark ? '#1e1e2e' : '#ffffff' 
    });
  }
};

// Listen for theme changes
document.addEventListener('DOMContentLoaded', () => {
  const observer = new MutationObserver(() => {
    const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
    updateStatusBarForTheme(isDark);
  });
  
  observer.observe(document.documentElement, {
    attributes: true,
    attributeFilter: ['data-bs-theme']
  });
});
```

### 4. Capacitor Configuration

Make sure your `capacitor.config.ts` includes:

```typescript
import { CapacitorConfig } from '@capacitor/cli';

const config: CapacitorConfig = {
  appId: 'com.yourcompany.islanders',
  appName: 'Islanders App',
  webDir: 'dist', // or wherever your built CI4 app is
  server: {
    androidScheme: 'https'
  },
  plugins: {
    StatusBar: {
      style: 'Light',
      backgroundColor: '#ffffff'
    }
  }
};

export default config;
```

### 5. iOS Specific Configuration

For iOS, add to your `ios/App/App/Info.plist`:

```xml
<key>UIViewControllerBasedStatusBarAppearance</key>
<true/>
<key>UIStatusBarStyle</key>
<string>UIStatusBarStyleLightContent</string>
```

### 6. Android Specific Configuration

For Android, the status bar configuration is handled automatically by the plugin.

## Testing

After implementing these changes:

1. Build your Capacitor app: `npx cap build`
2. Sync with native platforms: `npx cap sync`
3. Run on device: `npx cap run ios` or `npx cap run android`

The header should now appear properly below the status bar with appropriate spacing!

## Troubleshooting

- **Status bar still overlapping**: Check that `viewport-fit=cover` is in your meta viewport tag
- **Colors don't match**: Adjust the background colors in both the CSS and StatusBar plugin configuration
- **Theme switching issues**: Make sure the theme detection logic is working properly

## Color Reference

Current app colors used:
- Light theme header: `#ffffff`
- Dark theme header: `#1e1e2e`

Update these colors in both the CSS and StatusBar configuration to match your app's design.