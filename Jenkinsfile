pipeline {
    agent any

    environment {
        COMPOSE_CMD = "docker compose"
    }

    stages {

        stage('Clone Code') {
            steps {
                git branch: 'main', url: 'https://github.com/ShailendraExpress/School_mgmt_system_laravel.git'
            }
        }

        stage('Setup ENV') {
            steps {
                sh '''
                cp .env.example .env || true

                sed -i 's/DB_HOST=.*/DB_HOST=db/' .env
                sed -i 's/DB_DATABASE=.*/DB_DATABASE=school/' .env
                sed -i 's/DB_USERNAME=.*/DB_USERNAME=root/' .env
                sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=root/' .env

                sed -i 's/APP_ENV=.*/APP_ENV=production/' .env
                sed -i 's/APP_DEBUG=.*/APP_DEBUG=false/' .env
                '''
            }
        }

        stage('Docker Deploy') {
            steps {
                sh '''
                ${COMPOSE_CMD} down -v || true
                ${COMPOSE_CMD} up -d --build
                '''
            }
        }

        stage('Wait for Containers') {
            steps {
                sh '''
                echo "Waiting for containers to be ready..."
                sleep 15
                '''
            }
        }

        stage('Laravel Setup') {
            steps {
                sh '''
                docker exec school_app php artisan key:generate || true
                docker exec school_app php artisan migrate --force || true

                docker exec school_app php artisan config:clear || true
                docker exec school_app php artisan cache:clear || true

                docker exec school_app chmod -R 777 storage bootstrap/cache || true
                '''
            }
        }

        stage('Verify') {
            steps {
                sh '''
                docker ps
                '''
            }
        }
    }
}