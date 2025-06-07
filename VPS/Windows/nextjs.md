# NextJS

- Cấu hình IIS dùng module `iisnode` để chạy file `server.mjs`.
- Chuyển hướng tất cả yêu cầu đến `server.mjs` để xử lý routing của Next.js.

```xml
<?xml version="1.0" encoding="utf-8"?>
<configuration>
    <system.webServer>
        <handlers>
            <add name="iisnode" path="server.mjs" verb="*" modules="iisnode" resourceType="Unspecified" />
        </handlers>

        <rewrite>
            <rules>
                <rule name="NextJS Routing" stopProcessing="true">
                    <match url="(.*)" />
                    <action type="Rewrite" url="server.mjs/{R:1}" />
                </rule>
            </rules>
        </rewrite>
    </system.webServer>
</configuration>
```
