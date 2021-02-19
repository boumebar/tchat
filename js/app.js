function getMessages(){
    var xhr = new XMLHttpRequest();

    xhr.open('GET' , 'formulaire.php')

    xhr.onload = function(){
        var res = JSON.parse(xhr.responseText);

        var html = res.reverse().map(function(message){

            return `
                <div class="message">
                    <span class="date">${message.date.substring(11,16)} </span>
                    <span class="pseudo">${message.pseudo} </span>
                    <span class="content"> : ${message.content}</span>
                </div>
            
            `
        }).join('');

        var messages = document.querySelector('.messages');
        messages.innerHTML = html;
        messages.scrollTop = messages.scrollHeight;
    }

    xhr.send();
}

function postMessage(e){
    e.preventDefault();

    var pseudo = document.querySelector('#pseudo');
    var message = document.querySelector('#message');

    var data = new FormData();

    data.append('pseudo', pseudo.value);
    data.append('message', message.value);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "formulaire.php?task=write");

    xhr.onload = function(){
        message.value = "";
        message.focus();
        getMessages();

    };

    xhr.send(data);
}

document.querySelector('form').addEventListener('submit',postMessage);

const interval = window.setInterval(getMessages,3000);

getMessages();
