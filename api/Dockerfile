# Use the official PHP image as the base image
FROM php:8.2-cli

# Set the working directory inside the container
WORKDIR /app

# Copy the PHP backend files into the container
COPY . .

# Install SQLite (if needed)
RUN apt-get update && apt-get install -y sqlite3

# Expose port 10000 for the PHP server
EXPOSE 10000

# Start the PHP built-in web server
CMD ["php", "-S", "0.0.0.0:10000"]