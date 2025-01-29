# Setup Guide

## Prerequisites

Before you begin, ensure you have met the following requirements:

- **PHP** >= PHP 8.1+
- **Composer** (Dependency Manager for PHP)
- **MySQL** or another supported database

## Installation Steps

1. **Clone the Repository**

   Clone the project repository to your local machine:

   ```bash
   git clone https://github.com/phonixcode/innoscripta-news.git
   cd innoscripta-news
   cd backend
   ```

2. **Install dependencies**:
   ```bash
   composer install
   ```

3. **Set up your environment file**:
   ```bash
   cp .env.example .env
   ```

4. **Generate the application key**:
   ```bash
   php artisan key:generate
   ```

5. **Configure your database**: 
   Open the `.env` file and set your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```
6. **Run database migrations**:
   ```bash
   php artisan migrate
   ```

7. **(Optional) Seed the database**: 
   You can seed your database with initial data using:
   ```bash
   php artisan db:seed
   ```

8. **Get API Keys (Required for Article Fetching)**:
   The application requires API keys from different news sources. Obtain them from:

   - NewsAPI: [Get your API key](https://newsapi.org/docs/get-started)
   - The Guardian API: [Get your API key](https://open-platform.theguardian.com/access/)
   - New York Times API: [Get your API key](https://developer.nytimes.com/apis)

   Once obtained, add them to the `.env` file:

   ```sh
   NEWS_API_KEY=your_newsapi_key
   GUARDIAN_API_KEY=your_guardian_api_key
   NYT_API_KEY=your_nyt_api_key
   ```

9. **Generate Articles Using Artisan Command**:
    To fetch and save articles from the command line, run:
    ```sh
    php artisan articles:fetch-and-save
    ```
10. **Access the Application**:
    ```sh
    php artisan serve
    ```
    **Backend API:** Open `http://localhost:8000`