pipeline {
    agent any

    environment {
        APP_CONTAINER = "school_app"
        NGINX_CONTAINER = "school_nginx"
        DB_CONTAINER = "school_db"
    }

    stages {
        stage('Emergency Cleanup') {
            steps {
                script {
                    echo "--- Fixing Permissions Before Checkout ---"
                    // Hum Alpine container use karke workspace ki ownership Jenkins (ID 1000) ko wapas de rahe hain
                    // Isse 'Permission Denied' wala error checkout mein nahi aayega
                    sh 'docker run --rm -v ${WORKSPACE}:/workspace alpine chown -R 1000:1000 /workspace || true'
                    
                    echo "--- Cleaning Workspace ---"
                    deleteDir()
                }
            }
        }

        stage('Checkout Code') {
            steps {
                // Fresh code pull karein
                checkout scm
            }
        }

        stage('Setup Environment') {
            steps {
                sh '''
                cp .env.example .env || true
                sed -i 's/DB_HOST=.*/DB_HOST=db/' .env
                sed -i 's/DB_DATABASE=.*/DB_DATABASE=sms/' .env
                sed -i 's/DB_USERNAME=.*/DB_USERNAME=root/' .env
                sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=root/' .env
                '''
            }
        }

        stage('Docker Deploy') {
            steps {
                sh '''
                echo "--- Finding Host Path ---"
                # Jenkins container ke bahar ka asli path nikalna zaroori hai mount ke liye
                export HOST_PWD=$(docker inspect jenkins --format '{{ range .Mounts }}{{ if eq .Destination "/var/jenkins_home" }}{{ .Source }}{{ end }}{{ end }}')
                export PROJECT_PATH="${HOST_PWD}/workspace/${JOB_NAME}"
                
                echo "--- Cleaning Old Containers ---"
                docker-compose down || true
                docker rm -f ${APP_CONTAINER} ${NGINX_CONTAINER} ${DB_CONTAINER} || true
                
                echo "--- Starting Services ---"
                export APP_PATH=${PROJECT_PATH}
                docker-compose up -d --build
                '''
            }
        }

        stage('Laravel Setup & Permissions') {
            steps {
                echo "Waiting for containers to stabilize..."
                sleep 20
                sh '''
                echo "--- Installing Dependencies ---"
                docker exec ${APP_CONTAINER} composer install --no-interaction --prefer-dist --optimize-autoloader

                echo "--- Setting Permissions inside Container ---"
                # Laravel ko storage folder mein likhne ki ijazat dena
                docker exec ${APP_CONTAINER} chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
                docker exec ${APP_CONTAINER} chmod -R 775 /var/www/storage /var/www/bootstrap/cache
                
                echo "--- Running Laravel Commands ---"
                docker exec ${APP_CONTAINER} php artisan key:generate --force
                docker exec ${APP_CONTAINER} php artisan config:clear
                docker exec ${APP_CONTAINER} php artisan cache:clear
                docker exec ${APP_CONTAINER} php artisan migrate --force
                '''
            }
        }
    }

    post {
        success { 
            echo "🚀 Deployment Successful! URL: http://103.160.107.245:8083" 
        }
        failure { 
            echo "❌ Deployment Failed. Check logs above." 
        }
    }
}