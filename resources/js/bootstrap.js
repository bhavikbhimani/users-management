window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

// Import required libraries
import axios from 'axios';
import Echo from 'laravel-echo';

// Configure Pusher and Laravel Echo
window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true,
});

// Listen for chat events
window.Echo.channel('chat-channel')
    .listen('chat-event', (event) => {
        // Handle incoming message
        console.log(event.message);
        console.log(event.user);
        console.log(event);
        // Example: Update UI to display incoming message
        appendMessageToChat(event.user, event.message);
    });

// Event listener for submitting chat form
  var ischatForm =  document.getElementById('chat-form');
  if(ischatForm){
ischatForm.addEventListener('submit', function(event) {
    event.preventDefault();
    let message = document.getElementById('message').value;
    axios.post('/send-message', {
        message: message
    })
    .then(function(response) {
        // Clear message input after successful send
        document.getElementById('message').value = '';
        console.log(response.data);
        console.log(event);
        appendMessageToChat(event.user, event.message);
    })
    .catch(function(error) {
        console.error(error);
    });
});
}

// Function to append message to chat window
function appendMessageToChat(user, message) {
    // Add message to chat window
    var chatMessages = document.getElementById('chat-messages');
    let messageDiv = document.createElement('div');
    messageDiv.classList.add('message');
    messageDiv.innerHTML = `
        <div class="flex items-start mb-4">
            <img src="" alt="${user.name}" class="w-8 h-8 rounded-full mr-2">
            <div>
                <div class="font-bold">${user.name}</div>
                <div class="bg-gray-200 rounded-lg px-4 py-2">${message}</div>
            </div>
        </div>
    `;
    if(chatMessages){
    	chatMessages.appendChild(messageDiv);
    } 
}