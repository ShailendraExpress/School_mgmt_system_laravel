pipeline {
    agent any

    environment {
        APP_CONTAINER = "school_app"
    }

    stages {

        stage('Clean Workspace') {
            steps {
                cleanWs()
            }
        }

        stage('Checkout Code') {
            steps {
                git branch: 'main',
                    url: 'https://github.com/ShailendraExpress/School_mgmt_system_laravel.git'
            }
        }

        stage('Verify Files') {
            steps {
                sh '''
                ls -la

                if [ ! -f artisan ]; then
                    echo "❌ Laravel missing"
                    exit 1
                fi

                if [ ! -f nginx/default.conf ]; then
                    echo "❌ nginx config missing"
                    exit 1
                fi
                '''
            }
        }

        stage('Fix Wrong Folder Issue') {
            steps {
                sh '''
                if [ -d nginx/default.conf ]; then
                    echo "Fixing wrong folder..."
                    rm -rf nginx/default.conf
                    echo "Creating correct file..."
                    cat > nginx/default.conf <<EOF
server {
    listen 80;
    server_name localhost;

    root /var/www/public;
    index index.php index.html;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \\.php$ {
        include fastcgi_params;
        fastcgi_pass school_app:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
    }

    location ~ /\\. {
        deny all;
    }
}
EOF
                fi
                '''
            }
        }

        stage('Setup ENV') {
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

        stage('Docker Build & Run') {
            steps {
                sh '''
                docker-compose down -v || true
                docker-compose up -d --build
                '''
            }
        }

        stage('Laravel Setup') {
            steps {
                sh '''
                sleep 15

                docker exec ${APP_CONTAINER} php artisan key:generate
                docker exec ${APP_CONTAINER} php artisan migrate --force
                docker exec ${APP_CONTAINER} chmod -R 777 storage bootstrap/cache
                '''
            }
        }
    }

    post {
        success {
            echo "✅ SUCCESS"
        }
        failure {
            echo "❌ FAILED"
        }
    }
}