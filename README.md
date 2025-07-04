# Developer notes:

1. For this project, I used Inertia, Pinia, Lodash (for debouncer), Tailwind, and Axios on the front end
2. The front end uses components to organize the code as an optimal practice in Vue.
3. Tailwind was used for all the UI. I didn't go too heavy on the animations because I did not want to cause performance issues.
4. I created the structure on the back end to send e-mails to deleted contacts; as of now the e-mails are only being logged, because I didn't set up an SMTP server for a test-only environment.
5. In the back-end, I set up CSRF tokens with Laravel and used Axios on the front-end to handle the tokens properly.
6. The e-mail validation logic is separated into two parts, one for creations and another for updates, as Laravel doesn't allow me to update a row if the "unique" constraint is set in the validation without some context to guarantee proper behavior.
7. The task asked for a front end using Inertia and Vue.js, so I had to alter the test 'it should be able to list contacts paginated by 10 items per page' for it to check if the pagination was being generated correctly.
8. I removed some of the .gitignore from the project to give a clearer view of the project in the Github Repo



Objective:

Back-end Assessment: [X] Make all tests pass, applying the best practices of Laravel and SOLID and clean arch

Front-end Assessment: [X] Implement a front-end using Inertia.js, Vue3 and TailwindCss for contact CRUD

* Plus: Feel free to implement improvements and more features as you wish, such as sending an email to the contact when that contact is deleted from the system.

# Updated Installation
1. Clone the repository
2. Have PHP 8.3 installed on your machine, composer 2, and activate the extensions requested by composer when running "composer install"
3. Run "composer install"
4. Run "npm install"
5. Create a .env file and paste the contents of .env.example
6. Run the command php artisan key:generate
7. Git is currently deleting e
8. Run the command php artisan test, solve the tests

7. After the test is complete, create a repository on github, and upload your resolution to the repository
8. Send the repository link to WhatsApp +55 41 98702-5814
