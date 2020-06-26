function WebSocketConnection() 
{
   if ("WebSocket" in window) 
   {
      try
      {
         var ws = new WebSocket("ws://localhost:8080");
   	
         ws.onopen = function() {
            opened()
            //ws.send("connect");
         };
   	
         ws.onmessage = function (evt) { 
            var received_msg = evt.data;
            console.log("Message is received..." + received_msg);
         };
   	
         ws.onclose = function() { 
            closed()
         };

      }catch(error){
         console.log(error);
      }

   } else {
      alert("WebSocket is not supported by your Browser!");
   }

}

WebSocketConnection()

function opened(){
   document.getElementById("main").style.display = "block";
   document.getElementById("closed").style.display = "none";
}

function closed(){
   document.getElementById("main").style.display = "none";
   document.getElementById("closed").style.display = "block";
   document.getElementById("closed").innerHTML = "The connection to the server is closed";
}

//refresh auto pour la visualisation des animations
function update() {
   $.get("views/refreshStatus.php", function(data) {
       $("#refresh").html(data);
   });
   window.setTimeout("update();", 2000);
}

update();
