# WordPress

- Cấu hình IIS dùng `httpPlatformHandler` để chạy ứng dụng Node.js.
- Khởi động Node với file `server.js` và ghi log đầu ra vào thư mục `logs`.
- Thiết lập biến môi trường `PORT` và `NODE_ENV` cho môi trường sản xuất.

```xml
<?xml version="1.0" encoding="UTF-8"?>
<configuration>
    <system.webServer>
        <handlers>
            <add name="httpPlatformHandler" path="*" verb="*" modules="httpPlatformHandler" resourceType="Unspecified" requireAccess="Script" />
        </handlers>

        <httpPlatform stdoutLogEnabled="true" stdoutLogFile=".\logs\node.log" startupTimeLimit="20" processPath="C:\Program Files\nodejs\node.exe" arguments=".\server.js">
            <environmentVariables>
                <environmentVariable name="PORT" value="%HTTP_PLATFORM_PORT%" />
                <environmentVariable name="NODE_ENV" value="Production" />
            </environmentVariables>
        </httpPlatform>
    </system.webServer>
</configuration>
```
