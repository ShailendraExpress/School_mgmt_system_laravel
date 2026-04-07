pipeline {
    agent any

    environment {
        APP_CONTAINER = "school_app"
        NGINX_CONTAINER = "school_nginx"
        DB_CONTAINER = "school_db"
    }

    stages {

        stage('Checkout Code') {
            steps {
                echo "--- Pulling Latest Code ---"
                checkout scm
            }
        }

        stage('Setup Environment File') {
            steps {
                sh '''
                echo "--- Setting up .env ---"
                cp .env.example .env || true

                sed -i 's/DB_HOST=.*/DB_HOST=db/' .env
                sed -i 's/DB_DATABASE=.*/DB_DATABASE=sms/' .env
                sed -i 's/DB_USERNAME=.*/DB_USERNAME=root/' .env
                sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=root/' .env
                '''
            }
        }

        stage('Start / Update Containers') {
            steps {
                sh '''
                echo "--- Starting Containers (NO DOWN, NO REBUILD) ---"

                export HOST_PWD=$(docker inspect jenkins --format '{{ range .Mounts }}{{ if eq .Destination "/var/jenkins_home" }}{{ .Source }}{{ end }}{{ end }}')
                export PROJECT_PATH="${HOST_PWD}/workspace/${JOB_NAME}"

                export APP_PATH=${PROJECT_PATH}

                docker-compose up -d
                '''
            }
        }

        stage('Laravel Optimize') {
            steps {
                echo "Waiting for containers..."
                sleep 15

                sh '''
                echo "--- Installing Composer (if needed) ---"
                docker exec ${APP_CONTAINER} composer install --no-interaction --prefer-dist --optimize-autoloader

                echo "--- Fixing Permissions ---"
                docker exec ${APP_CONTAINER} chown -R www-data:www-data storage bootstrap/cache
                docker exec ${APP_CONTAINER} chmod -R 775 storage bootstrap/cache

                echo "--- Laravel Optimization (SAFE) ---"
                docker exec ${APP_CONTAINER} php artisan config:cache
                docker exec ${APP_CONTAINER} php artisan route:cache
                docker exec ${APP_CONTAINER} php artisan view:cache

                echo "--- Run Migration (only if needed) ---"
                docker exec ${APP_CONTAINER} php artisan migrate --force
                '''
            }
        }
    }

    post {
        success {
            echo "🚀 Deployment Successful! App Running Smoothly"
        }
        failure {
            echo "❌ Deployment Failed. Check logs."
        }
    }
}