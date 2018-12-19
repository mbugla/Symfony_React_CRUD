#How to run?

##Requirements:
   - docker
   - npm
 

##API installation:

Clone this repository

go to crud dir
`cd crud`

and run to install dependencies

`composer install`

go to root folder
`cd ..`

and execute

`docker-compose up -d`

It will install docker containers with webapp and database 
REST Api is exposed on port 81 of localhost - make sure the port is not used by any other process on your machine

##Install API client

Api client is a React application

Go to client dir

`cd client`

execute

`npm install`

after successfull instalation you can start application by executing

`yarn start`

or 

`npm start`

After last command app should be available on http://localhost:3000


