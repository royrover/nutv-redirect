# ใช้ Apache + PHP 8.1 image
FROM php:8.1-apache

# คัดลอกไฟล์ทั้งหมดไปไว้ใน /var/www/html
COPY . /var/www/html/

# เปิดพอร์ต 80 (จำเป็นสำหรับ Render)
EXPOSE 80
