pipeline {
    agent any

    environment {
        COMPOSE = "docker run --rm -v /var/run/docker.sock:/var/run/docker.sock -v ${WORKSPACE}:/app -w /app docker/compose:latest"
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
                echo "Current Directory:"
                pwd

                echo "Files:"
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

                echo ".env configured"
                '''
            }
        }

        stage('Docker Down (Clean Old)') {
            steps {
                sh '''
                ${COMPOSE} down -v || true
                '''
            }
        }

        stage('Docker Build & Up') {
            steps {
                sh '''
                ${COMPOSE} up -d --build
                '''
            }
        }

        stage('Wait for Containers') {
            steps {
                sh 'sleep 20'
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
                echo "Running Laravel commands..."

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
                echo "Final Running Containers:"
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
            echo "❌ Deployment Failed! Check logs."
        }
    }
}