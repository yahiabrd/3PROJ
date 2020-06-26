var createError = require('http-errors');
var express = require('express');
var path = require('path');
var cookieParser = require('cookie-parser');
var logger = require('morgan');
var session = require("express-session"); //sessions
var bodyParser = require("body-parser"); //for parsing forms

//mysql instance
//===============
const connection = require('./mysql'); //config sql file
connection.connect(function(err) {
  if (err) throw err;
  console.log("Server is connected to the MySQL database !");
});
//===============

//websocket Server
//================
var serverWebSocket = require('./serverWebSocket');
serverWebSocket.servWebSocket();
//================

var indexRouter = require('./routes/index');
var registerRouter = require('./routes/register');
var loginRouter = require('./routes/login');
var profileRouter = require('./routes/profile');
var usersRouter = require('./routes/users');
var docsRouter = require('./routes/docs');

var app = express();

// view engine setup
app.set('views', path.join(__dirname, 'views'));
app.set('view engine', 'ejs');

app.use(logger('dev'));
app.use(express.json());
app.use(express.urlencoded({ extended: false }));
app.use(cookieParser());
app.use(express.static(path.join(__dirname, 'public')));
app.use(session({
  saveUninitialized: true,
  resave: true,
  cookie: {
    maxAge : Date.now() + (30 * 86400 * 1000)
  },
  secret: "my secret key"
}));
app.use(bodyParser.urlencoded({ extended: true }));

app.use('/', indexRouter);
app.use('/register', registerRouter);
app.use('/login', loginRouter);
app.use('/profile', profileRouter);
app.use('/users', usersRouter);
app.use('/docs', docsRouter);

// catch 404 and forward to error handler
app.use(function(req, res, next) {
  next(createError(404));
});

// error handler
app.use(function(err, req, res, next) {
  // set locals, only providing error in development
  res.locals.message = err.message;
  res.locals.error = req.app.get('env') === 'development' ? err : {};

  // render the error page
  res.status(err.status || 500);
  res.render('error');
});

module.exports = app;