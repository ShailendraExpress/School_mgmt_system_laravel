pipeline {
    agent any

    environment {
        APP_CONTAINER = "school_app"
        NGINX_CONTAINER = "school_nginx"
        DB_CONTAINER = "school_db"
    }

    stages {
        stage('Checkout & Force Repair') {
            steps {
                script {
                    echo "--- Attempting Code Checkout ---"
                    try {
                        checkout scm
                    } catch (Exception e) {
                        echo "Permissions locked! Forcing root cleanup..."
                        // Use Docker to wipe the workspace as root
                        sh 'docker run --rm --user root -v ${WORKSPACE}:/workspace alpine sh -c "rm -rf /workspace/* /workspace/.* || true"'
                        echo "Workspace repaired. Retrying checkout..."
                        checkout scm
                    }
                }
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
                # This finds the actual path on the host machine for Docker volumes
                export HOST_PWD=$(docker inspect jenkins --format '{{ range .Mounts }}{{ if eq .Destination "/var/jenkins_home" }}{{ .Source }}{{ end }}{{ end }}')
                export PROJECT_PATH="${HOST_PWD}/workspace/${JOB_NAME}"
                
                echo "--- Cleaning Old Containers ---"
                docker-compose down || true
                
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

                echo "--- Fixing Permissions for Web Server ---"
                # Give ownership to www-data inside the container
                docker exec ${APP_CONTAINER} chown -R www-data:www-data storage bootstrap/cache
                docker exec ${APP_CONTAINER} chmod -R 775 storage bootstrap/cache
                
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