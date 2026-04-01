pipeline {
    agent any

    stages {
        stage('Clone Code') {
            steps {
                git branch: 'main', url: 'https://github.com/ShailendraExpress/School_mgmt_system_laravel.git'
            }
        }

        stage('Setup ENV') {
            steps {
                sh 'cp .env.example .env'
            }
        }

        stage('Build Docker') {
            steps {
                sh 'docker-compose down'
                sh 'docker-compose up -d --build'
            }
        }
    }
}