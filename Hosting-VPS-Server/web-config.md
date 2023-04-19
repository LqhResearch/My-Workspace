# Cấu hình file `web.config` trong hosting, vps và server

## 1. VPS (Window Server)

- Sử dụng cho **Laravel** có công dụng là:
  - Chuyển tất cả URI có phương thức http sang phương thức https.
  - Chuyển tất cả URI sang thư mục `public`.

```html
<configuration>
    <system.webServer>
        <rewrite>
            <rules>
                <!-- RewriteRule 1 -->
                <rule name="HTTPS Redirect" stopProcessing="true">
                    <match url="^(.*)$" />
                    <conditions>
                        <add input="{HTTPS}" pattern="off" />
                    </conditions>
                    <action type="Redirect" url="https://{HTTP_HOST}/{R:1}" redirectType="Permanent" />
                </rule>
                <!-- RewriteRule 2 -->
                <rule name="Public Folder" stopProcessing="true">
                    <match url="^(.*)$" />
                    <conditions>
                        <add input="{REQUEST_URI}" pattern="^/public/" negate="true" />
                    </conditions>
                    <action type="Rewrite" url="/public/{R:1}" />
                </rule>
            </rules>
        </rewrite>
    </system.webServer>
</configuration>
```