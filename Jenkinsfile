pipeline {
    agent any

    stages {
        stage('Build Docker') {
            steps {
                sh 'docker-compose down'
                sh 'docker-compose up -d --build'
            }
        }

        stage('Check Running') {
            steps {
                sh 'docker ps'
            }
        }
    }
}