pipeline {
    agent any

    environment {
        APP_CONTAINER = "school_app"
    }

    stages {

        stage('Clean Workspace') {
            steps {
                cleanWs()
            }
        }

        stage('Checkout Code') {
            steps {
                git branch: 'main',
                    url: 'https://github.com/ShailendraExpress/School_mgmt_system_laravel.git'
            }
        }

        stage('Verify Project') {
            steps {
                sh '''
                echo "Checking project files..."
                ls -la

                if [ ! -f artisan ]; then
                    echo "❌ Laravel project missing"
                    exit 1
                fi
                '''
            }
        }

        stage('Setup ENV') {
            steps {
                sh '''
                echo "Setting up .env..."

                cp .env.example .env || true

                sed -i 's/DB_HOST=.*/DB_HOST=db/' .env
                sed -i 's/DB_DATABASE=.*/DB_DATABASE=sms/' .env
                sed -i 's/DB_USERNAME=.*/DB_USERNAME=root/' .env
                sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=root/' .env

                sed -i 's/APP_ENV=.*/APP_ENV=production/' .env
                sed -i 's/APP_DEBUG=.*/APP_DEBUG=false/' .env

                echo "✅ .env ready"
                '''
            }
        }

        stage('Docker Clean') {
            steps {
                sh '''
                echo "Cleaning old containers..."
                docker-compose down -v || true
                '''
            }
        }

        stage('Docker Build & Run') {
            steps {
                sh '''
                echo "Building and starting containers..."
                docker-compose up -d --build
                '''
            }
        }

        stage('Wait for Containers') {
            steps {
                sh '''
                echo "Waiting for services..."
                sleep 20
                '''
            }
        }

        stage('Check Containers') {
            steps {
                sh '''
                echo "Running containers:"
                docker ps

                echo "Nginx Logs:"
                docker logs school_nginx || true

                echo "App Logs:"
                docker logs school_app || true
                '''
            }
        }

        stage('Laravel Setup') {
            steps {
                sh '''
                echo "Running Laravel setup..."

                docker exec ${APP_CONTAINER} php artisan key:generate
                docker exec ${APP_CONTAINER} php artisan migrate --force
                docker exec ${APP_CONTAINER} php artisan config:clear
                docker exec ${APP_CONTAINER} php artisan cache:clear

                docker exec ${APP_CONTAINER} chmod -R 777 storage bootstrap/cache

                echo "✅ Laravel ready"
                '''
            }
        }

        stage('Final Status') {
            steps {
                sh '''
                echo "Final containers:"
                docker ps
                '''
            }
        }
    }

    post {
        success {
            echo "✅ Deployment Successful 🚀"
        }
        failure {
            echo "❌ Deployment Failed"
        }
    }
}