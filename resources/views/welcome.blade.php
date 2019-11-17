<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Appointment System API</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #000;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 1%;
            }

        </style>
    </head>
    <body>
        <div >

            <div class="content">
                <h1>Appointment System API</h1>

                <p>The Appointment System API will help your keep your contacts organized and arrange appointments</p>
                <h2>Documentation</h2>
                <table style="width:100%">
                    <tr>
                        <th style="text-align:left;">Api Call</th>
                        <th style="text-align:left;">Http Method</th>
                        <th style="text-align:left;">Parameters</th>
                        <th style="text-align:left;">Description</th>
                    </tr>

                    <tr>
                        <td>/api/login</td>
                        <td>POST</td>
                        <td>UsrEmail, UsrPassword</td>
                        <td>Logs the user in and returns a token</td>
                    </tr>

                    <tr>
                        <td>/api/add_user</td>
                        <td>POST</td>
                        <td>token, UsrFirstname, UsrLastname, UsrEmail, UsrPassword, UsrRoleID</td>
                        <td>creates new user</td>
                    </tr>

                    <tr>
                        <td>/api/update_user</td>
                        <td>PUT</td>
                        <td>token, UsrFirstname, UsrLastname, UsrEmail, UsrPassword, UsrRoleID</td>
                        <td>updates new user</td>
                    </tr>

                    <tr>
                        <td>/api/contacts</td>
                        <td>GET</td>
                        <td>token</td>
                        <td>Lists all contacts</td>
                    </tr>

                    <tr>
                        <td>/api/add_contact</td>
                        <td>POST</td>
                        <td>token, ContactFirstname, ContactLastname, ContactEmail, ContactAddress, ContactCity, ContactCellphone</td>
                        <td>creates new contact</td>
                    </tr>

                    <tr>
                        <td>/api/contact/{id}</td>
                        <td>PUT</td>
                        <td>token, ContactFirstname, ContactLastname, ContactEmail, ContactAddress, ContactCity, ContactCellphone</td>
                        <td>updates new contact</td>
                    </tr>

                    <tr>
                        <td>/api/contact/{id}</td>
                        <td>GET</td>
                        <td>token, id</td>
                        <td>returns a contact contact</td>
                    </tr>

                    <tr>
                        <td>/api/contact/{id}</td>
                        <td>DELETE</td>
                        <td>token, id</td>
                        <td>deletes a contact contact</td>
                    </tr>

                    <tr>
                        <td>/api/add_appointment</td>
                        <td>POST</td>
                        <td>token, ApntDate, ApntContactID, Comments</td>
                        <td>creates new appointment</td>
                    </tr>

                    <tr>
                        <td>/api/appointment/{id}</td>
                        <td>GET</td>
                        <td>token, id</td>
                        <td>returns an appointment</td>
                    </tr>

                    <tr>
                        <td>/api/appointment/{id}</td>
                        <td>PUT</td>
                        <td>token, id, ApntDate, ApntContactID, Comments</td>
                        <td>updates an appointment</td>
                    </tr>

                    <tr>
                        <td>/api/appointment/{id}</td>
                        <td>DELETE</td>
                        <td>token, id</td>
                        <td>deletes an appointment</td>
                    </tr>

                    <tr>
                        <td>/api/appointments</td>
                        <td>GET</td>
                        <td>token</td>
                        <td>returns list of appointments</td>
                    </tr>

                    <tr>
                        <td>/api/logout</td>
                        <td>POST</td>
                        <td>token</td>
                        <td>logs the user out</td>
                    </tr>
                </table>

                <p>User with role id <b>1</b> is always the system administrator</p>

                <h3>Additional Information</h3>
                <p>
                    The sole intent of this application is to study the Test Driven Development method.
                    For the purpose in the test folder you can find all the test that were used for
                    the Development of this application.
                </p>

            </div>
        </div>
    </body>
</html>
