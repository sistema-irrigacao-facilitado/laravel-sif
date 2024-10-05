
    function formatarValor(input) {  
        // Remove caracteres não numéricos e não pontos  
        input.value = input.value.replace(/[^0-9.,]/g, '');  

        // Trocar vírgulas por pontos  
        input.value = input.value.replace(',', '.');  

        // Limitar a 3 casas decimais  
        const partes = input.value.split('.');  
        if (partes.length > 1) {  
            partes[1] = partes[1].substring(0, 3); // Limita a 3 casas decimais  
            input.value = partes.join('.');  
        }  
    }  

    function validarEntrada() {  
        const input = document.getElementById('vazao');  
        const erroMsg = document.getElementById('erro');  
        const regex = /^\d+(\.\d{0,3})?$/; // Regex para validar o formato  

        if (!regex.test(input.value)) {  
            erroMsg.style.display = 'block'; // Mostra mensagem de erro  
            return false; // Impede o envio do formulário  
        } else {  
            erroMsg.style.display = 'none'; // Oculta mensagem de erro  
        }  
        return true; // Permite o envio do formulário  
    }  

   
    function validarEntrada(vazao) {   
        vazao.value = vazao.value.replace(/[^0-9.]/g, '');  
    }  
 
 