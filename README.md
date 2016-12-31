#CMS

Content management system (CMS) application that allows publishing, editing and modifying content, organizing, deleting as well as maintenance from a central interface. Built with PHP and MySQL.

##Directory structure

```
├── includes/
│   ├── db_connection.php
│   ├── functions.php
│   ├── layouts/
│   │   ├── footer.php
│   │   └── header.php
│   ├── session.php
│   └── validation_functions.php
└── public/
    ├── admin.php
    ├── create_admin.php
    ├── create_page.php
    ├── create_subject.php
    ├── css/
    │   └── styles.css
    ├── delete_admin.php
    ├── delete_page.php
    ├── delete_subject.php
    ├── edit_admin.php
    ├── edit_page.php
    ├── edit_subject.php
    ├── images/
    ├── index.php
    ├── js/
    ├── login.php
    ├── manage_admins.php
    ├── manage_content.php
    ├── new_admin.php
    ├── new_page.php
    └── new_subject.php
```

## Usage

- Fork repository
- cd into `cms` directory

## Create MySQL database and tables

###1. Create your database

```mysql
mysql> CREATE DATABASE yourdatabasename;
Query OK, 1 row affected (0.01 sec)

mysql> USE yourdatabasename;
Database changed
```

###2. Configure database connection file **`Using mysqli API`**

###`cms/includes/db_connection.php`

```php
<?php
  // Create a database connection
  define("DB_SERVER", "yourserver"); // i.e. 'localhost'
  define("DB_USER", "youruser");
  define("DB_PASS", "yourpassword");
  define("DB_NAME", "yourdatabasename");
  $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

  // Test if connection occurred
  if(mysqli_connect_errno()) {
    die("Database connecton failed: " .
    mysqli_connect_error() . " (" .
    mysqli_connect_errno() . ") ");
  }
?>
```

###3. Create `subjects` table

```mysql
mysql> CREATE TABLE subjects (
    -> id INT(11) NOT NULL AUTO_INCREMENT,
    -> menu_name VARCHAR(30) NOT NULL,
    -> position INT(3) NOT NULL,
    -> visible TINYINT(1) NOT NULL,
    -> PRIMARY KEY(id)
    -> );
Query OK, 0 rows affected (0.02 sec)

mysql> SHOW COLUMNS FROM subjects;
+-----------+-------------+------+-----+---------+----------------+
| Field     | Type        | Null | Key | Default | Extra          |
+-----------+-------------+------+-----+---------+----------------+
| id        | int(11)     | NO   | PRI | NULL    | auto_increment |
| menu_name | varchar(30) | NO   |     | NULL    |                |
| position  | int(3)      | NO   |     | NULL    |                |
| visible   | tinyint(1)  | NO   |     | NULL    |                |
+-----------+-------------+------+-----+---------+----------------+
4 rows in set (0.01 sec)
```

###4. Create `pages` table

```mysql
mysql> CREATE TABLE pages (
    -> id INT(11) NOT NULL AUTO_INCREMENT,
    -> subject_id INT(11) NOT NULL,
    -> menu_name VARCHAR(30) NOT NULL,
    -> position INT(3) NOT NULL,
    -> visible TINYINT(1) NOT NULL,
    -> content TEXT,
    -> PRIMARY KEY (id),
    -> INDEX (subject_id)
    -> );
Query OK, 0 rows affected (0.02 sec)

mysql> SHOW COLUMNS FROM pages;
+------------+------------+------+-----+---------+----------------+
| Field      | Type       | Null | Key | Default | Extra          |
+------------+------------+------+-----+---------+----------------+
| id         | int(11)    | NO   | PRI | NULL    | auto_increment |
| subject_id | int(11)    | NO   | MUL | NULL    |                |
| menu_name  | varchar(3) | NO   |     | NULL    |                |
| position   | int(3)     | NO   |     | NULL    |                |
| visible    | tinyint(1) | NO   |     | NULL    |                |
| content    | text       | YES  |     | NULL    |                |
+------------+------------+------+-----+---------+----------------+
6 rows in set (0.00 sec)
```

###5. Create `admins` table

```mysql
mysql> CREATE TABLE admins (
    -> id INT(11) NOT NULL AUTO_INCREMENT,
    -> username VARCHAR(50) NOT NULL,
    -> hashed_password VARCHAR(60) NOT NULL,
    -> PRIMARY KEY (id)
    -> );
Query OK, 0 rows affected (0.02 sec)

mysql> SHOW COLUMNS FROM admins;

+-----------------+-------------+------+-----+---------+----------------+
| Field           | Type        | Null | Key | Default | Extra          |
+-----------------+-------------+------+-----+---------+----------------+
| id              | int(11)     | NO   | PRI | NULL    | auto_increment |
| username        | varchar(50) | NO   |     | NULL    |                |
| hashed_password | varchar(60) | NO   |     | NULL    |                |
+-----------------+-------------+------+-----+---------+----------------+
3 rows in set (0.00 sec)
```

###Tables

```mysql
mysql> SHOW TABLES;
+-----------------------+
| Tables_in_widget_corp |
+-----------------------+
| admins                |
| pages                 |
| subjects              |
+-----------------------+
3 rows in set (0.00 sec)
```

Then you can manage your content from **`manage_content.php`**, and admins from **`manage_admins.php`**.

## Contributing

Bug reports and pull requests are welcome on GitHub at https://github.com/aprietof/CMS. This project is intended to be a safe, welcoming space for collaboration, and contributors are expected to adhere to the [Contributor Covenant](http://contributor-covenant.org) code of conduct.


## License

This project is available as open source under the terms of the [MIT License](http://opensource.org/licenses/MIT).
