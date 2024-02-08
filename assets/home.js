const form = document.querySelector('#shortenForm');
const shortenCard = document.querySelector('#shortenCard');
const inputUrl = document.querySelector('#url');
const btnShortenUrl = document.querySelector('#btnShortenUrl');

const URL_SHORTEN = '/ajax/shorten';

const errorMessages = {
    'INVALID_ARG_URL': "Impossible de raccourcir ce lien. Ce n'est pas une URL valide",
    'MISSING_ARG_URL': "Veuillez fournir une URL valide"
}

form.addEventListener('submit', function(e) {
    e.preventDefault();

    fetch(URL_SHORTEN, {
        method: 'POST',
        body: new FormData(e.target)
    })
        .then(response => response.json())
        .then(handleData);
});

const handleData = function(data) {
    if (data.statusCode >= 400) {
        return handleError(data);
    }

    inputUrl.value = data.link;
    btnShortenUrl.innerText = "Copier";

    btnShortenUrl.addEventListener('click', function(e) 
       e.preventDefault();

       inputUrl.select();

       // Use the Clipboard API to copy text
       navigator.clipboard.writeText(inputUrl.value)
           .then(() => {
               this.innerText = "Réduire l'URL";
               console.log('Text copied to clipboard');
           })
           .catch((err) => {
               console.error('Unable to copy to clipboard', err);
           });
    }, { once: true });
}


const handleError = function(data) {
    const alert = document.createElement('div');
    alert.classList.add('alert', 'alert-danger', 'mt-2');
    alert.innerText = errorMessages[data.statusText];

    shortenCard.after(alert);
}