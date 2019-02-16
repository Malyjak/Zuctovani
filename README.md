# Zúčtování

Zuctovani (Zúčtování in Czech) is DnD analogy Management System.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

For succesful instalation, apache server is required.
You can use whatever type of this service you prefer, but it should have php version 5.6 or newer.
Examples of such services for most common Windows 10 OS are given bellow:

```
WampServer
XAMPP
ApacheHaus
Apache Lounge
BitNami WAMP Stack
```

For continuing, apache server with MySQL database running is required. Please make sure it is true.

### Installing

First step is getting project to your local machine. For such purpose, clone or download project to your Apache "www" folder. In case of WampServer instalation (64-bit machine), the default folder can be found at

```
C:\wamp64\www
```

Next step is initialization of database. This can be done by accessing the MySQL database you should already have running. If you do not know how to access your database, please read manual for your Appache service.

After connecting to your database, run script located at

```
zuctovani\scripts\create_db.sql
```

and populate just created database with script

```
zuctovani\scripts\create_tables.sql
```

The whole database was set and is ready to use!

### Logging in

In your browser type

```
localhost/zuctovani
```

You should see page with login form. Administrator information is following:

```
email: a@a.a
password: a
```

After entering these credentials you should be successfully logged in and redirected to a dashboard page.

### Changing storyteller group id
In

```
application/controllers/Dashboard.php
```

you can find two lines:

```
53: // Change your storyteller group id here!
54: $is_storyteller = ($group['id'] == 2);
```

Second line needs to be edited if the first group created after login in (as admin) is not the storyteller group!
### Changing language

Currently only supported language is Czech! Sorry guys :/ English translation will be added in future releases, after major functionality is reached.

## Deployment

TODO: Add additional notes about how to deploy this on a live system

## Authors

* **Jakub Malý** - *Overall work* - [Malyjak](https://github.com/Malyjak)

## License

This project is licensed under the (General Public License) GNU License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* This project was created on [AdminLTE](https://github.com/almasaeed2010/AdminLTE) Management System Core with usage of CodeIgniter Web Framework
