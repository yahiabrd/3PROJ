var express = require('express');
var router = express.Router();
var sha1 = require('sha1'); //hasher password
const con = require('../mysql'); //mysql config file
const multer = require('multer'); //for the form multipart/data

/* GET home page. */
router.get('/', function (req, res, next) {
    if (req.session && req.session.isLogged){
        res.redirect("/profile");
    }else{
        res.render('register', { title: 'Register', session: req.session, params: req.query });
    }
});

var storage = multer.diskStorage(
    {
        destination: './public/uploads/',
        filename: function (req, file, cb) {
            cb(null, file.originalname);
        }
    }
);
var upload = multer({ storage: storage });

router.post('/', upload.single('picture'), (req, res) => {
    if(req.body.firstname != "" && req.body.lastname != "" && req.body.password != "" && req.file.originalname != "") {
        try{
            con.query('INSERT INTO users(firstName, lastName, userPassword, pictureName) VALUES(?, ?, ?, ?)',[
                req.body.firstname, req.body.lastname, sha1(req.body.password), req.file.originalname
            ], function (err, result) {
                if (err) throw err;
            });
            res.redirect("/login/?success=1");
        }catch(err){
            console.log(err)
            res.redirect("/register/?error=1");
        }
    }
    res.redirect("/register/?error=1");
});

module.exports = router;
