## LANENTECH

The website application for the Lanentech Ltd business.

_NOTE: This application has been developed on a Linux machine and is untested on a Windows or macOS machine._

### PREREQUISITES

- This project uses Docker, and therefore you will have to docker engine and docker desktop installed.


- The project makes use of the Make GNU command, so you will need to install this if you haven't got access to it. This 
  comes installed on Linux and macOS out of the box.


- This project uses ports 3306 and 8090. If you have something bound to these ports already, you will experience
  port clashes and will need to resolve them, before building this project.

### INITIAL SETUP

If you've only just cloned the repository, you will need to run `make setup`. Once this has finished, you should have
some Docker containers up and running.

### LOCAL DEVELOPMENT ENVIRONMENT

If you haven't guessed it already, the local development environment uses Docker.

The application also uses PHP, MySQL and NGINX.

If you ever need to completely purge your databases (`dev` and `test`) and start from scratch, you can run
`make rebuild`. It assumes you already have the docker containers running, will purge both `dev` and `test` databases,
re-create them with the relevant schema and seed any fixtures available in the application.

### RUNNING TESTS

To run all the tests for the project, you can simply run `make run-tests`. This will run all Application, Integration
and Unit tests.

If you want to run specific test suites, you can do so using the following make commands:

- `make run-application-tests`
- `make run-integration-tests`
- `make run-unit-tests`
