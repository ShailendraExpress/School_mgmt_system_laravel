pipeline {
    agent any

    stages {

        stage('Clean Workspace') {
            steps {
                deleteDir()
            }
        }

        stage('Clone Code') {
            steps {
                git branch: 'main',
                url: 'https://github.com/ShailendraExpress/School_mgmt_system_laravel.git'
            }
        }

        stage('Verify Files') {
            steps {
                sh '''
                echo "Current Directory:"
                pwd

                echo "Files:"
                ls -l
                '''
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

                echo ".env configured"
                '''
            }
        }

        stage('Docker Down (Clean Old)') {
            steps {
                sh '''
                docker run --rm \
                -v /var/run/docker.sock:/var/run/docker.sock \
                -v $(pwd):/app \
                -w /app \
                docker/compose:latest down -v || true
                '''
            }
        }

        stage('Docker Build & Up') {
            steps {
                sh '''
                docker run --rm \
                -v /var/run/docker.sock:/var/run/docker.sock \
                -v $(pwd):/app \
                -w /app \
                docker/compose:latest up -d --build
                '''
            }
        }

        stage('Wait for Containers') {
            steps {
                sh '''
                echo "Waiting for containers..."
                sleep 20
                '''
            }
        }

        stage('Check Containers') {
            steps {
                sh '''
                docker ps
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

        stage('Final Status') {
            steps {
                sh '''
                echo "Final Running Containers:"
                docker ps
                '''
            }
        }
    }
}