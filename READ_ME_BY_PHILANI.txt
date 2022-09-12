These are the steps on how to run the project:

1.After you have downloaded the project from Github and unzipped it, you need to create the database named "csv" on MyPHP Admin.
2.then you need to run this command "php artisan migrate" for creating the database tables.
3.After you have ran the above command you can now open Command prompt and change directory to where your project is, e.g "cd directory/where/your/project /is".
4.Now run this command "php artisan serve" to start the development server.
5.open the browser and put this home URL: http://127.0.0.1:8000/

/*
*The "output.csv" file will be saved into this directory "public/" inside the project
*The uploaded file will be saved into this directory "public/files" inside the project.
*The files uploaded will show after you have saved your first file.
*/