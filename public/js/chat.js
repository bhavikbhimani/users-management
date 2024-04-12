    var chatElement = document.getElementById('chat-form');
    if(chatElement){
       chatElement.addEventListener('submit', function(event) {
        event.preventDefault();
        let message = document.getElementById('message').value;
        axios.post('/send-message', {
            message: message
        })
        .then(function(response) {
            console.log(response.data);
            appendMessageToChat(event.user, event.message);
        })
        .catch(function(error) {
            console.error(error);
        });
    });
   }

function appendMessageToChat(user, message) {
    // Add message to chat window
    let chatMessages = document.getElementById('chat-messages');
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
    chatMessages.appendChild(messageDiv);
}





