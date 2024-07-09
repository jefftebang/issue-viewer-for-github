# Issue Viewer for GitHub

By using this project, you can view the open issues assigned to you.

Steps to run this project on your local machine:

Run this on your terminal to clone the project:

`git clone https://github.com/jefftebang/issue-viewer-for-github.git`

After cloning, change your directory to the project folder.

Run this to reate an .env file:

`cp .env.example .env`

Fill in the value of the details below:

DB_CONNECTION=mysql

DB_HOST=127.0.0.1

DB_PORT=3306

DB_DATABASE=[name of the schema where you will store the data]

DB_USERNAME=[username of your database]

DB_PASSWORD=[password of your database]

Run this to migrate tables:

`php artisan migrate`

Run this to install composer packages:

`composer install` or `composer update`

Run this to generate key

`php artisan key:generate`

Run this to install npm packages:

`npm install`

Create an OAth Application on your GitHub account:
https://github.com/settings/applications/new

Fill in the three required inputs:

Application name: Sample name of your application

Homepage URL: http://localhost:8000

Authorization callback URL: http://localhost:8000/auth/callback

After saving, create your Client Secret. You can find it under the Client ID. Make sure to copy the newly generated client secret and paste it securely in your notes or wherever. Because you cannot copy it again after you leave or refresh the page.

Go to the created .env file and scroll to the bottom.

Fill in the value of the details below. You can get it in your created OAth Application on GitHub.

GITHUB_CLIENT_ID=

GITHUB_CLIENT_SECRET=

GITHUB_CLIENT_REDIRECT_URL=

Finally, you can run the project.

Run this on your terminal:

`php artisan serve`

Open a new tab or new window in your terminal, then run this:

`npm run dev`

and then open http://localhost:8000 in your browser.
