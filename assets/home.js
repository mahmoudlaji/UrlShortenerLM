
const form = document.querySelector('#shortenForm');
const shortenCard = document.querySelector('#shortenCard');
const inputUrl = document.querySelector('#url');
const  btnShortenUrl = document.querySelector('#btnShortenUrl');

const URL_Shorten= '/ajax/shorten';

form.addEventListener('submit', function(event) {
    event.preventDefault();

    fetch(URL_Shorten, {
        method: 'POST',
        body: new FormData(event.target)
    })
    .then(response => response.json())
    .then(handleData);

});
    
const handleData = function(data) {
    console.log(data);
};