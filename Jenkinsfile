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
                
                # Yeh line 'down' nahi karegi, aur '--build' bhi hata diya hai.
                # Agar DB aur Server pehle se chal rahe hain, toh yeh kuch nahi karega (0 seconds lagenge).
                docker-compose up -d
                '''
            }
        }

        stage('3. Instant Laravel Update') {
            steps {
                sh '''
                # 1. Laravel ko error na aaye isliye permissions theek ki
                docker exec ${APP_CONTAINER} chown -R www-data:www-data storage bootstrap/cache || true
                docker exec ${APP_CONTAINER} chmod -R 775 storage bootstrap/cache || true
                
                # 2. Sirf View Cache clear kiya taaki naya Blade design turant dikhe!
                docker exec ${APP_CONTAINER} php artisan view:clear
                '''
            }
        }
    }

    post {
        success { 
            echo "🚀 FAST Update Successful! URL: http://103.160.107.245:8083" 
        }
    }
}