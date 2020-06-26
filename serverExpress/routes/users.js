var express = require('express');
var router = express.Router();
const con = require('../mysql');

/* GET home page. */
router.get('/', function (req, res, next) {
    var data = []
    try{
        con.query('SELECT * FROM users', function(err, result){
            if (err) throw err;

            if(result.length != 0)
            {
                for(i = 0; i < result.length; i++) {
                    data.push(
                        [
                            result[i]["id"],
                            result[i]["firstName"],
                            result[i]["lastName"],
                            result[i]["pictureName"],
                        ]
                    );
                }
                res.render('users', { title: 'Users', data: data, session: req.session});
            }else {
                res.render('users', { title: 'Users', error: true, session: req.session});
            }
        });
    }catch(err){
        console.log(err)
    }
});

module.exports = router;