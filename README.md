## Project Context & Background

Payvice is an ITEX  web application hosted on https://payvice.com . It allows users to carry out their payvice services on the on the web application


## Data

Payvice.com gets is data from VAS BACKEND API AND TAMS API SERVICE


## Front-end
The frontend is built with HTML,JAVASCRIPT and CSS
### Commands

### Styles and Javascript

ALl the FE assets are living inside **public**

### API

2 sources for the API inside the application :
1. VAS 4.0 Endpoints that for VAS transactions
2. TAMS Endpoints for user authentication and wallet activities and other necessary activities


### Authentication

The service uses a key based authentication with TAMS and a JWT header token with VAS backend api service.

Users can login to the application with their normal Payvice login details

## Backend

## Installing this app
- Clone repository
- composer install
- configure your .env
- uncomment the test parameters in app/Http/contollers/VasFourOperations

## Deploying the application manually:
- the application is deployed on deploy.eu2.frbit.com
- cd vice
- git pull