# Imagen base oficial de PHP
FROM php:8.2-apache

# Copiar todos los archivos al contenedor
COPY . /var/www/html/

# Exponer el puerto donde se ejecutará (Render usa 10000 por defecto)
EXPOSE 10000

# Indicar a Apache que escuche en el puerto 10000
CMD ["bash", "-c", "sed -i 's/80/10000/g' /etc/apache2/sites-available/000-default.conf && apache2-foreground"]
