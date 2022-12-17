### The scope for works include the followings:

<ul>
<li>System study of the manual system practiced for class routine management.</li>
<li>Design and Development a dynamic web application for faculty.</li>
<li>Implementation of Class Routine Management System.</li>
<li>Maintenance of the Class Routine Management System.</li>
</ul>


### Modules:

| **SL** | **Module Title** | **Description** |
| --- | --- | --- |
| 1 | Batch | <ol><li>Create Batch with Department, Batch No. and Shift</li><li>Edit / Delete Batch </li></ol>|
| 2 | Departments | <ol><li> Create Departments (example: CSE, MBA etc.) </li><li>  Edit / Delete Departments </li> </ol> |
| 3 | Courses | <ol><li>Create Courses with Course Code, Credit and Course type (example: Data Communication-CSE435-3-Theory etc.) </li> <li>Edit / Delete Courses</li> <ol>|
| 4 | Rooms | <ol> <li>Create Rooms with Building, Room no, Capacity (example: A-101-Theory, B-203-Lab etc.)</li> <li>Edit / Delete Rooms</li> </ol> |
| 5 | Sections | <ol><li>Create different sections and their sub sections including their type (example: A-Theory, A1-Lab)</li> <li>Edit / Delete Sections</li> </ol>  |
| 6 | Sessions &amp; Yearly Sessions | <ol><li>Create Sessions (example: Fall, Summer, Spring) </li><li>Edit / Delete Sessions3. Generate Yearly Sessions every year which includes sessions (example: Fall-2020, Summer-2020, Spring-2020)</li><li>Activate or Deactivate yearly sessions</li></ol> |
| 7 | Teacher Ranks | <ol><li> Create Teacher Ranks (example: Lecturer, Sr. Lecturer)</li><li>Edit / Delete Teacher Ranks</li></ol> |
| 8 | Teacher Management | <ol><li> Add New Teacher with their corresponding information which includes role, rank and photo etc. </li><li>Edit / Delete Teacher Data</li><li>Assign teachers off day</li><li>Assigning teachers in routine committee</li><li>Inviting Teachers with expire time of accessing the main sheet</li><li>Revoke access of main sheet</li></ol> |
| 9 | Teacher Workloads |  <ol><li>Assign courses to teachers including the yearly session</li><li>Edit / Delete Workload Data </li> </ol> |
| 10 | Student Management Batch &amp; Section Wise |  <ol><li>Assign number of students in a batch including the yearly session and shifts</li><li>Assign number of students theory and lab wise </li><li>Edit / Delete Assigned Data </li> </ol> |
| 11 | Time Slot Management | <ol><li>Create Time Slots by Start time and end time</li><li>Edit / Delete time slots</li></ol> |
| 12 | Course Offers | <ol><li>Assign Courses to Batch with sessions</li><li>Edit / Delete Course offers data</li></ol> |
| 13 | Day wise time &amp; Class slot management | <ol><li>Assign Time Slots to Days</li><li>Assign Class Slots to Day and time slot</li><li>Edit Information of day</li></ol>|
| 14 | Assign Data in Main Sheet |<ol><li>Assign data (Teacher, Course, Room) in main sheet</li><li>Edit Assigned Data</li></ol>|
| 15 | Routine View &amp; Download | <ol><li>List view for batch and teachers</li><li>Search Teacher and batch view</li><li>Download as PDF</li></ol>

### Installation 
After cloning this repo create an .env file and copy everything from .env.example<br>
<pre> cp .env.example .env </pre>
It will create a copy of .env.example as .env <br><br>
Now open the .env file you just created and give a database name on DB_DATABASE as you want<br>
Suppose the database name is routine<br>
The database configuration will look like this<br>
<pre>DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=routine
DB_USERNAME=root
DB_PASSWORD=</pre>
After that create a database named as "routine" which I used as an example above <br><br>
Now install all composer packages <br>
<pre> composer install </pre>
Now generate an APP_KEY <br>
<pre> php artisan key:generate </pre>
Then run migration as well as db:seed command to get some pre-existing data to get started with the project<br>
<pre> php artisan migrate:fresh --seed </pre>
Now you can serve the project or run with xampp anyway you prefer<br><br>
To serve with artisan <br>
<pre> php artisan serve </pre>
Now you can run the project with localserver accessing this url below:
<pre> http://127.0.0.1:8000 </pre> 

**Admin** Credentaials:
<table>
<tbody>
<tr>
<td>Username</td>
<td>superadmin</td>
</tr>
<tr>
<td>Password</td>
<td>123456</td>
</tr>
</tbody>
</table>

**Teacher/User** Credentaials:
<table>
<tbody>
<tr>
<td>Username</td>
<td>maqsudur_rahman</td>
</tr>
<tr>
<td>Password</td>
<td>123456</td>
</tr>
</tbody>
</table>
