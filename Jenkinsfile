pipeline {
    agent any

    environment {
        APP_CONTAINER = "school_app"
        NGINX_CONTAINER = "school_nginx"
        DB_CONTAINER = "school_db"
    }

    stages {
        stage('Checkout & Sync Code') {
            steps {
                script {
                    echo "--- Pulling Latest Code ---"
                    try {
                        checkout scm
                    } catch (Exception e) {
                        echo "Permissions locked! Forcing root cleanup..."
                        sh 'docker run --rm --user root -v ${WORKSPACE}:/workspace alpine sh -c "rm -rf /workspace/* /workspace/.* || true"'
                        checkout scm
                    }
                }
            }
        }

        stage('Smart Setup Environment') {
            steps {
                sh '''
                # Agar .env file pehle se nahi hai, toh hi nayi banayega
                if [ ! -f .env ]; then
                    echo "Creating new .env file..."
                    cp .env.example .env
                    sed -i 's/DB_HOST=.*/DB_HOST=db/' .env
                    sed -i 's/DB_DATABASE=.*/DB_DATABASE=sms/' .env
                    sed -i 's/DB_USERNAME=.*/DB_USERNAME=root/' .env
                    sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=root/' .env
                else
                    echo ".env file already exists. Skipping setup."
                fi
                '''
            }
        }

        stage('Smart Docker Deploy') {
            steps {
                sh '''
                echo "--- Finding Host Path ---"
                export HOST_PWD=$(docker inspect jenkins --format '{{ range .Mounts }}{{ if eq .Destination "/var/jenkins_home" }}{{ .Source }}{{ end }}{{ end }}')
                export PROJECT_PATH="${HOST_PWD}/workspace/${JOB_NAME}"
                export APP_PATH=${PROJECT_PATH}
                
                echo "--- Updating Containers (No Downtime) ---"
                # docker-compose down HATA DIYA GAYA HAI
                # Yeh command sirf tabhi naya container banayegi jab Dockerfile mein change ho.
                # Minor Blade file changes par yeh bas check karega aur aage badh jayega (1 second mein).
                docker-compose up -d --build
                '''
            }
        }

        stage('Laravel Fast Update') {
            steps {
                sh '''
                echo "--- Fixing Permissions ---"
                # Nayi files aayi hain, unki permissions set karna zaroori hai
                docker exec ${APP_CONTAINER} chown -R www-data:www-data storage bootstrap/cache
                docker exec ${APP_CONTAINER} chmod -R 775 storage bootstrap/cache
                
                echo "--- Updating Laravel Cache & DB ---"
                # Sirf cache clear karega aur nayi migrations (agar koi hai) run karega
                docker exec ${APP_CONTAINER} php artisan optimize:clear
                docker exec ${APP_CONTAINER} php artisan migrate --force
                
                # Composer install fast mode mein chalega (agar nayi library add nahi hui toh 2 sec mein skip ho jayega)
                docker exec ${APP_CONTAINER} composer install --no-interaction --prefer-dist --optimize-autoloader
                '''
            }
        }
    }

    post {
        success { 
            echo "🚀 Update Deployed Successfully! URL: http://103.160.107.245:8083" 
        }
        failure { 
            echo "❌ Deployment Failed. Check logs above." 
        }
    }
}