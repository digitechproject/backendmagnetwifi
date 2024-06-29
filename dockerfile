# Utiliser une image PHP avec Apache
FROM php:7.4-apache

# Installer les dépendances nécessaires
RUN apt-get update && apt-get install -y \
    libssl-dev \
    libmcrypt-dev \
    && docker-php-ext-install mysqli

# Copier les fichiers de l'application dans le conteneur
COPY . /var/www/html/

# Configurer Apache pour pointer vers le dossier API
RUN echo "RewriteEngine On\nRewriteCond %{REQUEST_FILENAME} !-f\nRewriteRule ^(api/.*)$ /api/index.php [QSA,L]" > /etc/apache2/sites-available/000-default.conf

# Activer les modules Apache nécessaires
RUN a2enmod rewrite

# Exposer le port 80
EXPOSE 80
