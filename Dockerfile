# Use an official PHP runtime as a parent image
FROM php:7.4-apache

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Copy the current directory contents into the container at /var/www/html
COPY . /var/www/html

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install any needed extensions
RUN docker-php-ext-install mysqli pdo_mysql

# Expose port 80 for web traffic
EXPOSE 80