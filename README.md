# iteo-exercise

Application using docker to start.
## We need to take few steps to launch application:

1) **docker compose up --build** in main folder
1) **docker/bin/composer.sh install** in main folder
1) **docker/bin/npm.sh install** in main folder
1) **docker/bin/npm.sh run build** in main folder
1) **docker/bin/console.sh doc:mig:mig --no-interaction** in main folder


In next order we need to change some credentials in .env file:
* **GITHUB_USERNAME**=username -> github username
* **GITHUB_SECRET**=token -> its personal access token generated in github settings

**To import repositories we are using console command:**
* **docker/bin/console.sh app:import:repository < organization_name > < provider_name >** in main folder
there is one provider configured with name **github**

List of imported repositories is under endpoint: **http://localhost:7777/list**
