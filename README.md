# tymeshift's PHP code test 🧪

## Task Description 
This test project represents a small and simplified part of our backend. It is not identical to what we're using in production but it shows very briefly what is the structure and patterns that we're applying at tymeshift.

## Prerequisites
- `make` installed on your PC
- Docker for running project locally

## Guidelines 
- To build image run `make build` or run `docker build` command from Makefile
- Run `make run` to start container or run `docker run` command from Makefile
- Inside container run `composer install` to install all dependencies 
- Followed by `make test` to run unit test suite
- You can upload your solution to GitHub or send us a ZIP file with the solution via email (via reply in Breezy)

## Tasks
- Look around see what you like \ don't like and get familiar with code structure, so we can discuss it during the interview
- Fix tests and add any improvement you see suitable
- BONUS: Implement `ScheduleService` which picks up a `ScheduleEntity` via `DatabaseInterface` mock and `TaskCollection`
via mocking `HttpClientInterface` response and fills `ScheduleEntity::$items`

Happy coding!
