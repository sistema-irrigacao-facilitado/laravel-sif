

/* Uma logica bem melhor pra vc trabalhar*/

/* 

popupOn: previne o evento de link, exibe o popup e adiciona um id ao final da url de confirmar

Vantagem: você tira o popup do foreach, então não vai existir 1 bilhão de popups, um pra cada item, existe apenas um que da conta de todos, simplesmente o link de confirmar tem a base da url que serve pra todas, e a função apenas adiciona o id daquele item ao popup quando essa função é chamada, alem de claro de exibi-la */

function popupOn(event, id, who = 0, id2=0){
    event.preventDefault();

    all = document.querySelectorAll('.popup')
    popup = all[who]
    popup.style.display = "flex"

    confirmar = popup.querySelector('.conf')

    /* pega a url, no caso o href do <a> de cancelar */
    url = confirmar.href

    if(id2 != 0){
        url += `id=${id}&dispositivo_id=${id2}`
        confirmar.href = url
    }else{

        /* adiciona o id e joga pra url dnv*/
        url += `${id}`
        confirmar.href = url

    }




    /* cria um evento proprio pro botão de cancelar la do popup */
    cancel = popup.querySelector('.cancel')
    cancel.addEventListener('click', (event) => {
        event.preventDefault();
    
        // Encontra a posição do caractere 'id' na URL
        const idIndex = confirmar.href.indexOf('id=');
    
        // Se o 'id' for encontrado, encontra o próximo '?' após o 'id'
        if (idIndex !== -1) {
            const questionMarkIndex = confirmar.href.indexOf('?', idIndex);
    
            // Se houver um '?', corta a URL até antes dele
            if (questionMarkIndex !== -1) {
                url = confirmar.href.substring(0, questionMarkIndex);
            } else {
                // Se não houver outro '?', corta a URL até o final
                url = confirmar.href.substring(0, idIndex);
            }
    
            confirmar.href = url;
        }
    
        popup.style.display = "none";
    });

}
