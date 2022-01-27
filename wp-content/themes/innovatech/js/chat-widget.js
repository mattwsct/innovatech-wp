// File: static/js/app.js
(function() {
	'use strict';



    // ----------------------------------------------------
    // Chat Details
    // ----------------------------------------------------

    let chat = {
    	name:  'You:',
    	email: undefined,
    	myChannel: undefined,
    	socket: null
    }


    // ----------------------------------------------------
    // Targeted Elements
    // ----------------------------------------------------

    const chatPage   = $(document)
    const chatWindow = $('.chatbubble')
    const chatHeader = chatWindow.find('.unexpanded')
    const chatBody   = chatWindow.find('.chat-window')


    // ----------------------------------------------------
    // Register helpers
    // ----------------------------------------------------

    let helpers = {

        // ----------------------------------------------------
        // Toggles the display of the chat window.
        // ----------------------------------------------------

        ToggleChatWindow: function () {
        	chatWindow.toggleClass('opened')
        	chatHeader.find('.title').text('Innovatech Support Chat')
        },

        // --------------------------------------------------------------------
        // Show the appropriate display screen. Login screen or Chat screen.
        // --------------------------------------------------------------------

        ShowAppropriateChatDisplay: function () {
        	helpers.ShowChatRoomDisplay() 
        },

        

        // ----------------------------------------------------
        // Show the chat room messages display.
        // ----------------------------------------------------

        ShowChatRoomDisplay: function () {
        	chatBody.find('.chats').addClass('active')
        	chatBody.find('.login-screen').removeClass('active')

        	setTimeout(function(){
        		chatBody.find('.loader-wrapper').hide()
        		chatBody.find('.input, .messages').show()
        	}, 2000)
        },

        // ----------------------------------------------------
        // Append a message to the chat messages UI.
        // ----------------------------------------------------

        NewChatMessage: function (message) {
        	if (message !== undefined) {
        		const messageClass = message.sender !== chat.email ? 'support' : 'user'

        		chatBody.find('ul.messages').append(
        			`<li class="clearfix message ${messageClass}">
        			<div class="sender">${message.name}</div>
        			<div class="message">${message.text}</div>
        			</li>`
        			)


        		chatBody.scrollTop(chatBody[0].scrollHeight)
        	}
        },

        // ----------------------------------------------------
        // Send a message to the chat channel.
        // ----------------------------------------------------

        SendMessageToSupport: function (evt) {
        	console.log("SendMessageToSupport (Start)");
        	evt.preventDefault()

        	let createdAt = new Date()
        	createdAt = createdAt.toLocaleString()

        	const message = $('#newMessage').val().trim()

        	helpers.NewChatMessage({
        		'text': message,
        		'name': chat.name,
        		'sender': chat.email
        	})
        	console.log("SendMessageToSupport (Before chat.socket.send)");
        	chat.socket.send(JSON.stringify({
        		question: message,
        	}));
        	console.log("SendMessageToSupport (After chat.socket.send)");
        	$('#newMessage').val('')
        },

         // ----------------------------------------------------
        // Logs user into a chat session.
        // ----------------------------------------------------

        LogIntoChatSession: function (evt) {
        	const name  = $('#fullname').val().trim()
        	const email = $('#email').val().trim().toLowerCase()

            // Disable the form
            chatBody.find('#loginScreenForm input, #loginScreenForm button').attr('disabled', true)

            if ((name !== '' && name.length >= 3) && (email !== '' && email.length >= 5)) {
            	axios.post('/new/guest', {name, email}).then(response => {
            		chat.name = name
            		chat.email = email
                    //chat.myChannel = pusher.subscribe('private-' + response.data.email);
                    helpers.ShowAppropriateChatDisplay()
                })
            } else {
            	alert('Enter a valid name and email.')
            }

            evt.preventDefault()
        }
    }

    // ------------------------------------------------------------------
    // Listen for a new message event from the admin
    // ------------------------------------------------------------------

    //pusher.bind('client-support-new-message', function(data){
      //  helpers.NewChatMessage(data)
    //})

    function _connect() {
    	var chatSocket = new WebSocket("wss://chatbot-stg.innovatech.studio/ws/chat/");
    	console.log("_connect (Start)");
    	chatSocket.onopen = function() {
    		console.log("_connect (onopen)");
    	};

    	chatSocket.onmessage = function(e) {
    		console.log("_connect chatSocket.onmessage (Start)");
    		var answers = JSON.parse(e.data)["answer"];
    		for (var i = 0; i < answers.length; i++) {
    			helpers.NewChatMessage({
    				'text': answers[i]["text"],
    				'name': 'ChatBot:',
    				'sender': 'chatbot@innovatech.studio'
    			})
    		}
    		console.log("_connect chatSocket.onmessage (Finish)");
    	};

    	chatSocket.onerror = function(e) {
    		chatSocket.close();
    		console.log("_connect chatSocket.error");
    	};

    	chatSocket.onclose = function(e) {
    		setTimeout(function() {
    			_connect();
    		}, 5000);
    	}

    	chat.socket = chatSocket;
    }

    _connect();


    // ----------------------------------------------------
    // Register page event listeners
    // ----------------------------------------------------

    chatPage.ready(helpers.ShowAppropriateChatDisplay)
    chatHeader.on('click', helpers.ToggleChatWindow)
    chatBody.find('#loginScreenForm').on('submit', helpers.LogIntoChatSession)
    chatBody.find('#messageSupport').on('submit', helpers.SendMessageToSupport)
}())