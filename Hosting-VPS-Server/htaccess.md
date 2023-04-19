# Cấu hình file `.htaccess` trong hosting, vps và server

## 1. Hosting

- Sử dụng cho **Laravel** có công dụng là:
  - Chuyển tất cả URI có phương thức http sang phương thức https.
  - Chuyển tất cả URI sang thư mục `public`.

```html
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
    RewriteCond %{REQUEST_URI} !^/public/
    RewriteRule ^(.*)$ /public/$1 [L]
</IfModule>
```