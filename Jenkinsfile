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

        stage('2. Keep DB Safe & Running') {
            steps {
                sh '''
                export HOST_PWD=$(docker inspect jenkins --format '{{ range .Mounts }}{{ if eq .Destination "/var/jenkins_home" }}{{ .Source }}{{ end }}{{ end }}')
                export PROJECT_PATH="${HOST_PWD}/workspace/${JOB_NAME}"
                export APP_PATH=${PROJECT_PATH}
                
                # Yeh line 'down' nahi karegi. Container chalte rahenge.
                docker-compose up -d
                '''
            }
        }

        stage('3. Instant Laravel Update') {
            steps {
                sh '''
                # 1. Environment file check (agar delete ho gayi thi toh wapas banayega)
                if [ ! -f .env ]; then
                    echo "Creating new .env file..."
                    cp .env.example .env
                    sed -i 's/DB_HOST=.*/DB_HOST=db/' .env
                    sed -i 's/DB_DATABASE=.*/DB_DATABASE=sms/' .env
                    sed -i 's/DB_USERNAME=.*/DB_USERNAME=root/' .env
                    sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=root/' .env
                fi

                # 2. Composer packages install karega (Vendor folder wapas layega)
                # Note: Agar packages pehle se hain, toh yeh 2 second mein skip ho jayega!
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