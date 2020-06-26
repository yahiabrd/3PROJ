var express = require('express');
var router = express.Router();
var sha1 = require('sha1');
const con = require('../mysql');

/* GET home page. */
router.get('/', function (req, res, next) {
    if (req.session && req.session.isLogged){
        res.redirect("/profile");
    }else{
        res.render('login', { title: 'Login', session: req.session, params: req.query });
    }
});

router.get('/logout', function (req, res, next) {
    req.session.destroy(function (err) {
        res.redirect("/");
    });
});

router.post('/', function(req, res){
    var firstname = req.body.firstname;
    var password = req.body.password;
    var session = req.session;

    if(firstname != "" && password != "")
    {
        //unsecure sql request to show the injection vulnerability with the client
        con.query(`SELECT * FROM users WHERE firstName = "${firstname}" AND userPassword = "${sha1(password)}" `, function(err, result){
            if (err) throw err;

            if(result.length != 0) //si trouvé
            {
                session.userId = result[0].id;
                session.firstName = result[0].firstName;
                session.lastName = result[0].lastName;
                session.pictureName = result[0].pictureName;
                session.isLogged = true

                res.redirect("/profile");
            }
            else
                res.redirect("/login/?error=2"); //not found
        });
    }
    else
        res.redirect("/login/?error=3"); //uncompleted form
});

module.exports = router;