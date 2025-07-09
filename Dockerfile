FROM php:8.1-apache

# คัดลอกเฉพาะโฟลเดอร์ public ไปยัง DocumentRoot
COPY public/ /var/www/html/

EXPOSE 80
