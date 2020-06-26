const mysql = require('mysql');

var connection = mysql.createConnection({
  host: "localhost",
  user: "root",
  database: "3proj",
  password: ""
});

module.exports = connection;