# BVES
BVES (in the expanded version broker, validation, exchange, save)  - the project is aimed at teaching how to work with a message broker on a real business task related to convenient parallel validation and saving them to a database

### Installation
```
  cp .env.example .env
```
It is necessary to update the data in the received env file.
Then run the following commands:
```
make create
make start
make install-composer
```
```
make create-db
make migrate
```
```
make run-server
```

### Using
Also, you need to start the consumer to listen to the queue using this command
```
make run-consumer-validate 
```
You also need to run the consumer to work with the database
```
make run-consumer-db
```
After the above steps, you can simulate the interaction of an external service with our api
```
  make run-external-api
```
