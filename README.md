<h1>Cash Control</h1>

<p><strong>Cash Control</strong> is a web application designed to help users manage their finances efficiently. User can manage his income and expenses. Also user has abbility to create PDF and Excel reports.
</p>

<h2>Features</h2>
<ul>
    <li><strong>User Authentication</strong>: Secure sign-up and login: default login, via Google or GitHub</li>
    <li><strong>Add payments (income or expenses)</strong>: each payment has date and category.</li>
    <li><strong>Statistic</strong>: User can see payments statistic</li>
    <li><strong>Real-time Notifications</strong>: user can set limits and see real-time notifications if the limits are exceeded</li>
    <li><strong>Responsive Design</strong>: Accessible on both desktop and mobile devices.</li>
    <li><strong>Multilanguage interface</strong></li>
</ul>

<h2>Technologies Used</h2>
<ul>
    <li><strong>Frontend</strong>: Vue.js</li>
    <li><strong>Backend</strong>: Laravel</li>
    <li><strong>Database</strong>: MySQL/Postgresql</li>
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

 <li>Be sure that you have docker on your machine:
        <pre><code>git clone git@github.com:anastasiazavizion/cash_control.git</code></pre>
    </li>

     <li>Be sure that you have docker on your machine:
        <pre><code>git clone git@github.com:anastasiazavizion/cash_control.git</code></pre>
    </li>


    <li>Navigate to the project directory:
        <pre><code>cd cash-control</code></pre>
    </li>
    
    <li>Set up your .env file:
        <pre><code>cp .env.example .env</code></pre>
    </li>

    <li>Cinfigure necessary keys in your.env file:
        <pre><code>cp .env.example .env</code></pre>
    </li>
    
    <li>Install dependencies:
        <pre><code>composer install --ignore-platform-req=ext-gd</code>code></pre>
        bash ./vendor/laravel/sail/bin/sail up
        <pre><code>sail up -d</code></pre>
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
        <pre>Go to APP_URL:APP_PORT url, for example http://localhost:8097</pre>
    </li>
</ul>

<h2>Contributing</h2>
<p>Contributions are welcome! Please open an issue or submit a pull request for any changes you'd like to suggest.</p>

<h2>License</h2>
<p>This project is licensed under the MIT License - see the <a href="LICENSE">LICENSE</a> file for details.</p>
