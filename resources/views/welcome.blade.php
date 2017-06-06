<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>FUBER</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <!-- Styles -->
    </head>
    <body>
    <div class="container">
        <div class="row">
            <h2 id="requirement">Requirement</h2>

            <blockquote>
                <p>PHP 7</p>

                <p>Mysql >= 5.6</p>

                <p>Composer</p>
            </blockquote>

            <h2 id="steps">Steps</h2>

            <blockquote>
                <p>Clone the code base</p>

                <p>run <code>composer install</code> in terminal</p>

                <p>copy <code>env.example</code> as <code>.env</code> and change the database configuration</p>

                <p>run <code>php artisan migrate --seed</code></p>
            </blockquote>

            <h2 id="folderstructure">Folder Structure</h2>

            <ul>
                <li><code>app/Contracts</code> Contains all the interfaces used in various classes</li>

                <li><code>app/Exceptions</code> Contains the custom exception classes</li>

                <li><code>app/Http/Controllers</code> Contains the Controllers</li>

                <li><code>app/Http/Middeware</code> Contains the middleware for the HTTP request</li>

                <li><code>app/Http/Requests</code> Contains the Request validation classes</li>

                <li><code>app/Models</code> Contains all the Models</li>

                <li><code>app/Providers/AppServiceProvider.php</code> has the code for bootstraping various classes and objects,
                    binding between interface and models.</li>

                <li><code>app/Transformers</code> contains all the transformers used to transform data before sending response.</li>

                <li><code>app/Utils</code> contains additional classes used to support the app.</li>

                <li><code>config/location.php</code> has the dummy locations</li>

                <li><code>resources/lang/en/api.php</code> has the code for translation..</li>

                <li><code>routes/api.php</code> has the code for api routing</li>

                <li><code>tests</code> has the classes for unit test and functional test</li>
            </ul>

            <h2 id="postmancollectionlink">Postman Collection Link</h2>

            <pre><code>https://www.getpostman.com/collections/3537e70283e07a84464c
</code></pre>

            <h2 id="api">API</h2>

            <p>All apis are prefixed with <code>/api/v1</code></p>

            <p>All Api should have the following request headers</p>

            <pre><code>Content-Type : application/json
Accept: application/json
</code></pre>

            <ul>
                <li><p>GET <code>/customers</code>:</p>

                    <p>List the cutomers</p></li>

                <li><p>GET <code>/customers/{customer id}</code>:</p>

                    <p>Get a specific customer details</p></li>

                <li><p>GET <code>/cabs</code>:</p>

                    <p>Get list of cabs. Optional parameter</p>

                    <pre><code>includes: This param is used for lazy loading. The possible values for this API are <pre><code>- type : refers to the type of cab
</code></pre>available: This params is used to filter cabs which are current available. Value is only 'true'
</code></pre></li>

                <li><p>GET <code>/cabs/{cab id}</code>:</p>

                    <p>Get Details of a specific cab. Optional parameter</p>

                    <pre><code>includes: This param is used for lazy loading. The possible values for this API are <pre><code>- type : refers to the type of cab
</code></pre></code></pre></li>

                <li><p>GET <code>/cabs/nearby</code>:</p>

                    <p>Get nearby available cabs. Params:</p>

                    <pre><code>includes: Optional. This param is used for lazy loading. The possible values for this API are <pre><code>- type : refers to the type of cab
</code></pre>lat: required. Lattitude of the customer.
lng: required. Longitude of the customer.
radius: optional.Radius in which the cabs needs to be searched.
cab_type_id: optional. Type of cab. can be checked in cab type API
</code></pre></li>

                <li><p>GET <code>/cabs/transits</code>:</p>

                    <p>Get list of transits.</p>

                    <pre><code>includes: Optional. comma separated values (without any space in between). This param is used for lazy loading. The possible values for this API are <pre><code>- cab : refers to the cab which was in the transit
- customer: refers to the customer who was in the transit.
</code></pre></code></pre></li>

                <li><p>GET <code>/cabs/transits/{transit id}</code>:</p>

                    <p>Get the specific transit details.</p>

                    <pre><code>includes: Optional. comma separated values (without any space in between). This param is used for lazy loading. The possible values for this API are <pre><code>- cab : refers to the cab which was in the transit
- customer: refers to the customer who was in the transit.
</code></pre></code></pre></li>

                <li><p>POST <code>/cabs/book</code>:</p>

                    <p>Book a cab. Params:</p>

                    <pre><code>- customer_id
- cab_id
- from_lat
- from_lng
- to_lat
- to_lng
- includes: Optional. comma separated values (without any space in between). This param is used for lazy loading. The possible values for this API are       <pre><code>- cab : refers to the cab which was in the transit
- customer: refers to the customer who was in the transit.
</code></pre></code></pre></li>

                <li><p>PATCH <code>/cabs/transits/{transit id}/start</code>:</p>

                    <p>Start the transit/journey</p></li>

                <li><p>PATCH <code>/cabs/transits/{transit id}/end</code>:</p>

                    <p>End the transit/journey</p></li>
            </ul>
        </div>
    </div>
    </body>
    <script
            src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</html>
