FROM php:8.2-cli

# Install system dependencies, git, unzip, and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy composer files first
COPY composer.json composer.lock* ./

# Install dependencies (without --no-dev for now to avoid issues)
RUN composer install --optimize-autoloader --no-interaction

# Copy the rest of the project files
COPY . .

# Expose port
EXPOSE 8000

# Start PHP server
CMD php -S 0.0.0.0:${PORT:-8000}

# FROM php:8.2-cli

# # Install system dependencies, git, unzip, and PHP extensions
# RUN apt-get update && apt-get install -y \
#     git \
#     unzip \
#     libzip-dev \
#     && docker-php-ext-install zip \
#     && rm -rf /var/lib/apt/lists/*

# # Install Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# # Set working directory
# WORKDIR /app

# # Copy project files
# COPY . .

# # Install dependencies
# RUN composer install --no-dev --optimize-autoloader

# # Expose port
# EXPOSE 8000

# # Start PHP server
# CMD php -S 0.0.0.0:${PORT:-8000}
