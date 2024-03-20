FROM nginx

RUN apt-get update && \
    apt-get install -y php8.1-fpm php8.1-mysql

# Remove the default Nginx configuration file
RUN rm /etc/nginx/nginx.d/default.conf

# Copy your Nginx configuration file to the container
COPY docker/nginx/nginx.conf /etc/nginx/conf.d/

# Set the working directory
WORKDIR /var/www/html

# Expose ports
EXPOSE 80