//This is a class that implement observer pattern
//This is a notifier, notifier run on a "server", that handles the real time notification
//The notification is actually very simple, just let the related user know, the database is updated

class Channel{
	constructor(rid){
		this.rid = rid;
		this.subscribers = {};
	}

	addSubscriber(uid, subscriber){
		this.subscribers[uid] = subscriber;
  		
  		this.notiftyAll("list",this.getSubscribers());
  		console.log(uid + " client connected");
  	}

}

class Notifier{

	constructor() {
	    this.subscribers = {};
	    this.channels = {};
	    this.addSubscriber = this.addSubscriber.bind(this);
	}

	addSubscriber(uid, subscriber){
		/*if(channel != null){
			var chaObj = JSON.parse(channel);
			if(!this.channelExist(channel.rid)){
				var tempCha = new Channel(channel.rid);
				tempCha.addSubscriber(uid,subscriber);
				this.channels[channel.rid] = tempCha;
			}else{
				this.channels[channel.rid].addSubscriber(uid,subscriber);
			}

			console.log(uid + " client connected to " + channel.rid);
		}
*/
		this.subscribers[uid] = subscriber;
		this.notiftyAll("list",this.getSubscribers());
		console.log(uid + " client connected");
  		
  		
  	}

  	removeSubscriber(uid, code){
  		delete this.subscribers[uid];
  		console.log(uid + " disconnected ("+code+")");
  	}

  	notiftyAll(action, value){
		Object.values(this.subscribers).forEach((client)=>{
			client.send('{"action":"'+action+'","msg":"'+value+'"}');
		});
	}

	notifySubscriber(action,uid,value){
		this.subscribers[uid].send('{"action":"'+action+'","msg":"'+value+'"}');
	}

	channelExist(rid){
		Object.keys(this.channels).forEach((key)=>{
			key == rid;
			return true;
		});

		return false;
	}

	getSubscribers(){
		var tempStr = "";
		Object.keys(this.subscribers).forEach((key)=>{
			tempStr += key + ",";
		});
		return tempStr.slice(0,-1);
	}
}


//Start of socket programming
var server = require('ws').Server;
var s = new server({port: 55000});
var notifier = new Notifier();

s.on('connection', (client)=>{
	client.on('message', (message)=>{
		const jsonData = JSON.parse(message);
		if(jsonData.action == "open"){
			notifier.addSubscriber(jsonData.uid, client);
		}else if(jsonData.action == "notify"){
			notifier.notifySubscriber("notify",jsonData.uid, "Notify");
		}else if(jsonData.action == "notifyAll"){
			notifier.notiftyAll("notifyAll", "Notify All");
		}else if(jsonData.action == "notification"){
			notifier.notiftyAll("notifyAll", "notification");
		}else if(jsonData.action == "reply"){
			notifier.notiftyAll("notifyAll", "reply");
		}
	})

	client.on('close', function(code, userJson){;
		const jsonData = JSON.parse(userJson);
		notifier.removeSubscriber(jsonData.uid,code);
	})
});