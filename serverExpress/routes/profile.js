var express = require('express');
var router = express.Router();

/* GET home page. */
router.get('/', function (req, res, next) {
    if (req.session && req.session.isLogged){
        res.render('profile', { title: 'Profile', session: req.session });
    }else{
        res.redirect('/');
    }
});

module.exports = router;