## LANENTECH

The website application for the Lanentech Ltd business.

_NOTE: This application has been built on a Linux machine and is untested on a Windows or macOS machine._

### INITIAL SETUP

If you've only just cloned the repository, you will need to run `make setup`. Once this has finished, you should have
some Docker containers up and running.

_NOTE: If you receive "Connection Refused" from the database commands, please wait ~20 seconds and re-run the command.
This can happen when the DB docker container has not yet finished building, and the `make setup` command is trying to
create the database and update the schema, etc._

### LOCAL DEVELOPMENT ENVIRONMENT

If you haven't guessed it already, the local development environment uses Docker.

The application also uses PHP, MySQL and NGINX.

If you ever need to completely purge your databases (`dev` and `test`) and start from scratch, you can run
`make rebuild`. It assumes you already have the docker containers running, will purge both `dev` and `test` databases,
re-create them with the relevant schema and seed any fixtures available in the application.
