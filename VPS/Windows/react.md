# React

- Giữ nguyên đường dẫn các tài nguyên tĩnh (HTML, CSS, JS, ảnh).
- Chuyển hướng mọi URL bắt đầu bằng `/admin` về `/admin.html`.
- Với các yêu cầu khác không trỏ tới file hoặc thư mục thật, chuyển hướng về `/index.html` để xử lý SPA.

```xml
<?xml version="1.0" encoding="UTF-8"?>
<configuration>
    <system.webServer>
        <rewrite>
            <rules>
                <!-- Rule này xử lý các tài nguyên tĩnh như HTML, CSS, JS, ảnh (PNG, GIF, JPG, JPEG, SVG) -->
                <rule name="Static Assets" stopProcessing="true">
                    <match url="([\S]+[.](html|htm|svg|js|css|png|gif|jpg|jpeg))" />
                    <action type="Rewrite" url="/{R:1}" />
                </rule>

                <!-- Rule này sẽ chuyển hướng các yêu cầu bắt đầu với "/admin" đến trang /admin.html -->
                <rule name="Admin Route" stopProcessing="true">
                    <match url="^admin(/.*)?$" />
                    <action type="Rewrite" url="/admin.html" />
                </rule>

                <!-- Rule này xử lý các yêu cầu tới các route của client (SPA) nếu không phải là file hay thư mục có thật trên server -->
                <rule name="Client Routes" stopProcessing="true">
                    <match url=".*" />
                    <conditions logicalGrouping="MatchAll">
                        <add input="{REQUEST_FILENAME}" matchType="IsFile" negate="true" />
                        <add input="{REQUEST_FILENAME}" matchType="IsDirectory" negate="true" />
                    </conditions>
                    <action type="Rewrite" url="/index.html" />
                </rule>
            </rules>
        </rewrite>
    </system.webServer>
</configuration>
```
