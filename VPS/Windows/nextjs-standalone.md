# NextJS 15 (Standalone)

- Cấu hình IIS dùng `httpPlatformHandler` để chạy ứng dụng Node.js.
- Khởi động Node với file `server.js` và ghi log đầu ra vào `node.log`.
- Thiết lập biến môi trường `PORT` và `NODE_ENV` cho ứng dụng Next.js.

```xml
<?xml version="1.0" encoding="UTF-8"?>
<configuration>
    <system.webServer>
        <handlers>
            <add name="httpPlatformHandler" path="*" verb="*" modules="httpPlatformHandler" resourceType="Unspecified" requireAccess="Script" />
        </handlers>

        <httpPlatform stdoutLogEnabled="true" stdoutLogFile=".\node.log" startupTimeLimit="20" processPath="C:\Program Files\nodejs\node.exe" arguments=".\server.js">
            <environmentVariables>
                <environmentVariable name="PORT" value="%HTTP_PLATFORM_PORT%" />
                <environmentVariable name="NODE_ENV" value="Production" />
            </environmentVariables>
        </httpPlatform>
    </system.webServer>
</configuration>
```

- Script deploy/build

```bash
npm run build && xcopy public .next\\standalone\\public /E /I /Y && xcopy .next\\static .next\\standalone\\.next\\static /E /I /Y && copy web.config .next\\standalone\\web.config /Y && mkdir .next\\standalone\\iis-logs
```
