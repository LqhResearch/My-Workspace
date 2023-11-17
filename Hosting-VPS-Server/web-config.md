# Cấu hình file `web.config` trong hosting, vps và server

## 1. VPS (Window Server)

- Sử dụng cho **Laravel** có công dụng là:
  - Chuyển tất cả URI có phương thức http sang phương thức https.
  - Chuyển tất cả URI sang thư mục `public`.

```xml
<?xml version="1.0" encoding="UTF-8"?>
<configuration>
    <system.webServer>
        <defaultDocument>
            <files>
                <clear />
                <!-- Thiết lập tài liệu mặc định là index.php -->
                <add value="index.php" />
            </files>
        </defaultDocument>

        <rewrite>
            <rules>
                <!-- Luật chuyển hướng sang HTTPS -->
                <rule name="Redirect to HTTPS" stopProcessing="true">
                    <match url="(.*)" />
                    <conditions>
                        <add input="{HTTPS}" pattern="off" ignoreCase="true" />
                    </conditions>
                    <action type="Redirect" url="https://{HTTP_HOST}/{R:1}" redirectType="Permanent" />
                </rule>

                <!-- Luật Force Public của Laravel -->
                <rule name="Laravel Force public">
                    <match url="(.*)" ignoreCase="false" />
                    <action type="Rewrite" url="public/{R:1}" />
                </rule>

                <!-- Luật Routes của Laravel -->
                <rule name="Laravel Routes" stopProcessing="true">
                    <conditions>
                        <!-- Không áp dụng nếu là file hoặc thư mục tồn tại -->
                        <add input="{REQUEST_FILENAME}" matchType="IsFile" negate="true" />
                        <add input="{REQUEST_FILENAME}" matchType="IsDirectory" negate="true" />
                    </conditions>
                    <match url="^" ignoreCase="false" />
                    <action type="Rewrite" url="public/index.php" />
                </rule>
            </rules>
        </rewrite>
    </system.webServer>
</configuration>
```