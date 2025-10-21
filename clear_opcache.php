<?php
echo "<h2>Clear PHP OpCache</h2>\n";

if (function_exists('opcache_reset')) {
    $result = opcache_reset();
    if ($result) {
        echo "<p>✅ OpCache cleared successfully!</p>\n";
    } else {
        echo "<p>❌ Failed to clear OpCache</p>\n";
    }
} else {
    echo "<p>⚠️ OpCache not available</p>\n";
}

if (function_exists('opcache_get_status')) {
    $status = opcache_get_status();
    if ($status) {
        echo "<p>OpCache enabled: " . ($status['opcache_enabled'] ? 'YES' : 'NO') . "</p>\n";
        echo "<p>Cache full: " . ($status['cache_full'] ? 'YES' : 'NO') . "</p>\n";
        echo "<p>Cached scripts: " . $status['opcache_statistics']['num_cached_scripts'] . "</p>\n";
    }
}

echo "<p><a href='requests'>Test Requests Page Now</a></p>\n";