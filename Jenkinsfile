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
                checkout scmGit(
                    branches: [[name: '*/main']],
                    userRemoteConfigs: [[
                        url: 'https://github.com/ShailendraExpress/School_mgmt_system_laravel.git'
                    ]]
                )
            }
        }

        stage('Verify Files') {
            steps {
                sh '''
                echo "Current Directory:"
                pwd

                echo "Project Files:"
                ls -la

                echo "Check nginx folder:"
                ls -la nginx || true

                echo "IMPORTANT CHECK:"
                if [ ! -f artisan ]; then
                    echo "❌ Laravel files missing!"
                    exit 1
                fi

                if [ ! -f nginx/default.conf ]; then
                    echo "❌ nginx config missing!"
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

                echo ".env configured"
                '''
            }
        }

        stage('Docker Down') {
            steps {
                sh '''
                echo "Stopping old containers..."
                docker-compose down -v || true

                echo "Cleaning old Docker cache..."
                docker system prune -af || true
                '''
            }
        }

        stage('Docker Build & Up') {
            steps {
                sh '''
                echo "Building WITHOUT CACHE..."
                docker-compose build --no-cache

                echo "Starting containers..."
                docker-compose up -d
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

                echo "Check nginx config inside container:"
                docker exec school_nginx ls /etc/nginx/conf.d || true
                docker exec school_nginx cat /etc/nginx/conf.d/default.conf || true

                echo "Nginx Logs:"
                docker logs school_nginx || true
                '''
            }
        }

        stage('Laravel Setup') {
            steps {
                sh '''
                echo "Running Laravel setup..."

                docker exec ${APP_CONTAINER} ls /var/www || true

                docker exec ${APP_CONTAINER} php artisan key:generate || true
                docker exec ${APP_CONTAINER} php artisan migrate --force || true
                docker exec ${APP_CONTAINER} php artisan config:clear || true
                docker exec ${APP_CONTAINER} php artisan cache:clear || true

                docker exec ${APP_CONTAINER} chmod -R 777 storage bootstrap/cache || true
                '''
            }
        }

        stage('Final Status') {
            steps {
                sh '''
                echo "Final container status:"
                docker ps
                '''
            }
        }
    }

    post {
        success {
            echo "✅ Deployment Successful! 🚀"
        }
        failure {
            echo "❌ Deployment Failed! Check logs carefully."
        }
    }
}