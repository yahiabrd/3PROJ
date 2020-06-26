var express = require('express');
var router = express.Router();
const con = require('../mysql'); //appel de mysql
const multer = require('multer'); //pour les form multipart/data

/* GET home page. */
router.get('/', function(req, res, next) {
    var data = []
    try{
        con.query('SELECT * FROM documents WHERE userId = ?', [req.session.userId], function(err, result){
            if (err) throw err;

            if(result.length != 0)
            {
                for(i = 0; i < result.length; i++) {
                    data.push(
                        [
                            result[i]["id"],
                            result[i]["documentName"]
                        ]
                    );
                }
                res.render('docs', { title: 'My documents', data: data, session: req.session, params: req.query});
            }else{
                res.render('docs', { title: 'My documents', error: true, session: req.session, params: req.query});
            }
        });
    }catch(err){
        console.log(err)
    }
});


var storage = multer.diskStorage(
    {
        destination: './public/documents/',
        filename: function (req, file, cb) {
            cb(null, file.originalname);
        }
    }
);
var upload = multer({ storage: storage });

router.post('/', upload.single('document'), (req, res) => {
    if(req.file.originalname != "") {
        try{
            con.query('INSERT INTO documents(documentName, userId) VALUES(?, ?)',[
                req.file.originalname, req.session.userId
            ], function (err, result) {
                if (err) throw err;
            });
            res.redirect("/docs/?success=1");
        }catch(err){
            console.log(err)
            res.redirect("/docs/?err=1");
        }
    }
    res.redirect("/docs/?err=1");
});

module.exports = router;
