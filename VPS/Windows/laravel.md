# Laravel

- Đặt `index.php` làm tài liệu mặc định.
- Chuyển hướng tất cả truy cập sang HTTPS nếu chưa dùng.
- Ép mọi yêu cầu đi qua thư mục `public` của Laravel.
- Nếu đường dẫn không phải file hoặc thư mục thật, chuyển đến `public/index.php` để xử lý route.

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
