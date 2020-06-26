function servWebSocket() 
{
    const WebSocket = require('ws');
    const con = require('./mysql');
    const fs = require('fs');
    const createFSserver = require("fs-remote/createServer");

    //logs and date config
    const logsFileName = "logs.json";
    const date_ob = new Date(Date.now());
    const logDate = `${date_ob.getFullYear()}-${date_ob.getMonth() + 1}-${date_ob.getDate()} at ${date_ob.getHours()}:${date_ob.getMinutes()}:${date_ob.getSeconds()}`;
    
    //fs server
    const server = createFSserver();
    server.listen(4000, () => {
      console.log("fs-remote server is listening on port 4000");
    });

    var nbD = 0;

    //websocket serv
    const port = 8080;
    const wss = new WebSocket.Server({ port: port });

    console.log(`Websocket Server started at port ${port}`);
    
    wss.on('connection', function(ws, req) {
        try
        {
            console.log("Client connected " + req.socket.remoteAddress);
            
            ws.on('message', function(message) {
                switch(message){
                    case "dataAttack":
                        console.log("Data Attack detected !");
                        //update status bdd
                        con.query('UPDATE sections set sectionStatus = 1 WHERE id = 1', function (err, result) {
                            if (err) throw err;
                        });
                        //log insertion json
                        var logs = JSON.parse(fs.readFileSync(logsFileName));
                        var logsSize = Object.keys(logs).length;

                        logs[logsSize+1] = {
                            "attackName": "Data Attack",
                            "Date": logDate,
                            "section": "data protection",
                            "ip": req.socket.remoteAddress
                        };
                        try{
                            fs.writeFileSync(logsFileName, JSON.stringify(logs, null, 4), "utf8");
                        }catch(err){
                            console.log(err)
                        }
                        //insertion db monitoring
                        con.query('INSERT INTO threats(attackName, attackDate, sectionId, ip) VALUES(?, ?, ?, ?)', [
                            "Data Attack", date_ob, 1, req.socket.remoteAddress
                        ],function (err, result) {
                            if (err) throw err;
                        });
                        break;
                    case "dosAttack":
                        //detection
                        console.log("Dos Attack detected !");
                        nbD++;
                        if(nbD > 100000){
                            nbD = 0;
                            process.exit(0);
                        }
                        console.log(nbD);
                        //update status bdd
                        if(nbD == 1) //to not surcharge with many requests
                        { 
                            con.query('UPDATE sections set sectionStatus = 1 WHERE id = 2', function (err, result) {
                                if (err) throw err;
                            });
                        }
                        //insertion log
                        if(nbD == 1) //to not surcharge with many requests
                        { 
                            var logs = JSON.parse(fs.readFileSync(logsFileName));
                            var logsSize = Object.keys(logs).length;

                            logs[logsSize+1] = {
                                "attackName": "DoS Attack",
                                "Date": logDate,
                                "section": "server protection",
                                "ip": req.socket.remoteAddress
                            };
                            try{
                                fs.writeFileSync(logsFileName, JSON.stringify(logs, null, 4), "utf8");
                            }catch(err){
                                console.log(err)
                            }
                        }
                        //insertion bdd monitoring
                        if(nbD == 1) //to not surcharge with many requests
                        { 
                            con.query('INSERT INTO threats(attackName, attackDate, sectionId, ip) VALUES(?, ?, ?, ?)', [
                                "DoS Attack", date_ob, 2, req.socket.remoteAddress
                            ],function (err, result) {
                                if (err) throw err;
                            });
                        }
                        break;
                    case 'backdoorAttack':
                        //detection
                        console.log("backdoor Attack detected !");
                        //fetch /uploads for getting the files added by the attack
                        var path = "public/uploads";
                        files = fs.readdirSync(path);

                        if (files.length > 0) {
                            console.log(`${files.length} elements found\n`);
                            files.forEach((element, i) => {
                                console.log(`"File nᵒ${i} => ${element}`);
                            });
                        }
                        //logs
                        var logs = JSON.parse(fs.readFileSync(logsFileName));
                        var logsSize = Object.keys(logs).length;

                        logs[logsSize+1] = {
                            "attackName": "Backdoor Attack",
                            "Date": logDate,
                            "section": "backdoor protection",
                            "ip": req.socket.remoteAddress
                        };
                        try{
                            fs.writeFileSync(logsFileName, JSON.stringify(logs, null, 4), "utf8");
                        }catch(err){
                            console.log(err)
                        }
                        //bdd
                        //monitoring update
                        con.query('UPDATE sections set sectionStatus = 1 WHERE id = 3', function (err, result) {
                            if (err) throw err;
                        });
                        //log database
                        con.query('INSERT INTO threats(attackName, attackDate, sectionId, ip) VALUES(?, ?, ?, ?)', [
                            "Backdoor Attack", date_ob, 3, req.socket.remoteAddress
                        ],function (err, result) {
                            if (err) throw err;
                        });
                        break;
                    case 'databaseAttack':
                        //detection
                        console.log("Database Attack detected !");
                        //logs json
                        var logs = JSON.parse(fs.readFileSync(logsFileName));
                        var logsSize = Object.keys(logs).length;

                        logs[logsSize+1] = {
                            "attackName": "Database Attack",
                            "Date": logDate,
                            "section": "database protection",
                            "ip": req.socket.remoteAddress
                        };
                        try{
                            fs.writeFileSync(logsFileName, JSON.stringify(logs, null, 4), "utf8");
                        }catch(err){
                            console.log(err)
                        }
                        //monitoring update
                        con.query('UPDATE sections set sectionStatus = 1 WHERE id = 4', function (err, result) {
                            if (err) throw err;
                        });
                        //log db
                        con.query('INSERT INTO threats(attackName, attackDate, sectionId, ip) VALUES(?, ?, ?, ?)', [
                            "Database Attack", date_ob, 4, req.socket.remoteAddress
                        ],function (err, result) {
                            if (err) throw err;
                        });
                        break;
                }
            });

            ws.on('close', () => {
                console.log("Client disconnected " + req.socket.remoteAddress)
            });

        }catch(err){
            console.log(err);
        }
    })
}

exports.servWebSocket = servWebSocket;
