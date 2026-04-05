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

        stage('Verify Project') {
            steps {
                sh '''
                echo "Checking project files..."
                ls -la

                if [ ! -f artisan ]; then
                    echo "❌ Laravel project missing"
                    exit 1
                fi
                '''
            }
        }

        stage('Force Fix nginx config') {
            steps {
                sh '''
                echo "Fixing nginx config (force mode)..."

                # ALWAYS remove (file ho ya folder)
                rm -rf nginx/default.conf

                # Recreate correct file
                cat > nginx/default.conf <<'EOF'
server {
    listen 80;
    server_name localhost;

    root /var/www/public;
    index index.php index.html;

    client_max_body_size 20M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass school_app:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    location ~ /\. {
        deny all;
    }
}
EOF

                echo "✅ nginx config fixed"
                ls -l nginx/
                '''
            }
        }

        stage('Setup ENV') {
            steps {
                sh '''
                echo "Setting up .env..."

                cp .env.example .env || true

                sed -i 's/DB_HOST=.*/DB_HOST=db/' .env
                sed -i 's/DB_DATABASE=.*/DB_DATABASE=sms/' .env
                sed -i 's/DB_USERNAME=.*/DB_USERNAME=root/' .env
                sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=root/' .env

                sed -i 's/APP_ENV=.*/APP_ENV=production/' .env
                sed -i 's/APP_DEBUG=.*/APP_DEBUG=false/' .env

                echo "✅ .env ready"
                '''
            }
        }

        stage('Docker Clean') {
            steps {
                sh '''
                echo "Cleaning old containers..."
                docker-compose down -v || true
                docker system prune -af || true
                '''
            }
        }

        stage('Docker Build & Run') {
            steps {
                sh '''
                echo "Building containers..."
                docker-compose build --no-cache

                echo "Starting containers..."
                docker-compose up -d
                '''
            }
        }

        stage('Wait for Containers') {
            steps {
                sh '''
                echo "Waiting for services..."
                sleep 20
                '''
            }
        }

        stage('Check Containers') {
            steps {
                sh '''
                echo "Running containers:"
                docker ps

                echo "Check nginx config:"
                docker exec school_nginx ls /etc/nginx/conf.d || true
                docker exec school_nginx cat /etc/nginx/conf.d/default.conf || true

                echo "Nginx Logs:"
                docker logs school_nginx || true
                '''
            }
        }

        stage('Laravel Setup') {
            steps {
                sh '''
                echo "Running Laravel setup..."

                docker exec ${APP_CONTAINER} php artisan key:generate
                docker exec ${APP_CONTAINER} php artisan migrate --force
                docker exec ${APP_CONTAINER} php artisan config:clear
                docker exec ${APP_CONTAINER} php artisan cache:clear

                docker exec ${APP_CONTAINER} chmod -R 777 storage bootstrap/cache

                echo "✅ Laravel ready"
                '''
            }
        }

        stage('Final Status') {
            steps {
                sh '''
                echo "Final containers:"
                docker ps
                '''
            }
        }
    }

    post {
        success {
            echo "✅ Deployment Successful 🚀"
        }
        failure {
            echo "❌ Deployment Failed"
        }
    }
}
