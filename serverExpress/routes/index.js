var express = require('express');
var router = express.Router();

/* GET home page. */
router.get('/', function(req, res, next) {
  console.log(req.headers["user-agent"]);
  res.render('index', { title: 'Health Company', session: req.session });
});

module.exports = router;
