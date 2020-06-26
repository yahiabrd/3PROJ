var exec = require('child_process').exec;
const mysql = require('mysql');

var child = exec('mysqldump -u root -p root 3proj > save.sql');

var connection = mysql.createConnection({
  host: "localhost",
  user: "root",
  database: "3proj",
  password: ""
});

connection.query('INSERT INTO backup(dateBackup, commentBackup) VALUES(NOW(), "simple backup")', function (err, result) {
    if (err) throw err;
    console.log("Successfull backup")
});
