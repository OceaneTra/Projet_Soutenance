# Utiliser l'image officielle PHP avec Apache
FROM php:8.2-apache

# Activer le module de réécriture Apache
RUN a2enmod rewrite

# Copier les fichiers de votre application dans le conteneur
COPY . /var/www/html/

# Donner les bonnes permissions
RUN chown -R www-data:www-data /var/www/html

# Exposer le port 80 pour Apache
EXPOSE 80

# Commande par défaut pour démarrer Apache
CMD ["apache2-foreground"]

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Définir le répertoire de travail
WORKDIR /var/www/html