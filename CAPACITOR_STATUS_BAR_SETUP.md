# Capacitor Status Bar Configuration Guide

## 1. Install Status Bar Plugin (if not already installed)

```bash
npm install @capacitor/status-bar
npx cap sync
```

## 2. Update capacitor.config.ts (or capacitor.config.json)

Add this configuration to your Capacitor config file:

```typescript
import { CapacitorConfig } from '@capacitor/cli';

const config: CapacitorConfig = {
  appId: 'your.app.id',
  appName: 'Islanders App',
  webDir: 'public', // Your CI4 public directory
  bundledWebRuntime: false,
  plugins: {
    StatusBar: {
      style: 'LIGHT', // LIGHT or DARK
      backgroundColor: '#1e293b', // Match your header color
      androidShowStatusBarBackgroundColor: true,
    },
    SafeArea: {
      enabled: true,
      customColorsForSystemBars: true,
      statusBarColor: '#1e293b',
      statusBarStyle: 'LIGHT',
    }
  },
  server: {
    // For development
    url: 'http://localhost:8080', // Your CI4 dev server
    cleartext: true
  }
};

export default config;
```

## 3. Update MainActivity.java (Android)

In your Android project, update `MainActivity.java`:

```java
import com.capacitorjs.plugins.statusbar.StatusBarPlugin;

public class MainActivity extends BridgeActivity {
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        // Register StatusBar plugin
        this.init(savedInstanceState, new ArrayList<Class<? extends Plugin>>() {{
            add(StatusBarPlugin.class);
        }});
    }
}
```

## 4. Update Info.plist (iOS)

Add these entries to your iOS `Info.plist`:

```xml
<key>UIStatusBarStyle</key>
<string>UIStatusBarStyleLightContent</string>
<key>UIViewControllerBasedStatusBarAppearance</key>
<false/>
```

## 5. Build and Test

After making these changes:

```bash
npx cap sync
npx cap run android
# or
npx cap run ios
```

The header should now appear below the status bar with proper spacing.