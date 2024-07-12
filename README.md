# BVES
BVES (in the expanded version broker, validation, exchange, save)  - the project is aimed at teaching how to work with a message broker on a real business task related to convenient parallel validation and saving them to a database

### Installation
```
  cp .env.example .env
```
### Using
In this system, there is this command that provides the opportunity to simulate an external call to the API being developed
```
  php bin/console app:call-api
```
Also, you need to start the consumer to listen to the queue using this command
```
php bin/console rabbitMQ:consumer-validate-data "Your name queue, which contains the new data" 
```