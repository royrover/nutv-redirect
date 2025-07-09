# ใช้ PHP + Apache official image
FROM php:8.1-apache

# คัดลอกโฟลเดอร์ public ไปที่ root เว็บของ Apache
COPY public/ /var/www/html/

# เปิดพอร์ต 80
EXPOSE 80
