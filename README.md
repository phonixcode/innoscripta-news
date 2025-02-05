# Project Overview
The News Aggregator is a full-stack web application designed to aggregate, filter, and display news articles from multiple sources.

# Docker Setup Instructions

This project is fully containerized for seamless deployment. Follow these steps to get the application up and running.

## Prerequisites
Ensure you have the following installed on your machine:
- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Getting Started

### 1. Clone the Repository
```sh
git clone https://github.com/phonixcode/innoscripta-news.git
cd innoscripta-news
```

### 2. Navigate to Backend Directory
The backend service depends on environment variables, navigate into the backend directory before running Docker:
```sh
cd backend
cp .env.example .env
```

### 3. Set Up Environment Variables
```sh
APP_ENV=local
APP_DEBUG=true
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=mydatabase
DB_USERNAME=root
DB_PASSWORD=secret
```
Make sure to update `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` as needed.

### 4. Build and Start the Containers
Run the following command to build and start all services:
```sh
docker-compose up --build
```
This will start the following services:
- **Backend (Laravel API)** running on `http://localhost:8000`
- **MySQL Database** running on port `3306`
- **Frontend (React)** running on `http://localhost:3000`

### 5. Run Database Migrations
Once the containers are up, open a new terminal and run:
```sh
docker exec -it your-backend-container-name php artisan migrate:fresh --seed
```
Replace `your-backend-container-name` with the actual container name.You can find it by running:
```sh
docker ps
```

### 6. Get API Keys (Required for Article Fetching)
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

### 8. Generate Articles Using Artisan Command
To fetch and save articles from the command line, run:
```sh
docker exec -it backend-container-name php artisan articles:fetch-and-save
```

### 9. Access the Application
- **Frontend:** Open `http://localhost:3000`
- **Backend API:** Open `http://localhost:8000`
- **MySQL Database:** Connect using `localhost:3306`, username `root`, and the password set in `.env`

### 10. Stopping the Containers
To stop all running containers, use:
```sh
docker-compose down
```

### 11. Additional Docker Commands
- View running containers:
  ```sh
  docker ps
  ```
- Restart a specific container:
  ```sh
  docker restart your-container-name
  ```
- View container logs:
  ```sh
  docker logs -f your-container-name
  ```

## Troubleshooting
### MySQL Connection Issues
If Laravel cannot connect to MySQL, ensure the database container is running:
```sh
docker-compose ps
```
If needed, restart the database container:
```sh
docker-compose restart mysql
```

### Permission Issues
If you encounter storage permission issues, run:
```sh
docker exec -it your-backend-container-name chmod -R 777 storage bootstrap/cache
```

## Conclusion
You have successfully set up the News Aggregator using Docker!

For further customization, refer to the `README` files in the `/backend` and `/frontend` directories.