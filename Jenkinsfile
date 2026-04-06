pipeline {
    agent any

    environment {
        APP_CONTAINER = "school_app"
        NGINX_CONTAINER = "school_nginx"
    }

    stages {
        stage('Clean & Checkout') {
            steps {
                // Workspace ko puri tarah saaf karke fresh pull karega
                deleteDir()
                git branch: 'main', 
                    url: 'https://github.com/ShailendraExpress/School_mgmt_system_laravel.git'
            }
        }

        stage('Verify Files') {
            steps {
                sh '''
                echo "--- Checking Files ---"
                ls -la
                if [ ! -f docker-compose.yml ]; then
                    echo "❌ Error: docker-compose.yml not found in workspace!"
                    exit 1
                fi
                '''
            }
        }

        stage('Setup Environment') {
            steps {
                sh '''
                if [ ! -f .env ]; then
                    cp .env.example .env || true
                fi
                sed -i 's/DB_HOST=.*/DB_HOST=db/' .env
                sed -i 's/DB_DATABASE=.*/DB_DATABASE=sms/' .env
                sed -i 's/DB_USERNAME=.*/DB_USERNAME=root/' .env
                sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=root/' .env
                echo "✅ .env configured"
                '''
            }
        }

        stage('Docker Deploy') {
            steps {
                sh '''
                echo "--- Finding Host Path ---"
                # Ye command Jenkins container ke andar se bahar ka asli path dhoondti hai
                export HOST_PWD=$(docker inspect jenkins --format '{{ range .Mounts }}{{ if eq .Destination "/var/jenkins_home" }}{{ .Source }}{{ end }}{{ end }}')
                export PROJECT_PATH="${HOST_PWD}/workspace/${JOB_NAME}"
                
                echo "Deploying from: ${PROJECT_PATH}"
                
                docker-compose down || true
                
                # Hum manually volume mount override kar rahe hain
                docker run -d --name school_app -v ${PROJECT_PATH}:/var/www school_app-app
                docker run -d --name school_nginx -p 8083:80 -v ${PROJECT_PATH}:/var/www school_app-nginx
                
                # Ya phir agar aap compose hi use karna chahte hain:
                # docker-compose up -d --build
                '''
            }
        }

        stage('Wait & Health Check') {
            steps {
                sleep 15
                sh '''
                docker ps
                # Check if Nginx can see the public folder
                docker exec ${NGINX_CONTAINER} ls -l /var/www/public || echo "❌ Nginx still cannot see files!"
                '''
            }
        }

        stage('Laravel Optimization & Permissions') {
            steps {
                sh '''
                echo "--- Setting Permissions ---"
                docker exec ${APP_CONTAINER} chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
                docker exec ${APP_CONTAINER} chmod -R 775 /var/www/storage /var/www/bootstrap/cache
                
                echo "--- Laravel Commands ---"
                docker exec ${APP_CONTAINER} php artisan key:generate --force
                docker exec ${APP_CONTAINER} php artisan config:cache
                docker exec ${APP_CONTAINER} php artisan migrate --force
                '''
            }
        }
    }

    post {
        success {
            echo "🚀 Deployment Successful! Site should be live at :8083"
        }
        failure {
            echo "❌ Deployment Failed. Check Jenkins logs above."
        }
    }
}