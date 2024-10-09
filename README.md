<h1>Cash Control</h1>

<p><strong>Cash Control</strong> is a web application designed to help users manage their finances efficiently. Users can manage their income and expenses, and also generate PDF and Excel reports.</p>

<h2>Features</h2>
<ul>
    <li><strong>User Authentication</strong>: Secure sign-up and login: default login, via Google or GitHub</li>
    <li><strong>Add Payments (Income or Expenses)</strong>: Each payment has a date and category.</li>
    <li><strong>Statistics</strong>: Users can see payment statistics.</li>
    <li><strong>Real-time Notifications</strong>: Users can set limits and receive real-time notifications if the limits are exceeded.</li>
    <li><strong>Responsive Design</strong>: Accessible on both desktop and mobile devices.</li>
    <li><strong>Multilanguage Interface</strong></li>
</ul>

<h2>Technologies Used</h2>
<ul>
    <li><strong>Frontend</strong>: Vue.js, Tailwind CSS, SASS</li>
    <li><strong>Backend</strong>: Laravel</li>
    <li><strong>Database</strong>: MySQL/PostgreSQL</li>
    <li><strong>Caching, Queue</strong>: Redis</li>
    <li><strong>Cloud Storage</strong>: AWS S3</li>
    <li><strong>Real-time Communication</strong>: Pusher</li>
    <li><strong>Libraries</strong>: Chart.js, i18n</li>
</ul>

<h2>Getting Started</h2>
<p>To get started with the project:</p>
<ul>
    <li>Clone the repository:
        <pre><code>git clone git@github.com:anastasiazavizion/cash_control.git</code></pre>
    </li>
    <li>Make sure Docker is installed on your machine.</li>
    <li>Navigate to the project directory:
        <pre><code>cd cash-control</code></pre>
    </li>
    <li>Set up your .env file:
        <pre><code>cp .env.example .env</code></pre>
    </li>
    <li>Configure necessary keys in your .env file.</li>
    <li>Install dependencies:
        <pre><code>composer install --ignore-platform-req=ext-gd</code></pre>
        <pre><code>./vendor/laravel/sail/bin/sail up -d</code></pre>
        <pre><code>sail bash</code></pre>
        <pre><code>composer update</code></pre>
        <pre><code>npm install</code></pre>
        <pre><code>npm run dev</code></pre>
    </li>
    <li>Generate the application key:
        <pre><code>php artisan key:generate</code></pre>
    </li>
    <li>Migrate the database and run seeds:
        <pre><code>php artisan migrate --seed</code></pre>
    </li>
    <li>Run the application:
        Access the application at <code>http://localhost:8097</code>.</li>
</ul>

<h2>Contributing</h2>
<p>Contributions are welcome! Please open an issue or submit a pull request for any changes you'd like to suggest.</p>

<h2>License</h2>
<p>This project is licensed under the MIT License - see the <a href="LICENSE">LICENSE</a> file for details.</p>


![Screenshot from 2024-10-09 15-58-46](https://github.com/user-attachments/assets/5af87853-5b79-44e8-af1e-e1ce5c037134)
![Screenshot from 2024-10-09 16-00-04](https://github.com/user-attachments/assets/7a79622a-2f5f-4ac7-af00-b5fb48349e82)
![Screenshot from 2024-10-09 16-00-23](https://github.com/user-attachments/assets/2eddc4a7-06c1-4cb9-bf3a-15e462cdbbd4)
![Screenshot from 2024-10-09 16-01-46](https://github.com/user-attachments/assets/2cae000a-840c-4dba-b088-6880e780ee0f)
![Screenshot from 2024-10-09 16-02-06](https://github.com/user-attachments/assets/d9d5f003-d28e-47bb-b706-d8a0439c4fac)
![Screenshot from 2024-10-09 16-02-34](https://github.com/user-attachments/assets/d1fce50e-db9d-47d0-8a74-acd91e95077e)
![Screenshot from 2024-10-09 16-03-11](https://github.com/user-attachments/assets/487ea333-e4ff-46a4-bae9-ac5728b07619)
![Screenshot from 2024-10-09 16-03-49](https://github.com/user-attachments/assets/25629621-07eb-44e9-b6cb-206b4e6ae84b)


