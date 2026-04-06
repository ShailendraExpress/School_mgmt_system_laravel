pipeline {
    agent any

    environment {
        APP_CONTAINER = "school_app"
    }

    stages {
        stage('1. Pull New Code') {
            steps {
                script {
                    echo "--- Sirf Naya Code Pull Kar Rahe Hain ---"
                    try {
                        checkout scm
                    } catch (Exception e) {
                        echo "Permissions locked! Clearing old cache..."
                        sh 'docker run --rm --user root -v ${WORKSPACE}:/workspace alpine sh -c "rm -rf /workspace/* /workspace/.* || true"'
                        checkout scm
                    }
                }
            }
        }

        stage('2. Smart Restart Containers') {
            steps {
                sh '''
                export HOST_PWD=$(docker inspect jenkins --format '{{ range .Mounts }}{{ if eq .Destination "/var/jenkins_home" }}{{ .Source }}{{ end }}{{ end }}')
                export PROJECT_PATH="${HOST_PWD}/workspace/${JOB_NAME}"
                export APP_PATH=${PROJECT_PATH}
                
                # UPDATE: Pehle purane containers ko gracefully stop/remove karega (bina data udaye)
                # Taki "Name already in use" wala error kabhi na aaye.
                docker-compose down || true
                
                # Phir naye containers banayega
                docker-compose up -d --build
                '''
            }
        }

        stage('3. Instant Laravel Update') {
            steps {
                sh '''
                # 1. Environment file check
                if [ ! -f .env ]; then
                    echo "Creating new .env file..."
                    cp .env.example .env
                    sed -i 's/DB_HOST=.*/DB_HOST=db/' .env
                    sed -i 's/DB_DATABASE=.*/DB_DATABASE=sms/' .env
                    sed -i 's/DB_USERNAME=.*/DB_USERNAME=root/' .env
                    sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=root/' .env
                fi

                echo "Waiting 10 seconds for DB to wake up..."
                sleep 10

                # 2. Composer packages install karega (bahut zaruri, iske bina Laravel fail hota hai)
                docker exec ${APP_CONTAINER} composer install --no-interaction --prefer-dist --optimize-autoloader

                # 3. Permissions theek karega
                docker exec ${APP_CONTAINER} chown -R www-data:www-data storage bootstrap/cache || true
                docker exec ${APP_CONTAINER} chmod -R 775 storage bootstrap/cache || true
                
                # 4. View Cache clear karega taaki naya Blade design turant dikhe
                docker exec ${APP_CONTAINER} php artisan view:clear
                '''
            }
        }
    }

    post {
        success { 
            echo "🚀 FAST Update Successful! URL: http://103.160.107.245:8083" 
        }
        failure { 
            echo "❌ Deployment Failed. Check logs above." 
        }
    }
}