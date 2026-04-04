pipeline {
    agent any

    environment {
        APP_CONTAINER = "school_app"
    }

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
                pwd
                ls -la
                '''
            }
        }

        stage('Setup ENV') {
            steps {
                sh '''
                if [ ! -f .env ]; then
                    cp .env.example .env
                fi

                sed -i 's/DB_HOST=.*/DB_HOST=db/' .env
                sed -i 's/DB_DATABASE=.*/DB_DATABASE=school/' .env
                sed -i 's/DB_USERNAME=.*/DB_USERNAME=root/' .env
                sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=root/' .env

                sed -i 's/APP_ENV=.*/APP_ENV=production/' .env
                sed -i 's/APP_DEBUG=.*/APP_DEBUG=false/' .env
                '''
            }
        }

        stage('Docker Down') {
            steps {
                sh 'docker compose down -v || true'
            }
        }

        stage('Docker Build & Up') {
            steps {
                sh 'docker compose up -d --build'
            }
        }

        stage('Wait for Containers') {
            steps {
                sh 'sleep 25'
            }
        }

        stage('Check Containers') {
            steps {
                sh 'docker ps'
            }
        }

        stage('Laravel Setup') {
            steps {
                sh '''
                echo "Running Laravel setup..."

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
                echo "Final running containers:"
                docker ps
                '''
            }
        }
    }

    post {
        success {
            echo "✅ Deployment Successful!"
        }
        failure {
            echo "❌ Deployment Failed!"
        }
    }
}