pipeline {
    agent any

    options {
        skipDefaultCheckout(true)
    }

    stages {

        

        stage('Clean Workspace') {
    steps {
        deleteDir()
    }
}

        stage('Clone Code') {
    steps {
        sh '''
        rm -rf .git
        git init
        git remote add origin https://github.com/ShailendraExpress/School_mgmt_system_laravel.git
        git fetch --all
        git reset --hard origin/main
        '''
    }
}
        

        stage('Setup ENV') {
            steps {
                sh '''
                cp .env.example .env

                sed -i 's/DB_HOST=.*/DB_HOST=db/' .env
                sed -i 's/DB_DATABASE=.*/DB_DATABASE=school/' .env
                sed -i 's/DB_USERNAME=.*/DB_USERNAME=root/' .env
                sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=root/' .env

                sed -i 's/APP_ENV=.*/APP_ENV=production/' .env
                sed -i 's/APP_DEBUG=.*/APP_DEBUG=false/' .env
                '''
            }
        }

        stage('Build & Run Docker') {
            steps {
                sh '''
                docker compose down
                docker compose up -d --build
                '''
            }
        }

       stage('Laravel Setup') {
          steps {
        sh '''
        docker exec school_app bash -c "cd /var/www && php artisan key:generate"

        docker exec school_app php artisan migrate --force

        docker exec school_app php artisan config:clear
        docker exec school_app php artisan cache:clear

        docker exec school_app chmod -R 777 storage bootstrap/cache
        '''
    }
    
}
    }
}