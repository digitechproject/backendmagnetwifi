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
RUN a2enmod rewrite
RUN service apache2 restart

# Ajouter la configuration Apache
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Exposer le port 80
EXPOSE 80
