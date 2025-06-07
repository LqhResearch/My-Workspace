# Laravel

- Bật module Rewrite của Apache.
- Chuyển hướng tất cả truy cập sang HTTPS nếu chưa dùng.
- Nếu URL không bắt đầu bằng `/public/`, tự động chuyển hướng đến thư mục `/public/`.

```md
<IfModule mod_rewrite.c>
    # Bật module Rewrite
    RewriteEngine On

    # Chuyển hướng sang HTTPS nếu không sử dụng
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

    # Kiểm tra nếu đường dẫn không bắt đầu bằng "/public/"
    RewriteCond %{REQUEST_URI} !^/public/

    # Chuyển hướng tất cả các yêu cầu đến thư mục /public/
    RewriteRule ^(.*)$ /public/$1 [L]

</IfModule>
```
